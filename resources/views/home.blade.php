@extends('layouts.default')

@section('content')

    @if(Auth::user()->user_group_id == 2)
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 bordered">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="7800">780</span>
                            </h3>
                            <small>TOTAL Customer</small>
                        </div>
                        <div class="icon">
                            <i class="icon-users"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success green-sharp">
                                <span class="sr-only">100% progress</span>
                            </span>
                        </div>
                        <div class="status">
                            <div class="status-title"> progress </div>
                            <div class="status-number"> 100% </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 bordered">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-blue-sharp">
                                <span data-counter="counterup" data-value="120">120</span>
                            </h3>
                            <small>Total Available Spaces</small>
                        </div>
                        <div class="icon">
                            <i class="icon-pointer"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 60%;" class="progress-bar progress-bar-success blue-sharp">
                                <span class="sr-only">60% grow</span>
                            </span>
                        </div>
                        <div class="status">
                            <div class="status-title"> progress </div>
                            <div class="status-number"> 60% </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 bordered">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-purple-soft">
                                <span data-counter="counterup" data-value="80">80</span>
                            </h3>
                            <small>Total Booked</small>
                        </div>
                        <div class="icon">
                            <i class="icon-lock"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 40%;" class="progress-bar progress-bar-success purple-soft">
                                <span class="sr-only">40% change</span>
                            </span>
                        </div>
                        <div class="status">
                            <div class="status-title"> progress </div>
                            <div class="status-number"> 40% </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 bordered">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="7800">780</span>
                            </h3>
                            <small>TOTAL Customer</small>
                        </div>
                        <div class="icon">
                            <i class="icon-users"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success green-sharp">
                                <span class="sr-only">100% progress</span>
                            </span>
                        </div>
                        <div class="status">
                            <div class="status-title"> progress </div>
                            <div class="status-number"> 100% </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 bordered">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-red-haze">
                                <span data-counter="counterup" data-value="134">134</span>
                            </h3>
                            <small>Total Service Provider</small>
                        </div>
                        <div class="icon">
                            <i class="icon-user"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success red-haze">
                                <span class="sr-only">100% change</span>
                            </span>
                        </div>
                        <div class="status">
                            <div class="status-title"> progress </div>
                            <div class="status-number"> 100% </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 bordered">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-blue-sharp">
                                <span data-counter="counterup" data-value="567">567</span>
                            </h3>
                            <small>Total Available Spaces</small>
                        </div>
                        <div class="icon">
                            <i class="icon-pointer"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 45%;" class="progress-bar progress-bar-success blue-sharp">
                                <span class="sr-only">45% grow</span>
                            </span>
                        </div>
                        <div class="status">
                            <div class="status-title"> progress </div>
                            <div class="status-number"> 45% </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 bordered">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-purple-soft">
                                <span data-counter="counterup" data-value="276">276</span>
                            </h3>
                            <small>Total Booked</small>
                        </div>
                        <div class="icon">
                            <i class="icon-lock"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 57%;" class="progress-bar progress-bar-success purple-soft">
                                <span class="sr-only">56% change</span>
                            </span>
                        </div>
                        <div class="status">
                            <div class="status-title"> progress </div>
                            <div class="status-number"> 57% </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        {{-- Stats of spaces over different cities --}}
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-dark bold uppercase">Most Popular Spaces</span>
                        <span class="caption-helper">Sample Data</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="cityChartBars"></div>
                </div>
            </div>
        </div>

        @if(Auth::user()->user_group_id == 1)
            <div class="col-md-6">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-dark bold uppercase">Booking</span>
                            <span class="caption-helper">Sample Data</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="bookingLineChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-dark bold uppercase">Revenue</span>
                        <span class="caption-helper">Sample Data</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="revenueChart"></div>
                </div>
            </div>
        </div>
        @endif
    </div>

@endsection

@push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!--[if lt IE 9]>
    <script src="https://code.highcharts.com/modules/oldie.js"></script>
    <![endif]-->
    <script>
        $(document).ready(function () {
            // City bar chart
            Highcharts.chart('cityChartBars', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Number of spaces'
                    }

                },
                legend: {
                    enabled: false
                },
                "series": [
                    {
                        "name": "Spaces",
                        "colorByPoint": true, //sets the random colors to each bar
                        "data": [
                            {
                                "name": "Stockholm",
                                "y": 62,
                            },
                            {
                                "name": "Malmö",
                                "y": 112,
                            },
                            {
                                "name": "Gothenburg",
                                "y": 78,
                            },
                            {
                                "name": "Uppsala",
                                "y": 56,
                            },
                            {
                                "name": "Visby",
                                "y": 45,
                            },
                            {
                                "name": "Lund",
                                "y": 121,
                            },
                            {
                                "name": "Linköping",
                                "y": 77,
                            }
                            ,
                            {
                                "name": "Helsingborg",
                                "y": 98,
                            },
                            {
                                "name": "Gävle",
                                "y": 25,
                            },
                            {
                                "name": "Norrköping",
                                "y": 58,
                            },
                            {
                                "name": "Jönköping",
                                "y": 47,
                            },
                            {
                                "name": "Ystad",
                                "y": 69,
                            },
                            {
                                "name": "Copenhagen",
                                "y": 88,
                            },
                            {
                                "name": "Kalmar",
                                "y": 47,
                            },
                            {
                                "name": "Luleå",
                                "y": 39,
                            },
                            {
                                "name": "Others",
                                "y": 65,
                            }
                        ]
                    }
                ],
                credits: false
            });

            //Booking line chart
            Highcharts.chart('bookingLineChart', {
                chart: {
                    type: 'area'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                },
                yAxis: {
                    title: {
                        text: 'Number of Booking'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    area: {
                        dataLabels: {
                            enabled: true
                        },
                        enableMouseTracking: false,
                        lineWidth: 3,
                        lineColor: '#434348',
                        marker: {
                            lineWidth: 3,
                            lineColor: '#434348',
                            fillColor: '#ffffff'
                        }

                    },
                },
                series: [
                    {
                        name: '2018',
                        data: [70, 69, 95, 145, 184, 215, 252, 265, 233, 183, 139, 0]
                    }
                ],
                credits: false
            });

            //Revenue bar and line chart -- mix
            Highcharts.chart('revenueChart', {
                title: {
                    text: ''
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                },
                legend: {
                    enabled: false
                },
                series: [
                    {
                        type: 'column',
                        name: 'Spaces',
                        "colorByPoint": true,
                        data: [70, 69, 95, 145, 184, 215, 252, 265, 233, 183, 139, 0]
                    }, {
                        type: 'spline',
                        name: 'Average',
                        data: [70, 69, 95, 145, 184, 215, 252, 265, 233, 183, 139, 0],
                        marker: {
                            lineWidth: 2,
                            lineColor: Highcharts.getOptions().colors[3],
                            fillColor: 'white'
                        }
                    }],
                credits: false
            });

        });
    </script>
@endpush


