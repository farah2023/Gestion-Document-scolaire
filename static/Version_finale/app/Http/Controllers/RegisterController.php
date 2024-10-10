<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Partenaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller{

    public function register(){
        return view('register');
    }

    public function registerPost(Request $request){

        // Vérifier si l'email existe déjà dans la base de données
        $emailExistsClient = Client::where('email', $request->email)->exists() || Partenaire::where('email', $request->email)->exists();
        $emailExistsPartenaire = Partenaire::where('email', $request->email)->exists() || Partenaire::where('email', $request->email)->exists();

        if($emailExistsClient || $emailExistsPartenaire) {
            return back()->with('errorRegister', 'This email is already in use, please choose another');
        }

        // Continuer le processus d'inscription si l'email n'existe pas déjà
        if($request->user_type == 'client'){
            //sign up cas client

            $client = new Client();
            $client->nom_cl = $request->nom_cl;
            $client->prenom_cl = $request->prenom_cl;
            $client->ville = $request->Ville;
            $filename = '';

            if($request->hasFile('photo_cl')){
                $imgcl = $request->file('photo_cl');
                $filename = $imgcl->getClientOriginalName();
                $imgcl->move('uploads/client',$filename);
            }

            $client->photo_cl = $filename;

            $client->adresse = $request->adresse;

            $client->telephone = $request->telephone;
            $client->email = $request->email;
            $client->password = Hash::make($request->password);
            $client->save();
            return redirect()->route('login')->with('successRegisterClient', 'Your Customer account has been successfully created');

        } elseif ($request->user_type == 'partner') {
            // sign up cas partenaire

            $partenaire = new Partenaire();
            $partenaire->nom_par = $request->nom_par;
            $partenaire->prenom_par = $request->prenom_par;

            $filename = '';

            if($request->hasFile('photo_par')){
                $imgcl = $request->file('photo_par');
                $filename = $imgcl->getClientOriginalName();
                $imgcl->move('uploads/partenaire',$filename);
            }

            $partenaire->photo_par = $filename;

            $partenaire->ville = $request->ville;
            $partenaire->connexion = 0;
            $partenaire->nbr_experience = $request->nbr_experience;
            $partenaire->domaine_expertise = implode(', ', $request->domaine_expertise);//modifier
            $partenaire->email = $request->email;
            $partenaire->password = Hash::make($request->password);
            $partenaire->save();
            return redirect()->route('login')->with('successRegisterPartenaire', 'Your Partner account has been successfully created');

        } else {
            // Gérer le cas où aucun type d'utilisateur n'est sélectionné
            return back()->with('errorRegister', 'Please choose a valid user type');
        }

    }

}
