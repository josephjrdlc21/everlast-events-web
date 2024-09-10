<html lang="en">
    <head>
        @include('frontend._components.metas') 
        @include('frontend._components.styles')
        @yield('page-styles')
    </head>
    <body class="auth-background">
        <svg class="auth-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#5000ca" fill-opacity="1" d="M0,160L26.7,149.3C53.3,139,107,117,160,112C213.3,107,267,117,320,133.3C373.3,149,427,171,480,165.3C533.3,160,587,128,640,117.3C693.3,107,747,117,800,112C853.3,107,907,85,960,74.7C1013.3,64,1067,64,1120,85.3C1173.3,107,1227,149,1280,160C1333.3,171,1387,149,1413,138.7L1440,128L1440,320L1413.3,320C1386.7,320,1333,320,1280,320C1226.7,320,1173,320,1120,320C1066.7,320,1013,320,960,320C906.7,320,853,320,800,320C746.7,320,693,320,640,320C586.7,320,533,320,480,320C426.7,320,373,320,320,320C266.7,320,213,320,160,320C106.7,320,53,320,27,320L0,320Z"></path></svg>
        <main class="d-flex w-100">
            <div class="container d-flex flex-column">
                @yield('content')
            </div>
        </main>
    </body>
    @include('frontend._components.scripts')
    @yield('page-scripts')
</html>