@extends('layouts.page')
@section('content')
    <div class="main-content">
        @include('partials.user.messages')
        <section class="section">
            <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">
                    <h4 class="page-title m-b-0">Oxygen Supplies</h4>
                </li>
                <li class="breadcrumb-item">
                    <a href="/oxygen/inventory/add-actions" class="btn btn-success" style="float:right;">Update Oxygen
                        Cylinder Inventory</a>
                </li>
                <!--  -->
            </ul>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
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
                                                            <label for="checkbox-1"
                                                                class="custom-control-label">&nbsp;</label>
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

                </div>
            </div>
        </section>


    </div>
@endsection
