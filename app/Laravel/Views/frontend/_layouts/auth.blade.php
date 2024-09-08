<html lang="en">
    <head>
        @include('frontend._components.metas') 
        @include('frontend._components.styles')
        @yield('page-styles')
    </head>
    <body style="background: linear-gradient(90deg, #efd5ff 0%, #515ada 100%);">
        <main class="d-flex w-100">
            <div class="container d-flex flex-column">
                @yield('content')
            </div>
        </main>
    </body>
    @include('frontend._components.scripts')
    @yield('page-scripts')
</html>