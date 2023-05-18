@extends('layouts.layout')
@section('title', __('msg.menu_setting_project_main'))
@push('css')
    <link rel="stylesheet" href="{{ url('resources/assets') }}/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
@endpush

@push('script')
    <script>
        var lang = {
            title_add: '{{ __('msg.title_add_project_main') }}',
            title_edit: '{{ __('msg.title_edit_project_main') }}',
        };
    </script>
    <script src="{{ url('resources/assets') }}/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <script src="{{ url('resources/assets') }}/app/project_main.js?q={{ time() }}"></script>
@endpush

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('msg.menu_setting_project_main') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.index') }}">{{ __('msg.menu_dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('msg.menu_setting_project_main') }}</li>
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
                                    {{ __('msg.msg_list') . __('msg.menu_setting_project_main') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="" method="post" id="search-form">
                                    <div class="row mb-2">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="search" class="form-control" name="filter_project_main_name"
                                                    id="filter_project_main_name"
                                                    placeholder="{{ __('msg.filter_project_main_name') }}"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="submit" name="" id=""
                                                class="btn btn-info btn-block">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        @if (auth()->user()->user_role == 'admin')
                                            <div class="col-md-2 offset-md-6">
                                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                                    data-target="#modal-default" onclick="add_data()">
                                                    <i class="fas fa-plus-circle"></i> {{ __('msg.btn_add') }}
                                                </button>
                                            </div>
                                        @endif

                                    </div>
                                </form>
                                <table id="example1" class="table table-hover table-sm table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="25%">{{ __('msg.project_main_name') }}</th>
                                            <th width="10%">{{ __('msg.project_main_budget') }}</th>
                                            <th width="10%">{{ __('msg.year_name') }}</th>
                                            <th width="20%">{{ __('msg.strategic_name') }}</th>
                                            <th width="20%">{{ __('msg.msg_faculty_join') }}</th>
                                            <th width="15%">{{ __('msg.action') }}</th>
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
    @if (auth()->user()->user_role == 'admin')
        '<div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="" method="post" id="form">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="year_id" id="year_id" value="{{ $year->id }}">
                        <input type="hidden" name="mode" id="mode" value="">
                        <div class="modal-header">
                            <h5 class="modal-title">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="project_main_name">{{ __('msg.project_main_name') }}</label>

                                        <input type="text" class="form-control" name="project_main_name"
                                            id="project_main_name" placeholder="{{ __('msg.placeholder') }}"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="project_main_type_id">{{ __('msg.project_main_type_name') }}</label>
                                        <select class="custom-select" name="project_main_type_id" id="project_main_type_id">
                                            <option value="">{{ __('msg.select') }}</option>
                                            @if (!empty($project_main_type))
                                                @foreach ($project_main_type as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->project_main_type_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="faculty_id">{{ __('msg.msg_faculty_main') }}</label>
                                        <select class="custom-select" name="faculty_id" id="faculty_id">
                                            <option value="">{{ __('msg.select') }}</option>
                                            @if (!empty($faculty))
                                                @foreach ($faculty as $item)
                                                    <option value="{{ $item->id }}">{{ $item->faculty_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="project_main_budget">{{ __('msg.project_main_budget') }}</label>
                                        <input type="number" class="form-control" name="project_main_budget"
                                            id="project_main_budget" placeholder="{{ __('msg.placeholder') }}"
                                            autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            for="project_main_guidelines">{{ __('msg.project_main_guidelines') }}</label>
                                        <textarea class="form-control" name="project_main_guidelines" id="project_main_guidelines" rows="5"
                                            placeholder="{{ __('msg.placeholder') }}"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="project_main_target">{{ __('msg.project_main_target') }}</label>
                                        <textarea class="form-control" name="project_main_target" id="project_main_target" rows="5"
                                            placeholder="{{ __('msg.placeholder') }}"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="strategic_id">{{ __('msg.strategic_name') }}</label>
                                        <select class="custom-select" name="year_strategic_id" id="year_strategic_id">
                                            <option value="" data-year_strategic_detail_count="0"
                                                data-year_strategic_detail="[]">
                                                {{ __('msg.select') }}</option>
                                            @if (!empty($year_strategic))
                                                @foreach ($year_strategic as $item)
                                                    <option value="{{ $item->id }}"
                                                        data-year_strategic_detail_count="{{ $item->count_year_strategic_detail }}"
                                                        data-year_strategic_detail="{{ json_encode($item->get_year_strategic_detail) }}">
                                                        {{ $item->strategic_name }}</option>
                                                    >
                                                    {{ $item->strategic_name }}</option>
                                                @endforeach
                                            @endif
                                            <option value="no" data-year_strategic_detail_count="0"
                                                data-year_strategic_detail="[]">
                                                {{ __('msg.strategic_not_specified') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="strategic_id">{{ __('msg.sub_strategic') }}</label>
                                        <select class="custom-select" name="year_strategic_detail_id"
                                            id="year_strategic_detail_id" disabled>
                                            <option value="">{{ __('msg.select') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ __('msg.msg_faculty_join') }}</label>
                                <select class="duallistbox" multiple="multiple" id="faculty_join_id"
                                    name="faculty_join_id[]">
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
    @endif
    <!-- Modal -->

@endsection
