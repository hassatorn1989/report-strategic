@extends('layouts.layout-report')
@section('title', __('msg.menu2_report_project'))
@push('css')
@endpush
@push('script')
    <script src="{{ url('resources/assets') }}/app/report/report_project.js?q={{ time() }}"></script>
@endpush

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h5 class="m-0">{{ __('msg.menu2_report_project') }}</h5>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('home.index') }}">{{ __('msg.report_menu_home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('msg.menu2_report_project') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h5 class="card-title m-0">{{ __('msg.msg_list').__('msg.menu2_report_project') }}</h5>
                            </div>
                            <div class="card-body">
                                {{-- <form action="" method="post">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                              <input type="text"
                                                class="form-control" name="" id="" placeholder="{{ __('msg.placeholder') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select class="custom-select" name="" id="">
                                                    <option value="">{{ __('msg.select') }}</option>
                                                    <option value=""></option>
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select class="custom-select" name="" id="">
                                                    <option value="">{{ __('msg.select') }}</option>
                                                    <option value=""></option>
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select class="custom-select" name="" id="">
                                                    <option value="">{{ __('msg.select') }}</option>
                                                    <option value=""></option>
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form> --}}
                               <table id="example1" class="table table-hover table-sm table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="20%">{{ __('msg.project_name') }}</th>
                                            <th width="20%">{{ __('msg.project_budget') }}</th>
                                            <th width="20%">{{ __('msg.strategic_name') }}</th>
                                            <th width="20%">{{ __('msg.faculty_name') }}</th>
                                           {{--  <th width="25%">{{ __('msg.action') }}</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
@section('modal')

@endsection
