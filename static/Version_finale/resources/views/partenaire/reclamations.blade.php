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
    <main style="display: flex; justify-content: center; align-items: flex-start; height: 100vh; overflow: auto;">
        <div class="profile-container" style="width: 100%; max-width: 600px; padding: 20px;">
            <div style="text-align: center;"> <!-- Div pour centrer l'image -->
                <img src="{{ asset('alloexpert/assets/images/complaint.png') }}" style="width: 160px; height: 160px;"><br>
            </div>
            
            <!-- Check for success message and display it -->
            @if (session('success'))
                <div style="color: green; font-size: 18px; margin-bottom: 20px; text-align:center;">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Form for claim submission -->
            <form action="{{ route('submit-complaint') }}" method="post" style="text-align: left;">
                @csrf
                <h2 style="text-align: center">Complaint's Submission :</h2><br>
                <b>For which reason do you choose to submit that complaint?</b><br><br>
                <div style="margin-bottom: 10px;">
                    <label><input type="radio" name="claim_type" value="Non-payment for services rendered"> Non-payment for services rendered</label><br>
                    <label><input type="radio" name="claim_type" value="Uncompensated overtime"> Uncompensated overtime</label><br>
                    <label><input type="radio" name="claim_type" value="Late cancellation"> Late cancellation</label><br>
                </div>
                <br>
                <div style="margin-bottom: 10px;">
                    <label for="client_address"><b>Select client address:</b></label>
                    <select name="client_address" id="client_address" style="width: 100%; height: 50px; margin: 20px 0; background-color: lightgray; font-size: 16px;">
                        <option value="choose">Choose</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->adresse }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="submit" value="Submit Complaint" class="action message" style="width: 100%; height: 50px; margin: 20px 0; font-size: 16px;">
                {{-- <input type="submit" value="Submit Complaint" class="action message"> --}}
            </form>
        </div>        
    </main>
</section>
