<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\Service;
use App\Models\Partenaire;
use App\Models\Reservation;
use App\Models\CommentaireExpert;
use App\Models\Client;
use Carbon\Carbon;




class DashboardPartenaireController extends Controller
{
    // Afficher le tableau de bord partenaire
    public function dashboardpartenaire(){

        //Accéder aux variables de session
        $user_par = Session::get('user_par');
        $id_par = Session::get('id_par');
        $nom_par = Session::get('nom_par');
        $prenom_par = Session::get('prenom_par');
        $password_par = Session::get('password_par');
        $ville_par = Session::get('ville_par');
        $email_par = Session::get('email_par');
        $photo_par = Session::get('photo_par');
        $nbr_experience_parr = Session::get('nbr_experience_par');
        $domaine_expertise_par = Session::get('domaine_expertise_par');
    // Récupérer les services offerts par ce partenaire
    $servicesIds = Service::where('id_expert', $id_par)->pluck('id');


        // Récupérer le nombre total de réservations faites par le client
         // Compter les réservations totales et les réservations traitées pour les services du partenaire
    $totalReservations = Reservation::whereIn('id_service', $servicesIds)->count();
    $treatedReservations = Reservation::whereIn('id_service', $servicesIds)
                                      ->where('statut', 'traitee')
                                      ->count();
        // Récupérer le nombre total de commentaires faits par le client
        $totalComments = CommentaireExpert::count();

        // Récupérer le nombre total de partenaires dans la base de données
        $totalClients = Client::count();


        //comments

        $today = Carbon::today();
        $sevenDaysAfter = $today->copy()->addDays(7);

        $reservations = Reservation::with(['client', 'service'])
            ->where('date_fin', '<=', $today->format('Y-m-d')) // La date de fin doit être aujourd'hui ou dans le passé
            ->where('date_fin', '>=', $today->copy()->subDays(7)->format('Y-m-d'))
            ->where('statut', 'done') // La date de fin ne doit pas être plus vieille que 7 jours
            // La date de fin ne doit pas être plus vieille que 7 jours
            ->whereDoesntHave('commentaireExpert') // Vérifie que la réservation n'a pas déjà un commentaire
            ->get();



        return view('partenaire.dash_partenaire',compact('reservations','totalClients', 'totalComments','totalReservations', 'treatedReservations'));
    }

    // Se deconnecter
    public function logout(){

        // Détruire les variables de session
        Session::forget('user_par');
        Session::forget('id_par');
        Session::forget('nom_par');
        Session::forget('prenom_par');
        Session::forget('password_par');
        Session::forget('ville_par');
        Session::forget('email_par');
        Session::forget('photo_par');
        Session::forget('nbr_experience_par');
        Session::forget('domaine_expertise_par');


        return redirect()->route('login');
    }
    public function complete_profile_par(Request $request){
    // Retrieve the expert's ID from the session
    $expertId = Session::get('id_par'); // Assuming the expert's ID is stored in the session

    // Validate incoming request data
    $rules = [];
    $services = $request->except('_token');
    foreach ($services as $key => $value) {
        $rules[$key] = 'required';
        // Check if creneau$key and prix$key are present in the request
        if (Str::startsWith($key, 'creneau') && !empty($services['prix' . substr($key, 7)])) {
            $rules[$key] = 'required';
        }
        if (Str::startsWith($key, 'prix') && !empty($services['creneau' . substr($key, 4)])) {
            $rules[$key] = 'required';
        }
    }
    $request->validate($rules);

    // Save each service for the expert
    foreach ($services as $key => $value) {
        // Check if creneau$key and prix$key are present in the request
        if (Str::startsWith($key, 'creneau') && !empty($services['prix' . substr($key, 7)])) {
            $service = new Service();
            $service->id_expert = $expertId;
            $service->nom_service = $request->input("Service" . substr($key, 7));
            $service->crenau_dispo = $request->input($key);
            $service->prix = $request->input('prix' . substr($key, 7));
            $service->statut = 1; // Assuming the default status is 1
            $service->save();
        }
    }

    // Update the 'connexion' field in the 'partenaire' table
    Partenaire::where('id', $expertId)->update(['connexion' => 1]);

    // Redirect back with success message or do anything else you want
    return redirect()->back()->with('success', 'Profile completed successfully!');
}

public function updateProfilePartenaire(Request $request)
{

    $request->validate([
        'nom_par' => 'required',
        'prenom_par' => 'required',
        'email_par' => 'required|email',
        'ville_par' => 'required',
        'nbr_experience' => 'required|integer',
        'domaine_expertise' => 'required',
        // Add validation rules for service fields if needed
    ]);

    // Retrieve the connected partenaire's ID from the session
    $partenaireId = Session::get('id_par');

    // Update partenaire information
    $partenaire = Partenaire::find($partenaireId);
    $partenaire->nom_par = $request->input('nom_par');
    $partenaire->prenom_par = $request->input('prenom_par');
    $partenaire->email = $request->input('email_par');
    $partenaire->ville = $request->input('ville_par');
    $partenaire->nbr_experience = $request->input('nbr_experience');
    $partenaire->domaine_expertise = $request->input('domaine_expertise');

    // Update partenaire photo if provided
    if ($request->hasFile('photo_par')) {
        $photo_par = $request->file('photo_par');
        $fileName = time() . '_' . $photo_par->getClientOriginalName();
        $photo_par->move(public_path('uploads/partenaire'), $fileName);
        $partenaire->photo_par = $fileName;
    }

    // Save the updated partenaire information
    $partenaire->save();

    // Update service information if provided
    foreach ($request->all() as $key => $value) {
        if (strpos($key, 'nom_service_') === 0) {
            $serviceId = substr($key, strlen('nom_service_'));
            $service = Service::find($serviceId);
            if ($service) {
                $service->nom_service = $request->input('nom_service_' . $serviceId);
                $service->crenau_dispo = $request->input('creneau_dispo_' . $serviceId);
                $service->prix = $request->input('prix_' . $serviceId);
                $service->save();
            }
        }
    }

    // Redirect back with success message or do anything else you want
    return redirect()->back()->with('success', 'Profile updated successfully!');
}

}
