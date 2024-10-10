<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Client;
use App\Models\Partenaire;
use App\Models\Reclamation; 

class ReclamationsClientController extends Controller
{
    public function reclamationsClientPage()
    {
        $clientId = Session::get('id_cl');
        $partenaires = Partenaire::select('id', 'nom_par', 'prenom_par')->get(); 
        return view('client.reclamations', compact('partenaires'));
    }

    public function submitComplaint(Request $request)
    {
        $clientId = Session::get('id_cl');
        $partenaire = Partenaire::findOrFail($request->expert_name); 
        $claimType = $request->claim_type; 

        $reclamation = new Reclamation([
            'id_client' => $clientId, 
            'id_expert' => $partenaire->id, 
            'description' => $claimType, 
            'sender' => 'client' 
        ]);

        $reclamation->save();

        return back()->with('success', 'Complaint submitted successfully!');
    }
}
