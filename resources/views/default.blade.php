<!DOCTYPE html>
<html lang="fr">
    @include('core.head')

    <body class="fixed-left">

        <!-- Loader -->
        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

        <!-- Begin page -->
        <div id="wrapper">
            @include('core.leftsidebar')

            <!-- Start right Content here -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    @include('core.topbar')

                    <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            @include('core.breadcrumb')
                            @include('core.messages')
                            @include('sweetalert::alert')

                            @yield('content')
                     
                        </div><!-- container fluid -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->



              @include('core.footer')
            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->

    </body>
    @include('core.js')
</html>