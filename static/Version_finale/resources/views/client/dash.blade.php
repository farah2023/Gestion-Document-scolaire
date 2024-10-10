		<!-- NAVBAR -->
		@include('layouts.sidebar')
		<section id="content">
			<!-- NAVBAR -->
			<nav>
				<i class='bx bx-menu' ></i>
				<a href="#" class="nav-link">Search:</a>
				<form action="#">
					<div class="form-input">
						<input type="search" placeholder="">
						<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
					</div>
				</form>
				<input type="checkbox" id="switch-mode" hidden>
				<label for="switch-mode" class="switch-mode"></label>


			</nav>
		<!-- MAIN -->
		<main>
			<div class="head-title">


			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-calendar-check' ></i>
					<span class="text">
						<h3>{{ $totalReservations }}</h3>
						<p>Requests</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-calendar-check' ></i>
					<span class="text">
						<h3>{{ $treatedReservations }}</h3>
						<p>Intervenions</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-group' ></i>
					<span class="text">
						<h3>{{ $totalPartenaires }}</h3>
						<p>Partners</p>
					</span>
				</li>
				<li>
                    <a href="#" >
                        <i class='bx bxs-group'></i></a>
                        <span class="text">
                            <h3>{{ $totalComments }}</h3>
                            <p>Comments</p>
                        </span>

				</li>

			</ul>
<br>
@foreach ($reservations as $reservation)
@if ($reservation->service && $reservation->service->partenaire)
    <div class="card shadow mb-4" style="margin-left: 280px; background-color: var(--light);"> <!-- Utilise 'card' et 'shadow' pour un effet de cadre et d'ombre -->
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add your Comment NOW !!!</h6>
        </div>
        <div class="card-body">
            <p>Your request for the service <strong>{{ $reservation->service->name_service }}</strong> by the expert <strong>{{ $reservation->service->partenaire->prenom_par }} {{ $reservation->service->partenaire->nom_par }}</strong> has finished. You can now leave a comment.</p>
                    <a href="#" class="show-comment-form icon-link" data-id="{{ $reservation->id }}"><i class="fas fa-comments"></i></a>
        </div>

                    <!-- Superposition modale pour le formulaire -->
                    <div id="modal{{ $reservation->id }}" class="modal" style="display: none;">
                        <form id="commentForm{{ $reservation->id }}" method="POST" class="comment-form" action="{{ route('commentaires.store') }}">
                            @csrf
                            <input type="hidden" name="id_reservation" value="{{ $reservation->id }}">
                            <label for="contenu"> Your comment :</label>
                            <textarea name="contenu" id="contenu{{ $reservation->id }}" rows="3" cols="50"></textarea>
                            <label for="note">Note :</label>
                            <select name="note" id="note{{ $reservation->id }}">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <button type="submit" class="btn btn-primary submit-comment">Send</button>
                        </form>
                    </div>
                @else
                    <p>Service or customer information not available.</p>
                @endif
            </div>
        </div>
        @endforeach




</main>
<!-- MAIN -->
</section>
<script>
$(document).ready(function() {
    $('.show-comment-form').click(function() {
        var reservationId = $(this).data('id');
        $('#modal' + reservationId).fadeIn();
    });

    $('.modal').click(function(e) {
        if (e.target === this) {
            $(this).fadeOut();
        }
    });

    $('.comment-form').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: '{{ route('commentaires.store') }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                console.log(response);
                alert('Commentaire ajouté avec succès !');
                // $('.modal').fadeOut(); // Masquer la superposition modale après soumission
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Une erreur s\'est produite. Veuillez réessayer plus tard.');
            }
        });
    });
});
</script>
</body>
</html>
