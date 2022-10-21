@extends('layouts.layout-report')
@section('title', __('msg.menu2_report_project_stractegic'))
@push('css')
@endpush
@push('script')
    <script src="{{ url('resources/assets') }}/app/report/report_project_stractegic.js?q={{ time() }}"></script>
@endpush

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h5 class="m-0">{{ __('msg.menu2_report_project_stractegic') }}</h5>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('home.index') }}">{{ __('msg.report_menu_home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('msg.menu2_report_project_stractegic') }}</li>
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
                                <h5 class="card-title m-0">{{ __('msg.msg_list').__('msg.menu2_report_project_stractegic') }}</h5>
                            </div>
                            <div class="card-body">
                               <table id="example1" class="table table-hover table-sm table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="20%">{{ __('msg.project_name') }}</th>
                                            <th width="20%">{{ __('msg.msg_product') }}</th>
                                            <th width="20%">{{ __('msg.msg_process') }}</th>
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
