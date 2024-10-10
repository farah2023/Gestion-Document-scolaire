<?php

namespace App\Http\Controllers;


use App\Models\Client;
use App\Models\Partenaire;
use App\Models\Intervention;
use App\Models\CommentaireExpert;
use App\Models\CommentaireClient;
use App\Models\Reservation;


use Illuminate\Http\Request;


class DashboardAdminController extends Controller
{
    public function dashboardAdmin()
    {
        // Retrieve counts from the database
        $partenaireCount = Partenaire::count();
        $clientCount = Client::count();
        $interventionCount = Intervention::count();
        $commentCount = CommentaireExpert::count(); // Modify this based on your actual comments model

        $demandeCount = Reservation::count(); // Count all entries in the Reservation table
        $expertCommentCount = CommentaireExpert::count(); // Count all entries in the CommentaireExpert table
    
        // Pass all counts to the view
        return view('admin.dashboard_admin', compact('partenaireCount', 'clientCount', 'interventionCount', 'commentCount', 'demandeCount', 'expertCommentCount'));
    }

    public function showClients()
{
    $clients = Client::all(); // Fetch all clients

    foreach ($clients as $client) {
        // Calculate the average note for each client based on comments made on their interventions
        $client->average_note = CommentaireClient::whereHas('intervention', function ($query) use ($client) {
            $query->where('id_client', $client->id); // Ensure that the intervention is associated with the client
        })->avg('note');
    }

    return view('admin.clients', compact('clients'));
}

public function showPartenaires()
{
    $partenaires = Partenaire::with('services.interventions.commentairesExperts')->get();

    foreach ($partenaires as $partenaire) {
        // Initialize an array to hold all notes for this partenaire
        $notes = [];

        // Iterate over each service and their interventions
        foreach ($partenaire->services as $service) {
            foreach ($service->interventions as $intervention) {
                // Fetch the notes from the CommentaireExpert model related to the intervention
                $interventionNotes = $intervention->commentairesExperts->pluck('note');
                $notes = array_merge($notes, $interventionNotes->all());
            }
        }

        // Calculate the average note for the partenaire, if there are notes present
        $partenaire->average_note = count($notes) ? (array_sum($notes) / count($notes)) : null;
    }

    return view('admin.partenaires', compact('partenaires'));
}

    public function showInterventions()
    {
        $interventions = Intervention::with(['client', 'service'])->get(); // Fetch all interventions with related client and service
        return view('admin.interventions', compact('interventions')); // Return them to the view
    }
    public function searchPartenaires(Request $request)
{
    $searchTerm = $request->input('search');

    // Query the database using the search term against all relevant columns
    $partenaires = Partenaire::query()
        ->where('nom_par', 'LIKE', "%{$searchTerm}%")
        ->orWhere('prenom_par', 'LIKE', "%{$searchTerm}%")
        ->orWhere('email', 'LIKE', "%{$searchTerm}%")
        ->orWhere('ville', 'LIKE', "%{$searchTerm}%")
        ->orWhere('domaine_expertise', 'LIKE', "%{$searchTerm}%")
        ->get();

    // Calculate average notes for each partenaire if needed, similar to showPartenaires() method

    return view('admin.partenaires', compact('partenaires'));
}

public function searchClients(Request $request)
{
    // Get the search term from the query string
    $searchTerm = $request->query('search');

    // Query the clients based on the search term across multiple columns
    $clients = Client::query()
        ->where('nom_cl', 'LIKE', '%' . $searchTerm . '%')
        ->orWhere('prenom_cl', 'LIKE', '%' . $searchTerm . '%')
        ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
        ->orWhere('adresse', 'LIKE', '%' . $searchTerm . '%')
        ->orWhere('telephone', 'LIKE', '%' . $searchTerm . '%')
        ->get();

    // Calculate the average note for each client if needed
    // (Ensure the logic for calculating average notes is consistent with the method used in showClients)
    foreach ($clients as $client) {
        $client->average_note = $client->commentaires->avg('note')?? 'Not Available';
    }

    // Return the view with the filtered clients
    return view('admin.clients', compact('clients'));
}

}
