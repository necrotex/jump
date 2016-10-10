<div class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="pull-left">CORE :: JUMP</span>
            </a>
        </div>
        <div class="navbar-collapse collapse">
            @if(Auth::check())
                <p class="navbar-text navbar-right">
                    Signed in as <strong>{{ Auth::user()->name }}</strong>
                    (<a href="{{ route('auth.logout') }}" class="navbar-link">Logout</a>)
                </p>
            @else
                <p class="navbar-text navbar-right">
                    <a href="{{ route('auth.login') }}">Login</a>
                </p>
            @endif
        </div>
    </div>
</div>