@extends('layouts.page')
@section('content')
    <div class="main-content">
        @include('partials.user.messages')
        <section class="section">
            <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">
                    <h4 class="page-title m-b-0">All Flights</h4>
                </li>
            </ul>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="/download-flight" class="btn btn-success">Download Flight Data</a>
                                <div class="ml-2">
                                    <form action="" id="search">
                                        <input type="date" name="" id="query" placeholder="Search by date">
                                        <button type="submit">Search</button>
                                    </form>
                                </div>
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
                                                        <label for="checkbox-all"
                                                            class="custom-control-label">&nbsp;</label>
                                                    </div>
                                                </th>
                                                <th>S/N</th>
                                                <th>Passenger Name</th>
                                                {{-- <th>Passenger Email</th> --}}
                                                {{-- <th>Passenger Number</th> --}}
                                                {{-- <th>Passport Number</th> --}}
                                                <th>Airline</th>
                                                <th>Airport</th>
                                                <th>Origin</th>
                                                {{-- <th>Amount Paid</th> --}}
                                                <th>Time of Arrival</th>
                                                <th>Created By</th>
                                                <th>Date Of Arrival</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                // dd($flights[0]);
                                            @endphp
                                            @php $monitor = $flights->perPage() * $flights->currentPage() - $flights->perPage(); @endphp
                                            @foreach ($flights as $flight)
                                                {{-- The .data-canceled-row is defined in the public.assets.css.custom.css --}}
                                                <tr class="{{ $flight->canceled ? 'data-canceled-row' : '' }}">
                                                    <td class="text-center pt-2">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" data-checkboxes="mygroup"
                                                                class="custom-control-input" id="checkbox-1">
                                                            <label for="checkbox-1"
                                                                class="custom-control-label">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $monitor + $loop->iteration }}</td>
                                                    <td>{{ $flight->passengerName }}</td>
                                                    {{-- <td>{{ $flight->passengerEmail }}</td> --}}
                                                    {{-- <td>{{ $flight->passengerPhone }}</td> --}}
                                                    {{-- <td>{{ $flight->passportNumber }}</td> --}}
                                                    <td>{{ $flight->airline }}</td>
                                                    <td>{{ $flight->airport }}</td>
                                                    <td>{{ $flight->origin }}</td>
                                                    {{-- <td>{{ number_format($flight->amount) }}</td> --}}
                                                    <td>{{ $flight->time }}</td>
                                                    <td>{{ $flight->user->fullname }}</td>
                                                    <td>{{ $flight->dateOfArrival->format('F j, Y') }}</td>
                                                    <td>
                                                        @if ($flight->canceled)
                                                            <span class="badge badge-secondary">Canceled</span>
                                                        @else
                                                            {{-- Button to open the cancel flight modal, modal at the end of the html document --}}
                                                            <button data-toggle="modal"
                                                                data-target="#cancelFlightModal{{ $flight->id }}"
                                                                class="btn btn-danger">Cancel</button>
                                                        @endif
                                                    </td>
                                                    {{-- <td><a
                                                            href="/flight-details/{{ $flight->uuid }}"
                                                            class="btn btn-primary">Detail</a></td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-5">
                                            <div class="dataTables_info" id="table-2_info" role="status" aria-live="polite">
                                                Showing {{ $monitor + 1 }} to {{ $monitor + $flights->count() }} of
                                                {{ $flights->total() }} entries</div>
                                        </div>

                                        <div class="col-sm-12 col-md-7">
                                            <div class="dataTables_paginate paging_simple_numbers" id="table-2_paginate">
                                                {{ $flights->links('partials.datatable_pagination') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                    <div class="p-15 bflight-bottom">
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


        {{-- Cancel Flight modals --}}
        @foreach ($flights as $flight)
            <div class="modal fade" id="cancelFlightModal{{ $flight->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                <button class="btn btn-secondary mr-2" style="width: 100px;"
                                    data-dismiss="modal">Abort</button>
                                <form action="{{ route('cancel.flight') }}" class="m-0" method="post">
                                    <input type="text" name="id" value="{{ $flight->id }}" hidden>
                                    @csrf
                                    <button type="submit" style="width: 100px;" class="btn btn-primary">Continue</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script>
        let search = document.getElementById('search');
        search.addEventListener('submit', filter, false);

        function filter(e) {
            e.preventDefault();
            let query = document.getElementById('query').value;
            $.ajax({
                url: "{{ url('/search') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "search": query
                },
                success: function(data) {
                    return console.log(data);
                    // alert(data)
                },
                error: function(error) {
                    console.log(error)
                }
            });
        }

    </script>
@endsection
