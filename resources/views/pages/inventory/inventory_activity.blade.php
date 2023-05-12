@extends('layouts.page')
@section('content')
    <div class="main-content">
        @include('partials.user.messages')
        <section class="section">

            <div class="row align-items-center justify-content-between">
                <ul class="breadcrumb breadcrumb-style ">
                    <li class="breadcrumb-item">
                        <h4 class="page-title m-b-0">Inventory</h4>
                    </li>
                    <li class="breadcrumb-item">
                        <button href="#" data-toggle="modal" data-target="#transferModal" class="btn btn-success"
                            style="float:right;">Transfer packs between warehouses</button>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/manage-packs" class="btn btn-primary" style="float:right;">View Inventory Items</a>
                    </li>
                </ul>
                <filter-form baseurl="/inventory-activity" />
            </div>

            {{-- Summary cards --}}
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Care Packs</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalCarePacks }}
                            </div>
                        </div>
                        <div class="card-chart">
                            <canvas id="total-pack-chart" height="80"></canvas>
                        </div>
                    </div>
                </div>
                @foreach ($warehouses as $warehouse)
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="card card-statistic-2">

                            <div class="card-wrap ">
                                <div class="card-header">
                                    <h4>Total Care Pack ({{ $warehouse->location }})</h4>
                                </div>
                                <div class="card-body">
                                    {{ $warehouse->getNumberOfCarePacksBeforeAndAt($endDate) }}
                                </div>
                            </div>
                            <div class="card-chart">
                                <canvas id="warehouse-chart-{{ $warehouse->id }}" height="80"></canvas>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-12 col-sm-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Total Care Pack ({{ ucwords(strtolower($stepType)) }})</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart1"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Inventory input against Deduction (All)</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart2"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($inputOutputData['warehouses'] as $key => $warehouse)
                    <div class="col-12 col-sm-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Inventory input against Deduction ({{ $warehouse['location'] }})</h4>
                            </div>
                            <div class="card-body">
                                <div id="chartw{{ $key }}"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Care Pack Inventory Activity</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive col-md-6" id="proTeamScroll">
                                    <div class="badge l-bg-green mb-2">ADDITIONS (Packs Received)</div>
                                    <table class="table table-striped" id="table-2">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Quantity</th>
                                                <th>Warehouse</th>
                                                <th>Received From</th>
                                                <th>Collected By</th>
                                            </tr>
                                        </thead>
                                        @foreach ($packsReceived as $pack)
                                            <tr>
                                                <td>{{ $pack->created_at->format('F j, Y') }}</td>
                                                <td>{{ $pack->quantity }}</td>
                                                <td>{{ $pack->warehouse->location }}</td>
                                                <td>{{ $pack->receivedFrom }}</td>
                                                <td>{{ $pack->collectedBy }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    {{ $packsReceived->withQueryString()->links() }}
                                </div>
                                <div class="table-responsive col-md-6" id="proTeamScroll">
                                    <div class="badge l-bg-red mb-2">DEDUCTIONS (Care Pack Requests)</div>
                                    <table class="table table-striped" id="table-2">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Quantity</th>
                                                <th>Warehouse</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        @foreach ($packRequests as $packRequest)
                                            <tr>
                                                <td>{{ $packRequest->created_at->format('F j, Y') }}</td>
                                                <td>{{ $packRequest->quantity }}</td>
                                                <td>{{ $packRequest->warehouseLocation }}</td>
                                                <td>
                                                    @php
                                                        $statusColor = '';
                                                        
                                                        switch ($packRequest->status) {
                                                            case 'PICKED UP':
                                                                $statusColor = 'success';
                                                                break;
                                                            case 'DELIVERED':
                                                                $statusColor = 'secondary';
                                                                break;
                                                            case 'CANCELED':
                                                                $statusColor = 'danger';
                                                                break;
                                                            default:
                                                                $statusColor = 'warning';
                                                        }
                                                    @endphp
                                                    <span
                                                        class="badge badge-{{ $statusColor }}">{{ $packRequest->status }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    {{ $packRequests->withQueryString()->links() }}
                                </div>

                            </div>
                            <hr>
                            <div class="row mt-4">
                                <div class="table-responsive" id="proTeamScroll">
                                    <div class="badge badge-primary mb-2">Transfers (Between Warehouses)</div>
                                    <table class="table table-striped" id="table-2">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Quantity</th>
                                                <th>Rider</th>
                                                <th>From Warehouse</th>
                                                <th>To Warehouse</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        @foreach ($packTransfers as $pack)
                                            <tr>
                                                <td>{{ $pack->created_at->format('F j, Y') }}</td>
                                                <td>{{ $pack->quantity }}</td>
                                                <td>{{ $pack->rider->fullname }}</td>
                                                <td>{{ $pack->warehouseFrom->location }}</td>
                                                <td>{{ $pack->warehouseTo->location }}</td>
                                                <td> <a href="#" class="btn btn-primary">Details</a></td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    {{ $packTransfers->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>



        <div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="formModal"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModal">Care Packs Transfer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="/transfer-pack">
                            @csrf
                            <div class="form-group">
                                <label>Quantity</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('quantity') is-invalid @enderror"
                                        placeholder="Enter number of items" name="quantity">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Received From</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('receivedFrom') is-invalid @enderror"
                                        placeholder="Received From" name="receivedFrom">

                                </div>
                            </div>
                            <div class="form-group">
                                <label>Collected By</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('collectedBy') is-invalid @enderror"
                                        placeholder="Collected By" name="collectedBy">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Transfer From</label>
                                <div class="input-group">

                                    <select name="warehouseFrom" id="warehouseFrom"
                                        class="form-control @error('warehouseFrom') is-invalid @enderror">
                                        <option value="" selected hidden>Select warehouse to transfer from</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}"> {{ $warehouse->location }}
                                                [{{ $warehouse->noOfCarePacks }}]</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Transfer To</label>
                                <div class="input-group">
                                    <select name="warehouseTo" id="warehouseTo"
                                        class="form-control @error('warehouseTo') is-invalid @enderror">
                                        <option value="" selected hidden>Select warehouse to transfer to</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}"> {{ $warehouse->location }}
                                                [{{ $warehouse->noOfCarePacks }}] </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Rider</label>
                                <div class="input-group">
                                    <select name="rider" id="rider"
                                        class="form-control @error('rider') is-invalid @enderror">
                                        <option value="" selected hidden>-- Assign Rider --</option>
                                        @foreach ($riders as $rider)
                                            <option value="{{ $rider->id }}"> {{ $rider->fullname }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Reason</label>
                                <div class="input-group">
                                    <textarea class="form-control @error('reason') is-invalid @enderror" name="reason"
                                        name="reason">Reason for transfer</textarea>
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input" id="remember-me"
                                        required>
                                    <label class="custom-control-label" for="remember-me">I acknowledge that I have counted
                                        and assessed the items</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Complete</button>
                            <button type="button" class="btn btn-danger m-t-15 waves-effect"
                                style="float:right;">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


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
                        <h6 class="font-medium m-b-10">Color Theme</h6>
                        <div class="theme-setting-options">
                            <ul class="choose-theme list-unstyled mb-0">
                                <li title="white" class="active">
                                    <div class="white"></div>
                                </li>
                                <li title="cyan">
                                    <div class="cyan"></div>
                                </li>
                                <li title="black">
                                    <div class="black"></div>
                                </li>
                                <li title="purple">
                                    <div class="purple"></div>
                                </li>
                                <li title="orange">
                                    <div class="orange"></div>
                                </li>
                                <li title="green">
                                    <div class="green"></div>
                                </li>
                                <li title="red">
                                    <div class="red"></div>
                                </li>
                            </ul>
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
                    <div class="p-15 border-bottom">
                        <div class="theme-setting-options">
                            <label class="m-b-0">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                                    id="sticky_header_setting">
                                <span class="custom-switch-indicator"></span>
                                <span class="control-label p-l-10">Sticky Header</span>
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
        const warehouses = JSON.parse('{!! json_encode($warehouses) !!}');
        const monthlyChartData = JSON.parse('{!! json_encode($monthlyChartData) !!}');
        const inputOutputData = JSON.parse('{!! json_encode($inputOutputData) !!}');

        const smallcharts = (id) => {
            let colors = [{
                    colorStop: ["rgba(156,39,176,.2)", "rgba(156,39,176,0)"],
                    borderColor: "#9c27b0",
                    pointHoverBackgroundColor: "rgba(63,82,227,1)"
                },
                {
                    colorStop: ["rgba(255,87,34,.2)", "rgba(255,87,34,0)"],
                    borderColor: "#ff9800",
                    pointHoverBackgroundColor: "rgba(63,82,227,1)"
                },
                {
                    colorStop: ["rgba(76,175,80,.2)", "rgba(76,175,80,0)"],
                    borderColor: "#4caf50",
                    pointHoverBackgroundColor: "rgba(63,82,227,1)"
                },
                {
                    colorStop: ["rgba(63,82,227,.2)", "rgba(63,82,227,0)"],
                    borderColor: "rgba(63,82,227,1)",
                    pointHoverBackgroundColor: "rgba(63,82,227,1)"
                }
            ];

            const color = colors[Math.floor(Math.random() * colors.length)]

            let balance_chart = document.getElementById(id).getContext("2d");

            let balance_chart_bg_color = balance_chart.createLinearGradient(0, 0, 0, 70);
            balance_chart_bg_color.addColorStop(0, color.colorStop[0]);
            balance_chart_bg_color.addColorStop(1, color.colorStop[1]);

            const options = {
                type: "line",
                data: {
                    labels: [
                        "16-07-2018",
                        "17-07-2018",
                        "18-07-2018",
                        "19-07-2018",
                        "20-07-2018",
                        "21-07-2018",
                        "22-07-2018",
                        "23-07-2018",
                        "24-07-2018",
                        "25-07-2018",
                        "26-07-2018",
                        "27-07-2018",
                        "28-07-2018",
                        "29-07-2018",
                        "30-07-2018",
                        "31-07-2018",
                    ],
                    datasets: [{
                        label: "Balance",
                        data: [
                            50,
                            61,
                            80,
                            50,
                            72,
                            52,
                            60,
                            41,
                            30,
                            45,
                            70,
                            40,
                            93,
                            63,
                            50,
                            62,
                        ],
                        backgroundColor: balance_chart_bg_color,
                        borderWidth: 3,
                        borderColor: color.borderColor,
                        pointBorderWidth: 0,
                        pointBorderColor: "transparent",
                        pointRadius: 3,
                        pointBackgroundColor: "transparent",
                        pointHoverBackgroundColor: color.pointHoverBackgroundColor,
                    }, ],
                },
                options: {
                    layout: {
                        padding: {
                            bottom: -1,
                            left: -1,
                        },
                    },
                    legend: {
                        display: false,
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                beginAtZero: true,
                                display: false,
                            },
                        }, ],
                        xAxes: [{
                            gridLines: {
                                drawBorder: false,
                                display: false,
                            },
                            ticks: {
                                display: false,
                            },
                        }, ],
                    },
                },
            }

            var myChart = new Chart(balance_chart, options);
        } // end smallCharts function

        function chart1() {

            var options = {
                series: [{
                    name: "Total Care Packs",
                    data: monthlyChartData.values,
                }, ],
                chart: {
                    type: "bar",
                    height: 350,
                    dropShadow: {
                        enabled: true,
                        opacity: 0.3,
                        blur: 2,
                        left: -10,
                        top: 22,
                    },
                    toolbar: {
                        show: false,
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "30%",
                        endingShape: "rounded",
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ["transparent"],
                },
                xaxis: {
                    categories: monthlyChartData.months,
                    labels: {
                        offsetX: 0,
                        offsetY: 0,
                        style: {
                            fontSize: "12px",
                            fontFamily: "Segoe UI",
                            cssClass: "apexcharts-xaxis-title",
                        },
                    },
                    tooltip: {
                        enabled: false
                    }
                },
                yaxis: {
                    title: {
                        text: "",
                    },
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
                fill: {
                    type: "gradient",
                    gradient: {
                        shade: "light",
                        type: "verticle",
                        shadeIntensity: 0.25,
                        gradientToColors: undefined,
                        inverseColors: false,
                        opacityFrom: 0.85,
                        opacityTo: 0.85,
                        stops: [0, 90, 100],
                    },
                    colors: ["#6777EF"],
                },
                tooltip: {
                    enabled: false
                },
            };

            var chart = new ApexCharts(document.querySelector("#chart1"), options);
            chart.render();
        }

        function chart2() {
            var options = {
                series: [{
                        name: "Care Pack Input",
                        type: "line",
                        data: inputOutputData.input,
                    },
                    {
                        name: "Care Pack Output",
                        type: "area",
                        data: inputOutputData.output,
                    },
                    {
                        name: "Total",
                        type: "line",
                        data: inputOutputData.total,
                    },
                ],
                chart: {
                    height: 350,
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
                    stacked: false,
                },
                colors: ["rgba(103, 119, 239, 0.68)", "#FEB019", "#f34739"],
                stroke: {
                    width: [5, 5, 3],
                    curve: "smooth",
                },
                plotOptions: {
                    bar: {
                        columnWidth: "50%",
                    },
                },

                fill: {
                    opacity: [0.85, 0.25, 1],
                    gradient: {
                        inverseColors: false,
                        shade: "light",
                        type: "vertical",
                        opacityFrom: 0.85,
                        opacityTo: 0.55,
                        stops: [0, 100, 100, 100],
                    },
                },
                labels: inputOutputData.months,
                markers: {
                    size: 0,
                },
                xaxis: {
                    labels: {
                        offsetX: 0,
                        offsetY: 0,
                        style: {
                            fontSize: "12px",
                            fontFamily: "Segoe UI",
                            cssClass: "apexcharts-xaxis-title",
                        },
                    },
                },
                yaxis: {
                    title: {
                        text: "Dollers",
                    },
                    labels: {
                        offsetX: 0,
                        offsetY: 0,
                        style: {
                            fontSize: "12px",
                            fontFamily: "Segoe UI",
                            cssClass: "apexcharts-yaxis-title",
                        },
                    },
                    min: 0,
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

            var chart = new ApexCharts(document.querySelector("#chart2"), options);
            chart.render();
        }

        function warehouseIOCharts(key, inputOutputData) {
            let warehouse = inputOutputData.warehouses[key]
            var options = {
                series: [{
                        name: "Input",
                        type: "line",
                        data: warehouse.input,
                    },
                    {
                        name: "Output",
                        type: "area",
                        data: warehouse.output,
                    },
                    {
                        name: "Total",
                        type: "line",
                        data: warehouse.total,
                    },
                ],
                chart: {
                    height: 350,
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
                    stacked: false,
                },
                colors: ["rgba(103, 119, 239, 0.68)", "#FEB019", "#f34739"],
                stroke: {
                    width: [5, 5, 3],
                    curve: "smooth",
                },
                plotOptions: {
                    bar: {
                        columnWidth: "50%",
                    },
                },

                fill: {
                    opacity: [0.85, 0.25, 1],
                    gradient: {
                        inverseColors: false,
                        shade: "light",
                        type: "vertical",
                        opacityFrom: 0.85,
                        opacityTo: 0.55,
                        stops: [0, 100, 100, 100],
                    },
                },
                labels: inputOutputData.months,
                markers: {
                    size: 0,
                },
                xaxis: {
                    labels: {
                        offsetX: 0,
                        offsetY: 0,
                        style: {
                            fontSize: "12px",
                            fontFamily: "Segoe UI",
                            cssClass: "apexcharts-xaxis-title",
                        },
                    },
                },
                yaxis: {
                    title: {
                        text: "Dollers",
                    },
                    labels: {
                        offsetX: 0,
                        offsetY: 0,
                        style: {
                            fontSize: "12px",
                            fontFamily: "Segoe UI",
                            cssClass: "apexcharts-yaxis-title",
                        },
                    },
                    min: 0,
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

            var chart = new ApexCharts(document.querySelector(`#chartw${key}`), options);
            chart.render();
        } //end function warehouseIOCharts


        $(() => {
            smallcharts('total-pack-chart')

            for (let warehouse of warehouses) {
                try {
                    smallcharts(`warehouse-chart-${warehouse.id}`)
                } catch (e) {}
            }

            for (let key in inputOutputData.warehouses) {

                warehouseIOCharts(key, inputOutputData)
            }
        })

    </script>
@endsection
