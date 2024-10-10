<?php


// app/Http/Controllers/CommentsController.php
namespace App\Http\Controllers;

use App\Models\CommentaireClient;
use App\Models\CommentaireExpert;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Service;



class CommentsController extends Controller
{
    public function store(Request $request)
    {
        // Validez les données du formulaire
        $request->validate([
            'id_reservation' => 'required|exists:reservations,id',
            'contenu' => 'required|string',
            'note' => 'required|integer|between:1,5',
        ]);

        // Créez le commentaire
        $commentaire = new CommentaireClient([
            'id_reservation' => $request->id_reservation,
            'contenu' => $request->contenu,
            'note' => $request->note,
            'date_commentaire' => now(), // Ou la date que vous souhaitez utiliser
        ]);

        // Sauvegardez le commentaire
        $commentaire->save();

        // Répondez avec un message de succès
        return response()->json(['message' => 'Commentaire ajouté avec succès !'], 200);
    }





    public function store_par(Request $request)
    {
        // Validez les données du formulaire
        $request->validate([
            'id_reservation' => 'required|exists:reservations,id',
            'contenu' => 'required|string',
            'note' => 'required|integer|between:1,5',
        ]);

        // Créez le commentaire
        $commentaire = new CommentaireExpert([
            'id_reservation' => $request->id_reservation,
            'contenu' => $request->contenu,
            'note' => $request->note,
            'date_commentaire' => now(), // Ou la date que vous souhaitez utiliser
        ]);

        // Sauvegardez le commentaire
        $commentaire->save();

        // Répondez avec un message de succès
        return response()->json(['message' => 'Commentaire ajouté avec succès !'], 200);
    }


    public function expertComments()
    {
        $clientId = Session::get('id_cl');
        $dateLimit = Carbon::now()->subWeek();

        $reservations = Reservation::with(['commentaireExpert', 'service.partenaire'])
            ->where('id_client', $clientId)
            ->where('statut', 'done')
            ->where('date_fin', '<', now())
            ->where(function ($query) use ($dateLimit) {
                $query->whereHas('commentaireClient')
                      ->orWhere('date_fin', '<=', $dateLimit);
            })
            ->get();

        $comments = $reservations->map(function ($reservation) {
            if ($reservation->commentaireExpert) {
                return [
                    'nom' => $reservation->service->partenaire->nom_par ?? 'Nom Inconnu',
                    'prenom' => $reservation->service->partenaire->prenom_par ?? 'Prénom Inconnu',
                    'commentaire' => $reservation->commentaireExpert->contenu
                ];
            }
        })->filter()->values();

        return view('client.commentaire_list', [
            'comments' => $comments
        ]);
    }


}
