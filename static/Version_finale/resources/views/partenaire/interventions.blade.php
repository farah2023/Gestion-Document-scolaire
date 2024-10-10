@include('layouts.sidebar_par')

<section id="content">
    <!-- NAVBAR -->
    <nav>
        <i class='bx bx-menu'></i>
        <a href="#" class="nav-link">Search:</a>
        <form action="#" method="GET">
            <div class="form-input">
                <input type="search" id="searchInput" name="search" placeholder="Via duration, date..." onkeyup="searchData()">
                <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
            </div>
        </form>

        <div style="margin-left: 300px;">
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
        </div>
    </nav>

    <!-- MAIN -->
    <main>

        <!-- Reservations Section -->
        <div class="head-title">
            <div class="left">
                <h1>Interventions</h1>
            </div>
        </div>

        <div class="table-data">
            <div class="order">
                <table>
                    <thead>
                        <tr>
                            <th>ID Intervention</th>
                            <th>Duration</th>
                            <th>Date Start</th>
                            <th>Date End</th>
                            <th>Status</th>
                            <th>Client Address</th>
                            <th>Client's Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->id }}</td>
                                <td>{{ $reservation->duree }}</td>
                                <td>{{ $reservation->date_debut }}</td>
                                <td>{{ $reservation->date_fin }}</td>
                                <td>done</td>
                                <td>{{ $reservation->client->adresse ?? 'No address provided' }}</td>
                                        <!-- Afficher le commentaire du client si disponible -->
                            <td>{{ $commentairesClients[$reservation->id]->contenu ?? 'No comment available' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">No Available Intervention.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>

        let searchTimeout;

        function searchData() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                var input = document.getElementById('searchInput').value;
                console.log("Search input: ", input); // Log pour debug
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '/search-reservations?q=' + encodeURIComponent(input), true);
                xhr.onload = function() {
                    if (this.status === 200) {
                        var reservations = JSON.parse(this.responseText);
                        console.log("Data received: ", reservations); // Log pour debug
                        updateTable(reservations);
                    } else {
                        console.error("Failed to fetch data: ", this.status);
                    }
                };
                xhr.onerror = function () {
                    console.error("Request error.");
                };
                xhr.send();
            }, 300);
        }

        function updateTable(reservations) {
            var output = '';
            reservations.forEach(function(reservation) {
                output += '<tr>' +
                        '<td>' + reservation.id + '</td>' +
                        '<td>' + reservation.duree + '</td>' +
                        '<td>' + reservation.date_debut + '</td>' +
                        '<td>' + reservation.date_fin + '</td>' +
                        '<td>' + (new Date(reservation.date_fin) > new Date() ? 'en cours' : 'done') + '</td>' +
                        '<td>' + reservation.id_client + '</td>' +
                        '<td>' + (reservation.commentaire_client || '') + '</td>' +
                        '</tr>';
            });
            document.querySelector('.table-data .order table tbody').innerHTML = output;
        }

    </script>

</section>
