<!DOCTYPE html>
<html lang="es">
<head>
    @include('includes.head')
</head>

<body>

<div class="container">
    <div class="header">
        @include('includes.header')
    </div>

    <div class="content">
        <div>
            @include('includes.breadcrumbs')
        </div>
        <div class="errors">
            @include('includes.errors')
        </div>
        @yield('content')
    </div>

    <div class="footer">
        @include('includes.footer')
    </div>

</div>
<div id="printarea" class="container">
</div>

@yield('script')
</body>
</html>