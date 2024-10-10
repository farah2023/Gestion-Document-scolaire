@include('layouts.sidebar')

<section id="content">
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
                <img src="{{ asset('uploads/partenaire/' . $partenaire->photo_par) }}" alt="Partner Photo" class="w-100 border-radius-lg shadow-sm">
            </div>
            <p class="info full-name">{{ $partenaire->nom_par }} {{ $partenaire->prenom_par }}</p>
            <div class="posts-info">
                <p><span>City: </span> {{ $partenaire->ville }}</p>
            </div>
            <div class="posts-info">
                <p><span>Email: </span> {{ $partenaire->email }}</p>
            </div>
            <div class="posts-info">
                <p><span>Number of years of experience: </span>{{ $partenaire->nbr_experience }}</p>
            </div>
            <div class="posts-info">
                <p><span>Expertise field: </span>{{ $partenaire->domaine_expertise }}</p>
            </div>
            <!-- Display services -->
            <div class="services-container">
                <h3>Services</h3>
                <div class="service-columns">
                    @foreach ($services as $service)
                    <div class="service-box">
                        <p><strong>Nom du service:</strong> {{ $service->nom_service }}</p>
                        <p><strong>Créneau de disponibilité:</strong> {{ $service->creneau_dispo }}</p>
                        <p><strong>Prix:</strong> {{ $service->prix }}</p>
                        <button class="action message">Reserver</button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</section>
