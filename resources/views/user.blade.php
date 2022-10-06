@extends('layouts.layout')
@section('title', __('msg.menu_setting_user'))
@push('css')
@endpush

@push('script')
    <script>
        var lang = {
            title_add: '{{ __('msg.title_add_user') }}',
            title_edit: '{{ __('msg.title_edit_user') }}',
            msg_username_used: '{{ __('msg.msg_username_used') }}',
            msg_password_minlength: '{{ __('msg.msg_password_minlength') }}',
        };
    </script>
    <script src="{{ url('resources/assets') }}/app/user.js?q={{ time() }}"></script>
@endpush

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('msg.menu_setting_user') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.index') }}">{{ __('msg.menu_dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('msg.menu_setting_user') }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-list"></i>
                                    {{ __('msg.msg_list') . __('msg.menu_setting_user') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="" method="post" id="search-form">
                                    <div class="row mb-2">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="search" class="form-control" name="filter_user_name"
                                                    id="filter_user_name" placeholder="{{ __('msg.filter_user_name') }}"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="submit" name="" id=""
                                                class="btn btn-info btn-block">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-2 offset-md-6">
                                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                                data-target="#modal-default" onclick="add_data()">
                                                <i class="fas fa-plus-circle"></i> {{ __('msg.btn_add') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <table id="example1" class="table table-hover table-sm table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="25%">{{ __('msg.full_name') }}</th>
                                            <th width="25%">{{ __('msg.user_role') }}</th>
                                            <th width="20%">{{ __('msg.faculty_name') }}</th>
                                            <th width="25%">{{ __('msg.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="post" id="form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="user_prefix">{{ __('msg.user_prefix') }}</label>
                            <input type="hidden" name="id" id="id">
                            <input type="text" class="form-control" name="user_prefix" id="user_prefix"
                                placeholder="{{ __('msg.placeholder') }}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="user_name">{{ __('msg.user_name') }}</label>
                            <input type="text" class="form-control" name="user_name" id="user_name"
                                placeholder="{{ __('msg.placeholder') }}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="user_last">{{ __('msg.user_last') }}</label>
                            <input type="text" class="form-control" name="user_last" id="user_last"
                                placeholder="{{ __('msg.placeholder') }}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="username">{{ __('msg.username') }}</label>
                            <input type="text" class="form-control" name="username" id="username"
                                placeholder="{{ __('msg.placeholder') }}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('msg.password') }}</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="{{ __('msg.placeholder') }}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="user_role">{{ __('msg.user_role') }}</label>
                            <select class="custom-select" name="user_role" id="user_role">
                                <option value="">{{ __('msg.select') }}</option>
                                <option value="admin">{{ __('msg.user_role_admin') }}</option>
                                <option value="user">{{ __('msg.user_role_user') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="faculty_id">{{ __('msg.faculty_name') }}</label>
                            <select class="custom-select" name="faculty_id" id="faculty_id">
                                <option value="">{{ __('msg.select') }}</option>
                                @if (count($faculty) > 0)
                                    @foreach ($faculty as $item)
                                        <option value="{{ $item->id }}">{{ $item->faculty_name }}</option>
                                    @endforeach
                                @endif
                                <option value="other">{{ __('msg.admin_university') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn_save"><i class="fas fa-save"></i>
                            {{ __('msg.btn_save') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i
                                class="fas fa-times-circle"></i> {{ __('msg.btn_close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
