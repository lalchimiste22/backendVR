<ul class="nav navbar-nav navbar-right">
    <li>
        <div class="text-center"><span class="navbar-text">¿Ya tienes una cuenta?</span></div>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle text-center" data-toggle="dropdown">Ingresar</a>
        <ul class="login-dropdown dropdown-menu">
            <li>
                <div class="row">
                    <div class="col-xs-12">
                        <span>Ya tengo una cuenta</span>
                        {!! Form::open(['url' => 'login']) !!}
                        <div class="form-group">
                            {!! Form::text('email','', ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::password('password',['placeholder' => 'Password', 'class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Ingresar',['class'=> 'btn btn-primary btn-block']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-xs-12 text-center nav-register">
                        <span>Soy nuevo: <a href="/register">Registrarse</a></span>
                    </div>
                </div>
            </li>
        </ul>
    </li>
</ul>