@extends('frontend.layouts.default')
@section('pageTitle', 'Dashboard')

@section('content')

    <!--begin:: Widgets/Stats-->
    <div class="m-portlet  m-portlet--unair">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12 col-lg-6 col-xl-3">

                    <!--begin::Total Profit-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">Thorax Card</h4><br>
                            <span class="m-widget24__desc">Anatomy</span>
                            <span class="m-widget24__stats m--font-brand">9</span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-brand" role="progressbar" style="width: 78%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="m-widget24__change">Change</span>
                            <span class="m-widget24__number">78%</span>
                        </div>
                    </div>

                    <!--end::Total Profit-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">

                    <!--begin::New Feedbacks-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">Abdomen</h4><br>
                            <span class="m-widget24__desc">Anatomy</span>
                            <span class="m-widget24__stats m--font-info">17</span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-info" role="progressbar" style="width: 84%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="m-widget24__change">Change</span>
                            <span class="m-widget24__number">84%</span>
                        </div>
                    </div>

                    <!--end::New Feedbacks-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">

                    <!--begin::New Orders-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">Food and Nutrition</h4><br>
                            <span class="m-widget24__desc">Biochemistry</span>
                            <span class="m-widget24__stats m--font-danger">10</span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-danger" role="progressbar" style="width: 69%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="m-widget24__change">Change</span>
                            <span class="m-widget24__number">69%</span>
                        </div>
                    </div>

                    <!--end::New Orders-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">

                    <!--begin::New Users-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">Clinical Biochemistry</h4><br>
                            <span class="m-widget24__desc">Biochemistry</span>
                            <span class="m-widget24__stats m--font-success">12</span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-success" role="progressbar" style="width: 90%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="m-widget24__change">Change</span>
                            <span class="m-widget24__number">90%</span>
                        </div>
                    </div>

                    <!--end::New Users-->
                </div>
            </div>
        </div>
    </div>

    <!--end:: Widgets/Stats-->


    <!--end:: Widgets/Stats-->

    <div class="m-portlet  m-portlet--unair">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
        </div>
    </div>

    <div class="m-portlet  m-portlet--unair">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div id="container1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
    </div>


@endsection

@push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        // Build the chart
        Highcharts.chart('container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Anatomy Card 1 (Sample data)'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'Completed',
                    y: 70,
                    color: '#7CFC00',
                }, {
                    name: 'Not Yet Completed',
                    y: 30,
                    color: '#FF6666',
                }]
            }]
        });



        Highcharts.chart('container1', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Monthly Attendance - Anatomy (Sample Data)'
            },
            subtitle: {
                /*text: 'Source: WorldClimate.com'*/
            },
            xAxis: {
                categories: [
                    '1',
                    '2',
                    '3',
                    '4',
                    '5',
                    '6',
                    '7',
                    '8',
                    '9',
                    '10',
                    '11',
                    '12',
                    '13',
                    '14',
                    '15',
                    '16',
                    '17',
                    '18',
                    '19',
                    '20',
                    '21',
                    '22',
                    '23',
                    '25',
                    '26',
                    '27',
                    '28',
                    '29',
                    '30'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rainfall (mm)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Present',
                data: [50,20, 30, 50,50,60,30,80,90,200,110,120,70,50,80,30,10,90,110,80,30,120,50,60,40,55,33,60,20,5]

            }, {
                name: 'Absent',
                data: [10,20, 20, 50,50,60,30,150,90,200,10,20,20,5,40,30,10,90,18,30,20,10,50,60,40,55,33,60,20,5]

            },]
        });
    </script>

@endpush

