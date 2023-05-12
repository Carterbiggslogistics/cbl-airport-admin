@extends('layouts.page')
@section('content')
    <div class="main-content">
        <section class="section">
            <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">
                    <h4 class="page-title m-b-0">Inventories</h4>
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
                                        <a href="/all-care-packs" class="btn btn-info" style="float:right;">All
                                            Care Pack Orders</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="/incomplete-inventories" class="btn btn-warning"
                                            style="float:right;">Unassigned
                                            care packs</a>
                                    </li>

                                    <li class="breadcrumb-item">
                                        <a class="btn btn-success" href="/delivered-care-packs"
                                            style="float:right;">Delivered
                                            Care Packs</a>
                                    </li>
                                    {{-- <li class="breadcrumb-item">
                                        <a class="btn btn-danger" href="#" style="float:right;">Cancelled
                                            Care Packs</a>
                                    </li>
                                    <!-- <li class="breadcrumb-item active">Inventory Dashboard</li> -->
                                    --}}
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
                                                {{-- <th>S/N</th>
                                                --}}
                                                <th>Requests</th>
                                                <th>Quantity</th>
                                                <th>Amount</th>
                                                <th>Delivery Area</th>
                                                <th>Request Created By</th>
                                                <th>Request Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($inventories as $key => $inventories)
                                                <tr>
                                                    <td class="text-center pt-2">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" data-checkboxes="mygroup"
                                                                class="custom-control-input" id="checkbox-1">
                                                            <label for="checkbox-1"
                                                                class="custom-control-label">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    {{-- <td>{{ $key + 1 }}</td>
                                                    --}}
                                                    <td>{{ $inventories->pack->name }}</td>
                                                    <td>{{ $inventories->quantity }}</td>
                                                    <td>{{ number_format($inventories->amount) }}</td>
                                                    <td>{{ $inventories->deliveryRegion }}</td>
                                                    <td>{{ $inventories->user->fullname }}</td>
                                                    <td>{{ $inventories->created_at->format('F j, Y') }}</td>
                                                    <td>
                                                        <div class="badge badge-success badge-shadow">
                                                            {{ $inventories->status }}
                                                        </div>
                                                    </td>
                                                    <td><a href="/inventories-details/{{ $inventories->uuid }}"
                                                            class="btn btn-primary">Detail</a></td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{$inventories->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
