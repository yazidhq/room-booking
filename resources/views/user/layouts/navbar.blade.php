<nav class="navbar navbar-expand-lg bg-dark-blue fixed-top">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="/">RESERVASI RUANG</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
            <ul class="navbar-nav">
                @if (auth()->user())
                    <li class="nav-item">
                        <a class="nav-link text-white active fw-bold" aria-current="page"
                            href={{ route('login') }}>{{ Str::upper(auth()->user()->name) }}</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="nav-link fw-bold text-warning">LOGOUT</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-white active fw-bold" aria-current="page"
                            href={{ route('login') }}>LOGIN</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
