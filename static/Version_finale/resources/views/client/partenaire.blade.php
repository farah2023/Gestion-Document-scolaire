

    		<!-- NAVBAR -->
            @include('layouts.sidebar')
            <!-- MAIN -->
            <section id="content">
                <!-- NAVBAR -->
                <nav>
                    <i class='bx bx-menu' ></i>
                    <a href="#" class="nav-link">Search :</a>
                    <form action="{{route('part_search')}}" method="GET">
                        <div class="form-input" >
                            <input type="search"  name="search" placeholder="">
                            <button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
                        </div>
                    </form>
                    <input type="checkbox" id="switch-mode" hidden>
                    <label for="switch-mode" class="switch-mode"></label>

                </nav>
            <main>

                <div class="table-data">

                    <div class="order">


                    <table>
                        <thead>
                            <tr>
                                <th>Profil </th>
                                <th>Last Name </th>
                                <th>First Name </th>
                                <th>City  </th>
                                <th>Number of years of experience  </th>
                                <th>Action </th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($partenaire as $p)
                            <tr>
                                <td> <img src="{{ asset('uploads/partenaire/' . $p->photo_par) }}" alt="profile image"></td>
                                <td>{{ $p->nom_par }}</td>
                                <td>{{ $p->prenom_par }}</td>
                                <td>{{ $p->ville }}</td>
                                <td>{{ $p->nbr_experience }} ans</td>
                                <td>
                                    <a href="{{ route('partenaire-info', $p->id) }}" class="status completed">Profil</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                </div>

            </main>
            <!-- MAIN -->
        </section>
        <!-- CONTENT -->


    </body>
    </html>
