<ul class="nav navbar-nav navbar-right">
    <li>
        <a href="/user/profile"><div class="text-center"><span class="glyphicon glyphicon-user"></span> {!! Auth::user()->nombre !!}</div></a>
    </li>
    <li>
        <span class="hidden-xs navbar-text">|</span>
    </li>
    <li>
        {!! Form::open(['url'=>'/logout', 'class'=>'navbar-form']) !!}
        <div class="form-group">
            {!! Form::submit('Logout', ['class' => 'btn btn-danger btn-block']) !!}
        </div>
        {!! Form::close() !!}
    </li>

</ul>