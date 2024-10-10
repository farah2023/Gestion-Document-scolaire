<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardClientController;
use App\Http\Controllers\DashboardPartenaireController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PartenaireController;
use App\Http\Controllers\InterventionsPartenaireController;
use App\Http\Controllers\CommentsController;
use  App\Http\Controllers\ReclamationsClientController;
use App\Http\Controllers\ReclamationsPartenaireController;
// Route::get('/dashboard_client', [CommentsController::class, 'checkReservations']);


// Pour afficher la page d'acceuil
Route::get('/', function () {
    return view('index');
})->name('index');

// Pour l'inscription
// Afficher la page de sign up
Route::get('/register',[RegisterController::class,'register'])->name('register');
// Traitement backend du signup
Route::post('/register',[RegisterController::class,'registerPost'])->name('register');

// Pour la connexion
// Afficher la page de login
Route::get('/login',[LoginController::class,'login'])->name('login');
// Traitement backend du login
Route::post('/login',[LoginController::class,'loginPost'])->name('login');

// Pour le tableau de bord client
// Afficher le tableau de bord client
Route::get('/dashboard_client',[DashboardClientController::class,'dashboardclient'])->name('dashboard_client');

// Se deconnecter
Route::delete('/logout', [DashboardClientController::class,'logout'])->name('logout');

// Pour le tableau de bord partenaire
// Afficher le tableau de bord partenaire
Route::get('/dashboard_partenaire',[DashboardPartenaireController::class,'dashboardpartenaire'])->name('dashboard_partenaire');
// Se deconnecter
Route::delete('/logout', [DashboardPartenaireController::class,'logout'])->name('logout');

//
Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
// Pour le tableau de bord admin
Route::get('/dashboard_admin', [DashboardAdminController::class, 'dashboardAdmin'])->name('dashboard_admin');

//
Route::get('/demandes',[ServiceController::class, 'demande'])->name('demande');
Route::get('/partenaire',[ServiceController::class, 'partenaire'])->name('partenaire');




//pour afficher le profile de client
Route::get('/profile_cl', [DashboardClientController::class, 'ProfileForm'])->name('profile');
//pour editer le profile
Route::get('/edit_profile', [DashboardClientController::class, 'editProfile'])->name('edit-profile');
//update-profile
Route::put('/update-profile', [DashboardClientController::class, 'updateProfile'])->name('update-profile');
//partenaire profile
// Route::get('/partenaireProfile', [DashboardClientController::class, 'partenaireProfile'])->name('partenaire-Profile');
//route to home page
Route::get('/home',[LoginController::class,'home'])->name('home');

// part_search
Route::get('/partenaireSearch', [DashboardClientController::class, 'part_search'])->name('part_search');
//demande_search
Route::get('/demandeSearch', [DashboardClientController::class, 'demande_search'])->name('demande_search');


// Route to the dashboard index which shows the counts
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/admin/clients', [DashboardAdminController::class, 'showClients'])->name('admin.clients');
Route::get('/partenaires', [DashboardAdminController::class, 'showPartenaires'])->name('partenaires.show');
Route::get('/interventions',[DashboardAdminController::class, 'showInterventions'])->name('interventions.show');
// Routes for Client activation and deactivation
Route::post('/clients/{id}/activate', [DashboardClientController::class, 'activate'])->name('clients.activate');
Route::post('/clients/{id}/deactivate', [DashboardClientController::class, 'deactivate'])->name('clients.deactivate');

// Routes for Partenaire activation and deactivation
Route::post('/partenaires/{id}/activate', [PartenaireController::class, 'activate'])->name('partenaires.activate');
Route::post('/partenaires/{id}/deactivate', [PartenaireController::class, 'deactivate'])->name('partenaires.deactivate');
Route::get('/partenaires/search', [DashboardAdminController::class, 'searchPartenaires'])->name('partenaires.search');

Route::get('/clients/search', [DashboardAdminController::class, 'searchClients'])->name('clients.search');






Route::get('/profile', [PartenaireController::class, 'ProfileForm'])->name('partenaire_profile');

//complete_profile_par
Route::post('/complete_profile_par', [DashboardPartenaireController::class, 'complete_profile_par'])->name('complete_profile_par');
//complete_profile

Route::get('/complete_profile', [PartenaireController::class, 'complete_profile'])->name('complete_profile');
//view de modification de profile partenaire
Route::get('/edit_profile_par', [PartenaireController::class, 'editProfilePartenaire'])->name('edit-profile_par');
//update de profile partenaire dans DB
Route::put('/update-profile-partenaire', [DashboardPartenaireController::class, 'updateProfilePartenaire'])->name('update-profile-partenaire');

//
Route::get('/partenaire_info/{id}', [DashboardClientController::class, 'partenaire_info'])->name('partenaire-info');
Route::get('/partner/demandes', [PartenaireController::class,'showDemandes'])->name('partner.demandes');
Route::get('/reservations/{id}/accept', [ServiceController::class,'accept'])->name('reservation.accept');
Route::get('/reservations/{id}/refuse', [ServiceController::class,'refuse'])->name('reservation.refuse');

//Comments
Route::post('/store', [CommentsController::class, 'store'])->name('commentaires.store');
Route::post('/store_par', [CommentsController::class, 'store_par'])->name('store_par');
Route::get('/comments_par', [CommentsController::class, 'expertComments'])->name('comments_par');


// Routes de traitement de interventions de partenaire
/* Afficher les interventions */
Route::get('/interventions_partenaire', [InterventionsPartenaireController::class, 'interventionsPartenairePage'])->name('interventions_partenaire');
/* Rechercher les interventions */
Route::get('/search-reservations', [InterventionsPartenaireController::class, 'search'])->name('search-reservations');




// Routes de traitement des reclamations
// Partenaire
/* Afficher la section */
Route::get('/reclamations_partenaire', [ReclamationsPartenaireController::class, 'reclamationsPartenairePage'])->name('reclamations_partenaire');
/* Soumettre la reclamation */
Route::post('/submit-complaint', [ReclamationsPartenaireController::class, 'submitComplaint'])->name('submit-complaint');

// Client
/* Afficher la section */
Route::get('/reclamations_client', [ReclamationsClientController::class, 'reclamationsClientPage'])->name('reclamations_client');
/* Soumettre la reclamation */
Route::post('/submit-complaint', [ReclamationsClientController::class, 'submitComplaint'])->name('submit-complaint');
