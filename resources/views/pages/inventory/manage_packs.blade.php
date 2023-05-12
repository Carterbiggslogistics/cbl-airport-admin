@extends('layouts.page')
@section('content')
    <div class="main-content">
        <section class="section">
            @include('partials.user.messages')
            <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">
                    <h4 class="page-title m-b-0">Inventory Items</h4>
                </li>
            </ul>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header m-2">
                                <button class="btn btn-primary" type="reset" data-toggle="modal"
                                    data-target="#createPack"><i class="fa fa-plus text-white m-3"></i> Add Care Pack To
                                    Warehouse</button>

                            </div>
                            @if (count($packs) > 0)
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
                                                    <th>Created By</th>
                                                    <th>Category Name</th>
                                                    <th>Name</th>
                                                    <th>Quantity</th>
                                                    <th>Collected By</th>
                                                    <th>Received From</th>
                                                    <th>Warehouse</th>
                                                    <th>Date</th>
                                                    {{-- <th>Action</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($packs as $pack)
                                                    <tr>
                                                        <td class="text-center pt-2">
                                                            <div class="custom-checkbox custom-control">
                                                                <input type="checkbox" data-checkboxes="mygroup"
                                                                    class="custom-control-input" id="checkbox-1">
                                                                <label for="checkbox-1"
                                                                    class="custom-control-label">&nbsp;</label>
                                                            </div>
                                                        </td>
                                                        <td>{{ Str::of($pack->user->fullname)->ucfirst() }}</td>
                                                        <td>{{ Str::of($pack->category->name)->ucfirst() }}</td>
                                                        <td>{{ Str::of($pack->name)->ucfirst() }}</td>
                                                        <td>{{ $pack->quantity }}</td>
                                                        <td>{{ $pack->collectedBy }}</td>
                                                        <td>{{ $pack->receivedFrom }}</td>
                                                        <td>{{ Str::of($pack->warehouse->location)->ucfirst() }}</td>
                                                        <td>{{ $pack->created_at->format('F j, Y') }}</td>
                                                        {{-- <td><a href="#"
                                                                class="btn btn-primary">Update</a></td> --}}
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <h3>No pack created</h3>
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

    <!-- Create Pack Modal for warehouse-->
    <div class="modal fade" id="createPack" tabindex="-1" role="dialog" aria-labelledby="packModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="packModalLabel">Add New Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/add-pack" method="post">
                    @csrf
                    <div class="form-group form-float col-12">
                        <label class="form-label">Item Name<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select name="name" class="form-control " id="name" disabled>
                                <option value="">Care Pack
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float col-12">
                        <div class=" form-line">
                            <label class="form-label">Item Quantity<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('quantity') is-invalid @enderror" name="quantity"
                                id="quantity" required placeholder="Quantity to be stored">
                        </div>
                    </div>
                    <div class="form-group form-float col-12">
                        <label>Warehouse</label>
                        <div class="input-group">
                            <select name="warehouse" class="form-control @error('warehouse') is-invalid @enderror" required>
                                <option selected hidden value="">Select warehouse</option>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->location }}">
                                        {{ Str::of($warehouse->location)->ucfirst() }} [{{ $warehouse->noOfCarePacks }}]
                                    </option>
                                @endforeach
                            </select>
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
