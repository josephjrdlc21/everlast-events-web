<html lang="en">
    <head>
        @include('portal._components.metas') 
        @include('portal._components.styles')
        @yield('page-styles')
    </head>
    <body class="d-flex align-items-center justify-content-center" style="background-image: linear-gradient(to right bottom, #0050c6, #3970d7, #5f90e6, #86b0f3, #aed0ff);">
        <div class="container">
            <div class="row justify-content-center">
                @yield('content')
            </div>
        </div>
    </body>
    @include('portal._components.scripts')
    @yield('page-scripts')
</html>