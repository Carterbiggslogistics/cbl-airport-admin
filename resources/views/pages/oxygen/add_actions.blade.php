.
@extends('layouts.page')
@section('content')
    <div class="main-content">
        <section class="section">
            @include('partials.user.messages')
            <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">
                    <h4 class="page-title m-b-0">Oxygen Inventory Items</h4>
                </li>
            </ul>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header m-2">
                                <button class="btn btn-primary" type="reset" data-toggle="modal"
                                    data-target="#createAddRequest"><i class="fa fa-plus text-white m-3"></i> Add
                                    Cylinder(s) To
                                    Plant</button>

                            </div>
                            @if (isset($addRequests) && count($addRequests) > 0)
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
                                                                <label for="checkbox-1"
                                                                    class="custom-control-label">&nbsp;</label>
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
                                        {{ $addRequests->links() }}
                                    </div>
                                </div>
                            @else
                                <div class="card-body">
                                    <h3>No Oxygen Inventory Item created</h3>
                                </div>
                            @endif
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
    <!-- Create Oxygen Add Request -->
    <div class="modal fade" id="createAddRequest" tabindex="-1" role="dialog" aria-labelledby="createAddRequestLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAddRequestLabel">Add New Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/oxygen/add-requests/create" method="post">
                    @csrf
                    <div class="form-group form-float col-12">
                        <label>Plant</label>
                        <div class="input-group">
                            <select name="plant" class="form-control @error('plant') is-invalid @enderror" required>
                                <option selected hidden disabled value="">Select plant</option>
                                @foreach ($plants as $plant)
                                    <option value="{{ $plant->id }}">{{ $plant->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float col-12">
                        <label class="form-label">Oxygen Cylinder Size<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select name="size" class="form-control @error('size') is-invalid @enderror">
                                <option value="" selected hidden disabled>Select Cylinder Size</option>
                                @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->size }} m3</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float col-12">
                        <div class=" form-line">
                            <label class="form-label">Quantity<span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('count') is-invalid @enderror" name="count"
                                id="count" required placeholder="Quantity to be stored">
                        </div>
                    </div>

                    <div class="form-group form-float col-12">
                        <div class=" form-line">
                            <label class="form-label">Item Collecetd By<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('collectedBy') is-invalid @enderror"
                                name="collectedBy" id="collectedBy" required placeholder="Item collected by">
                        </div>
                    </div>
                    <div class="form-group form-float col-12">
                        <div class=" form-line">
                            <label class="form-label">Item Received From<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('receivedFrom') is-invalid @enderror"
                                name="receivedFrom" id="receivedFrom" required placeholder="Item received from">
                        </div>
                    </div>
                    <div class="form-group form-float col-12">
                        <div class="form-line">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
