@extends('layouts.page')
@section('content')
    <div class="main-content">
        @include('partials.user.messages')
        <h1 class="h1 text-dark">Oxygen Request</h1>
        <div class="card">
            <div class="card-body">
                <ul class="list-group text-dark">
                    <li class="list-group-item"><span class="text-bold">Date:
                        </span>{{ $oxygenRequest->created_at->format('F j, Y') }}</li>
                    <li class="list-group-item"><span class="text-bold">Number of cylinder:
                        </span>{{ $oxygenRequest->noOfCylinders }}</li>
                    {{-- <li class="list-group-item"><span class="text-bold">Price:
                        </span>N {{ convertToPriceString($oxygenRequest->price) }}</li> --}}
                    <li class="list-group-item"><span class="text-bold">Status:
                        </span> &nbsp; <span
                            class="badge {{ $oxygenRequest->status == 'ON-ROUTE' ? 'badge-warning' : ($oxygenRequest->status == 'DELIVERED' ? 'badge-secondary' : 'badge-success') }} ">{{ $oxygenRequest->status }}</span>
                    </li>
                    @if ($oxygenRequest->status == 'PICKED-UP')
                        <li class="list-group-item"><span class="text-bold">
                                Pickup Date < {{ toCarbonDate($oxygenRequest->pickupDate)->format('d-m-Y') }}>:
                                    {{ dateToHumanDiff($oxygenRequest->pickupDate) }}
                        </li>
                    @endif
                    <li class="list-group-item"><span class="text-bold">Requesting Pickup:
                        </span> <span
                            class="badge custom-badge-{{ $oxygenRequest->isRequestingPickup ? '' : 'secondary' }} badge-{{ $oxygenRequest->isRequestingPickup ? 'danger' : '' }}">{{ $oxygenRequest->isRequestingPickup ? 'Yes' : 'No' }}</span>
                    </li>
                </ul>
                <div class="d-flex mt-2">
                    <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#changeStatusModal">Update
                        Status</button>

                    <button class="btn btn-{{ $oxygenRequest->status == 'DELIVERED' ? 'success' : 'secondary' }} mr-2"
                        data-toggle="modal" data-target="#requestPickupModal">Request
                        Pickup</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-body">
                        <h5 class="card-title">{{ $oxygenRequest->plant->name }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Oxygen Plant </h6>
                        <ul class="list-group">
                            <li class="list-group-item">{{ $oxygenRequest->plant->email }}</li>
                            <li class="list-group-item">{{ $oxygenRequest->plant->phoneNumber }}</li>
                            <li class="list-group-item">{{ $oxygenRequest->plant->address }}</li>
                            <li class="list-group-item">{{ $oxygenRequest->plant->region }} [region] </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-body">
                        <h5 class="card-title">{{ $oxygenRequest->client->name }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Oxygen Client </h6>
                        <ul class="list-group">
                            <li class="list-group-item">{{ $oxygenRequest->client->email }}</li>
                            <li class="list-group-item">{{ $oxygenRequest->client->phoneNumber }}</li>
                            <li class="list-group-item">{{ $oxygenRequest->client->address }}</li>
                            <li class="list-group-item">N
                                {{ convertToPriceString($oxygenRequest->client->pricePerUnit) }}
                                [price per unit]</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="card col-md-6">
                <div class="card-body">
                    <h5 class="card-title mb-2 text-dark">Oxygen Supplies</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th>Size</th>
                                <th>Number of cylinder</th>
                                {{-- <th>Price</th> --}}
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($oxygenRequest->supplies as $key => $supply)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $supply->size->size }}</td>
                                    <td>{{ $supply->noOfCylinders }}</td>
                                    {{-- <td>N
                                        {{ convertToPriceString(($oxygenRequest->price / $oxygenRequest->totalVolume) * $supply->noOfCylinders * $supply->size->size) }}
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Change Status Modal --}}
    <div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="changeStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeStatusModalLabel">Change Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <change-oxygen-request-status-form initstatus="{{ $oxygenRequest->status }}"
                        csrftoken="{{ csrf_token() }}" submit-url="/oxygen/request/change-status"
                        :statuses="{{ $statuses }}" id="{{ $oxygenRequest->id }}" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Change Request Pickup --}}
    <div class="modal fade" id="requestPickupModal" tabindex="-1" role="dialog"
        aria-labelledby="requestPickupModalModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center text-dark">
                        <h2 class="h2">Are you sure?</h2>
                        <h6 class="h6">This action cannot be undone</h6>
                        <div class="d-flex justify-content-center mt-3">
                            <button class="btn btn-secondary mr-2" style="width: 100px;" data-dismiss="modal">Abort</button>
                            <form action="/oxygen/request/request-pickup" class="m-0" method="post">
                                <input type="text" name="id" value="{{ $oxygenRequest->id }}" hidden>
                                @csrf
                                <button type="submit" style="width: 100px;" class="btn btn-primary">Continue</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
