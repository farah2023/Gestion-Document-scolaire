@extends('layouts.app1')

@section('content')



<section class="" style ="background-color: #f9fbfc ;">
  <!-- New field for choosing user type -->

  <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 ">

    <div class="container" style="margin-top:20px; margin-left:450px;  >
      <div class="row justify-content-center">
        <div class="col-lg-5 text-center mx-auto">
          <h1 style="color:#fd7e14;  font-size:50px; ">Welcome</h1>
          <p style="color:black; font-size:15px; font-weight: bold; ">Register now to get services and sell your experience for free </p>
        </div>
      </div>
      <div class="alerts-container">

                        @if (Session::has('errorRegister'))
                            <div class="alert alert-danger" role="alert">
                                {{ Session::get('errorRegister') }}
                            </div>
                        @endif
                    </div>

  <div class="container-fluid" style="margin-top:20px; margin-left:380px; width:680px; background-color: white ;">
    <div style=" margin-left:130px; height:400px;" >
        <div class="col-xl-4 col-lg-7 col-md-5">
            <div class="card z-index-0">
                <div class="card-body">
            <form role="form text-left" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <br>
                <label for="user_type" class="form-label" style="color: black ;">I am :     </label>
                <select class="form-select" id="user_type" name="user_type">
                  <!-- Ajouter ici pour choisir -->

                  <option value="choisir">Choose</option>
                  <option value="partner">Partner</option>
                  <option value="client">Client</option>
                </select>
              </div>
              <br>
              <div class="client-fields" style="display: none; color:black" > <!-- Conditional client fields -->
                <div class="mb-3">
                  <label for="nom_cl"> First Name: </label>
                  <input type="text" class="form-control" placeholder="" aria-label="Nom" aria-describedby="nom-addon" name="nom_cl" id="nom_cl">
                </div>
                <div class="mb-3">
                  <label for="prenom_cl">Last Name: </label>
                  <input type="text" class="form-control" placeholder="" aria-label="Prénom" aria-describedby="prenom-addon" name="prenom_cl" id="prenom_cl">
                </div>
                <div class="mb-3">
                  <label for="photo_cl">Picture:</label>
                  <input type="file" class="form-control" id="photo_cl" name="photo_cl" accept="image/*">
                </div>
                <div class="mb-3">
                    <label for="Ville"> City:</label>
                    <input type="text" class="form-control" placeholder="" aria-label="Ville" aria-describedby="ville-addon" name="Ville" id="VSille">
                  </div>
                <div class="mb-3">
                  <label for="adresse"> Adress:</label>
                  <input type="text" class="form-control" placeholder="Adresse" aria-label="Adresse" aria-describedby="adresse-addon" name="adresse" id="adresse">
                </div>
                <div class="mb-3">
                  <label for="telephone">Phone: </label>
                  <input type="tel" class="form-control" placeholder="06xxxxxx" aria-label="Téléphone" aria-describedby="telephone-addon" name="telephone" id="telephone">
                </div>
              </div>
              <!-- End of conditional client fields -->

              <div class="partner-fields" style="display: none; color:black"> <!-- Conditional partner fields -->
                <div class="mb-3">
                  <label for="nom_par">Last Name:</label>
                  <input type="text" class="form-control" placeholder="" aria-label="Nom" aria-describedby="nom-addon" name="nom_par" id="nom_par">
                </div>
                <div class="mb-3">
                  <label for="prenom_par">First Name:</label>
                  <input type="text" class="form-control" placeholder="" aria-label="Prénom" aria-describedby="prenom-addon" name="prenom_par" id="prenom_par">
                </div>
                <div class="mb-3">
                  <label for="photo_par">Picture:</label>
                  <input type="file" class="form-control" id="photo_par" name="photo_par" accept="image/*">
                </div>
                <div class="mb-3">
                  <label for="ville"> City:</label>
                  <input type="text" class="form-control" placeholder="" aria-label="Ville" aria-describedby="ville-addon" name="ville" id="ville">
                </div>

                <div class="mb-3">
                  <label style="color :black;" for="nbr_experience"> Number of years of experience:</label>
                  <input type="number" class="form-control" placeholder="xx" aria-label="Nombre d'expérience" aria-describedby="experience-addon" name="nbr_experience" id="nbr_experience" min="0" max="30">
                </div>


                        <div class="mb-3">
                            <label for="domaine_expertise" class="form-label">Expertise field :</label>
                            <div class="form-select" id="domaine_expertise" name="domaine_expertise">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="jardinage" name="domaine_expertise[]" value="jardinage">
                                    <label class="form-check-label" for="jardinage">Gardening</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="bricolage" name="domaine_expertise[]" value="bricolage">
                                    <label class="form-check-label" for="bricolage">DIY</label>
                                </div>
                            </div>
                        </div>

                  </div>
                </div>
              </div>

              <!-- End of conditional partner fields -->

              <!-- Common fields for both client and partner -->
              <div class="mb-3" style="color:black;">
                <label for="email"> Email :</label>
                <input type="email" class="form-control" placeholder="Ex:nom@gmail.com" aria-label="Email" aria-describedby="email-addon" name="email" id="email">
                @error('email')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
              </div>
              <div class="mb-3" style="color:black;">
                <label for="password">Password :</label>
                <input type="password" class="form-control" placeholder="******" aria-label="Password"
                  aria-describedby="password-addon" name="password" id="password">
                @error('password')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
              </div>
              <div class="form-check form-check-info text-left">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked name="agreement">
                <label class="form-check-label" for="flexCheckDefault">
                    <br>
                   <p " class="text-dark font-weight-bolder" style=" font-size:12px;"> I agree to the Terms and
                    Conditions</p>
                </label>
              </div>
              <br>
              <div class="text-center">
                <button type="submit" class="btn btn-orange w-100 my-4 mb-2">Sign up</button>
              </div>
              <br>
              <p class="text-sm mt-3 mb-0">Already have an account? <a href="{{ route('login') }}"
                  class="text-dark font-weight-bolder" >Sign in</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    $('#user_type').change(function () {
      var userType = $(this).val();
      if (userType === 'partner') {
        $('.client-fields').hide();
        $('.partner-fields').show();
      } else if (userType === 'client') {
        $('.partner-fields').hide();
        $('.client-fields').show();
        // Ajouter ici l'option de ni client ni partner avant de choisir pour remplir
      } else if (userType === 'choisir') {
        $('.partner-fields').hide();
        $('.client-fields').hide();
      }
    });
  });
</script>
</section>

@endsection
