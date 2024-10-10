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
    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-lg-3">
             
            </div>
            <div class="col-lg-6"> <!-- Adjust the size according to your layout -->
                <div class="card border border-primary shadow-lg">
                    <div class="card-header bg-primary text-white">Add Service</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('services.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="service" class="form-label">Service</label>
                                <select id="service" class="form-select" name="service" required>
                                    <option value="Tache Menagiere">Jardinage</option>
                                    <option value="Bricolage">Bricolage</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="date_reservation" class="form-label">Date Reservation</label>
                                <input id="date_reservation" type="date" class="form-control" name="date_reservation" required>
                            </div>
                            <div class="mb-3">
                                <label for="heure" class="form-label">Heure</label>
                                <input id="heure" type="time" class="form-control" name="heure" required>
                            </div>
                            <div class="mb-3">
                                <label for="partenaire" class="form-label">Partenaire</label>
                                <select id="partenaire" class="form-select" name="partenaire" required>
                                    @foreach($partenaires as $partenaire)
                                        <option value="{{ $partenaire->id }}">{{ $partenaire->nom_par }} {{ $partenaire->prenom_par }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Service</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

