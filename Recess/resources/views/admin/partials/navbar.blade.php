<header class="border-bottom px-4 bg-secondary d-flex align-items-center justify-content-between">
    <div>
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="" width="40">
            <h4 class="text-primary mt-4">Uprise <br /> Sacco</h4>
        </a>
    </div>
    <div class="d-flex align-items-center gap-2">


        <div>
            <a class="btn btn-primary rounded-5 text-white" href="{{ route('logout') }}" onclick="event.preventDefault();
      document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>

        </div>
        <div class="btn btn-primary rounded-5 d-flex align-items-center">
            <a class="text-white text-decoration-none" href="{{route('admin.member.create')}}">{{ __('Register a
                Member') }}</a>
        </div>
    </div>
</header>