<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients List</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> 
    <!-- Include Custom CSS -->
    {{-- <link href="{{ asset('/assets/css/custom.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   
    
</head>
<body>
    <div class="container-fluid">
        @include('layouts.sidebar_admin')
      </div>
<!-- Sidebar -->


<!-- Content -->
<section id="content">
    <nav>
        <i class='bx bx-menu' ></i>
        <a href="#" class="nav-link"></a>
        <form action="{{ route('clients.search') }}" method="GET">
            <div class="form-input">
                <input type="search" name="search" placeholder="Search clients..." value="{{ request('search') }}">
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
                <h1>Clients List</h1>
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
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Average Note</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td>{{ $client->nom_cl }} {{ $client->prenom_cl }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->adresse }}</td>
                                <td>{{ $client->telephone }}</td>
                                <td>{{ number_format($client->average_note, 2) ?? 'Not Available' }}</td>
                                <td>
                                    @if($client->is_active)
                                    <form action="{{ route('clients.deactivate', $client->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-danger"><i class="fa fa-unlock"></i></button>
                                    </form>
                                    @else
                                    <form action="{{ route('clients.activate', $client->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-success"><i class="fa fa-lock"></i></button>
                                    </form>
                                    @endif
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
