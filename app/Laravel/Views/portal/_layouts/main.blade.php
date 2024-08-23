<html lang="en">
    <head>
        @include('portal._components.metas') 
        @include('portal._components.styles')
        @yield('page-styles')
    </head>
    <body id="page-top" class="sidebar-toggled">
        <div id="wrapper">
            @include('portal._components.sidebar')
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    @include('portal._components.topbar')
                    <div class="container-fluid">
                        @yield('breadcrumb')
                        @yield('content')
                    </div>
                </div>
                @include('portal._components.footer')
            </div>
        </div>
        <a class="scroll-to-top rounded" href="#page-top" style="display: none; display: flex; justify-content: center; align-items: center;">
            <i class="fas fa-angle-up"></i>
        </a>
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
    @include('portal._components.scripts')
    @yield('page-scripts')
</html>