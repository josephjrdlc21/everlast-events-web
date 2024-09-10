<html lang="en">
    <head>
        @include('portal._components.metas') 
        @include('portal._components.styles')
        @yield('page-styles')
    </head>
    <body class="d-flex align-items-center justify-content-center auth-background">
        <svg class="auth-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#0099ff" fill-opacity="1" d="M0,320L48,298.7C96,277,192,235,288,202.7C384,171,480,149,576,165.3C672,181,768,235,864,240C960,245,1056,203,1152,160C1248,117,1344,75,1392,53.3L1440,32L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path></svg>        
        <div class="container">
            <div class="row justify-content-center">
                @yield('content')
            </div>
        </div>
    </body>
    @include('portal._components.scripts')
    @yield('page-scripts')
</html>