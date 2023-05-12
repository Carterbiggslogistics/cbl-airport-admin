@extends('layouts.page')
@section('content')
    <div class="main-content">
        <section class="section">
            @include('partials.user.messages')
            <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">
                    <h4 class="page-title m-b-0">Manage Warehouses</h4>
                </li>
            </ul>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <button class="btn btn-success" type="reset" data-toggle="modal"
                                    data-target="#createWarehouse"><span class="fa fa-user-plus text-white">Create
                                        Warehouse</span></button>
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
                                                <th>Warehouse name</th>
                                                {{-- <th>Admin</th> --}}
                                                <th>No. of Care Packs</th>
                                                <th>Address</th>
                                                <th>Date Created</th>
                                                <th>Action</th>
                                                <th>Canceled By</th>
                                                <th>Date Canceled</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($warehouses as $key => $warehouse)
                                                <tr class="{{ $warehouse->canceled ? 'data-canceled-row' : '' }}">
                                                    <td class="text-center pt-2">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" data-checkboxes="mygroup"
                                                                class="custom-control-input" id="checkbox-1">
                                                            <label for="checkbox-1"
                                                                class="custom-control-label">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ Str::of($warehouse->location)->ucfirst() }}</td>
                                                    {{-- <td>{{ $warehouse->admin->fullname }}
                                                    </td> --}}
                                                    <td>{{ $warehouse->noOfCarePacks }}</td>
                                                    <td>{{ $warehouse->address }}</td>
                                                    <td>{{ $warehouse->created_at->format('F j, Y') }}</td>
                                                    <td>
                                                        @if ($warehouse->canceled)
                                                            <span class="badge badge-secondary">Canceled</span>
                                                        @else
                                                            <div class="d-flex">
                                                                <a href="/edit-warehouse/{{ $warehouse->uuid }}"
                                                                    class="btn btn-primary">Detail</a>
                                                                {{-- Button to open the cancel warehouse modal, modal at the end of the html document --}}
                                                                <button data-toggle="modal"
                                                                    data-target="#cancelWarehouseModal{{ $warehouse->id }}"
                                                                    class="btn btn-danger ml-2">Cancel</button>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $warehouse->cancelingUser ? $warehouse->cancelingUser->fullname : '-' }}
                                                    </td>
                                                    <td>
                                                        {{ $warehouse->dateCanceled ?? '-' }}
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $warehouses->links() }}
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

    <!-- Create warehouse Modal -->
    <div class="modal fade" id="createWarehouse" tabindex="-1" role="dialog" aria-labelledby="warehouseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="warehouseModalLabel">Create Warehouse</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/create-warehouse" method="post">
                    @csrf
                    <fieldset>
                        <div class="form-group form-float col-12">
                            <div class="form-line">
                                <label class="form-label">Warehouse Name<span class="text-danger"> *</span></label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror"
                                    name="location" id="location" required>

                            </div>
                        </div>
                        <div class="form-group form-float col-12">
                            <div class="form-line">
                                <label class="form-label">Warehouse Address<span class="text-danger"> *</span></label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    name="address" id="address" required>

                            </div>
                        </div>
                    </fieldset>
                    {{-- <div class="form-group col-12">
                        <label>admins<span class="text-danger">*</span></label>
                        @if (count($admins) > 0)
                            <select class="form-control @error('supervisor') is-invalid @enderror"
                                name="supervisor">
                                @foreach ($admins as $admin)
                                    <option value="{{ $admin->email }}">{{ $admin->fullname }}</option>
                                @endforeach
                            </select>
                            
                            @else
                            <h3>No registered admin</h3>
                        @endif
                    </div> --}}
                    <div class="form-group form-float col-12">
                        <div class="form-line">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Cancel Warehouse modals --}}
    @foreach ($warehouses as $warehouse)
        <div class="modal fade" id="cancelWarehouseModal{{ $warehouse->id }}" tabindex="-1" role="dialog"
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
                            <button class="btn btn-secondary mr-2" style="width: 100px;" data-dismiss="modal">Abort</button>
                            <form class="m-0" action="{{ route('cancel.warehouse') }}" method="post">
                                <input type="text" name="id" value="{{ $warehouse->id }}" hidden>
                                @csrf
                                <button type="submit" style="width: 100px;" class="btn btn-primary">Continue</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
