@extends('layouts.page')
@section('content')
    <div class="main-content">
        @include('partials.user.messages')
        <section class="section">
            <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">
                    <h4 class="page-title m-b-0">Care Pack Requests</h4>
                </li>
                <!--  -->
            </ul>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body">
                                <ul class="breadcrumb breadcrumb-style">
                                    <li class="breadcrumb-item">
                                        <a href="/all-care-pack-requests" class="btn btn-info" style="float:right;">All
                                            Care Pack Orders</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="/all-care-pack-requests?status=TRANSIT" class="btn btn-warning"
                                            style="float:right;">Care Packs in transit</a>
                                    </li>

                                    <li class="breadcrumb-item">
                                        <a href="/all-care-pack-requests?status=PICKED%20UP" class="btn btn-primary"
                                            style="float:right;">Picked Up Care Packs</a>
                                    </li>

                                    <li class="breadcrumb-item">
                                        <a href="/all-care-pack-requests?status=CANCELED" class="btn btn-danger"
                                            style="float:right;">Canceled Care Packs</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a class="btn btn-success" href="/all-care-pack-requests?status=DELIVERED"
                                            style="float:right;">Delivered Care Packs</a>
                                    </li>
                                    {{-- <li class="breadcrumb-item">
                                        <a class="btn btn-danger" href="#" style="float:right;">Cancelled
                                            Care Packs</a>
                                    </li>
                                    <!-- <li class="breadcrumb-item active">Inventory Dashboard</li> --> --}}
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
                                                        <label for="checkbox-all" class="custom-control-label">&nbsp;
                                                        </label>
                                                    </div>
                                                </th>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Quantity</th>
                                                <th>Pickup Region</th>
                                                <th>Delivery Region</th>
                                                <th>Request By</th>
                                                <th>Warehouse</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($packRequests as $packRequest)
                                                <tr>
                                                    <td class="text-center pt-2">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" data-checkboxes="mygroup"
                                                                class="custom-control-input" id="checkbox-1">
                                                            <label for="checkbox-1"
                                                                class="custom-control-label">&nbsp;</label>
                                                        </div>
                                                    </td>

                                                    <td>{{ $packRequest->created_at->format('F j, Y') }}</td>
                                                    <td>{{ $packRequest->description }}</td>
                                                    <td>{{ $packRequest->quantity }}</td>
                                                    <td>{{ $packRequest->pickupRegion }}</td>
                                                    <td>{{ $packRequest->deliveryRegion }}</td>
                                                    <td>{{ $packRequest->requestedBy }}</td>
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
                                                    <td>
                                                        <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                            data-target="#changeStatusModal{{ $packRequest->id }}"
                                                            style="white-space: nowrap">Change Status</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $packRequests->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

    {{-- Change care pack status --}}

    @foreach ($packRequests as $packRequest)
        <div class="modal fade" id="changeStatusModal{{ $packRequest->id }}" tabindex="-1" role="dialog"
            aria-labelledby="changeStatusModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center text-dark">
                            <h4 class="h4">Change Status</h4>
                            <change-oxygen-request-status-form initstatus="{{ $packRequest->status }}"
                                csrftoken="{{ csrf_token() }}" submit-url="/change-pack-status"
                                :statuses="{{ $statuses }}" id="{{ $packRequest->id }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
