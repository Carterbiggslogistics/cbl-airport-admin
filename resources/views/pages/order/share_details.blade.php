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
                    <h4 class="page-title m-b-0">Shared samples details</h4>
                </li>
            </ul>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                @can('isSuperAdmin')
                                    <button class="btn btn-primary mr-3" type="reset" data-toggle="modal"
                                        data-target="#assignRider">Assign
                                        a Rider
                                    </button>
                                    <button class="btn btn-info mr-3" type="reset" data-toggle="modal"
                                        data-target="#status">Change Status
                                    </button>
                                    <button class="btn btn-success" id="delivered" data-toggle="tooltip"
                                        data-target="#delivered" data-placement="right" title="Mark this samples as delivered"
                                        value="{{ $share->id }}">Delivered
                                    </button>
                                @endcan
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>ID</label>
                                        <input type="text" value="{{ $share->uuid }}" disabled class="form-control">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Shared Date</label>
                                        <input type="text" value="{{ $share->created_at->format('F j, Y') }}" disabled
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>Lab Sharing Samples</label>
                                        <input type="text" value="{{ $share->labA->fullname }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Lab Receiving Samples</label>
                                        <input type="text" value="{{ $share->labB->fullname }}" disabled
                                            class="form-control">
                                        <input type="hidden" value="{{ $share->labB->email }}" id="lab">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Shared Samples</label>
                                        <input type="text" value="{{ $share->samples }}" disabled class="form-control">
                                        <input type="hidden" value="{{ $share->samples }}" id="samples">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Status</label>
                                        @if ($share->status === '')
                                            <input type="text" value="Waiting for rider to be assigned" disabled
                                                class="form-control text-danger">
                                        @else
                                            <input type="text" value="{{ $share->status }}" disabled class="form-control">
                                        @endif
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Shared Samples</label>
                                        @if ($share->rider)
                                            <input type="text" value="{{ $share->rider->fullname }}" disabled
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
                <form action="/assign-rider/{{ $share->id }}" method="post">
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
                        <input type="hidden" name="samples" value="{{ $share->samples }}">
                        <input type="hidden" name="lab" value="{{ $share->labB->email }}">
                    </div>
                    <div>
                        <button class="btn btn-success" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Status modal --}}
    <div class="modal fade" id="status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/change-status/{{ $share->id }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-6">
                            <label>Change Status</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="">Select Status</option>
                                <option value="Picked-Up">Picked Up</option>
                                <option value="in-transit">In Transit</option>
                                <option value="in-progress">In Progress</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-success" type="submit">Submit</button>
                    </div>
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
        $('#delivered').on('click', (e) => {
            if (confirm('Are you sure this samples is delivered?')) {
                e.preventDefault();
                let id = $('#delivered').val()
                let lab = $('#lab').val()
                let samples = $('#samples').val()
                $.ajax({
                    url: "{{ url('/delivered-samples') }}",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                        "lab": lab,
                        "samples": samples,
                    },
                    success: function(data) {
                        alert(data)
                        window.location.replace('/all-delivered-samples')
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
