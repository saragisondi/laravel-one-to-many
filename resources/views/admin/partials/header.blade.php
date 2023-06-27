<nav class="bg-dark navbar navbar-expand-md navbar-dark">
  <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
          LOGO
          {{-- config('app.name', 'Laravel') --}}
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav me-auto">
              <li class="nav-item">
                  <a class="nav-link fw-bold" href="{{ route('home')}}">{{'Home'}}</a>
              </li>
          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="ml-auto navbar-nav">
              <!-- Authentication Links -->
              @guest
              <li class="nav-item">
                  <a class="nav-link fw-bold" href="{{ route('login') }}"> Login </a>
              </li>
              @if (Route::has('register'))
              <li class="nav-item">
                  <a class="nav-link fw-bold" href="{{ route('register') }}"> Registrati </a>
              </li>
              @endif
              @else
              <li class="nav-item dropdown">

                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button class="mx-3 btn btn-secondary" type="submit" title="Logout"><i class="fa-solid fa-right-from-bracket"></i></button>
              </form>

              </li>
              @endguest
          </ul>
      </div>
  </div>
</nav>
