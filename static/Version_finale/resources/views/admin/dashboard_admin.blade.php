		<!-- NAVBAR -->
		@include('layouts.sidebar_admin')
		<section id="content">
			<!-- NAVBAR -->
			
		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>

				</div>

			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-business'></i></i>
					<span class="text">
						<h3>{{ $partenaireCount }}</h3>
						<p>Partenaires</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-user-circle'></i> </i>
					<span class="text">
						<h3>{{ $clientCount }}</h3>
						<p>Clients</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-wrench'></i>
					<span class="text">
						<h3>{{ $interventionCount }}</h3>
						<p>Interventions</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-comment-detail'></i>
					<span class="text">
						<h3>{{ $commentCount }}</h3>
						<p>Commentaires Client</p>
					</span>
				</li>
				<li>
					'<i class='bx bxs-user-voice'></i>
					<span class="text">
						<h3>{{ $expertCommentCount }}</h3>
						<p>Commentaires Expert</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-hand-right'></i>
					<span class="text">
						<h3>{{ $demandeCount }}</h3>
						<p>Demandes</p>
					</span>
				</li>
			</ul>
			


			<div class="table-data">

			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->



</body>
</html>
