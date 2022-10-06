@extends('layouts.layout')
@section('title', __('msg.title_manage_project'))
@push('css')
@endpush

@push('script')
    <script>
        var lang = {
            title_add: '{{ __('msg.title_add_project') }}',
            title_edit: '{{ __('msg.title_edit_project') }}',
        };
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
                                    href="{{ route('project.index') }}">{{ __('msg.menu_project') . __('msg.year_name') . ' ' . $project->year_name }}</a>
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
                <div class="row">
                    <div class="col-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-tasks"></i>
                                    {{ $project->project_name }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5 col-sm-3">
                                        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                                            aria-orientation="vertical">
                                            <a class="nav-link active" id="vert-tabs-project-main-tab" data-toggle="pill"
                                                href="#vert-tabs-project-main" role="tab"
                                                aria-controls="vert-tabs-project-main"
                                                aria-selected="true">{{ __('msg.tab_project_main') }}</a>
                                            <a class="nav-link" id="vert-tabs-project-responsible-person-tab"
                                                data-toggle="pill" href="#vert-tabs-project-responsible-person"
                                                role="tab" aria-controls="vert-tabs-project-responsible-person"
                                                aria-selected="false">{{ __('msg.tab_project_responsible_person') }}</a>
                                            <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill"
                                                href="#vert-tabs-messages" role="tab" aria-controls="vert-tabs-messages"
                                                aria-selected="false">Messages</a>
                                            <a class="nav-link" id="vert-tabs-settings-tab" data-toggle="pill"
                                                href="#vert-tabs-settings" role="tab" aria-controls="vert-tabs-settings"
                                                aria-selected="false">Settings</a>
                                        </div>
                                    </div>
                                    <div class="col-7 col-sm-9">
                                        <div class="tab-content" id="vert-tabs-tabContent">
                                            <div class="tab-pane text-left fade show active" id="vert-tabs-project-main"
                                                role="tabpanel" aria-labelledby="vert-tabs-project-main-tab">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="project_name">{{ __('msg.project_name') }}</label>
                                                            <input type="text" class="form-control" name="project_name"
                                                                id="project_name" placeholder="{{ __('msg.placeholder') }}"
                                                                autocomplete="off" value="{{ $project->project_name }}">
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
                                                            <input type="text" class="form-control" name="project_budget"
                                                                id="project_budget"
                                                                placeholder="{{ __('msg.placeholder') }}"
                                                                value="{{ $project->project_budget }}" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="project_period">{{ __('msg.project_period') }}</label>
                                                            <input type="text" class="form-control" name="project_period"
                                                                id="project_period"
                                                                placeholder="{{ __('msg.placeholder') }}"
                                                                value="{{ $project->project_period }}"
                                                                autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="strategic_id">{{ __('msg.strategic_name') }}</label>
                                                            <select class="custom-select" name="year_strategic_id"
                                                                id="year_strategic_id">
                                                                <option value="">{{ __('msg.select') }}</option>
                                                                @if (!empty($year_strategic))
                                                                    @foreach ($year_strategic as $item)
                                                                        <option value="{{ $item->id }}"
                                                                            {{ $item->id == $project->year_strategic_id ? 'selected' : '' }}
                                                                            data-year_strategic_detail="{{ $item->count_year_strategic_detail }}">
                                                                            {{ $item->strategic_name }}</option>
                                                                    @endforeach
                                                                @endif
                                                                <option value="no" data-year_strategic_detail="0">
                                                                    {{ __('msg.strategic_not_specified') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="strategic_id">{{ __('msg.sub_strategic') }}</label>
                                                            <select class="custom-select" name="year_strategic_detail_id"
                                                                id="year_strategic_detail_id" disabled>
                                                                <option value="">{{ __('msg.select') }}</option>
                                                                @if (!empty($year_strategic))
                                                                    @foreach ($year_strategic as $item)
                                                                        <option value="{{ $item->id }}"
                                                                            {{ $item->id == $project->year_strategic_id ? 'selected' : '' }}>
                                                                            {{ $item->strategic_name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="budget_id">{{ __('msg.budget_name') }}</label>
                                                            <select class="custom-select" name="budget_id"
                                                                id="budget_id">
                                                                <option value="">{{ __('msg.select') }}</option>
                                                                @if (!empty($budget))
                                                                    @foreach ($budget as $item)
                                                                        <option value="{{ $item->id }}"
                                                                            {{ $item->id == $project->year_strategic_id ? 'selected' : '' }}
                                                                            data-budget_specify_status="{{ $item->budget_specify_status }}">
                                                                            {{ $item->budget_name }}</option>
                                                                    @endforeach
                                                                @endif
                                                                <option value="no"
                                                                    data-budget_specify_status="inactive">
                                                                    {{ __('msg.budget_not_specified') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="budget_specify_other">{{ __('msg.sub_strategic') }}</label>
                                                            <input type="text" class="form-control"
                                                                name="budget_specify_other" id="budget_specify_other"
                                                                placeholder="{{ __('msg.placeholder') }}" value=""
                                                                autocomplete="off" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label
                                                                for="project_target_group">{{ __('msg.project_target_group') }}</label>
                                                            <textarea class="form-control" name="project_target_group" id="project_target_group" rows="4"
                                                                autocomplete="off" placeholder="{{ __('msg.placeholder') }}"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label
                                                                for="project_problem">{{ __('msg.project_problem') }}</label>
                                                            <textarea class="form-control" name="project_problem" id="project_problem" rows="4" autocomplete="off"
                                                                placeholder="{{ __('msg.placeholder') }}"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label
                                                                for="project_solotion_problem">{{ __('msg.project_solotion_problem') }}</label>
                                                            <textarea class="form-control" name="project_solotion_problem" id="project_solotion_problem" rows="4"
                                                                autocomplete="off" placeholder="{{ __('msg.placeholder') }}"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-project-responsible-person"
                                                role="tabpanel"
                                                aria-labelledby="vert-tabs-project-responsible-person-tab">
                                                <div class="row mb-2">
                                                    <div class="col-md-4 offset-md-8">
                                                        <button type="button" class="btn btn-primary btn-block"
                                                            data-toggle="modal" data-target="#modal-project-responsible-person"
                                                            onclick="add_data_project_responsible_person()">
                                                            <i class="fas fa-plus-circle"></i> {{ __('msg.btn_add') }}
                                                        </button>
                                                    </div>
                                                </div>
                                                <table class="table table-sm">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>{{ __('msg.project_responsible_person_name') }}</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($project->get_project_responsible_person) > 0)
                                                            @foreach ($project->get_project_responsible_person as $key => $item)
                                                                <tr>
                                                                    <td scope="row">{{ $key + 1 }}</td>
                                                                    <td>{{ $item->project_responsible_person_name }}</td>
                                                                    <td></td>
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
                                            <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel"
                                                aria-labelledby="vert-tabs-messages-tab">
                                                Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris.
                                                Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa
                                                eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer
                                                vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit
                                                condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis
                                                velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum
                                                odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla
                                                lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum
                                                metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac
                                                ornare magna.
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-settings" role="tabpanel"
                                                aria-labelledby="vert-tabs-settings-tab">
                                                Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna,
                                                iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor.
                                                Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique.
                                                Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat
                                                urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at
                                                consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse
                                                platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis.
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
    <div class="modal fade" id="modal-project-responsible-person" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
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
                            <label for="project_responsible_person_name">{{ __('msg.project_responsible_person_name') }}</label>
                            <input type="hidden" name="id" id="id">
                            <input type="text" class="form-control" name="project_responsible_person_name" id="project_responsible_person_name"
                                placeholder="{{ __('msg.placeholder') }}" autocomplete="off" value="">
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
