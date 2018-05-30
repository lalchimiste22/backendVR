<!-- create the navbar -->
<nav class="navbar no-padding navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">VrForKids</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="text-center {{Request::is('/') ? 'active' : ''}}">
                    <a href="/">Inicio</a>
                </li>

                @if(Auth::check() && Auth::user()->isAdmin())
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administración <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/recursos">Recursos</a></li>
                    </ul>
                </li>
                @endif

            </ul>

            <!-- User Login Form-->
            @if(Auth::check())
                @include('includes.navbar_user')
            @endif
        </div>
    </div>
</nav>