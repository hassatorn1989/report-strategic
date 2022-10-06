@extends('layouts.layout')
@section('title', __('msg.menu_result_analysis'))
@push('css')
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ url('resources/assets') }}/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
@endpush

@push('script')
    <script>
        var lang = {
            title_add: '{{ __('msg.title_add_result_analysis') }}',
            title_edit: '{{ __('msg.title_edit_result_analysis') }}',
        };
    </script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ url('resources/assets') }}/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <script src="{{ url('resources/assets') }}/app/result_analysis.js?q={{ time() }}"></script>
@endpush

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('msg.menu_result_analysis').__('msg.year_name').' '.$year->year_name }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.index') }}">{{ __('msg.menu_dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('msg.menu_result_analysis').__('msg.year_name').' '.$year->year_name }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if (!empty($strategic))
                    @foreach ($strategic as $item)
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-list"></i>
                                            {{ $item->strategic_name }}</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        @if (is_null($item->get_result_analysis))
                                            <div style="text-align: center;">
                                                <button type="button" class="btn btn-outline-danger btn-lg"
                                                    data-toggle="modal" data-target="#modal-default"
                                                    onclick="add_data('{{ $item->id }}', '{{ $item->strategic_name }}')">
                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                    {{ __('msg.btn_add') }}
                                                </button>
                                            </div>
                                        @else
                                            <div class="callout callout-success">
                                                <u>
                                                    <h5>{{ __('msg.swot_title') }}</h5>
                                                </u>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <u>
                                                            <h5>{{ __('msg.swot_strength') }}</h5>
                                                        </u>
                                                        {!! $item->get_result_analysis->swot_strength !!}
                                                    </div>
                                                    <div class="col-md-6">
                                                        <u>
                                                            <h5>{{ __('msg.swot_weakness') }}</h5>
                                                        </u>
                                                        {!! $item->get_result_analysis->swot_weakness !!}
                                                    </div>
                                                    <div class="col-md-6">
                                                        <u>
                                                            <h5>{{ __('msg.swot_opportunity') }}</h5>
                                                        </u>
                                                        {!! $item->get_result_analysis->swot_opportunity !!}
                                                    </div>
                                                    <div class="col-md-6">
                                                        <u>
                                                            <h5>{{ __('msg.swot_threat') }}</h5>
                                                        </u>
                                                        {!! $item->get_result_analysis->swot_threat !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="callout callout-danger">
                                                <u>
                                                    <h5>{{ __('msg.tow_title') }}</h5>
                                                </u>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <u>
                                                            <h5>{{ __('msg.tow_so') }}</h5>
                                                        </u>
                                                        {!! $item->get_result_analysis->tow_so !!}
                                                    </div>
                                                    <div class="col-md-6">
                                                        <u>
                                                            <h5>{{ __('msg.tow_wo') }}</h5>
                                                        </u>
                                                        {!! $item->get_result_analysis->tow_wo !!}
                                                    </div>
                                                    <div class="col-md-6">
                                                        <u>
                                                            <h5>{{ __('msg.tow_st') }}</h5>
                                                        </u>
                                                        {!! $item->get_result_analysis->tow_st !!}
                                                    </div>
                                                    <div class="col-md-6">
                                                        <u>
                                                            <h5>{{ __('msg.tow_wt') }}</h5>
                                                        </u>
                                                        {!! $item->get_result_analysis->tow_wt !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12" style="text-align: right">
                                                    <button type="button" class="btn btn-warning waves-effect waves-light"
                                                        data-toggle="modal" data-target="#modal-default"
                                                        onclick="edit_data('{{ $item->get_result_analysis->id }}', '{{ $item->strategic_name }}')">
                                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                                        {{ __('msg.btn_edit') }}</button>
                                                    <button class="btn btn-danger waves-effect waves-light"
                                                        onclick="destroy('{{ $item->get_result_analysis->id }}')"> <i
                                                            class="fas fa-trash-alt"></i>
                                                        {{ __('msg.btn_delete') }}</button>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                        </div>
                    @endforeach
                @endif

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
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="year_strategic_id" id="year_strategic_id">
                        <div class="callout callout-success">
                            <u>
                                <h5>{{ __('msg.swot_title') }}</h5>
                            </u>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="swot_strength">{{ __('msg.swot_strength') }}</label>
                                        <textarea class="form-control" name="swot_strength" id="swot_strength" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="swot_weakness">{{ __('msg.swot_weakness') }}</label>
                                        <textarea class="form-control" name="swot_weakness" id="swot_weakness" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="swot_opportunity">{{ __('msg.swot_opportunity') }}</label>
                                        <textarea class="form-control" name="swot_opportunity" id="swot_opportunity" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="swot_threat">{{ __('msg.swot_threat') }}</label>
                                        <textarea class="form-control" name="swot_threat" id="swot_threat" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="callout callout-danger">
                            <u>
                                <h5>{{ __('msg.tow_title') }}</h5>
                            </u>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tow_so">{{ __('msg.tow_so') }}</label>
                                        <textarea class="form-control" name="tow_so" id="tow_so" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tow_wo">{{ __('msg.tow_wo') }}</label>
                                        <textarea class="form-control" name="tow_wo" id="tow_wo" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tow_st">{{ __('msg.tow_st') }}</label>
                                        <textarea class="form-control" name="tow_st" id="tow_st" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tow_wt">{{ __('msg.tow_wt') }}</label>
                                        <textarea class="form-control" name="tow_wt" id="tow_wt" rows="5"></textarea>
                                    </div>
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
