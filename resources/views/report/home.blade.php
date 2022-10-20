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
    <script src="{{ url('resources/assets') }}/app/home.js?q={{ time() }}"></script>
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
                                <h3>{{ count($year_strategic) }}</h3>
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
                            <div class="card-body">
                                <div id="container1" style="height: 500px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div id="container2" style="height: 500px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                @if (!empty($year_strategic))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header border-transparent">
                                    <h3 class="card-title">
                                        รายงานผลการดำเนินงานภายใต้ยุทธสาสตร์มหาวิทยาลัยราชภัฎเพื่อการพัฒนาท้องถิ่น ประจำปี
                                        {{ $year->year_name }}</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table m-0">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" colspan="2">
                                                        <div style="text-align: center;">ประเด็นยุทธศาสตร์</div>
                                                    </th>
                                                    <th colspan="3">
                                                        <div style="text-align: center;">งบประมาณแผ่นดิน</div>
                                                    </th>
                                                    <th rowspan="2">
                                                        <div style="text-align: center;">รวม</div>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>งบประมาณแผ่นดิน</th>
                                                    <th>งบประมาณรายได้มหาวิทยาลัย</th>
                                                    <th>งบประมาณสนับสนุนอื่น ๆ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($year_strategic as $key => $item)
                                                    <tr>
                                                        <td>{{ $key + 1 }})</td>
                                                        <td><a href="#" data-toggle="modal"
                                                                data-target="#modal-detail-strategic"
                                                                onclick="get_project('{{ $item->id }}', '{{ $item->strategic_name }}')">{{ $item->strategic_name }}</a>
                                                        </td>
                                                        <td>{{ count($item->get_project1) > 0 ? count($item->get_project1) : '-' }}
                                                        </td>
                                                        <td>{{ count($item->get_project2) > 0 ? count($item->get_project2) : '-' }}
                                                        </td>
                                                        <td>{{ count($item->get_project3) > 0 ? count($item->get_project3) : '-' }}
                                                        </td>
                                                        <td>{{ count($item->get_project) > 0 ? count($item->get_project) : '-' }}
                                                        </td>
                                                    </tr>
                                                    @if (count($item->get_year_strategic_detail) > 0)
                                                        @foreach ($item->get_year_strategic_detail as $key1 => $item1)
                                                            <tr class="table-secondary">
                                                                <td></td>
                                                                <td>&nbsp;&nbsp;&nbsp;&nbsp; - <a href="#" data-toggle="modal"
                                                                data-target="#modal-detail-strategic"
                                                                onclick="get_project_detail('{{ $item1->id }}', '{{ $item->strategic_name }}', '{{ $item1->year_strategic_detail_detail }}')">{{ $item1->year_strategic_detail_detail }}</a>
                                                                </td>
                                                                <td>{{ count($item1->get_project1) > 0 ? count($item1->get_project1) : '-' }}
                                                                </td>
                                                                <td>{{ count($item1->get_project2) > 0 ? count($item1->get_project2) : '-' }}
                                                                </td>
                                                                <td>{{ count($item1->get_project3) > 0 ? count($item1->get_project3) : '-' }}
                                                                </td>
                                                                <td>{{ count($item1->get_project) > 0 ? count($item1->get_project) : '-' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="modal-detail-strategic" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h5><u>งบประมาณแผ่นดิน</u></h5>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped table-sm" id="project1">
                                    <thead  class="thead-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>{{ __('msg.project_name') }}</th>
                                            <th width="20%">{{ __('msg.project_budget') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                    </div>
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h5><u>งบประมาณรายได้มหาวิทยาลัย</u></h5>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped table-sm" id="project2">
                                    <thead  class="thead-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>{{ __('msg.project_name') }}</th>
                                            <th width="20%">{{ __('msg.project_budget') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                    </div>
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h5><u>งบประมาณสนับสนุนอื่น ๆ</u></h5>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped table-sm" id="project3">
                                    <thead  class="thead-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>{{ __('msg.project_name') }}</th>
                                            <th width="20%">{{ __('msg.project_budget') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> <i
                            class="fas fa-times-circle"></i>
                        {{ __('msg.btn_close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
