<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('msg.system_name_en') }} | @yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('resources/assets') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ url('resources/assets') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ url('resources/assets') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ url('resources/assets') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ url('resources/assets') }}/plugins/daterangepicker/daterangepicker.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('resources/assets') }}/dist/css/adminlte.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ url('resources/assets') }}/plugins/sweetalert2/sweetalert2.css">
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

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        @livewire('navbar')
        <!-- /.navbar -->
        @livewire('sidebar')
        <!-- Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        @yield('modal')
        @livewire('modal')
        <!-- /.content-wrapper -->

        @livewire('footer')
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ url('resources/assets') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('resources/assets') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery UI -->
    <script src="{{ url('resources/assets') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
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

    <!-- jquery-validation -->
    <script src="{{ url('resources/assets') }}/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/jquery-validation/additional-methods.min.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/jquery-validation/localization/messages_th.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="{{ url('resources/assets') }}/plugins/sweetalert2/sweetalert2.min.js"></script>

    <!-- InputMask -->
    <script src="{{ url('resources/assets') }}/plugins/moment/moment.min.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/daterangepicker/daterangepicker.js"></script>

    <script>
        // $.widget.bridge('uibutton', $.ui.button)
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var myurl = '{{ url('') }}';
        var lang_action = {
            'btn_saving': '{{ __('msg.btn_saving') }}',
            'btn_detail': '{{ __('msg.btn_detail') }}',
            'destroy_title': '{{ __('msg.destroy_title') }}',
            'checkin_title': '{{ __('msg.checkin_title') }}',
            'checkout_title': '{{ __('msg.checkout_title') }}',
            'destroy_ok': '{{ __('msg.destroy_ok') }}',
            'destroy_cancle': '{{ __('msg.destroy_cancle') }}',
            'placeholder': '{{ __('msg.placeholder') }}',
        };
    </script>
    <!-- Page specific script -->
    @stack('script')
    <script src="{{ url('resources/assets') }}/app/change_password.js?q={{ time() }}"></script>
</body>

</html>
