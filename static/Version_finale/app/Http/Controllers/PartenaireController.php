<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partenaire;
use Illuminate\Support\Facades\Session;
use App\Models\Service;
use App\Models\Reservation;


class PartenaireController extends Controller
{
    public function complete_profile(){
        return view('partenaire.complete_profile');
    }

    public function editProfilePartenaire()
    {
        $partenaireId = Session::get('id_par');
        $partenaire = Partenaire::find($partenaireId);
        $services = Service::where('id_expert', $partenaireId)->get();
    
        return view('partenaire.edit_profile_par', compact('partenaire', 'services'));
    }

    public function ProfileForm()
{
    $partenaire = auth()->user(); // Récupérer le partenaire connecté
    $partenaireId = Session::get('id_par');
    $services = Service::where('id_expert', $partenaireId)->get(); // Retrieve services associated with the partenaire

    return view('partenaire.profile', compact('partenaire', 'services'));
}


    public function activate($id)
{
    $partenaire = Partenaire::findOrFail($id);
    $partenaire->is_active = 1;
    $partenaire->save();
    return redirect()->back()->with('success', 'Partenaire activated successfully.');
}

public function deactivate($id)
{
    $partenaire = Partenaire::findOrFail($id);
    $partenaire->is_active = 0;
    $partenaire->save();
    return redirect()->back()->with('success', 'Partenaire deactivated successfully.');
}
 public function showDemandes()
    {
        // Retrieve the partner ID from session, adjust if using a different method to store partner ID
        $partenaireId = Session::get('id_par');

        // Fetch all reservations linked to the services offered by the authenticated partner
        $reservations = Reservation::whereHas('service', function ($query) use ($partenaireId) {
            $query->where('id_expert', $partenaireId);
        })->with(['service', 'client'])->get();

        // Pass the reservations to the view
        return view('partenaire.demandes', compact('reservations'));
    }


}
