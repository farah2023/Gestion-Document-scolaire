<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Client; 
use App\Models\Reclamation; 

class ReclamationsPartenaireController extends Controller
{
    public function reclamationsPartenairePage()
    {
        $partenaireId = Session::get('id_par');
        $clients = Client::select('id', 'adresse')->get(); 
        return view('partenaire.reclamations', compact('clients'));
    }

    public function submitComplaint(Request $request)
    {
        $partenaireId = Session::get('id_par');
        $client = Client::findOrFail($request->client_address); 
        $claimType = $request->claim_type; 

        $reclamation = new Reclamation([
            'id_client' => $client->id, 
            'id_expert' => $partenaireId, 
            'description' => $claimType, 
            'sender' => 'partenaire' 
        ]);

        $reclamation->save();

        return back()->with('success', 'Complaint submitted successfully!');
    }
}
