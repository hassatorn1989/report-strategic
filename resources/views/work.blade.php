@extends('layouts.layout')
@section('title', __('msg.menu_work'))
@push('css')
@endpush

@push('script')
    <script>
        var lang = {
            title_add: '{{ __('msg.title_add_work') }}',
            title_edit: '{{ __('msg.title_edit_work') }}',
        };
    </script>
    <script src="{{ url('resources/assets') }}/app/work.js?q={{ time() }}"></script>
@endpush

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('msg.menu_work') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.index') }}">{{ __('msg.menu_dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('msg.menu_work') }}</li>
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
                                    {{ __('msg.msg_list') . __('msg.menu_work') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="" method="post" id="search-form">
                                    <div class="row mb-2">
                                        <div class="col-md-2 offset-md-10">
                                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                                data-target="#modal-default" onclick="add_data()">
                                                <i class="fas fa-plus-circle"></i> {{ __('msg.btn_add') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    @if (!empty($work))
                                        @foreach ($work as $key => $item)
                                            <div class="col-md-12">
                                                <div class="card card-danger">
                                                    <div class="card-header">
                                                        <h5 class="card-title m-0">{{ $item->project_name }}</h5>
                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool" data-toggle="modal"
                                                                data-target="#modal-default"
                                                                onclick="edit_data('{{ $item->id }}')">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-tool"
                                                                onclick="destroy('{{ $item->id }}')">
                                                                <i class="fas
                                                                fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <h6 class="card-title"><u>ปี {{ $item->year_name }}</u></h6>
                                                        <p class="card-text">
                                                            {!! $item->work_detail !!}
                                                        </p>
                                                        <h6 class="card-title"><u>ปี {{ $item->year_name_compare }}</u>
                                                        </h6>
                                                        <p class="card-text">
                                                            {!! $item->work_detail_compare !!}
                                                        </p>
                                                        <h6 class="card-title"><u>{{ __('msg.work_change') }}</u></h6>
                                                        <p class="card-text">
                                                            {!! $item->work_change !!}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                    @endif
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
    <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
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
                            <label for="project_id">{{ __('msg.project_name') }}</label>
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="year_id" id="year_id" value="{{ $year->id }}">
                            <select class="custom-select" name="project_id" id="project_id">
                                <option value="">{{ __('msg.select') }}</option>
                                @if (!empty($project))
                                    @foreach ($project as $item)
                                        <option value="{{ $item->id }}">{{ $item->project_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="year_now_id">{{ __('msg.year_now') }}</label>
                                            <select class="custom-select" name="year_now_id" id="year_now_id">
                                                <option value="">{{ __('msg.select') }}</option>
                                                @if (!empty($year_all))
                                                    @foreach ($year_all as $item)
                                                        <option value="{{ $item->id }}">{{ $item->year_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="work_detail">{{ __('msg.work_detail') }}</label>
                                            <textarea class="form-control" name="work_detail" id="work_detail" rows="4"
                                                placeholder="{{ __('msg.placeholder') }}"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="year_id_compare">{{ __('msg.year_compare') }}</label>
                                            <select class="custom-select" name="year_id_compare" id="year_id_compare">
                                                <option value="">{{ __('msg.select') }}</option>
                                                @if (!empty($year_all))
                                                    @foreach ($year_all as $item)
                                                        <option value="{{ $item->id }}">{{ $item->year_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="work_detail_compare">{{ __('msg.work_detail') }}</label>
                                            <textarea class="form-control" name="work_detail_compare" id="work_detail_compare" rows="4"
                                                placeholder="{{ __('msg.placeholder') }}"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="work_change">{{ __('msg.work_change') }}</label>
                                    <textarea class="form-control" name="work_change" id="work_change" rows="4"
                                        placeholder="{{ __('msg.placeholder') }}"></textarea>
                                </div>
                            </div>
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
