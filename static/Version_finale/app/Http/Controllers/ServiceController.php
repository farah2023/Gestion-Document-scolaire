<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Partenaire;
use Illuminate\Support\Facades\Session;
use App\Mail\ReservationStatusChanged;
use Illuminate\Support\Facades\Mail;

class ServiceController extends Controller
{
    public function create()
    {
        // Retrieve the list of partners to populate the dropdown
        $partenaires = Partenaire::all();
        return view('client.add-service', compact('partenaires'));
    }

     //recuperation des demandes de service des client
     public function demande(){
        // Retrieve client ID from session. Make sure 'client_id' is set in session upon login.
        $clientId = Session::get('id_cl');

        // Query the reservations for the logged-in client
        $demande = Reservation::where('id_client', $clientId)->get();

        // Return the view with the reservations data
        return view('client.demandes', compact('demande'));
    }




    public function partenaire(){
        $partenaire = Partenaire::where('is_active', 1)->get();

    return view('client.partenaire', compact('partenaire'));//compact('partenaire'), est une fonction PHP qui crée un tableau associatif à partir de variables et de leurs valeurs. Ici, elle crée un tableau contenant la variable $partenaire afin que la donnée puisse être accessible dans la vue sous le même nom de variable.
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'service' => 'required|string',
            'date_reservation' => 'required|date',
            'heure' => 'required|date_format:H:i',
            'partenaire' => 'required|exists:partenaire,id', // Assuming you name your select input 'partenaire'
        ]);

        // Retrieve the client ID from the session
        $id_cl = Session::get('id_cl');

        // Retrieve the partner information
        $partenaire = Partenaire::findOrFail($validatedData['partenaire']);

        // Create new reservation
        $reservation = new Reservation();
        $reservation->status = 'in progress';
        $reservation->service = $validatedData['service'];
        $reservation->date_reservation = $validatedData['date_reservation'];
        $reservation->heure = $validatedData['heure'];
        $reservation->partenaire_nom = $partenaire->nom_par; // Assuming your Reservation model has a 'partenaire_nom' field
        $reservation->partenaire_prenom = $partenaire->prenom_par; // Assuming your Reservation model has a 'partenaire_prenom' field
        $reservation->id_clt = $id_cl;
        $reservation->save();

        // Redirect to a success page or anywhere you want
        return redirect()->route('services.create')->with('success', 'Service added successfully.');
    }


public function accept($id)
{
    $reservation = Reservation::findOrFail($id);
    $reservation->statut = 'accepted';
    $reservation->save();

    // Send email to the client
    Mail::to($reservation->client->email)->send(new ReservationStatusChanged($reservation, 'accepted'));

    return back()->with('success', 'Reservation accepted and client notified.');
}

public function refuse($id)
{
    $reservation = Reservation::findOrFail($id);
    $reservation->statut = 'refused';
    $reservation->save();

    // Send email to the client
    Mail::to($reservation->client->email)->send(new ReservationStatusChanged($reservation, 'refused'));

    return back()->with('success', 'Reservation refused and client notified.');
}

}
