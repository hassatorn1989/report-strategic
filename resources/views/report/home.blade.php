@extends('layouts.layout-report')
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
                pointFormat: '{series.name}: <b>{point.y:.2f} โครงการ</b>'
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
                name: '{{ __('msg.msg_faculty') }}',
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
                pointFormat: '{series.name}: <b>{point.y:.2f} บาท</b>'
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
                name: '{{ __('msg.msg_budget') }}',
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
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('msg.report_menu_home') }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            {{-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Layout</a></li> --}}
                            <li class="breadcrumb-item active">{{ __('msg.report_menu_home') }}</li>
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
                                <h3>65 </h3>

                                <p>Unique Visitors</p>
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
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
