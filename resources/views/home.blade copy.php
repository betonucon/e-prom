
@extends('layouts.app')
@push('datatable')
        
        
    <script type="text/javascript">
        function load_data(){
			$.ajax({ 
                type: 'GET', 
                url: "{{ url('home/get_data_one')}}", 
                data: { ide: 1 }, 
                dataType: 'json',
                success: function (data) {
                    $.each(data, function(i, result){
                       
                    });
                }
            });
        }

        $(document).ready(function() {
			load_data();

		});
    </script>
@endpush
@section('content')
    

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">DASHBOARD</h4>

                            <div class="page-title-right">
                            <span onclick="location.assign(`{{url('service/view')}}?id={{encoder(0)}}`)" class="btn btn-success btn-sm waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> New Service</span>
                            </div>

                        </div>
                    </div>
                </div>
                

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div id="chart-pie" data-colors="[&quot;--vz-primary&quot;, &quot;--vz-success&quot;, &quot;--vz-warning&quot;, &quot;--vz-danger&quot;, &quot;--vz-info&quot;]" class="e-charts" _echarts_instance_="ec_1685890680648" style="-webkit-tap-highlight-color: transparent; user-select: none; position: relative;"><div style="position: relative; width: 482px; height: 350px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;"><canvas data-zr-dom-id="zr_0" width="482" height="350" style="position: absolute; left: 0px; top: 0px; width: 482px; height: 350px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div><div class=""></div></div>
                                    </div>
                                    <div class="col-md-4">
                                    
                                        <div class="card-body">

                                            <div class="row align-items-center">
                                                <div class="col-6">
                                                    <h6 class="text-muted text-uppercase fw-semibold text-truncate fs-12 mb-3">
                                                        Total Nilai</h6>
                                                    <h4 class="fs- mb-0">{{uang(sum_dashboard_customer())}}</h4>
                                                    </span> Customer PT KPDP</p>
                                                </div><!-- end col -->
                                                <div class="col-6">
                                                    <div class="text-center">
                                                        <img src="assets/images/illustrator-1.png" class="img-fluid" alt="">
                                                    </div>
                                                </div><!-- end col -->
                                            </div><!-- end row -->
                                            <div class="mt-3 pt-2">
                                                <div class="progress progress-lg rounded-pill">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: 18%" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 16%" aria-valuenow="16" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 19%" aria-valuenow="19" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div><!-- end -->

                                            <div class="mt-3 pt-2">
                                                <div class="d-flex mb-2">
                                                    <div class="flex-grow-1">
                                                        <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-primary me-2"></i>Total
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <p class="mb-0">{{total_dashboard(1,1)}} (Rp.{{uang(total_dashboard(2,1))}})</p>
                                                    </div>
                                                </div><!-- end -->
                                                <div class="d-flex mb-2">
                                                    <div class="flex-grow-1">
                                                        <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-success me-2"></i>Penyusunan
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <p class="mb-0">{{total_dashboard(1,2)}} (Rp.{{uang(total_dashboard(2,2))}})</p>
                                                    </div>
                                                </div><!-- end -->
                                                <div class="d-flex mb-2">
                                                    <div class="flex-grow-1">
                                                        <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-warning me-2"></i>Evaluasi Pimpinan
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <p class="mb-0">{{total_dashboard(1,3)}}  (Rp.{{uang(total_dashboard(2,3))}})</p>
                                                    </div>
                                                </div><!-- end -->
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-danger me-2"></i>Progres
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <p class="mb-0">{{total_dashboard(1,4)}} (Rp.{{uang(total_dashboard(2,4))}})</p>
                                                    </div>
                                                </div><!-- end -->
                                                <div class="d-flex mb-2">
                                                    <div class="flex-grow-1">
                                                        <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-info me-2"></i>Selesai
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <p class="mb-0">{{total_dashboard(1,5)}} (Rp.{{uang(total_dashboard(2,5))}})</p>
                                                    </div>
                                                </div><!-- end -->
                                                
                                                
                                                
                                            </div><!-- end -->

                                            <div class="mt-2 text-center">
                                               
                                            </div>

                                        </div>



                                    </div>
                                </div>
                                
                            </div>
                            
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div id="custom_datalabels_bar" data-colors='["--vz-success", "--vz-primary"]' class="apex-charts" dir="ltr"></div>
                                    </div>
                                    <div class="col-md-5">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        
@endsection
@push('ajax')
        <script src="{{url_plug()}}/assets/libs/echarts/echarts.min.js"></script>
        <script src="{{url_plug()}}/assets/libs/apexcharts/apexcharts.min.js"></script>
        <script type="text/javascript">
            function getChartColorsArray(t) {
                if (null !== document.getElementById(t)) {
                    var t = document.getElementById(t).getAttribute("data-colors");
                    return (t = JSON.parse(t)).map(function(t) {
                        var e = t.replace(" ", "");
                        if (-1 === e.indexOf(",")) {
                            var a = getComputedStyle(document.documentElement).getPropertyValue(e);
                            return a || e
                        }
                        t = t.split(",");
                        return 2 != t.length ? e : "rgba(" + getComputedStyle(document.documentElement).getPropertyValue(t[0]) + "," + t[1] + ")"
                    })
                }
            }
            var chartDatalabelsBarColors = getChartColorsArray("custom_datalabels_bar");
                chartDatalabelsBarColors && (options = {
                    series: [{
                        data: [
                            @foreach(get_dashboard_customer() as $o)
                                {{$o->total}},
                            @endforeach
                        ]
                    }],
                    chart: {
                        type: "bar",
                        height: 350,
                        toolbar: {
                            show: !1
                        }
                    },
                    plotOptions: {
                        bar: {
                            barHeight: "100%",
                            distributed: !0,
                            horizontal: !0,
                            dataLabels: {
                                position: "bottom"
                            }
                        }
                    },
                    colors: chartDatalabelsBarColors,
                    dataLabels: {
                        enabled: !0,
                        textAnchor: "start",
                        style: {
                            colors: ["#fff"]
                        },
                        formatter: function(t, e) {
                            return e.w.globals.labels[e.dataPointIndex] + ":  " + t
                        },
                        offsetX: 5,
                        dropShadow: {
                            enabled: !1
                        }
                    },
                    stroke: {
                        width: 1,
                        colors: ["#fff"]
                    },
                    xaxis: {
                        categories: [
                            @foreach(get_dashboard_customer() as $o)
                                "{{$o->customer}}",
                            @endforeach
                        ]
                    },
                    yaxis: {
                        labels: {
                            show: !1
                        }
                    },
                    title: {
                        text: "Customer PO",
                        align: "center",
                        floating: !0,
                        style: {
                            fontWeight: 500
                        }
                    },
                    subtitle: {
                        text: "Customer Project PT KPDP",
                        align: "center"
                    },
                    tooltip: {
                        theme: "dark",
                        x: {
                            show: !1
                        },
                        y: {
                            title: {
                                formatter: function() {
                                    return ""
                                }
                            }
                        }
                    }
                }, (chart = new ApexCharts(document.querySelector("#custom_datalabels_bar"), options)).render());
            
            var chartPieColors = getChartColorsArray("chart-pie");
                chartPieColors && (chartDom = document.getElementById("chart-pie"), myChart = echarts.init(chartDom), (option = {
                    tooltip: {
                        trigger: "item"
                    },
                    legend: {
                        orient: "vertical",
                        left: "left",
                        textStyle: {
                            color: "#858d98"
                        }
                    },
                    color: chartPieColors,
                    series: [{
                        name: "Access From",
                        type: "pie",
                        radius: "50%",
                        data: [{
                            value: {{total_dashboard(1,1)}},
                            name: "Total Project"
                        }, {
                            value: {{total_dashboard(1,2)}},
                            name: "Penyusunan RABOB"
                        },{
                            value: {{total_dashboard(1,3)}},
                            name: "Evaluasi Pimpinan"
                        }, {
                            value:{{total_dashboard(1,4)}},
                            name: "Progres"
                        }, {
                            value:{{total_dashboard(1,5)}},
                            name: "Selesai"
                        }],
                        emphasis: {
                            itemStyle: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: "rgba(0, 0, 0, 0.5)"
                            }
                        }
                    }],
                    textStyle: {
                        fontFamily: "Poppins, sans-serif"
                    }
                }) && myChart.setOption(option));
        </script>
@endpush   