<nav style="position:fixed; margin:100%;" class="navbar navbar-expand-md bg-secondary p-0 m-0">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="" width="30">
            <h5 class="text-primary mt-4 ">Uprise <br /> Sacco</h5>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto d-flex gap-3">
                <!-- Authentication Links -->
                @guest
                @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link btn btn-primary text-white" href="{{ route('login') }}">{{ __('Login')
                        }}</a>
                </li>
                @endif
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>