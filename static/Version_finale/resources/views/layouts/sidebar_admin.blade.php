<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">


	<!-- My CSS -->
	<link rel="stylesheet" href="../assets/css/style.css">
    {{-- <link rel="stylesheet" href="../assets/css/style2.css"> --}}
    <link rel="stylesheet" href="../assets/css/style3.css">
	<link rel="stylesheet" href="../assets/css/style4.css">

	<title>AlloExpert</title>
	<style>
		#sidebar a:hover {
  text-decoration: none; /* Removes the underline */
  color: inherit; /* Keeps the text color the same as non-hover state */
}
	</style>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<span ><img class="logo1" src="../alloexpert/assets/images/logo1.png" alt=""></span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="{{ route('dashboard_admin') }}">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="{{ route('interventions.show') }}">
					<i class='bx bxs-wrench' ></i>
					<span class="text">Interventions</span>
				</a>
			</li>
			<li>
				<a href="{{ route('admin.clients') }}">
					<i class='bx bxs-user-circle' ></i>
					<span class="text">Clients</span>
				</a>
			</li>
			<li>
				<a href="{{	route('partenaires.show')}}">
					<i class='bx bxs-business' ></i>
					<span class="text">Partenaires</span>
				</a>
			</li>
			
		</ul>
		<ul class="side-menu">

			<li>
				<form action="{{ route('logout') }}" method="POST">
					@csrf
					@method('DELETE')
				<a  class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<button type="submit"  style="background: none; border: none;">
					<span class="text">se deconnecter</span>
					</button>
				</a>
				</form>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->


    <script src="../assets/js/script.js"></script>
	<!-- CONTENT -->


