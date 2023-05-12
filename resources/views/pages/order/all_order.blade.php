@extends('layouts.page')
@section('content')
    <div class="main-content">
        @include('partials.user.messages')
        <section class="section">
            <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">
                    <h4 class="page-title m-b-0">All Orders</h4>
                </li>
            </ul>
            <div class="section-body">
                <div class="row">
                    @can('isSuperAdmin')
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                </div>
                                <div class="card-body">
                                    <ul class="breadcrumb breadcrumb-style">
                                        <li class="breadcrumb-item">
                                            <a href="/all-orders" class="btn btn-info" style="float:right;">All
                                                Orders</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="/incomplete-orders" class="btn btn-warning" style="float:right;">Unassigned
                                                Orders</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a class="btn btn-primary" href="/open-orders" style="float:right;">Open Orders</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a class="btn btn-success" href="/completed-orders" style="float:right;">Completed
                                                Orders</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a class="btn btn-danger" href="/deleted-orders" style="float:right;">Cancelled
                                                Orders</a>
                                        </li>
                                        <!-- <li class="breadcrumb-item active">Inventory Dashboard</li> -->
                                    </ul>
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-2">
                                            <thead>
                                                <tr>
                                                    <th class="text-center pt-3">
                                                        <div class="custom-checkbox custom-checkbox-table custom-control">
                                                            <input type="checkbox" data-checkboxes="mygroup"
                                                                data-checkbox-role="dad" class="custom-control-input"
                                                                id="checkbox-all">
                                                            <label for="checkbox-all"
                                                                class="custom-control-label">&nbsp;</label>
                                                        </div>
                                                    </th>
                                                    {{-- <th>S/N</th> --}}
                                                    <th>Requested by</th>
                                                    <th>Pickup Area</th>
                                                    <th>Delivery Area</th>
                                                    <th>Order Date</th>
                                                    <th>Quantity</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $key => $order)
                                                    <tr>
                                                        <td class="text-center pt-2">
                                                            <div class="custom-checkbox custom-control">
                                                                <input type="checkbox" data-checkboxes="mygroup"
                                                                    class="custom-control-input" id="checkbox-1">
                                                                <label for="checkbox-1"
                                                                    class="custom-control-label">&nbsp;</label>
                                                            </div>
                                                        </td>
                                                        {{-- <td>{{ $key + 1 }}</td> --}}
                                                        <td>{{ $order->user->fullname }}</td>
                                                        <td>{{ $order->pickupRegion }}</td>
                                                        <td>{{ $order->deliveryRegion }}</td>
                                                        <td>{{ $order->created_at->format('F j, Y') }}</td>
                                                        <td>{{ $order->quantity }}</td>
                                                        <td>
                                                            @switch($order->status)
                                                                @case('PENDING')
                                                                    <div class="badge badge-secondary badge-shadow">
                                                                        {{ $order->status }}
                                                                    </div>
                                                                @break
                                                                @case('PICKED-UP')
                                                                    <div class="badge badge-warning badge-shadow">
                                                                        {{ $order->status }}
                                                                    </div>
                                                                @break
                                                                @case('IN-TRANSIT')
                                                                    <div class="badge badge-warning badge-shadow">
                                                                        {{ $order->status }}
                                                                    </div>
                                                                @break
                                                                @case('IN-PROGRESS')
                                                                    <div class="badge badge-warning badge-shadow">
                                                                        {{ $order->status }}
                                                                    </div>
                                                                @break
                                                                @case('CANCELED')
                                                                    <div class="badge badge-danger badge-shadow">
                                                                        {{ $order->status }}
                                                                    </div>
                                                                @break
                                                                @case('DELIVERED')
                                                                    <div class="badge badge-primary badge-shadow">
                                                                        {{ $order->status }}
                                                                    </div>
                                                                @break
                                                                @case('COMPLETED')
                                                                    <div class="badge badge-success badge-shadow">
                                                                        {{ $order->status }}
                                                                    </div>
                                                                @break
                                                                @case('RETURNED-ORDER')
                                                                    <div class="badge badge-danger badge-shadow">
                                                                        {{ $order->status }}
                                                                    </div>
                                                                @break
                                                                @default
                                                                    <div class="badge badge-warning badge-shadow">
                                                                        {{ $order->status }}</div>
                                                            @endswitch
                                                        </td>
                                                        <td><a href="/order-details/{{ $order->uuid }}"
                                                                class="btn btn-primary">Detail</a></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $orders->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
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
