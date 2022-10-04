<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('msg.system_name_en') }} | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('resources/assets') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ url('resources/assets') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('resources/assets') }}/dist/css/adminlte.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Noto Sans Thai', sans-serif;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#!"><b>{{ __('msg.system_name_en') }}</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="{{ route('auth.login') }}" method="post" id="form">
                    @csrf
                    @if (Session::has('message'))
                        <div class="alert alert-danger alert-dismissible">
                            <small>{{ Session::get('message') }}</small>
                        </div>
                    @endif
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="username" id="username"
                                placeholder="{{ __('msg.username') }}" autocomplete="off">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="{{ __('msg.password') }}" autocomplete="off">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-block" id="btn_login"> <i
                                    class="fas fa-sign-in-alt"></i>
                                {{ __('msg.btn_login') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>


            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ url('resources/assets') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('resources/assets') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('resources/assets') }}/dist/js/adminlte.min.js"></script>

    <!-- jquery-validation -->
    <script src="{{ url('resources/assets') }}/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/jquery-validation/additional-methods.min.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/jquery-validation/localization/messages_th.min.js"></script>
    <script>
        var lang_action = {
            btn_logining: '{{ __('msg.btn_logining') }}',
        }
    </script>
    <script src="{{ url('resources/assets') }}/app/signin.js?q={{ time() }}"></script>
</body>

</html>
