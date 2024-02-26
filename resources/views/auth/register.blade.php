<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />

        <link rel="stylesheet" href="{{ asset('assets/estilos.css')}}">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>

    <body>
    <section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Registrate</h2>
              @if($errors->any())
              <ul>
              @foreach($errors->all() as $error)
               <li>{{ $error }}</li>
              @endforeach
              </ul>
              @endif
              <form action="{{ route('register')}}" method="post">
                @csrf
              <p class="text-white-50 mb-5">Porfavor llena los siguientes campos</p>

              <div class="form-outline form-white mb-4">
                <label class="form-label" for="typeNameX">Nombre</label>
                <input type="text" minlenght="4" maxlenght="50" name="name" id="typeNameX" value="{{ old('name') }}" class="form-control form-control-lg" />
              </div>

              <div class="form-outline form-white mb-4">
                <label class="form-label" for="typeEmailX">Correo</label>
                <input type="email" name="email" id="typeEmailX" value="{{ old('email') }}" class="form-control form-control-lg" />
              </div>

              <div class="form-outline form-white mb-4">
                <label class="form-label" for="typePasswordX">Contraseña</label>
                <input type="password" minlenght="8" maxlenght="50" name="password" id="typePasswordX" class="form-control form-control-lg"/>
              </div>
              <div class="form-outline form-white mb-4">
                <label class="form-label" for="typePasswordConX">Confirmar Contraseña</label>
                <input type="password" minlenght="8" maxlenght="50" name="password_confirmation" id="typePasswordConX" class="form-control form-control-lg"/>
              </div>
              <div class="g-recaptcha" data-sitekey="6LddkF4pAAAAAEz83TIqmCvbgQlgXKalrio0MHO_"></div>
              @if(Session::has('g-recaptcha-response'))
              <p class="alert {{Session::get('alert-class' , 'alert-info')}}">
                {{Session::get('g-recaptcha-response')}}
              </p>
              @endif
              <br/>

              <button class="btn btn-outline-light btn-lg px-5" type="submit">Registrar</button>

            </div>

            <div>
              <p class="mb-0">¿Ya tienes cuenta?<a href="{{ route('login')}}" class="text-white-50 fw-bold">Inicia sesion</a>
              </p>
            </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
