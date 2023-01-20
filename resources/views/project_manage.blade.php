@extends('layouts.layout')
@section('title', __('msg.title_manage_project'))
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <style>
        .dropzone {
            border: 2px dashed #CFCFCF;
            border-radius: 10px;
            background: white;
        }
    </style>
@endpush

@push('script')
    <script>
        var lang = {
            title_add_project_responsible_person: '{{ __('msg.title_add_project_responsible_person') }}',
            title_edit_project_responsible_person: '{{ __('msg.title_edit_project_responsible_person') }}',
        };
    </script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        @if ($project->project_period_start == '' && $project->project_period_end == '')
            var project_period = {
                start: '{{ date('d/m/Y') }}',
                end: '{{ date('d/m/Y') }}',
            };
        @else
            var project_period = {
                start: '{{ date('d/m/Y', strtotime($project->project_period_start)) }}',
                end: '{{ date('d/m/Y', strtotime($project->project_period_end)) }}',
            };
        @endif
        var project_id = '{{ $project->id }}';
    </script>
    <script src="{{ url('resources/assets') }}/app/project_manage.js?q={{ time() }}"></script>
@endpush


@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('msg.title_manage_project') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.index') }}">{{ __('msg.menu_dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('setting-project.project-main.index') }}">{{ __('msg.menu_setting_project_main') }}</a>
                            </li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('project.index', ['id' => $project->project_main_id]) }}">{{ __('msg.menu_project') . __('msg.year_name') . ' ' . $project->year_name }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('msg.title_manage_project') }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-3 offset-md-9">
                        @if ($project->project_status == 'draff' || $project->project_status == 'unpublish')
                            <form action="{{ route('project.manage.publish') }}" method="post" id="form_publish">
                                @csrf
                                <input type="hidden" id="id" name="id" value="{{ Request::segment(4) }}">
                                <input type="hidden" id="project_status" name="project_status" value="publish">
                                <button type="submit" name="btn_publish" id="btn_publish"
                                    class="btn btn-primary btn-block"><i class="fas fa-paper-plane"></i>
                                    {{ __('msg.btn_publish') }}</button>
                            </form>
                        @else
                            <form action="{{ route('project.manage.publish') }}" method="post" id="form_publish">
                                @csrf
                                <input type="hidden" id="id" name="id" value="{{ Request::segment(4) }}">
                                <input type="hidden" id="project_status" name="project_status" value="unpublish">
                                <button type="submit" name="btn_publish" id="btn_publish"
                                    class="btn btn-danger btn-block"><i class="fas fa-times-circle"></i>
                                    {{ __('msg.btn_unpublish') }}</button>
                            </form>
                        @endif

                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-tasks"></i>
                                    {{ $project->project_name }}</h3>
                                <div class="card-tools">
                                    @switch($project->project_status)
                                        @case('draff')
                                            <small class="badge badge-warning">{{ __('msg.project_status_draff') }}</small>
                                        @break

                                        @case('publish')
                                            <small class="badge badge-success">{{ __('msg.project_status_publish') }}</small>
                                        @break

                                        @case('unpublish')
                                            <small class="badge badge-danger">{{ __('msg.project_status_unpublish') }}</small>
                                        @break

                                        @default
                                    @endswitch
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="progress progress-sm active">
                                    <div class="progress-bar bg-primary progress-bar-striped" role="progressbar"
                                        aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"
                                        style="width: {{ $cal }}%">
                                        <span class="sr-only">20% Complete</span>
                                    </div>
                                </div>
                                <small>{{ __('msg.project_percentage') . ' : ' . $cal }}%</small>
                                <div class="row mt-3">
                                    <div class="col-5 col-sm-3">
                                        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                                            aria-orientation="vertical">
                                            @php
                                                $flag_update_data = false;
                                            @endphp
                                            @if ($project->project_name != '' &&
                                                $project->project_period_start != '' &&
                                                $project->project_period_end != '' &&
                                                $project->project_type_id != '' &&
                                                $project->project_budget != '')
                                                @php
                                                    $flag_update_data = true;
                                                @endphp
                                            @endif
                                            <a class="nav-link active" id="vert-tabs-project-main-tab" data-toggle="pill"
                                                href="#vert-tabs-project-main" role="tab"
                                                aria-controls="vert-tabs-project-main"
                                                aria-selected="true">{{ __('msg.tab_project_main') }}
                                                {!! $flag_update_data == false
                                                    ? '<small class="text-danger"><i class="fas fa-exclamation-circle"></i></small>'
                                                    : '<small class="text-success"><i class="fas fa-check-circle"></i></small>' !!}
                                            </a>
                                            <a class="nav-link" id="vert-tabs-project-responsible-person-tab"
                                                data-toggle="pill" href="#vert-tabs-project-responsible-person"
                                                role="tab" aria-controls="vert-tabs-project-responsible-person"
                                                aria-selected="false">{{ __('msg.tab_project_responsible_person') }}
                                                {!! count($project->get_project_responsible_person) == 0
                                                    ? '<small class="text-danger"><i class="fas fa-exclamation-circle"></i></small>'
                                                    : '<small class="text-success"><i class="fas fa-check-circle"></i></small>' !!}</a>
                                            <a class="nav-link" id="vert-tabs-project-location-tab" data-toggle="pill"
                                                href="#vert-tabs-project-location" role="tab"
                                                aria-controls="vert-tabs-project-location"
                                                aria-selected="false">{{ __('msg.tab_project_location') }}
                                                {!! count($project->get_project_location) == 0
                                                    ? '<small class="text-danger"><i class="fas fa-exclamation-circle"></i></small>'
                                                    : '<small class="text-success"><i class="fas fa-check-circle"></i></small>' !!}
                                            </a>
                                            <a class="nav-link" id="vert-tabs-project-target-group-tab" data-toggle="pill"
                                                href="#vert-tabs-project-target-group" role="tab"
                                                aria-controls="vert-tabs-project-target-group"
                                                aria-selected="false">{{ __('msg.tab_project_target_group') }}
                                                {!! count($project->get_project_target_group) == 0
                                                    ? '<small class="text-danger"><i class="fas fa-exclamation-circle"></i></small>'
                                                    : '<small class="text-success"><i class="fas fa-check-circle"></i></small>' !!}
                                            </a>
                                            <a class="nav-link" id="vert-tabs-project-problem-tab" data-toggle="pill"
                                                href="#vert-tabs-project-problem" role="tab"
                                                aria-controls="vert-tabs-project-problem"
                                                aria-selected="false">{{ __('msg.tab_project_problem') }}
                                                {!! count($project->get_project_problem) == 0
                                                    ? '<small class="text-danger"><i class="fas fa-exclamation-circle"></i></small>'
                                                    : '<small class="text-success"><i class="fas fa-check-circle"></i></small>' !!}
                                            </a>
                                            <a class="nav-link" id="vert-tabs-project-problem-solution-tab"
                                                data-toggle="pill" href="#vert-tabs-project-problem-solution"
                                                role="tab" aria-controls="vert-tabs-project-problem-solution"
                                                aria-selected="false">{{ __('msg.tab_project_problem_solution') }}
                                                {!! count($project->get_project_problem_solution) == 0
                                                    ? '<small class="text-danger"><i class="fas fa-exclamation-circle"></i></small>'
                                                    : '<small class="text-success"><i class="fas fa-check-circle"></i></small>' !!}
                                            </a>
                                            <a class="nav-link" id="vert-tabs-project-quantitative-indicators-tab"
                                                data-toggle="pill" href="#vert-tabs-project-quantitative-indicators"
                                                role="tab" aria-controls="vert-tabs-project-quantitative-indicators"
                                                aria-selected="false">{{ __('msg.tab_project_quantitative_indicators') }}
                                                {!! count($project->get_project_quantitative_indicators) == 0
                                                    ? '<small class="text-danger"><i class="fas fa-exclamation-circle"></i></small>'
                                                    : '<small class="text-success"><i class="fas fa-check-circle"></i></small>' !!}
                                            </a>
                                            <a class="nav-link" id="vert-tabs-project-qualitative-indicators-tab"
                                                data-toggle="pill" href="#vert-tabs-project-qualitative-indicators"
                                                role="tab" aria-controls="vert-tabs-project-qualitative-indicators"
                                                aria-selected="false">{{ __('msg.tab_project_qualitative_indicators') }}
                                                {!! count($project->get_project_qualitative_indicators) == 0
                                                    ? '<small class="text-danger"><i class="fas fa-exclamation-circle"></i></small>'
                                                    : '<small class="text-success"><i class="fas fa-check-circle"></i></small>' !!}
                                            </a>
                                            <a class="nav-link" id="vert-tabs-project-output-tab" data-toggle="pill"
                                                href="#vert-tabs-project-output" role="tab"
                                                aria-controls="vert-tabs-project-output"
                                                aria-selected="false">{{ __('msg.tab_project_output') }}
                                                {!! count($project->get_project_output) == 0
                                                    ? '<small class="text-danger"><i class="fas fa-exclamation-circle"></i></small>'
                                                    : '<small class="text-success"><i class="fas fa-check-circle"></i></small>' !!}
                                            </a>
                                            <a class="nav-link" id="vert-tabs-project-outcome-tab" data-toggle="pill"
                                                href="#vert-tabs-project-outcome" role="tab"
                                                aria-controls="vert-tabs-project-outcome"
                                                aria-selected="false">{{ __('msg.tab_project_outcome') }}
                                                {!! count($project->get_project_outcome) == 0
                                                    ? '<small class="text-danger"><i class="fas fa-exclamation-circle"></i></small>'
                                                    : '<small class="text-success"><i class="fas fa-check-circle"></i></small>' !!}
                                            </a>
                                            <a class="nav-link" id="vert-tabs-project-impact-tab" data-toggle="pill"
                                                href="#vert-tabs-project-impact" role="tab"
                                                aria-controls="vert-tabs-project-impact"
                                                aria-selected="false">{{ __('msg.tab_project_impact') }}
                                                {!! count($project->get_project_impact) == 0
                                                    ? '<small class="text-danger"><i class="fas fa-exclamation-circle"></i></small>'
                                                    : '<small class="text-success"><i class="fas fa-check-circle"></i></small>' !!}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-7 col-sm-9">
                                        <div class="tab-content" id="vert-tabs-tabContent">
                                            <div class="tab-pane text-left fade show active" id="vert-tabs-project-main"
                                                role="tabpanel" aria-labelledby="vert-tabs-project-main-tab">
                                                <form action="{{ route('project.update') }}" method="post"
                                                    id="form_update">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label
                                                                    for="project_name">{{ __('msg.project_name') }}</label>
                                                                <input type="hidden" name="id" id="id"
                                                                    value="{{ $project->id }}">
                                                                <input type="text" class="form-control"
                                                                    name="project_name" id="project_name"
                                                                    placeholder="{{ __('msg.placeholder') }}"
                                                                    autocomplete="off"
                                                                    value="{{ $project->project_name }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label
                                                                    for="project_type_id">{{ __('msg.project_type_name') }}</label>
                                                                <select class="custom-select" name="project_type_id"
                                                                    id="project_type_id">
                                                                    <option value="">{{ __('msg.select') }}</option>
                                                                    @if (!empty($project_type))
                                                                        @foreach ($project_type as $item)
                                                                            <option value="{{ $item->id }}"
                                                                                {{ $item->id == $project->project_type_id ? 'selected' : '' }}>
                                                                                {{ $item->project_type_name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label
                                                                    for="project_budget">{{ __('msg.project_budget') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="project_budget" id="project_budget"
                                                                    placeholder="{{ __('msg.placeholder') }}"
                                                                    value="{{ $project->project_budget }}"
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label
                                                                    for="project_period">{{ __('msg.project_period') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="project_period" id="project_period"
                                                                    placeholder="{{ __('msg.placeholder') }}"
                                                                    value="{{ $project->project_period }}"
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label
                                                                    for="project_main_id">{{ __('msg.project_main_name') }}</label>
                                                                <select class="custom-select" name="project_main_id"
                                                                    id="project_main_id">
                                                                    <option value="">{{ __('msg.select') }}</option>
                                                                    @if (!empty($project_main))
                                                                        @foreach ($project_main as $item)
                                                                            <option value="{{ $item->id }}"
                                                                                {{ $item->id == $project->project_main_id ? 'selected' : '' }}>
                                                                                {{ $item->project_main_name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    <button type="submit" class="btn btn-primary"
                                                        id="btn_save_project"><i class="fas fa-save"></i>
                                                        {{ __('msg.btn_save') }}</button>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-project-responsible-person"
                                                role="tabpanel"
                                                aria-labelledby="vert-tabs-project-responsible-person-tab">
                                                <form action="{{ route('project.manage.responsible-person-store') }}"
                                                    method="post" id="form-project-responsible-person">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="hidden" name="id" id="id">
                                                                <input type="hidden" name="project_id" id="project_id"
                                                                    value="{{ Request::segment(4) }}">
                                                                <input type="text" class="form-control"
                                                                    name="project_responsible_person_name"
                                                                    id="project_responsible_person_name"
                                                                    placeholder="{{ __('msg.placeholder') . __('msg.project_responsible_person_name') }}"
                                                                    autocomplete="off" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    name="project_responsible_person_tel"
                                                                    id="project_responsible_person_tel"
                                                                    placeholder="{{ __('msg.placeholder') . __('msg.project_responsible_person_tel') }}"
                                                                    autocomplete="off" value=""
                                                                    onkeypress="validate_number(event)">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="submit" class="btn btn-primary btn-block"
                                                                id="btn_save_project_responsible_person"><i
                                                                    class="fas fa-save"></i>
                                                                {{ __('msg.btn_save') }}</button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <small class="text-danger">{{ __('msg.msg_mode') }} : <u><span
                                                                        id="project_responsible_person_mode">เพิ่มข้อมูล</span></u></small>
                                                        </div>
                                                    </div>
                                                </form>
                                                <table class="table table-hover table-sm table-striped">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>{{ __('msg.project_responsible_person_name') }}</th>
                                                            <th>{{ __('msg.project_responsible_person_tel') }}</th>
                                                            <th>
                                                                <div style="text-align: center;">
                                                                    <a href="#"
                                                                        onclick="add_data_project_responsible_person()"><i
                                                                            class="fa fa-plus-circle"></i>
                                                                        {{ __('msg.btn_add') }}</a>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($project->get_project_responsible_person) > 0)
                                                            @foreach ($project->get_project_responsible_person as $key => $item)
                                                                <tr>
                                                                    <td scope="row">{{ $key + 1 }}</td>
                                                                    <td>{{ $item->project_responsible_person_name }}</td>
                                                                    <td>{{ $item->project_responsible_person_tel }}</td>
                                                                    <td width="20%" align="center">
                                                                        <button
                                                                            class="btn btn-warning btn-sm waves-effect waves-light"
                                                                            onclick="edit_data_project_responsible_person('{{ $item->id }}')">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>
                                                                        <button
                                                                            class="btn btn-danger btn-sm waves-effect waves-light"
                                                                            onclick="destroy_project_responsible_person('{{ $item->id }}')">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="4" align="center">
                                                                    <span
                                                                        class="text-danger">{{ __('msg.msg_no_data') }}</span>
                                                                </td>
                                                            </tr>
                                                        @endif

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-project-location" role="tabpanel"
                                                aria-labelledby="vert-tabs-project-location-tab">
                                                <table class="table table-hover table-sm table-striped">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>{{ __('msg.mname') }}</th>
                                                            <th>{{ __('msg.tname') }}</th>
                                                            <th>{{ __('msg.aname') }}</th>
                                                            <th>{{ __('msg.pname') }}</th>
                                                            <th>
                                                                <div style="text-align: center;">
                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#modal-manage-project-location"
                                                                        onclick="add_data_project_location()"><i
                                                                            class="fa fa-plus-circle"></i>
                                                                        {{ __('msg.btn_add') }}</a>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($project->get_project_location) > 0)
                                                            @foreach ($project->get_project_location as $key => $item)
                                                                <tr>
                                                                    <td scope="row">{{ $key + 1 }}</td>
                                                                    <td>{{ $item->mname }}</td>
                                                                    <td>{{ $item->tname }}</td>
                                                                    <td>{{ $item->aname }}</td>
                                                                    <td>{{ $item->pname }}</td>
                                                                    <td width="20%" align="center">
                                                                        <button
                                                                            class="btn btn-warning btn-sm waves-effect waves-light"
                                                                            data-toggle="modal"
                                                                            data-target="#modal-manage-project-location"
                                                                            onclick="edit_data_project_location('{{ $item->id }}')">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>
                                                                        <button
                                                                            class="btn btn-danger btn-sm waves-effect waves-light"
                                                                            onclick="destroy_project_location('{{ $item->id }}')">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="6" align="center">
                                                                    <span
                                                                        class="text-danger">{{ __('msg.msg_no_data') }}</span>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-project-target-group"
                                                role="tabpanel" aria-labelledby="vert-tabs-project-target-group-tab">
                                                <form action="{{ route('project.manage.target-group-store') }}"
                                                    method="post" id="form-project-target-group">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <input type="hidden" name="id" id="id">
                                                                <input type="hidden" name="project_id" id="project_id"
                                                                    value="{{ Request::segment(4) }}">
                                                                <input type="text" class="form-control"
                                                                    name="project_target_group_detail"
                                                                    id="project_target_group_detail"
                                                                    placeholder="{{ __('msg.placeholder') . __('msg.project_target_group_detail') }}"
                                                                    autocomplete="off" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="submit" class="btn btn-primary btn-block"
                                                                id="btn_save_project_target_group"><i
                                                                    class="fas fa-save"></i>
                                                                {{ __('msg.btn_save') }}</button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <small class="text-danger">{{ __('msg.msg_mode') }} :
                                                                <u><span
                                                                        id="project_target_group_mode">เพิ่มข้อมูล</span></u></small>
                                                        </div>
                                                    </div>
                                                </form>
                                                <table class="table table-hover table-sm table-striped">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>{{ __('msg.project_target_group_detail') }}</th>
                                                            <th>
                                                                <div style="text-align: center;">
                                                                    <a href="#"
                                                                        onclick="add_data_project_target_group()"><i
                                                                            class="fa fa-plus-circle"></i>
                                                                        {{ __('msg.btn_short_add') }}</a>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($project->get_project_target_group) > 0)
                                                            @foreach ($project->get_project_target_group as $key => $item)
                                                                <tr>
                                                                    <td scope="row">{{ $key + 1 }}</td>
                                                                    <td>{{ $item->project_target_group_detail }}</td>
                                                                    <td width="20%" align="center">
                                                                        <button
                                                                            class="btn btn-warning btn-sm waves-effect waves-light"
                                                                            onclick="edit_data_project_target_group('{{ $item->id }}')">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>
                                                                        <button
                                                                            class="btn btn-danger btn-sm waves-effect waves-light"
                                                                            onclick="destroy_project_target_group('{{ $item->id }}')">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="3" align="center">
                                                                    <span
                                                                        class="text-danger">{{ __('msg.msg_no_data') }}</span>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-project-problem" role="tabpanel"
                                                aria-labelledby="vert-tabs-project-problem-tab">
                                                <form action="{{ route('project.manage.problem-store') }}"
                                                    method="post" id="form-project-problem">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <input type="hidden" name="id" id="id">
                                                                <input type="hidden" name="project_id" id="project_id"
                                                                    value="{{ Request::segment(4) }}">
                                                                <input type="text" class="form-control"
                                                                    name="project_problem_detail"
                                                                    id="project_problem_detail"
                                                                    placeholder="{{ __('msg.placeholder') . __('msg.project_problem_detail') }}"
                                                                    autocomplete="off" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="submit" class="btn btn-primary btn-block"
                                                                id="btn_save_project_problem"><i class="fas fa-save"></i>
                                                                {{ __('msg.btn_save') }}</button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <small class="text-danger">{{ __('msg.msg_mode') }} :
                                                                <u><span
                                                                        id="project_problem_mode">เพิ่มข้อมูล</span></u></small>
                                                        </div>
                                                    </div>
                                                </form>
                                                <table class="table table-hover table-sm table-striped">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>{{ __('msg.project_problem_detail') }}</th>
                                                            <th>
                                                                <div style="text-align: center;">
                                                                    <a href="#"
                                                                        onclick="add_data_project_problem()"><i
                                                                            class="fa fa-plus-circle"></i>
                                                                        {{ __('msg.btn_short_add') }}</a>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($project->get_project_problem) > 0)
                                                            @foreach ($project->get_project_problem as $key => $item)
                                                                <tr>
                                                                    <td scope="row">{{ $key + 1 }}</td>
                                                                    <td>{{ $item->project_problem_detail }}</td>
                                                                    <td width="20%" align="center">
                                                                        <button
                                                                            class="btn btn-warning btn-sm waves-effect waves-light"
                                                                            onclick="edit_data_project_problem('{{ $item->id }}')">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>
                                                                        <button
                                                                            class="btn btn-danger btn-sm waves-effect waves-light"
                                                                            onclick="destroy_project_problem('{{ $item->id }}')">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="3" align="center">
                                                                    <span
                                                                        class="text-danger">{{ __('msg.msg_no_data') }}</span>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-project-problem-solution"
                                                role="tabpanel" aria-labelledby="vert-tabs-project-problem-solution-tab">
                                                <form action="{{ route('project.manage.problem-solution-store') }}"
                                                    method="post" id="form-project-problem-solution">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <input type="hidden" name="id" id="id">
                                                                <input type="hidden" name="project_id" id="project_id"
                                                                    value="{{ Request::segment(4) }}">
                                                                <input type="text" class="form-control"
                                                                    name="project_problem_solution_detail"
                                                                    id="project_problem_solution_detail"
                                                                    placeholder="{{ __('msg.placeholder') . __('msg.project_problem_solution_detail') }}"
                                                                    autocomplete="off" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="submit" class="btn btn-primary btn-block"
                                                                id="btn_save_project_problem_solution"><i
                                                                    class="fas fa-save"></i>
                                                                {{ __('msg.btn_save') }}</button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <small class="text-danger">{{ __('msg.msg_mode') }} :
                                                                <u><span
                                                                        id="project_problem_solution_mode">เพิ่มข้อมูล</span></u></small>
                                                        </div>
                                                    </div>
                                                </form>
                                                <table class="table table-hover table-sm table-striped">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>{{ __('msg.project_problem_solution_detail') }}</th>
                                                            <th>
                                                                <div style="text-align: center;">
                                                                    <a href="#"
                                                                        onclick="add_data_project_problem_solution()"><i
                                                                            class="fa fa-plus-circle"></i>
                                                                        {{ __('msg.btn_short_add') }}</a>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($project->get_project_problem_solution) > 0)
                                                            @foreach ($project->get_project_problem_solution as $key => $item)
                                                                <tr>
                                                                    <td scope="row">{{ $key + 1 }}</td>
                                                                    <td>{{ $item->project_problem_solution_detail }}</td>
                                                                    <td width="20%" align="center">
                                                                        <button
                                                                            class="btn btn-warning btn-sm waves-effect waves-light"
                                                                            onclick="edit_data_project_problem_solution('{{ $item->id }}')">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>
                                                                        <button
                                                                            class="btn btn-danger btn-sm waves-effect waves-light"
                                                                            onclick="destroy_project_problem_solution('{{ $item->id }}')">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="3" align="center">
                                                                    <span
                                                                        class="text-danger">{{ __('msg.msg_no_data') }}</span>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-project-quantitative-indicators"
                                                role="tabpanel"
                                                aria-labelledby="vert-tabs-project-quantitative-indicators-tab">
                                                <form
                                                    action="{{ route('project.manage.quantitative-indicators-store') }}"
                                                    method="post" id="form-project-quantitative-indicators">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="hidden" name="id" id="id">
                                                                <input type="hidden" name="project_id" id="project_id"
                                                                    value="{{ Request::segment(4) }}">
                                                                <input type="text" class="form-control"
                                                                    name="project_quantitative_indicators_value"
                                                                    id="project_quantitative_indicators_value"
                                                                    placeholder="{{ __('msg.placeholder') . __('msg.project_quantitative_indicators_value') }}"
                                                                    autocomplete="off" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    name="project_quantitative_indicators_unit"
                                                                    id="project_quantitative_indicators_unit"
                                                                    placeholder="{{ __('msg.placeholder') . __('msg.project_quantitative_indicators_unit') }}"
                                                                    autocomplete="off" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="submit" class="btn btn-primary btn-block"
                                                                id="btn_save_project_quantitative_indicators"><i
                                                                    class="fas fa-save"></i>
                                                                {{ __('msg.btn_save') }}</button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <small class="text-danger">{{ __('msg.msg_mode') }} :
                                                                <u><span
                                                                        id="project_quantitative_indicators_mode">เพิ่มข้อมูล</span></u></small>
                                                        </div>
                                                    </div>
                                                </form>
                                                <table class="table table-hover table-sm table-striped">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>{{ __('msg.project_quantitative_indicators_value') }}</th>
                                                            <th>{{ __('msg.project_quantitative_indicators_unit') }}</th>
                                                            <th>
                                                                <div style="text-align: center;">
                                                                    <a href="#"
                                                                        onclick="add_data_project_quantitative_indicators()"><i
                                                                            class="fa fa-plus-circle"></i>
                                                                        {{ __('msg.btn_short_add') }}</a>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($project->get_project_quantitative_indicators) > 0)
                                                            @foreach ($project->get_project_quantitative_indicators as $key => $item)
                                                                <tr>
                                                                    <td scope="row">{{ $key + 1 }}</td>
                                                                    <td>{{ $item->project_quantitative_indicators_value }}
                                                                    </td>
                                                                    <td>{{ $item->project_quantitative_indicators_unit }}
                                                                    </td>
                                                                    <td width="20%" align="center">
                                                                        <button
                                                                            class="btn btn-warning btn-sm waves-effect waves-light"
                                                                            onclick="edit_data_project_quantitative_indicators('{{ $item->id }}')">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>
                                                                        <button
                                                                            class="btn btn-danger btn-sm waves-effect waves-light"
                                                                            onclick="destroy_project_quantitative_indicators('{{ $item->id }}')">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="4" align="center">
                                                                    <span
                                                                        class="text-danger">{{ __('msg.msg_no_data') }}</span>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-project-qualitative-indicators"
                                                role="tabpanel"
                                                aria-labelledby="vert-tabs-project-qualitative-indicators-tab">
                                                <form action="{{ route('project.manage.qualitative-indicators-store') }}"
                                                    method="post" id="form-project-qualitative-indicators">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="hidden" name="id" id="id">
                                                                <input type="hidden" name="project_id" id="project_id"
                                                                    value="{{ Request::segment(4) }}">
                                                                <input type="text" class="form-control"
                                                                    name="project_qualitative_indicators_value"
                                                                    id="project_qualitative_indicators_value"
                                                                    placeholder="{{ __('msg.placeholder') . __('msg.project_qualitative_indicators_value') }}"
                                                                    autocomplete="off" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    name="project_qualitative_indicators_unit"
                                                                    id="project_qualitative_indicators_unit"
                                                                    placeholder="{{ __('msg.placeholder') . __('msg.project_qualitative_indicators_unit') }}"
                                                                    autocomplete="off" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="submit" class="btn btn-primary btn-block"
                                                                id="btn_save_project_qualitative_indicators"><i
                                                                    class="fas fa-save"></i>
                                                                {{ __('msg.btn_save') }}</button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <small class="text-danger">{{ __('msg.msg_mode') }} :
                                                                <u><span
                                                                        id="project_qualitative_indicators_mode">เพิ่มข้อมูล</span></u></small>
                                                        </div>
                                                    </div>
                                                </form>
                                                <table class="table table-hover table-sm table-striped">
                                                    <thead class="thead-light">
                                                        <tr> 
                                                            <th>#</th>
                                                            <th>{{ __('msg.project_qualitative_indicators_value') }}</th>
                                                            <th>{{ __('msg.project_qualitative_indicators_unit') }}</th>
                                                            <th>
                                                                <div style="text-align: center;">
                                                                    <a href="#"
                                                                        onclick="add_data_project_qualitative_indicators()"><i
                                                                            class="fa fa-plus-circle"></i>
                                                                        {{ __('msg.btn_short_add') }}</a>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($project->get_project_qualitative_indicators) > 0)
                                                            @foreach ($project->get_project_qualitative_indicators as $key => $item)
                                                                <tr>
                                                                    <td scope="row">{{ $key + 1 }}</td>
                                                                    <td>{{ $item->project_qualitative_indicators_value }}
                                                                    </td>
                                                                    <td>{{ $item->project_qualitative_indicators_unit }}
                                                                    </td>
                                                                    <td width="20%" align="center">
                                                                        <button
                                                                            class="btn btn-warning btn-sm waves-effect waves-light"
                                                                            onclick="edit_data_project_qualitative_indicators('{{ $item->id }}')">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>
                                                                        <button
                                                                            class="btn btn-danger btn-sm waves-effect waves-light"
                                                                            onclick="destroy_project_qualitative_indicators('{{ $item->id }}')">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="4" align="center">
                                                                    <span
                                                                        class="text-danger">{{ __('msg.msg_no_data') }}</span>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-project-output" role="tabpanel"
                                                aria-labelledby="vert-tabs-project-output-tab">
                                                <table class="table table-hover table-sm table-striped">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>{{ __('msg.project_output_detail') }}</th>
                                                            <th>{{ __('msg.project_output_detail_gallery') }}</th>
                                                            <th>
                                                                <div style="text-align: center;">
                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#modal-project-output"
                                                                        onclick="add_data_project_output()"><i
                                                                            class="fa fa-plus-circle"></i>
                                                                        {{ __('msg.btn_add') }}</a>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($project->get_project_output) > 0)
                                                            @foreach ($project->get_project_output as $key => $item)
                                                                <tr>
                                                                    <td scope="row">{{ $key + 1 }}</td>
                                                                    <td>{{ $item->project_output_detail }} <br>
                                                                        <small><u>
                                                                                {{ $item->indicators_type == 'qualitative' ? __('msg.tab_project_qualitative_indicators') : __('msg.tab_project_quantitative_indicators') }}
                                                                            </u> : {{ $item->indicators_value }}
                                                                            ({{ $item->indicators_unit }})
                                                                        </small>
                                                                    </td>
                                                                    <td>
                                                                        <span id="count_image_{{ $item->id }}">
                                                                            @if ($item->total_gallery > 0)
                                                                                <a href="#" data-toggle="modal"
                                                                                    data-target="#modal-manage-gallery-project-output-view"
                                                                                    onclick="manage_output_gallery_show('{{ $item->id }}')">
                                                                                    {{ $item->total_gallery }} รูป
                                                                                </a>
                                                                            @else
                                                                                -
                                                                            @endif
                                                                        </span>
                                                                    </td>
                                                                    <td width="20%" align="center">
                                                                        <button
                                                                            class="btn btn-info btn-sm waves-effect waves-light"
                                                                            data-toggle="modal"
                                                                            data-target="#modal-manage-gallery-project-output"
                                                                            onclick="manage_gallery_project_output('{{ $item->id }}')">
                                                                            <i class="fas fa-images"></i></button>
                                                                        <button
                                                                            class="btn btn-warning btn-sm waves-effect waves-light"
                                                                            data-toggle="modal"
                                                                            data-target="#modal-project-output"
                                                                            onclick="edit_data_project_output('{{ $item->id }}')">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>
                                                                        <button
                                                                            class="btn btn-danger btn-sm waves-effect waves-light"
                                                                            onclick="destroy_project_output('{{ $item->id }}')">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="4" align="center">
                                                                    <span
                                                                        class="text-danger">{{ __('msg.msg_no_data') }}</span>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-project-outcome" role="tabpanel"
                                                aria-labelledby="vert-tabs-project-outcome-tab">
                                                <table class="table table-hover table-sm table-striped">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>{{ __('msg.project_outcome_detail') }}</th>
                                                            <th>
                                                                <div style="text-align: center;">
                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#modal-project-outcome"
                                                                        onclick="add_data_project_outcome()"><i
                                                                            class="fa fa-plus-circle"></i>
                                                                        {{ __('msg.btn_add') }}</a>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($project->get_project_outcome) > 0)
                                                            @foreach ($project->get_project_outcome as $key => $item)
                                                                <tr>
                                                                    <td scope="row">{{ $key + 1 }}</td>
                                                                    <td>{{ $item->project_outcome_detail }} <br>
                                                                        <small><u>
                                                                                {{ $item->indicators_type == 'qualitative' ? __('msg.tab_project_qualitative_indicators') : __('msg.tab_project_quantitative_indicators') }}
                                                                            </u> : {{ $item->indicators_value }}
                                                                            ({{ $item->indicators_unit }})
                                                                        </small>
                                                                    </td>
                                                                    <td width="20%" align="center">
                                                                        <button
                                                                            class="btn btn-warning btn-sm waves-effect waves-light"
                                                                            data-toggle="modal"
                                                                            data-target="#modal-project-outcome"
                                                                            onclick="edit_data_project_outcome('{{ $item->id }}')">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>
                                                                        <button
                                                                            class="btn btn-danger btn-sm waves-effect waves-light"
                                                                            onclick="destroy_project_outcome('{{ $item->id }}')">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="3" align="center">
                                                                    <span
                                                                        class="text-danger">{{ __('msg.msg_no_data') }}</span>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-project-impact" role="tabpanel"
                                                aria-labelledby="vert-tabs-project-impact-tab">
                                                <form action="{{ route('project.manage.impact-store') }}" method="post"
                                                    id="form-project-impact">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <input type="hidden" name="id" id="id">
                                                                <input type="hidden" name="project_id" id="project_id"
                                                                    value="{{ Request::segment(4) }}">
                                                                <input type="text" class="form-control"
                                                                    name="project_impact_detail"
                                                                    id="project_impact_detail"
                                                                    placeholder="{{ __('msg.placeholder') . __('msg.project_impact_detail') }}"
                                                                    autocomplete="off" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="submit" class="btn btn-primary btn-block"
                                                                id="btn_save_project_impact"><i class="fas fa-save"></i>
                                                                {{ __('msg.btn_save') }}</button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <small class="text-danger">{{ __('msg.msg_mode') }} :
                                                                <u><span
                                                                        id="project_impact_mode">เพิ่มข้อมูล</span></u></small>
                                                        </div>
                                                    </div>
                                                </form>
                                                <table class="table table-hover table-sm table-striped">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>{{ __('msg.project_impact_detail') }}</th>
                                                            <th>
                                                                <div style="text-align: center;">
                                                                    <a href="#"
                                                                        onclick="add_data_project_impact()"><i
                                                                            class="fa fa-plus-circle"></i>
                                                                        {{ __('msg.btn_short_add') }}</a>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($project->get_project_impact) > 0)
                                                            @foreach ($project->get_project_impact as $key => $item)
                                                                <tr>
                                                                    <td scope="row">{{ $key + 1 }}</td>
                                                                    <td>{{ $item->project_impact_detail }}</td>
                                                                    <td width="20%" align="center">
                                                                        <button
                                                                            class="btn btn-warning btn-sm waves-effect waves-light"
                                                                            onclick="edit_data_project_impact('{{ $item->id }}')">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>
                                                                        <button
                                                                            class="btn btn-danger btn-sm waves-effect waves-light"
                                                                            onclick="destroy_project_impact('{{ $item->id }}')">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="3" align="center">
                                                                    <span
                                                                        class="text-danger">{{ __('msg.msg_no_data') }}</span>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    <div class="modal fade" id="modal-manage-gallery-project-output" tabindex="-1" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="" method="post" id="form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="dropzone" id="myDropzone"></div>
                        <input type="hidden" name="project_output_id" id="project_output_id">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn_save_gallery_project_output"><i
                                class="fas fa-save"></i>
                            {{ __('msg.btn_save') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i
                                class="fas fa-times-circle"></i> {{ __('msg.btn_close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-manage-project-location" tabindex="-1" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="post" id="form-project-location">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="pcode">{{ __('msg.pname') }}</label>
                            <input type="hidden" name="id" id="id" value="">
                            <input type="hidden" name="project_id" id="project_id" value="{{ Request::segment(4) }}">
                            <select class="custom-select" name="pcode" id="pcode">
                                <option value="">{{ __('msg.select') }}</option>
                                @if (!empty($province))
                                    @foreach ($province as $item)
                                        <option value="{{ $item->pcode }}">
                                            {{ $item->pcode }}-{{ $item->pname }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="acode">{{ __('msg.aname') }}</label>
                            <select class="custom-select" name="acode" id="acode">
                                <option value="">{{ __('msg.select') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tcode">{{ __('msg.tname') }}</label>
                            <select class="custom-select" name="tcode" id="tcode">
                                <option value="">{{ __('msg.select') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mcode">{{ __('msg.mname') }}</label>
                            <select class="custom-select" name="mcode" id="mcode">
                                <option value="">{{ __('msg.select') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn_save_project_location"><i
                                class="fas fa-save"></i>
                            {{ __('msg.btn_save') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i
                                class="fas fa-times-circle"></i> {{ __('msg.btn_close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-manage-gallery-project-output-view" tabindex="-1" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="" method="post" id="form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="project_output_id" value="project_output_id">
                        <div class="row show_gallery">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i
                                class="fas fa-times-circle"></i> {{ __('msg.btn_close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-project-output" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('project.manage.output-store') }}" method="post" id="form-project-output">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="project_output_upgrading">{{ __('msg.project_output_detail') }}</label>
                                    <input type="hidden" name="id" id="id">
                                    <input type="hidden" name="project_id" id="project_id"
                                        value="{{ Request::segment(4) }}">
                                    <input type="text" class="form-control" name="project_output_detail"
                                        id="project_output_detail"
                                        placeholder="{{ __('msg.placeholder') . __('msg.project_output_detail') }}"
                                        autocomplete="off" value="">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="indicators_output_type"
                                            name="indicators_output_type" value="quantitative">
                                        <label for="indicators_output_type"
                                            class="custom-control-label">{{ __('msg.tab_project_quantitative_indicators') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="indicators_output_type2"
                                            name="indicators_output_type" value="qualitative">
                                        <label for="indicators_output_type2"
                                            class="custom-control-label">{{ __('msg.tab_project_qualitative_indicators') }}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="indicators_output_id">{{ __('msg.project_indicator') }}</label>
                                    <select class="custom-select" name="indicators_output_id" id="indicators_output_id">
                                        <option value="">{{ __('msg.select') }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label
                                        for="project_output_upgrading">{{ __('msg.project_output_upgrading') }}</label>
                                    <textarea class="form-control" name="project_output_upgrading" id="project_output_upgrading" rows="3"
                                        placeholder="{{ __('msg.placeholder') }}"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn_save_project_output"><i
                                class="fas fa-save"></i>
                            {{ __('msg.btn_save') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i
                                class="fas fa-times-circle"></i>
                            {{ __('msg.btn_close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modal-project-outcome" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('project.manage.outcome-store') }}" method="post" id="form-project-outcome">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label for="project_output_upgrading">{{ __('msg.project_outcome_detail') }}</label>
                                <div class="form-group">
                                    <input type="hidden" name="id" id="id">
                                    <input type="hidden" name="project_id" id="project_id"
                                        value="{{ Request::segment(4) }}">
                                    <input type="text" class="form-control" name="project_outcome_detail"
                                        id="project_outcome_detail"
                                        placeholder="{{ __('msg.placeholder') . __('msg.project_outcome_detail') }}"
                                        autocomplete="off" value="">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="indicators_outcome_type"
                                            name="indicators_outcome_type" value="quantitative">
                                        <label for="indicators_outcome_type"
                                            class="custom-control-label">{{ __('msg.tab_project_quantitative_indicators') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="indicators_outcome_type2"
                                            name="indicators_outcome_type" value="qualitative">
                                        <label for="indicators_outcome_type2"
                                            class="custom-control-label">{{ __('msg.tab_project_qualitative_indicators') }}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="indicators_outcome_id">{{ __('msg.project_indicator') }}</label>
                                    <select class="custom-select" name="indicators_outcome_id"
                                        id="indicators_outcome_id">
                                        <option value="">{{ __('msg.select') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn_save_project_outcome"><i
                                class="fas fa-save"></i>
                            {{ __('msg.btn_save') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i
                                class="fas fa-times-circle"></i>
                            {{ __('msg.btn_close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
