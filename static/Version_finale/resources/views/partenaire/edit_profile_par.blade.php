@include('layouts.sidebar_par')

<section id="content">
    <!-- NAVBAR -->
    <nav>
        <i class='bx bx-menu'></i>
        <div style="margin-left: 800px;">
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
        </div>
    </nav>

    <main>
        <div class="profile-container">
             <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1>Modifier Profile</h1>
                </div>
                <form action="{{ route('update-profile-partenaire') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Display partenaire photo -->
                    <div class="mb-3">
                        <label for="photo_par" class="form-label">Photo :</label>
                        <img src="{{ asset('uploads/partenaire/' . session('photo_par')) }}" alt="photo_par" class="w-9 border-radius-lg shadow-sm" style="margin: 0 0 0 280px ; border : 5px solid #fd7e14; border-radius: 50%; width:200px; height:200px;">
                        <input type="file" class="form-control" id="photo_par" name="photo_par" accept="image/*">
                    </div>

                    <!-- Form fields for partenaire's personal information -->
                    <div class="mb-3">
                        <label for="nom_par" class="form-label">Nom :</label>
                        <input type="text" class="form-control" id="nom_par" name="nom_par" value="{{ old('nom_par', session('nom_par')) }}">
                    </div>
                    <div class="mb-3">
                        <label for="prenom_par" class="form-label">Prenom :</label>
                        <input type="text" class="form-control" id="prenom_par" name="prenom_par" value="{{ old('prenom_par', session('prenom_par')) }}">
                    </div>
                    <div class="mb-3">
                        <label for="email_par" class="form-label">Email :</label>
                        <input type="text" class="form-control" id="email_par" name="email_par" value="{{ old('email_par', session('email_par')) }}">
                    </div>
                    <div class="mb-3">
                        <label for="ville_par" class="form-label">Ville :</label>
                        <input type="text" class="form-control" id="ville_par" name="ville_par" value="{{ old('ville_par', session('ville_par')) }}">
                    </div>
                    <div class="mb-3">
                        <label for="nbr_experience" class="form-label">Nombre d'année d'expérience :</label>
                        <input type="text" class="form-control" id="nbr_experience" name="nbr_experience" value="{{ old('nbr_experience', session('nbr_experience')) }}">
                    </div>
                    <div class="mb-3">
                        <label for="domaine_expertise" class="form-label">Domaine d'expertise :</label>
                        <input type="text" class="form-control" id="domaine_expertise" name="domaine_expertise" value="{{ old('domaine_expertise', session('domaine_expertise')) }}">
                    </div>

                    <!-- Form fields for updating services -->
                    <h2>Modifier Services</h2>
                    @foreach ($services as $service)
                        <div class="mb-3">
                            <label for="nom_service_{{ $service->id }}" class="form-label">Nom du service {{ $loop->iteration }} :</label>
                            <input type="text" class="form-control" id="nom_service_{{ $service->id }}" name="nom_service_{{ $service->id }}" value="{{ old('nom_service_' . $service->id, $service->nom_service) }}">
                        </div>
                        <div class="mb-3">
                            <label for="creneau_dispo_{{ $service->id }}" class="form-label">Créneau de disponibilité {{ $loop->iteration }} :</label>
                            <input type="text" class="form-control" id="creneau_dispo_{{ $service->id }}" name="creneau_dispo_{{ $service->id }}" value="{{ old('creneau_dispo_' . $service->id, $service->crenau_dispo) }}">
                        </div>
                        <div class="mb-3">
                            <label for="prix_{{ $service->id }}" class="form-label">Prix du service {{ $loop->iteration }} :</label>
                            <input type="text" class="form-control" id="prix_{{ $service->id }}" name="prix_{{ $service->id }}" value="{{ old('prix_' . $service->id, $service->prix) }}">
                        </div>
                    @endforeach

                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </form>
            </div>
        </div>
        
        <!-- Profile update form -->
       
        </div>
    </main>
</section>
