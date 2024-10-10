@include('layouts.sidebar')

<section id="content">
    <!-- NAVBAR -->
    <nav>
        <i class='bx bx-menu'></i>

        <form action="#" method="GET">

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
                <h1>Expert's Comments</h1>
            </div>
        </div>

        <div class="table-data">
            <div class="order">
                <table>
                    <thead>
                        <tr>
                            <th>Expert's First Name</th>
                            <th>Expert's Last Name</th>
                            <th>Expert's Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($comments as $comment)
                            <tr>
                                <td>{{ $comment['nom'] }}</td>
                                <td>{{ $comment['prenom'] }}</td>
                                <td>{{ $comment['commentaire'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No Available Comments.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </main>

