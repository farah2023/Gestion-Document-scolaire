<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partenaires List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Custom CSS if needed like in the Clients -->
    {{-- <link href="{{ asset('/assets/css/custom.css') }}" rel="stylesheet"> --}}
</head>
<body>
    <div class="container-fluid">
        @include('layouts.sidebar_admin')
        <!-- Sidebar -->
    </div>

    <!-- Content -->
    <section id="content">
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="nav-link"></a>
            <form action="{{ route('partenaires.search') }}" method="GET">
                <div class="form-input">
                    <input type="search" name="search" placeholder="Search partenaires..." value="{{ request('search') }}">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
        </nav>
        <!-- Main Content Area -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Partenaires List</h1>
                </div>
            </div>
            <div class="table-responsive">
                <div class="table-data">
                    <div class="order">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>City</th>
                                    <th>Profession</th>
                                    <th>Domain of Expertise</th>
                                    <th>Average Note</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($partenaires as $partenaire)
                                    <tr>
                                        <td>{{ $partenaire->nom_par }} {{ $partenaire->prenom_par }}</td>
                                        <td>{{ $partenaire->email }}</td>
                                        <td>{{ $partenaire->ville }}</td>
                                        <td>{{ $partenaire->metier }}</td>
                                        <td>{{ $partenaire->domaine_expertise }}</td>
                                        <td>{{ number_format($partenaire->average_note, 1) ?? 'N/A' }}</td>
                                        <td>
                                            <td>
                                                @if($partenaire->is_active)
                                                <form action="{{ route('partenaires.deactivate', $partenaire->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-danger"><i class="fa fa-unlock"></i></button>
                                                </form>
                                                @else
                                                <form action="{{ route('partenaires.activate', $partenaire->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-success"><i class="fa fa-lock"></i></button>
                                                </form>
                                                @endif
                                            </td>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div> 
        </main>
    </section>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
