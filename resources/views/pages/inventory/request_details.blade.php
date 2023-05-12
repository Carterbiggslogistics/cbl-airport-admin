@extends('layouts.page')
<style>
    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        /* width: 50%; Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 70px;
        border: 1px solid #888;
        width: 80%;
    }

    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

</style>
@section('content')
    <div class="main-content">
        <section class="section">
            @include('partials.user.messages')

            <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">
                    <h4 class="page-title m-b-0">inventory details</h4>
                </li>
            </ul>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                {{-- @can('isAdmin')
                                <button class="btn btn-success mr-1" id="status" value="{{ $inventory->id }}"
                                    type="button">Request for pickup</button>
                                @endcan --}}
                                @can('isSuperAdmin')
                                    @if ($inventory->is_assigned)
                                        <button class="btn btn-success mr-1" id="completed" data-toggle="tooltip"
                                            data-target="#delivered" data-placement="bottom"
                                            title="Mark this inventory as completed"
                                            value="{{ $inventory->id }}">Delivered</button>
                                    @endif
                                    {{-- <button class="btn btn-info mr-1" type="reset"
                                        data-toggle="modal" data-target="#changeStatus">Change Status
                                    </button> --}}
                                    {{-- <button class="btn btn-danger mr-1" type="reset"
                                        id="deleteinventory" onclick="cancelModal();" data-toggle="tooltip"
                                        data-target="#deleteinventory" data-placement="top" title="Cancel this inventory">Cancel
                                        inventory</button> --}}
                                    <button class="btn btn-primary" type="reset" data-toggle="modal"
                                        data-target="#assignRider">Assign
                                        a Rider
                                    </button>
                                @endcan
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>Inventory Name</label>
                                        <input type="text" value="{{ $inventory->pack->name }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Inventory Quantity</label>
                                        <input type="text" value="{{ $inventory->quantity }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Inventory Amount</label>
                                        <input type="text" value="{{ number_format($inventory->amount) }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Delivery Area</label>
                                        <input type="text" value="{{ $inventory->deliveryRegion }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Delivery Address</label>
                                        <input type="text" value="{{ $inventory->deliveryAddress }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Delivery Contact Name</label>
                                        <input type="text" value="{{ $inventory->deliveryContactName }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Delivery Contact Phone</label>
                                        <input type="text" value="{{ $inventory->deliveryContactPhone }}" disabled
                                            class="form-control">
                                    </div>
                                    @if ($inventory->warehouse)
                                        <div class="form-group col-6">
                                            <label>Warehouse</label>
                                            <input type="text" value="{{ $inventory->warehouse->location }}" disabled
                                                class="form-control">
                                        </div>
                                    @endif
                                    <div class="form-group col-6">
                                        <label>inventory Date</label>
                                        <input type="text" value="{{ $inventory->created_at->format('F j, Y') }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>inventory created by</label>
                                        <input type="text" value="{{ $inventory->user->fullname }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Status</label>
                                        @if (!$inventory->is_assigned)
                                            <input type="text" value="Wait for the admin to approve this inventory" disabled
                                                class="form-control text-danger">
                                        @else
                                            <input type="text" value="{{ $inventory->status }}" disabled
                                                class="form-control">
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-danger" type="reset" onclick="history.back();">Cancel</button>
                                {{-- <a href="/generate-transaction/{{ $order->uuid }}"
                                    class="btn btn-primary mr-1" type="submit">Generate
                                    Transaction</a> --}}
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

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <form action="/delete-order/{{ $inventory->id }}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="form-group col-6">
                        <label>Reasons</label>
                        <textarea class="form-control @error('comment') is-invalid @enderror" name="comment"></textarea>
                    </div>
                </div>
                <div>
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Rider Modal -->
    <div class="modal fade" id="assignRider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assign a rider</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/incomplete-inventory/{{ $inventory->id }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-12">
                            <label>Riders</label>
                            @if (count($riders) > 0)
                                <select class="form-control @error('rider') is-invalid @enderror" name="rider">
                                    @foreach ($riders as $rider)
                                        <option value="{{ $rider->email }}">{{ $rider->fullname }}</option>
                                    @endforeach
                                </select>
                            @else
                                <h3>No registered rider</h3>
                            @endif
                        </div>
                        <div class="form-group col-12">
                            <label>Warehouse</label>
                            @if (count($warehouses) > 0)
                                <select class="form-control @error('warehouse') is-invalid @enderror" name="warehouse">
                                    @foreach ($warehouses as $warehouse)
                                        <option value="{{ $warehouse->location }}">{{ $warehouse->location }}</option>
                                    @endforeach
                                </select>
                            @else
                                <h3>No registered warehouse</h3>
                            @endif
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-success" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Status Modal -->
    <div class="modal fade" id="changeStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Order Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/edit-status/{{ $inventory->id }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group col-6">
                        <label>Change Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="">Select Status</option>
                            <option value="in-transit">In Transit</option>
                            <option value="in-progress">In Progress</option>
                            <option value="Picked-Up">Picked Up</option>
                        </select>
                    </div>
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script>
        //Tooltip
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

        // Set share request to delivered
        $('#completed').on('click', (e) => {
            if (confirm('Are you sure this inventory is delivered?')) {
                e.preventDefault();
                let id = $('#completed').val()
                $.ajax({
                    url: "{{ url('/delivered-care-packs') }}",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                    },
                    success: function(data) {
                        alert(data)
                        window.location.replace('/all-care-packs')
                    },
                    error: function(error) {}
                });
            } else {
                close()
            }
        })

        function cancelModal() {
            // Get the modal for delete
            var modal = document.getElementById("deleteModal");
            // When the user clicks the button, open the modal 
            modal.style.display = "block";
            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];
            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }
            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        }

        // Set order status to successful
        $('#status').on('click', (e) => {
            if (confirm('Are you sure?')) {
                e.preventDefault();
                let id = $('#status').val()
                $.ajax({
                    url: "{{ url('/update-status') }}",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id
                    },
                    success: function(data) {
                        alert(data)
                        window.location.replace('/all-orders');
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            } else {
                close()
            }
        })

    </script>
@endsection
