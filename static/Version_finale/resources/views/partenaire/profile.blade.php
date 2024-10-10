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
            <div class="img-container">
                <img src="{{ asset('uploads/partenaire/' . session('photo_par')) }}" alt="photo_par" class="w-100 border-radius-lg shadow-sm">
            </div>
            <div class="posts-info">
                <p class="info full-name">{{ session('nom_par') }} {{ session('prenom_par') }}</p>
                <br>
                <p><span>Ville: </span> {{ session('ville_par') }}</p>
                <br>
                <p><span>Email: </span> {{ session('email_par') }}</p>
                <br>
                <p><span>Nombre d'année d'expérience: </span> {{ session('nbr_experience') }} ans</p>
                <br>
                <p><span>Domaine expertise: </span>{{ session('domaine_expertise') }}</p>
                {{-- Display services --}}
                <br>
                <p><strong>Services:</strong></p>
                <br>
                @foreach ($services as $service)
                    <p><span>Nom du service: </span>{{ $service->nom_service }}</p>
                    <br>
                    <p><span>Créneau de disponibilité: </span>{{ $service->crenau_dispo }}</p>
                    <br>
                    <p><span>Prix: </span>{{ $service->prix }}</p>
                    <br>
                    <hr> <!-- Optional: Add a horizontal line between services -->
                @endforeach
            </div>

            <!-- Container for buttons -->
            <div class="pip">
                <a href={{ route('edit-profile_par') }}>
                    <button class="action message">Modifier</button>
                </a>
           
            </div>
        </div>
    </main>
</section>
