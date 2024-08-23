<html lang="en">
    <head>
        @include('frontend._components.metas') 
        @include('frontend._components.styles')
        @yield('page-styles')
    </head>
    <body>
        <div class="wrapper">
            @include('frontend._components.sidebar')
            <div class="main">
                @include('frontend._components.topbar')
                <main class="content">
                    <div class="container-fluid p-0">
                        @yield('breadcrumb')
                        @yield('content')
                    </div>
                </main>
                @include('frontend._components.footer')
            </div>
        </div>
    </body>
    @include('frontend._components.scripts')
    @yield('page-scripts')
</html>