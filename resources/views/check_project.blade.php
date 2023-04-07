@extends('layouts.layout')
@section('title', __('msg.menu_project'))
@push('css')
    <link rel="stylesheet" href="{{ url('resources/assets') }}/plugins/taginput/tagsinput.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ url('resources/assets') }}/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
@endpush

@push('script')
    <script>
        var lang = {
            title_add: '{{ __('msg.title_add_project') . __('msg.year_name') . ' ' . $year->year_name }}',
            title_edit: '{{ __('msg.title_edit_project') . __('msg.year_name') . ' ' . $year->year_name }}',
        };
        var project_main_id = '{{ Request::segment(3) }}';
    </script>
    <script src="{{ url('resources/assets') }}/plugins/taginput/tagsinput.js"></script>

    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ url('resources/assets') }}/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <script src="{{ url('resources/assets') }}/app/check_project.js?q={{ time() }}"></script>
@endpush

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('msg.menu_project') . __('msg.year_name') . ' ' . $year->year_name }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.index') }}">{{ __('msg.menu_dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('setting-project.project-main.index') }}">{{ __('msg.menu_setting_project_main') }}</a>
                            </li>
                            <li class="breadcrumb-item active">
                                {{ __('msg.menu_project') . __('msg.year_name') . ' ' . $year->year_name }}</li>
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
                                    {{ __('msg.msg_list') . __('msg.menu_project') . __('msg.year_name') . ' ' . $year->year_name }}
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="" method="post" id="search-form">
                                    <div class="row mb-2">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="search" class="form-control" name="filter_project_name"
                                                    id="filter_project_name"
                                                    placeholder="{{ __('msg.filter_project_name') }}" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="submit" name="" id=""
                                                class="btn btn-info btn-block">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <table id="example1" class="table table-hover table-sm table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="15%">{{ __('msg.project_code') }}</th>
                                            <th width="30%">{{ __('msg.project_name') }}</th>
                                            <th width="10%">{{ __('msg.project_status') }}</th>
                                            <th width="20%">{{ __('msg.project_percentage') }}</th>
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
    <div class="modal fade" id="modal-check" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="project_status"></label>
                        <select class="form-control" name="project_status" id="project_status">
                            <option value="">{{ __('msg.select') }}</option>
                            <option value="publish">{{ __('msg.project_status_publish') }}</option>
                            <option value="reject">{{ __('msg.project_status_reject') }}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
