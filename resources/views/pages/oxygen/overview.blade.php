@extends('layouts.page')
@section('content')
    <div class="main-content">
        <section class="section">
            @include('partials.user.messages')
            <div class="row align-items-center justify-content-between mb-4">
                <ul class="breadcrumb breadcrumb-style mb-0">
                    <li class="breadcrumb-item">
                        <h4 class="page-title m-b-0">Oxygen Overview</h4>
                    </li>
                    <li class="breadcrumb-item ">
                        <a href="index.html">
                            <i data-feather="home"></i></a>
                    </li>
                    <li class="breadcrumb-item active">Data collected on {{ date('d/m/Y') }}</li>
                    <li class="breadcrumb-item">
                        <a href="/oxygen/inventory/add-actions" class="btn btn-success" style="float:right;">Update Oxygen
                            Cylinder Inventory</a>
                    </li>

                </ul>
                <filter-form baseurl="/oxygen/inventory" />
            </div>
            <div class="row ">
                <div class="col-xl-4 col-lg-6">
                    <div class="card l-bg-cherry">
                        <div class="card-statistic-3 p-4">
                            <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
                            <div class="mb-4">
                                <h5 class="card-title mb-0 custom-overflow-ellipsis-no-wrap">Total No. Cylinders</h5>
                            </div>
                            <div class="row align-items-center mb-2 d-flex">
                                <div class="col-8">
                                    <h4 class="d-flex align-items-center mb-0">{{ $cylindersData['total'] }} </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($cylindersData['plants'] as $plant)
                    <div class="col-xl-4 col-lg-6">
                        <div class="card l-bg-cherry">
                            <div class="card-statistic-3 p-4 oxygen-plant-cylinder-card">
                                <div class="hover-details">
                                    <div class="row head">
                                        <div class="col-4">Size</div>
                                        <div class="col">Quantity</div>
                                    </div>
                                    @foreach ($plant['sizes'] as $size)
                                        <div class="row body">
                                            <div class="col-4">{{ $size['size'] }} m3</div>
                                            <div class="col">{{ $size['count'] }}</div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0 custom-overflow-ellipsis-no-wrap">
                                        ({{ $plant['name'] }}) Cylinder Count</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h4 class="d-flex align-items-center mb-0">{{ $plant['total'] }} </h4>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach


                <div class="col-xl-4 col-lg-6">
                    <div class="card l-bg-blue-dark">
                        <div class="card-statistic-3 p-4">
                            <div class="card-icon card-icon-large"><i class="fas fa-plane"></i></div>
                            <div class="mb-4">
                                <h5 class="card-title mb-0 custom-overflow-ellipsis-no-wrap">Supply Requests</h5>
                            </div>
                            <div class="row align-items-center mb-2 d-flex">
                                <div class="col-8">
                                    <h4 class="d-flex align-items-center mb-0">
                                        {{ $oxygenRequestsData['supply_requests'] }}</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-12">
                    <div class="card l-bg-green-dark">
                        <div class="card-statistic-3 p-4">
                            <div class="card-icon card-icon-large"><i class="fas fa-medkit"></i></div>
                            <div class="mb-4">
                                <h5 class="card-title mb-0 custom-overflow-ellipsis-no-wrap">Unreturned Cylinders</h5>
                            </div>
                            <div class="row align-items-center mb-2 d-flex">
                                <div class="col-8">
                                    <h4 class="d-flex align-items-center mb-0">
                                        {{ $cylindersData['pendingCylinders'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Supply Request Analysis</h4>
                        </div>
                        <div class="card-body">
                            <div id="requestsLineChart"></div>
                            <div class="row">
                                <div class="col-4">
                                    <p class="text-muted font-15 text-truncate">Total</p>
                                    <h5>
                                        {{ $oxygenRequestsData['total_past_week'] }}
                                    </h5>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted font-15 text-truncate">Today
                                    </p>
                                    <h5>
                                        {{ $oxygenRequestsData['today'] }}
                                    </h5>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted text-truncate">
                                        Last Month
                                    </p>
                                    <h5>
                                        <i class="fas fa-arrow-circle-up col-green m-r-5"></i>
                                        {{ $oxygenRequestsData['lastMonth'] }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Oxygen supply Activity</h4>
                        </div>
                        <div class="card-body">
                            <div id="cylindersDataLineChart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Region Data ( Supply Request )</h4>
                        </div>
                        <div class="card-body">
                            <div style="width: 100%; height: 400px;" id="regionDataBarChart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Oxygen supply trends between plants (Supply Count)</h4>
                        </div>
                        <div class="card-body">
                            <div id="plantsRequestLineChart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Oxygen supply trends between plants (Cylinder Count)</h4>
                        </div>
                        <div class="card-body">
                            <div id="plantsRequestCylLineChart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h4 class="h4">Oxygen Supplies</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th class="text-center pt-3">
                                                <div class="custom-checkbox custom-checkbox-table custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        data-checkbox-role="dad" class="custom-control-input"
                                                        id="checkbox-all">
                                                    <label for="checkbox-all" class="custom-control-label">&nbsp;
                                                    </label>
                                                </div>
                                            </th>
                                            <th>Date</th>
                                            <th>Client</th>
                                            <th>Plant</th>
                                            <th>No. of Cylinders</th>
                                            {{-- <th>Price</th> --}}
                                            <th>Requesting Pickup</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($oxygenRequests as $oRequest)
                                            <tr>
                                                <td class="text-center pt-2">
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" data-checkboxes="mygroup"
                                                            class="custom-control-input" id="checkbox-1">
                                                        <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td> {{ $oRequest->created_at->format('F j, Y') }}</td>
                                                <td> {{ $oRequest->client->name }}</td>
                                                <td> {{ $oRequest->plant->name }}</td>
                                                <td> {{ $oRequest->noOfCylinders }}</td>
                                                {{-- <td> N {{ convertToPriceString($oRequest->price) }}</td> --}}
                                                <td> <span
                                                        class="badge custom-badge-{{ $oRequest->isRequestingPickup ? '' : 'secondary' }} badge-{{ $oRequest->isRequestingPickup ? 'danger' : '' }}">{{ $oRequest->isRequestingPickup ? 'Yes' : 'No' }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge {{ $oRequest->status == 'ON-ROUTE' ? 'badge-warning' : ($oRequest->status == 'DELIVERED' ? 'badge-secondary' : 'badge-success') }} ">{{ $oRequest->status }}</span>
                                                </td>

                                                <td>
                                                    <a href="/oxygen/request/{{ $oRequest->id }}"
                                                        class="btn btn-primary">Details</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $oxygenRequests->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 card">
                    <div class="card-header">
                        <h4 class="h4">Oxygen Additions to Plants</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <th class="text-center pt-3">
                                            <div class="custom-checkbox custom-checkbox-table custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                                                    class="custom-control-input" id="checkbox-all">
                                                <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>Date</th>
                                        <th>Plant</th>
                                        <th>Size (m3)</th>
                                        <th>Quantity</th>
                                        <th>CollectedBy</th>
                                        <th>ReceivedFrom</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($addRequests as $request)
                                        <tr>
                                            <td class="text-center pt-2">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        class="custom-control-input" id="checkbox-1">
                                                    <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>{{ $request->created_at->format('F j, Y') }}</td>
                                            <td>{{ $request->plant->name }}</td>
                                            <td>{{ $request->size->size }}</td>
                                            <td>{{ $request->count }}</td>
                                            <td>{{ $request->collectedBy }}</td>
                                            <td>{{ $request->receivedFrom }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $addRequests->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>

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
        const requestsData = JSON.parse('{!! json_encode($oxygenRequestsData) !!}')
        const cylindersData = JSON.parse('{!! json_encode($cylindersData) !!}')
        const regionData = JSON.parse('{!! json_encode($regionData) !!}')

        console.log("======================================================================");
        console.log(requestsData);

        const requestsLineChart = () => {
            const options = {
                series: [{
                    name: "Sample Requests",
                    data: requestsData.values,
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
                    categories: requestsData.days,
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

            let chart = new ApexCharts(document.getElementById("requestsLineChart"), options);
            chart.render();
        } //end ordersLineChart

        const cylindersDataChart = () => {
            const options = {
                series: [{
                        name: "Sent Cylinders",
                        data: cylindersData.sent,
                    },
                    {
                        name: "Picked Up Cylinders",
                        data: cylindersData.pickedUp,
                    },
                    {
                        name: "Net",
                        data: cylindersData.net,
                    },
                ],
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
                colors: ["#6777EF", "#FEB019", "#Ff00ff"],
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
                    categories: cylindersData.xMarkers,
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

            let chart = new ApexCharts(document.getElementById("cylindersDataLineChart"), options);
            chart.render();
        } //end ordersLineChart

        const plantsRequestChart = () => {
            let countSeries = requestsData.plants.map(plant => {
                return {
                    name: plant.name,
                    data: plant.values
                }
            })

            let cylSeries = requestsData.plants.map(plant => {
                return {
                    name: plant.name,
                    data: plant.cylValues
                }
            })

            let options = {
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
                colors: ["#6777EF", "#FEB019", "#B255D9", "#69EFF0", "#9BF828", "#C59FF0", "#A39B7C", "#F86165"],
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
                    categories: requestsData.days,
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
                    show: true,
                    position: 'top',
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

            options.series = countSeries;
            let chart = new ApexCharts(document.getElementById("plantsRequestLineChart"), options);

            options.series = cylSeries;
            let chart2 = new ApexCharts(document.getElementById("plantsRequestCylLineChart"), options);

            chart.render();
            chart2.render();
        } //end plantsRequestChart

        const regionDataBarChart = () => {
            am4core.ready(() => {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                // Create chart instance
                var chart = am4core.create("regionDataBarChart", am4charts.XYChart);

                chart.data = regionData.xMarkers.map((val, index) => {
                    return {
                        xMarker: regionData.xMarkers[index],
                        yMarker: regionData.yMarkers[index]
                    }
                });

                // Create axes

                var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "xMarker";
                categoryAxis.renderer.grid.template.location = 0;
                categoryAxis.renderer.minGridDistance = 30;

                categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
                    if (target.dataItem && target.dataItem.index & 2 == 2) {
                        return dy + 25;
                    }
                    return dy;
                });

                var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

                // Create series
                var series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.valueY = "yMarker";
                series.dataFields.categoryX = "xMarker";
                series.name = "Supply Requests";
                series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
                series.columns.template.fillOpacity = .8;

                var columnTemplate = series.columns.template;
                columnTemplate.strokeWidth = 2;
                columnTemplate.strokeOpacity = 1;

            }); // end am4core.ready()
        } //end passengersRecordedBarChart

        $(() => {
            try {
                requestsLineChart();
            } catch (e) {}

            try {
                cylindersDataChart();
            } catch (e) {}

            try {
                plantsRequestChart();
            } catch (e) {}
            try {
                regionDataBarChart();
            } catch (e) {}
        });

    </script>
@endsection
