@extends('layouts.app')

@section('content')

<div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
    <span class="mask bg-gradient-dark opacity-6"></span>
    <div class="container my-auto">
      <div class="row">
        <div class="col-lg-4 col-md-8 col-12 mx-auto">
          <div class="card z-index-0 fadeIn3 fadeInBottom">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Forgot your password?</h4>
                <div class="row mt-3">
                  <div class="col-2 text-center ms-auto">
                    <a class="btn btn-link px-3" target="_blank" href="https://www.facebook.com/HenriqueSalesOP/">
                      <i class="fa fa-facebook text-white text-lg"></i>
                    </a>
                  </div>
                  <div class="col-2 text-center px-1">
                    <a class="btn btn-link px-3" target="_blank" href="https://github.com/henriquesalesmg">
                      <i class="fa fa-github text-white text-lg"></i>
                    </a>
                  </div>
                  <div class="col-2 text-center me-auto">
                    <a class="btn btn-link px-3" target="_blank" href="https://www.linkedin.com/in/henrique-sales-mg/">
                      <i class="fa fa-linkedin text-white text-lg"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}" class="text-start">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <div class="input-group input-group-outline my-3">
                  <label class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" :value="old('email')" required autofocus>
                </div>
                <div class="input-group input-group-outline mb-3">
                  <label class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" required autocomplete="new-password" >
                </div>
                <div class="input-group input-group-outline mb-3">
                  <label class="form-label">Confirm Password</label>
                  <input type="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="new-password" >
                </div>
                <div class="text-center">
                  <button type="submit" class="btn bg-primary text-white w-100 my-4 mb-2">Sign in</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="footer position-absolute bottom-2 py-2 w-100">
      <div class="container">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-12 col-md-6 my-auto">
            <div class="copyright text-center text-sm text-white text-lg-start">
              © <script>
                document.write(new Date().getFullYear())
              </script>, Henrique Sales Developer
            </div>
          </div>
          <div class="col-12 col-md-6">
            </ul>
          </div>
        </div>
      </div>
    </footer>
  </div>
@endsection
