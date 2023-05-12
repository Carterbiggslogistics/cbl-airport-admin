@extends('layouts.page')
@section('content')
    <div class="main-content">
        <section class="section">
            @include('partials.user.messages')
            <div class="row align-items-center justify-content-between mb-4">
                <ul class="breadcrumb breadcrumb-style mb-0">
                    <li class="breadcrumb-item">
                        <h4 class="page-title m-b-0">Dashboard</h4>
                    </li>
                    <li class="breadcrumb-item ">
                        <a href="index.html">
                            <i data-feather="home"></i></a>
                    </li>
                    <li class="breadcrumb-item active">Data collected on {{ date('d/m/Y') }}</li>
                </ul>
                <filter-form baseurl="/dashboard" />
            </div>
            {{-- @can('isSuperAdmin') --}}
            <div class="row ">
                @can('isNotMmiaAgents')
                    <div class="col-xl-3 col-lg-6">
                        <div class="card l-bg-cherry">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0 custom-overflow-ellipsis-no-wrap">Sample Collections</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">{{ $noOfSampleRequests }} </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="card l-bg-green-dark">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-medkit"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0 custom-overflow-ellipsis-no-wrap">Care Pack Requests</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">{{ $noOfPackRequests }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="card l-bg-orange-dark">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-boxes"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0 custom-overflow-ellipsis-no-wrap">Care Packs Inventory</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">{{ $totalCarePacks }}</h2>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
                <div class="col-xl-3 col-lg-6">
                    <div class="card l-bg-blue-dark">
                        <div class="card-statistic-3 p-4">
                            <div class="card-icon card-icon-large"><i class="fas fa-plane"></i></div>
                            <div class="mb-4">
                                <h5 class="card-title mb-0 custom-overflow-ellipsis-no-wrap">Airport PCR Payments</h5>
                            </div>
                            <div class="row align-items-center mb-2 d-flex">
                                <div class="col-8">
                                    <h2 class="d-flex align-items-center mb-0">{{ $noOfFlights }}</h2>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- @endcan --}}

            {{-- End of other admins card --}}
            @can('isNotMmiaAgents')
                <div class="row">
                    <div class="col-12 col-sm-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Sample Requests</h4>
                            </div>
                            <div class="card-body">
                                <div id="ordersLineChart"></div>
                                <div class="row">
                                    <div class="col-4">
                                        <p class="text-muted font-15 text-truncate">Total</p>
                                        <h5>
                                            {{ $ordersData['total'] }}
                                        </h5>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-muted font-15 text-truncate">Today
                                        </p>
                                        <h5>
                                            {{ $ordersData['today'] }}
                                        </h5>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-muted text-truncate">Last
                                            Month</p>
                                        <h5>
                                            <i
                                                class="fas fa-arrow-circle-up col-green m-r-5"></i>{{ $ordersData['lastMonth'] }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Care Pack Requests</h4>
                            </div>
                            <div class="card-body">
                                <div id="carepacksLineChart"></div>
                                <div class="row">
                                    <div class="col-4">
                                        <p class="text-muted font-15 text-truncate">Total</p>
                                        <h5>
                                            {{ $carePacksData['total'] }}
                                        </h5>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-muted font-15 text-truncate">Today
                                        </p>
                                        <h5>
                                            {{ $carePacksData['today'] }}
                                        </h5>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-muted text-truncate">Last
                                            Month</p>
                                        <h5>
                                            <i
                                                class="fas fa-arrow-circle-up col-green m-r-5"></i>{{ $carePacksData['lastMonth'] }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
            @canany(['isSuperAdmin', 'isMMIAAgent'])
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Passengers Recorded</h4>
                            </div>
                            <div class="card-body">
                                <div style="width: 100%; height: 400px;" id="passengersRecordedBarChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcanany
        </section>
        <div class="settingSidebar">
            <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
            </a>
            <div class="settingSidebar-body ps-container ps-theme-default">
                <div class=" fade show active">
                    <div class="setting-panel-header">Setting Panel
                    </div>
                    <div class="p-15 border-bottom">
                        <h6 class="font-medium m-b-10">Select Layout</h6>
                        <div class="selectgroup layout-color w-50">
                            <label class="selectgroup-item">
                                <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout"
                                    checked>
                                <span class="selectgroup-button">Light</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                                <span class="selectgroup-button">Dark</span>
                            </label>
                        </div>
                    </div>
                    <div class="p-15 border-bottom">
                        <h6 class="font-medium m-b-10">Sidebar Color</h6>
                        <div class="selectgroup selectgroup-pills sidebar-color">
                            <label class="selectgroup-item">
                                <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                                <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                                    data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar"
                                    checked>
                                <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                                    data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="p-15 border-bottom">
                        <div class="theme-setting-options">
                            <label class="m-b-0">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                                    id="mini_sidebar_setting">
                                <span class="custom-switch-indicator"></span>
                                <span class="control-label p-l-10">Mini Sidebar</span>
                            </label>
                        </div>
                    </div>
                    <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                        <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                            <i class="fas fa-undo"></i> Restore Default
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additionalScripts')
    <script>
        const ordersData = JSON.parse('{!! json_encode($ordersData) !!}')

        const passengersRecordedData = JSON.parse('{!! json_encode($passengersRecordedData) !!}')

        const carePacksData = JSON.parse('{!! json_encode($carePacksData) !!}')

        const ordersLineChart = () => {
            const options = {
                series: [{
                    name: "Sample Requests",
                    data: ordersData.values,
                }, ],
                chart: {
                    height: 300,
                    type: "line",
                    dropShadow: {
                        enabled: true,
                        opacity: 0.3,
                        blur: 5,
                        left: -7,
                        top: 22,
                    },
                    toolbar: {
                        show: false,
                    },
                },
                colors: ["#6777EF", "#FEB019"],
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    show: true,
                    curve: "smooth",
                    width: 3,
                    lineCap: "square",
                },
                xaxis: {
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                    crosshairs: {
                        show: true,
                    },
                    categories: ordersData.days,
                    labels: {
                        offsetX: 0,
                        offsetY: 5,
                        style: {
                            fontSize: "12px",
                            fontFamily: "Segoe UI",
                            cssClass: "apexcharts-xaxis-title",
                        },
                    },
                },
                yaxis: {
                    labels: {
                        offsetX: 0,
                        offsetY: 0,
                        style: {
                            fontSize: "12px",
                            fontFamily: "Segoe UI",
                            cssClass: "apexcharts-yaxis-title",
                        },
                    },
                },
                legend: {
                    show: false,
                },
                tooltip: {
                    theme: "dark",
                    marker: {
                        show: true,
                    },
                    x: {
                        show: true,
                    },
                },
            };

            let chart = new ApexCharts(document.getElementById("ordersLineChart"), options);
            chart.render();
        } //end ordersLineChart

        //carepacksLineChart
        const carepacksLineChart = () => {
            const options = {
                series: [{
                    name: "Care Pack Requests",
                    data: carePacksData.values,
                }, ],
                chart: {
                    height: 300,
                    type: "line",
                    dropShadow: {
                        enabled: true,
                        opacity: 0.3,
                        blur: 5,
                        left: -7,
                        top: 22,
                    },
                    toolbar: {
                        show: false,
                    },
                },
                colors: ["#FEB019"],
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    show: true,
                    curve: "smooth",
                    width: 3,
                    lineCap: "square",
                },
                xaxis: {
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                    crosshairs: {
                        show: true,
                    },
                    categories: carePacksData.days,
                    labels: {
                        offsetX: 0,
                        offsetY: 5,
                        style: {
                            fontSize: "12px",
                            fontFamily: "Segoe UI",
                            cssClass: "apexcharts-xaxis-title",
                        },
                    },
                },
                yaxis: {
                    labels: {
                        offsetX: 0,
                        offsetY: 0,
                        style: {
                            fontSize: "12px",
                            fontFamily: "Segoe UI",
                            cssClass: "apexcharts-yaxis-title",
                        },
                    },
                    // max: carePacksData.values.reduce((a, b) => Math.max(a, b)) + 10,
                },
                legend: {
                    show: false,
                },
                tooltip: {
                    theme: "dark",
                    marker: {
                        show: true,
                    },
                    x: {
                        show: true,
                    },
                },
            };

            let chart = new ApexCharts(document.getElementById("carepacksLineChart"), options);
            chart.render();
        } //end carepacksLineChart

        const passengersRecordedBarChart = () => {
            am4core.ready(function() {
                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                /**
                 * Chart design taken from Samsung health app
                 */

                var chart = am4core.create("passengersRecordedBarChart", am4charts.XYChart);
                chart.hiddenState.properties.opacity = 0; // this creates initial fade-in


                chart.data = passengersRecordedData.days.map((day, index) => {
                    return {
                        day,
                        count: passengersRecordedData.values[index]
                    }
                })

                // chart.dateFormatter.inputDateFormat = "YYYY-MM-dd";
                // chart.zoomOutButton.disabled = true;

                var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "day";
                categoryAxis.renderer.grid.template.location = 0;
                categoryAxis.renderer.minGridDistance = 10;
                categoryAxis.tooltip.hiddenState.properties.opacity = 1;
                categoryAxis.tooltip.hiddenState.properties.visible = true;
                categoryAxis.renderer.labels.template.fill = am4core.color("#8e8da4");


                // categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
                // if (target.dataItem && target.dataItem.index & 2 == 2) {
                //     return dy + 25;
                // }
                // return dy;
                // });

                // var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                // dateAxis.renderer.grid.template.strokeOpacity = 0;
                // dateAxis.renderer.minGridDistance = 10;
                // dateAxis.dateFormats.setKey("day", "d");
                // dateAxis.tooltip.hiddenState.properties.opacity = 1;
                // dateAxis.tooltip.hiddenState.properties.visible = true;
                // dateAxis.renderer.labels.template.fill = am4core.color("#8e8da4");

                var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis.renderer.inside = true;
                valueAxis.renderer.grid.template.strokeOpacity = 0;
                valueAxis.min = 0;
                valueAxis.cursorTooltipEnabled = false;
                valueAxis.renderer.labels.template.fill = am4core.color("#8e8da4");

                // goal guides
                var axisRange = valueAxis.axisRanges.create();
                axisRange.value = 6000;
                axisRange.grid.strokeOpacity = 0.1;
                axisRange.label.text = "Goal";
                axisRange.label.align = "right";
                axisRange.label.verticalCenter = "bottom";

                valueAxis.renderer.gridContainer.zIndex = 1;

                var axisRange2 = valueAxis.axisRanges.create();
                axisRange2.value = 12000;
                axisRange2.grid.strokeOpacity = 0.1;
                axisRange2.label.text = "2x goal";
                axisRange2.label.align = "right";
                axisRange2.label.verticalCenter = "bottom";
                axisRange2.label.fillOpacity = 0.8;

                var series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.valueY = "count";
                series.dataFields.categoryX = "day";
                series.tooltipText = "{valueY.value}";
                series.tooltip.pointerOrientation = "vertical";
                series.tooltip.hiddenState.properties.opacity = 1;
                series.tooltip.hiddenState.properties.visible = true;

                var columnTemplate = series.columns.template;
                columnTemplate.width = 30;
                columnTemplate.column.cornerRadiusTopLeft = 20;
                columnTemplate.column.cornerRadiusTopRight = 20;
                columnTemplate.strokeOpacity = 0;

                columnTemplate.adapter.add("fill", function(fill, target) {
                    var dataItem = target.dataItem;
                    if (dataItem.valueY > 6000) {
                        return am4core.color("#10CFBD");
                    } else {
                        return am4core.color("#a8b3b7");
                    }
                });

                var cursor = new am4charts.XYCursor();
                cursor.behavior = "panX";
                chart.cursor = cursor;
                cursor.lineX.disabled = true;

                var middleLine = chart.plotContainer.createChild(am4core.Line);
                middleLine.strokeOpacity = 1;
                middleLine.stroke = am4core.color("#000000");
                middleLine.strokeDasharray = "2,2";
                middleLine.align = "center";
                middleLine.zIndex = 1;
                middleLine.adapter.add("y2", function(y2, target) {
                    return target.parent.pixelHeight;
                });

                cursor.events.on("cursorpositionchanged", updateTooltip);
                dateAxis.events.on("datarangechanged", updateTooltip);

                function updateTooltip() {
                    dateAxis.showTooltipAtPosition(0.5);
                    series.showTooltipAtPosition(0.5, 0);
                    series.tooltip.validate(); // otherwise will show other columns values for a second
                }
            }); // end am4core.ready()
        } //end passengersRecordedBarChart

        $(() => {
            console.log("===================================================")
            try {
                ordersLineChart();

            } catch (e) {}
            try {
                passengersRecordedBarChart();

            } catch (e) {}
            try {
                carepacksLineChart();

            } catch (e) {}
        });

    </script>
@endsection
