@extends('layouts.app1')

@section('content')

<section class="" style ="background-color: #f9fbfc ;">

    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 ">

        <div class="container" style="margin-top:20px; margin-left:450px; " >

            <div class="col-lg-5 text-center mx-auto">
                        <h1 style="color:#fd7e14;  font-size:50px; ">Welcome back</h1>
                      </div>

                </div>
                <div class="alerts-container">
                    @if (Session::has('successRegisterClient'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('successRegisterClient') }}
                    </div>
                    @elseif (Session::has('successRegisterPartenaire'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('successRegisterPartenaire') }}
                    </div>

                @endif
                @if (Session::has('errorLogin'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ Session::get('errorLogin') }}
                                    </div>
                                @elseif (Session::has('successLoginClient'))
                                    <div class="alert alert-success" role="alert">
                                        {{ Session::get('successLoginClient') }}
                                    </div>
                                    @elseif (Session::has('successLoginPartenaire'))
                                        <div class="alert alert-success" role="alert">
                                            {{ Session::get('successLoginPartenaire') }}
                                        </div>
                                    @endif
                                    </div>
  <div class="container-fluid" style="margin-top:20px; margin-left:380px; width:680px; background-color: white ;">
                                        <div style=" margin-left:130px; height:400px;" >
                                            <div class="col-xl-4 col-lg-7 col-md-5">
                                                <div class="card z-index-0">
                                                    <br>
                <div class="card-body">
                  <form role="form" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" style="color: black;">Email :</label>

                      <input type="email" class="form-control" name="email" id="email" placeholder="email@gmail.com" value="" aria-label="Email" aria-describedby="email-addon">
                      @error('email')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                      @enderror
                    </div>
                    <br>
                    <div class="mb-3">
                    <label  for="password" style="color: black; ">Password :</label>

                      <input type="password" class="form-control" name="password" id="password" placeholder="******"  aria-label="Password" aria-describedby="password-addon">
                      @error('password')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                      @enderror
                    </div>
                    <br>

                    <div class="text-center">
                      <button type="submit" class="btn btn-orange w-100 my-4 mb-2">Sign in</button>
                    </div>
                    <br>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">

                  <p class="mb-4 text-sm mx-auto">
                    Don't have an account?
                    <a href="register" class="text-info  font-weight-bold" style="color: #ff5e14 !important">Sign up</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('../assets/img/curved-images/curved6.jpg')"></div>

      </div>
    </div>
  </div>
</div>
</div>
</div>
</section>

@endsection
