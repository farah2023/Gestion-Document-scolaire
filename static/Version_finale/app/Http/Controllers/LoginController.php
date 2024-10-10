<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Partenaire;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller{

    public function login(){
        return view('login');
    }

    public function home(){
        return view('index');
    }

    public function loginPost(Request $request){

        $existingRecordClient = Client::where('email', $request->email)->first();
        $existingRecordPartenaire = Partenaire::where('email', $request->email)->first();
        $existingRecordAdmin = Admin::where('email', $request->email)->first();

        if($existingRecordClient && Hash::check($request->password, $existingRecordClient->password)){

            // Démarrer une session pour le client
            Session::put('user_cl', 'Client');
            Session::put('id_cl', $existingRecordClient->id);
            Session::put('nom_cl', $existingRecordClient->nom_cl);
            Session::put('prenom_cl', $existingRecordClient->prenom_cl);
            Session::put('photo_cl', $existingRecordClient->photo_cl);
            Session::put('password_cl', $existingRecordClient->password);
            Session::put('adresse_cl', $existingRecordClient->adresse);
            Session::put('ville', $existingRecordClient->ville);
            Session::put('email_cl', $existingRecordClient->email);
            Session::put('telephone_cl', $existingRecordClient->telephone);
            Session::put('id_admin_cl', $existingRecordClient->id_admin);

            return redirect('dashboard_client')->with('successLoginClient', 'Customer exists!');

        } else if($existingRecordPartenaire && Hash::check($request->password, $existingRecordPartenaire->password)){
            if ($existingRecordPartenaire->connexion == 0) {
                  // Démarrer une session pour le partenaire
            Session::put('user_par', 'Partenaire');
            Session::put('id_par', $existingRecordPartenaire->id);
            Session::put('nom_par', $existingRecordPartenaire->nom_par);
            Session::put('prenom_par', $existingRecordPartenaire->prenom_par);
            Session::put('password_par', $existingRecordPartenaire->password);
            Session::put('ville_par', $existingRecordPartenaire->ville);
            Session::put('email_par', $existingRecordPartenaire->email);
            Session::put('photo_par', $existingRecordPartenaire->photo_par);
            Session::put('connexion', $existingRecordPartenaire->connexion);
            Session::put('nbr_experience', $existingRecordPartenaire->nbr_experience);
            Session::put('domaine_expertise', $existingRecordPartenaire->domaine_expertise);
                // Redirect the user to complete profile
                return redirect('complete_profile')->with('info', 'Please complete your profile.');
            } else {
                  // Démarrer une session pour le partenaire
            Session::put('user_par', 'Partenaire');
            Session::put('id_par', $existingRecordPartenaire->id);
            Session::put('nom_par', $existingRecordPartenaire->nom_par);
            Session::put('prenom_par', $existingRecordPartenaire->prenom_par);
            Session::put('password_par', $existingRecordPartenaire->password);
            Session::put('ville_par', $existingRecordPartenaire->ville);
            Session::put('email_par', $existingRecordPartenaire->email);
            Session::put('photo_par', $existingRecordPartenaire->photo_par);
            // Session::put('metier_par', $existingRecordPartenaire->metier);
            Session::put('connexion', $existingRecordPartenaire->connexion);
            Session::put('nbr_experience', $existingRecordPartenaire->nbr_experience);
            Session::put('domaine_expertise', $existingRecordPartenaire->domaine_expertise);
                // Redirect the user to the dashboard
                return redirect('dashboard_partenaire')->with('successLoginPartenaire', 'Partner exists!');
            }
        } else {
            if ($existingRecordAdmin && $request->password === $existingRecordAdmin->password) {
                // Start a session for the admin
                Session::put('user_type', 'Admin');
                Session::put('user_id', $existingRecordAdmin->id);
                Session::put('user_email', $existingRecordAdmin->email);
                Session::put('user_name', $existingRecordAdmin->name);

                return redirect('dashboard_admin')->with('successLoginAdmin', 'Admin login successful!');
            }
        }
    }
}
