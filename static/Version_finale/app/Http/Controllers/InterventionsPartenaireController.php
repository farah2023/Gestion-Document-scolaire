<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Reservation;
use App\Models\Service;
use Carbon\Carbon;

class InterventionsPartenaireController extends Controller
{
    public function interventionsPartenairePage()
    {
        $partenaireId = Session::get('id_par');

        // Récupérer les services offerts par le partenaire connecté.
        $services = Service::where('id_expert', $partenaireId)->get();

        // Récupérer les réservations acceptées pour les services de ce partenaire.
        // Assurez-vous d'avoir une relation 'client' définie dans votre modèle Reservation.
        $reservations = Reservation::with('client')  // Pré-chargement de la relation client
                                ->whereIn('id_service', $services->pluck('id'))
                                ->where('statut', 'done')
                                ->where('date_fin', '<', now())
                                ->get();

 // Date limite une semaine avant aujourd'hui
 $dateLimit = Carbon::now()->subWeek();

 // Récupérer les commentaires clients selon les conditions spécifiées
        $commentairesClients = $reservations->mapWithKeys(function ($reservation) use ($dateLimit) {
            if ($reservation->commentaireExpert || $reservation->date_fin <= $dateLimit) {
                return [$reservation->id => $reservation->commentaireClient];
            }
            return [];
        });

        return view('partenaire.interventions', [
            'services' => $services,
            'reservations' => $reservations,
            'commentairesClients' => $commentairesClients
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $reservations = Reservation::where('statut', 'accepted')
                                ->where(function($q) use ($query) {
                                    $q->where('id_client', 'like', '%' . $query . '%')
                                        ->orWhere('id', 'like', '%' . $query . '%')
                                        ->orWhere('duree', 'like', '%' . $query . '%')
                                        ->orWhere('date_debut', 'like', '%' . $query . '%')
                                        ->orWhere('date_fin', 'like', '%' . $query . '%');
                                })
                                ->get();

        return response()->json($reservations);
    }

}
