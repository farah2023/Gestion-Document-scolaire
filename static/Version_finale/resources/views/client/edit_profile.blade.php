		@include('layouts.sidebar')
        <section id="content">
            <!-- NAVBAR -->
            <nav>
                
                </form>
                <i class='bx bx-menu' ></i>
                <div style="margin-left: 800px;">
                <input type="checkbox" id="switch-mode" hidden>
                <label for="switch-mode" class="switch-mode"></label>
                </div>
               
            </nav>
            <main>
            <div class="table-data">    
     
                <div class="todo" >
   <div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h1>Modifier Profile</h1>
        </div>
            <form action="{{ route('update-profile') }}" method="POST">
                @csrf
                @method('PUT')

                  <!-- Afficher la photo du client -->
                  <div class="mb-3">
                    <label for="nom_cl" class="form-label">Photo :</label>
                    <img src="{{ asset('uploads/client/' . session('photo_cl')) }}" alt="photo_cl" class="w-9 border-radius-lg shadow-sm " style="margin: 0 0 0 280px ; border : 5px solid #fd7e14; border-radius: 50%; width:200px; height:200px;">
                    <input type="file" class="form-control" id="photo_cl" name="photo_cl" accept="image/*">
                </div>
                <!-- Champs de formulaire pour la modification du profil -->
                <div class="mb-3">
                    <label for="nom_cl" class="form-label">Nom :</label>
                    <input type="text" class="form-control" id="nom_cl" name="nom_cl" value="{{ old('nom_cl', session('nom_cl')) }}">
                </div>
                <div class="mb-3">
                    <label for="prenom_cl" class="form-label">Prenom :</label>
                    <input type="text" class="form-control" id="prenom_cl" name="prenom_cl" value="{{ old('prenom_cl', session('prenom_cl')) }}">
                </div>
                <div class="mb-3">
                    <label for="email_cl" class="form-label">Email :</label>
                    <input type="text" class="form-control" id="email_cl" name="email_cl" value="{{ old('email_cl', session('email_cl')) }}">
                </div>
                <div class="mb-3">
                    <label for="adresse_cl" class="form-label">Adresse :</label>
                    <input type="text" class="form-control" id="adresse_cl" name="adresse_cl" value="{{ old('adresse_cl', session('adresse_cl')) }}">
                </div>
                <div class="mb-3">
                    <label for="telephone_cl" class="form-label">Telephone :</label>
                    <input type="text" class="form-control" id="telephone_cl" name="telephone_cl" value="{{ old('telephone_cl', session('telephone_cl')) }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password :</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Nouveau mot de passe">
                    <!-- Champ caché pour stocker la valeur actuelle du mot de passe -->
                    <input type="hidden" name="current_password" value="{{ session('password_cl') }}">
                </div>
                
                <!-- Ajoutez d'autres champs de formulaire pour les autres informations du profil -->

                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            </form>
        </div>
    </div>
  </div>
 </div>
</div>
<main>