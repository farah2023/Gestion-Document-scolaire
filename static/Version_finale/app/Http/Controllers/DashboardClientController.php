<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;
use App\Models\Partenaire;
use App\Models\Reservation;

use Carbon\Carbon;
use App\Models\CommentaireClient;
use App\Models\Service;

class DashboardClientController extends Controller
{
    // Afficher le tableau de bord Client
    public function dashboardclient(){

        // Accéder aux variables de session
        $user_cl = Session::get('user_cl');
        $id_cl = Session::get('id_cl');
        $nom_cl = Session::get('nom_cl');
        $prenom_cl = Session::get('prenom_cl');
        $photo_cl = Session::get('photo_cl');
        $password_cl = Session::get('password_cl');
        $adresse_cl = Session::get('adresse_cl');
        $adresse_cl = Session::get('ville');
        $email_cl = Session::get('email_cl');
        $telephone_cl = Session::get('telephone_cl');




        // Récupérer le nombre total de réservations faites par le client
        $totalReservations = Reservation::where('id_client', $id_cl)->count();

        // Récupérer le nombre de réservations traitées (statut = 'traitee')
        $treatedReservations = Reservation::where('id_client', $id_cl)
                                          ->where('statut', 'traitee')
                                          ->count();

        // Récupérer le nombre total de commentaires faits par le client
        $totalComments = CommentaireClient::count();

        // Récupérer le nombre total de partenaires dans la base de données
        $totalPartenaires = Partenaire::count();


        //comments

        $today = Carbon::today();
        $sevenDaysAfter = $today->copy()->addDays(7);

        $reservations = Reservation::with(['client', 'service'])
            ->where('date_fin', '<=', $today->format('Y-m-d')) // La date de fin doit être aujourd'hui ou dans le passé
            ->where('date_fin', '>=', $today->copy()->subDays(7)->format('Y-m-d'))
            ->where('statut', 'done') // La date de fin ne doit pas être plus vieille que 7 jours
            ->whereDoesntHave('commentaireClient') // Vérifie que la réservation n'a pas déjà un commentaire
            ->get();




        return view('client.dash', compact('totalReservations', 'treatedReservations', 'totalComments', 'totalPartenaires','today','reservations'));


    }


    // Se deconnecter
    public function logout(){

        // Détruire les variables de session
        Session::forget('user_cl');
        Session::forget('id_cl');
        Session::forget('nom_cl');
        Session::forget('prenom_cl');
        Session::forget('photo_cl');
        Session::forget('password_cl');
        Session::forget('adresse_cl');
        Session::forget('email_cl');
        Session::forget('telephone_cl');
        Session::forget('id_admin_cl');

        return redirect()->route('login');
    }
    // Vue du profil
    public function ProfileForm()
    {
        $client = auth()->user(); // Récupérer le client connecté

        return view('client.profile', compact('client'));
    }
    public function activate($id)
{
    $client = Client::findOrFail($id);
    $client->is_active = true;
    $client->save();
    return redirect()->back()->with('success', 'Client activated successfully.');
}

public function deactivate($id)
{
    $client = Client::findOrFail($id);
    $client->is_active = false;
    $client->save();
    return redirect()->back()->with('success', 'Client deactivated successfully.');
}


    // Modifier le profil
    public function editProfile()
    {
        return view('client.edit_profile');
    }

    // Mettre à jour le profil
    public function updateProfile(Request $request)
    {

        // Valider les données du formulaire
        $validatedData = $request->validate([
            'nom_cl' => 'required|string|max:255',
            'prenom_cl' => 'required|string|max:255',
            'email_cl' => 'required|string|max:255',
            'adresse_cl' => 'required|string|max:255',
            'telephone_cl' => 'required|string|max:10'
        ]);

        // Récupérer l'ID du client connecté
        $clientId = Session::get('id_cl');

         //Mettre à jour les informations du client dans la base de données
        $filename = '';

        if ($request->hasFile('photo_cl')) {
            $imgcl = $request->file('photo_cl');
            $filename = $imgcl->getClientOriginalName();
            $imgcl->move('uploads/client', $filename);
        }
       $filename=$request->photo_cl;
        $affectedRows = Client::where('id', $clientId)->update([
            'photo_cl' =>$request->photo_cl,
            'nom_cl' => $request->nom_cl,
            'prenom_cl' => $request->prenom_cl,
            'email' => $request->email_cl,
            'adresse' => $request->adresse_cl,
            'telephone' => $request->telephone_cl,
            'password' => Hash::make($request->password)
        ]);

        // Vérifier si des lignes ont été affectées (mise à jour réussie)
        if ($affectedRows > 0) {
            // Rediriger l'utilisateur vers la page de profil après la mise à jour
                // Mettre à jour les informations du profil dans la session
              //  Session::put('photo_cl', $request->photo_cl);

              Session::put('photo_cl',$request->photo_cl) ;
              Session::put('nom_cl', $request->nom_cl);
                // Mettez à jour d'autres champs de profil de la même manière
              Session::put('prenom_cl', $request->prenom_cl);
              Session::put('email_cl', $request->email_cl);
              Session::put('adresse_cl', $request->adresse_cl);
              Session::put('telephone_cl', $request->telephone_cl);
            return redirect()->route('profile')->with('success', 'Profil mis à jour avec succès !');
        } else {
            // En cas d'échec de la mise à jour, rediriger avec un message d'erreur
            return redirect()->route('profile')->with('error', 'La mise à jour du profil a échoué.');
        }
    }
    /*view profile partenaire */
    // public function partenaireProfile()
    // {
    //     return view('client.profile_partenaire');
    // }
    public function part_search()
    {
        $partenaire = Partenaire::orderBy('created_at', 'desc');

        if (request()->has('search')) {
            $search = request()->get('search');
            $partenaire = $partenaire->where(function ($query) use ($search) {
                $query->where('nbr_experience', 'like', '%' . $search . '%')
                      ->orWhere('ville', 'like', '%' . $search . '%');

            });
        }

        return view('client.partenaire', ['partenaire' => $partenaire->paginate(5)]);
    }


    public function demande_search()
{
    $query = Reservation::orderBy('created_at', 'desc');

    // Recherche par 'heure'
    if (request()->has('search')) {
        $search = request()->get('search');
        $query->where(function ($q) use ($search) {
            $q->where('heure', 'like', '%' . $search . '%')
              ->orWhere('date_reservation', 'like', '%' . $search . '%')
              ->orWhere('status', 'like', '%' . $search . '%')
              ->orWhere('service', 'like', '%' . $search . '%');
        });
    }

    // Ajouter plus de paramètres si nécessaire
    // Par exemple, recherche spécifique pour 'status'
    if (request()->has('status')) {
        $status = request()->get('status');
        $query->where('status', $status);
    }

    // Recherche spécifique pour 'date_reservation'
    if (request()->has('date')) {
        $date = request()->get('date');
        $query->whereDate('date_reservation', '=', $date);
    }
    if (request()->has('service')) {
        $service = request()->get('service');
        $query->whereDate('service', '=', $service);
    }

    // Continuer à ajouter plus de conditions selon les besoins

    $demande = $query->paginate(5);
    return view('client.demandes', compact('demande'));
}

//partenaireProfile
public function partenaire_info($id)
{
    // Fetch the partner data from the database
    $partenaire = Partenaire::findOrFail($id);
    // $partenaire = Partenaire::with('commentaires')->findOrFail($id);  // Assuming 'commentaires' is the relationship name
    $services = Service::where('id_expert', $id)->get();

    // Pass partner data and services to the view
    return view('client.partenaire_info', compact('partenaire', 'services'));


}

}




