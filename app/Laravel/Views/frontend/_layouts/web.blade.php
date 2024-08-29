<html lang="en">
    <head>
        @include('frontend._components.web.metas') 
        @include('frontend._components.web.styles')
        @yield('page-styles')
    </head>
    <body>
        <div id="js-preloader" class="js-preloader loaded">
            <div class="preloader-inner">
                <span class="dot"></span>
                <div class="dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        @include('frontend._components.web.topbar')
        @yield('content')
        @include('frontend._components.web.footer')
    </body>
    @include('frontend._components.web.scripts')
    @yield('page-scripts')
</html>