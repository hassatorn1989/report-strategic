<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('msg.system_name_en') }} | @yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ url('resources/assets') }}/plugins/fontawesome-free/css/all.min.css">

       <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ url('resources/assets') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ url('resources/assets') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ url('resources/assets') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('resources/assets') }}/dist/css/adminlte.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai&display=swap" rel="stylesheet">
    <style>
        body,
        h1 {
            font-family: 'Noto Sans Thai', sans-serif;
        }
    </style>
    @stack('css')
</head>

<body class="hold-transition layout-top-nav text-sm">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="{{ route('home.index') }}" class="navbar-brand">
                    <img src="{{ url('resources/assets') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                        class="brand-image img-circle">
                    <span
                        class="brand-text font-weight-light"><i><strong>{{ __('msg.system_name_en_full') }}</strong></i></span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        {{-- <li class="nav-item">
                            <a href="index3.html" class="nav-link">Home</a>
                        </li> --}}
                        <li class="nav-item dropdown">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="nav-link dropdown-toggle">{{ __('msg.menu2_report') }}</a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                <li><a href="{{ route('report.project') }}" class="dropdown-item">{{ __('msg.menu2_report_project') }}</a></li>
                                <li><a href="{{ route('report.project-stractegic') }}" class="dropdown-item">{{ __('msg.menu2_report_project_stractegic') }}</a></li>
                                <!-- End Level two -->
                            </ul>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="#" class="nav-link">Contact</a>
                        </li> --}}
                    </ul>
                </div>

                <!-- Right navbar links -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.index') }}">
                            <i class="fas fa-user"></i> {{ __('msg.btn_login') }}
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        @yield('modal')
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="container">
                {{-- <div class="float-right d-none d-sm-inline">
                    Anything you want
                </div> --}}
                <!-- Default to the left -->
                <strong>Copyright &copy; {{ date('Y') }} <a href="https://www.pcru.ac.th/"
                        target="_blank">{{ __('msg.system_uni_en') }}</a>.</strong> All rights
                reserved.
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ url('resources/assets') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('resources/assets') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ url('resources/assets') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/jszip/jszip.min.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('resources/assets') }}/dist/js/adminlte.min.js"></script>
    <script>
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var myurl = '{{ url('') }}';
    </script>
    @stack('script')
</body>

</html>
