@extends('layouts.layout')
@section('title', __('msg.menu_setting_project_main_type'))
@push('css')
@endpush

@push('script')
    <script>
        var lang = {
            title_add: '{{ __('msg.title_add_project_main_type') }}',
            title_edit: '{{ __('msg.title_edit_project_main_type') }}',
        };
    </script>
    <script src="{{ url('resources/assets') }}/app/project_main_type.js?q={{ time() }}"></script>
@endpush

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('msg.menu_setting_project_main_type') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.index') }}">{{ __('msg.menu_dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('msg.menu_setting_project_main_type') }}</li>
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
                                    {{ __('msg.msg_list') . __('msg.menu_setting_project_main_type') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="" method="post" id="search-form">
                                    <div class="row mb-2">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="search" class="form-control"
                                                    name="filter_project_main_type_name" id="filter_project_main_type_name"
                                                    placeholder="{{ __('msg.filter_project_main_type_name') }}"
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
                                            <th width="35%">{{ __('msg.project_main_type_name') }}</th>
                                            <th width="35%">{{ __('msg.project_main_type_budget') }}</th>
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
                            <label for="year_name">{{ __('msg.year_name') }}</label>
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="year_id" id="year_id" value="{{ $year->id }}">
                            <input type="text" class="form-control" name="year_name" id="year_name"
                                placeholder="{{ __('msg.placeholder') }}" autocomplete="off"
                                value="{{ $year->year_name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="project_main_type_name">{{ __('msg.project_main_type_name') }}</label>
                            <input type="text" class="form-control" name="project_main_type_name"
                                id="project_main_type_name" placeholder="{{ __('msg.placeholder') }}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="project_main_type_budget">{{ __('msg.project_main_type_budget') }}</label>
                            <input type="number" class="form-control" name="project_main_type_budget"
                                id="project_main_type_budget" placeholder="{{ __('msg.placeholder') }}"
                                autocomplete="off">
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
