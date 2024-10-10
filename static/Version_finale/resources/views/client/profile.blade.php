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
 <main>



<div class="profile-container" >
<div class="img-container">
    <img src="{{ asset('uploads/client/' . session('photo_cl')) }}" alt="photo_cl" class="w-100 border-radius-lg shadow-sm">
</div>
<p class="info full-name">{{ session('nom_cl') }} {{ session('prenom_cl') }}</p>
<p class="info place">
    <i class="fas fa-map-marker-alt"></i>
    {{ session('adresse_cl') }}
</p>

<div class="posts-info">
    <p><span>Email: </span> {{ session('email_cl') }}</p>
</div>
<div class="posts-info">
    <p><span>Tel: </span>{{ session('telephone_cl') }} </p>
</div>
<a  href={{route('edit-profile')}}>
<button class="action message">Modifier profile </button>
</a>
</div>  <br>

    </div>


</main>
<!-- MAIN -->
</section>
<!-- CONTENT -->



</body>
</html>
