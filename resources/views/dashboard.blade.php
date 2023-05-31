@extends('layouts.layout')
@section('title', __('msg.menu_dashboard'))
@push('css')
@endpush

@push('script')
    <script src="{{ url('resources/assets') }}/plugins/highcharts/highcharts.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/highcharts/highcharts-3d.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/highcharts/modules/exporting.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/highcharts/modules/export-data.js"></script>
    <script src="{{ url('resources/assets') }}/plugins/highcharts/modules/accessibility.js"></script>
    <script>
        // Data retrieved from https://netmarketshare.com/
        // Build the chart
        Highcharts.chart('container1', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
                style: {
                    fontFamily: 'Noto Sans Thai'
                },
            },
            title: {
                text: 'กราฟแสดงจำนวนโครงการแยกหน่วยงาน ปีงบประมาณ {{ $year->year_name }}'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [
                    @foreach ($data2 as $item)
                        {
                            name: '{{ $item->faculty_name }}',
                            y: {{ $item->count_project }}
                        },
                    @endforeach
                ]
            }]
        });
        Highcharts.chart('container2', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
                style: {
                    fontFamily: 'Noto Sans Thai'
                },
            },
            title: {
                text: 'กราฟแสดงงบประมาณแยกหน่วยงาน ปีงบประมาณ {{ $year->year_name }}'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [
                    @foreach ($data2 as $item)
                        {
                            name: '{{ $item->faculty_name }}',
                            y: {{ $item->sum_budget }}
                        },
                    @endforeach
                ]
            }]
        });
    </script>
@endpush

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('msg.menu_dashboard') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.index') }}">{{ __('msg.menu_dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('msg.menu_dashboard') }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $data1->count_project }}</h3>

                                <p>{{ __('msg.msg_project') }}</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-folder"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ num1($data1->sum_budget) }}</h3>

                                <p>{{ __('msg.msg_budget') }}</p>
                            </div>
                            <div class="icon">

                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $data1->count_faculty }}</h3>

                                <p>{{ __('msg.msg_faculty') }}</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-clipboard"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ count($year_strategic) }} </h3>
                                <p>ประเด็นยุทธศาสตร์</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            {{-- <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Online Store Visitors</h3>
                                </div>
                            </div> --}}
                            <div class="card-body">
                                <div id="container1" style="height: 500px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            {{-- <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Online Store Visitors</h3>
                                </div>
                            </div> --}}
                            <div class="card-body">
                                <div id="container2" style="height: 500px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
{{--
@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true"  data-keyboard="false" data-backdrop="static">
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
                            <label for="strategic_name">{{ __('msg.strategic_name') }}</label>
                            <input type="hidden" name="id" id="id">
                            <input type="text" class="form-control" name="strategic_name" id="strategic_name"
                                placeholder="{{ __('msg.placeholder') }}" autocomplete="off">
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
@endsection --}}
