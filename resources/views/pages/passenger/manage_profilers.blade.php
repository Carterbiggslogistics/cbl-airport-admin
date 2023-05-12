@extends('layouts.page')
@section('content')
    <div class="main-content">
        <section class="section">
            @include('partials.user.messages')
            <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">
                    <h4 class="page-title m-b-0">Manage Profilers</h4>
                </li>
                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <button class="btn btn-success" type="reset" data-toggle="modal"
                                        data-target="#createProfiler"><span class="fa fa-user-plus text-white">Add
                                            Profiler</span></button>
                                </div>
                                @if (count($profilers) > 0)
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="table-2">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center pt-3">
                                                            <div
                                                                class="custom-checkbox custom-checkbox-table custom-control">
                                                                <input type="checkbox" data-checkboxes="mygroup"
                                                                    data-checkbox-role="dad" class="custom-control-input"
                                                                    id="checkbox-all">
                                                                <label for="checkbox-all"
                                                                    class="custom-control-label">&nbsp;</label>
                                                            </div>
                                                        </th>
                                                        <th>S/N</th>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Date Joined</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($profilers as $key => $profiler)
                                                        <tr>
                                                            <td class="text-center pt-2">
                                                                <div class="custom-checkbox custom-control">
                                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                                        class="custom-control-input" id="checkbox-1">
                                                                    <label for="checkbox-1"
                                                                        class="custom-control-label">&nbsp;</label>
                                                                </div>
                                                            </td>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $profiler->uuid }}</td>
                                                            <td>{{ $profiler->fullname }}</td>
                                                            <td>{{ $profiler->email }}</td>
                                                            <td>{{ $profiler->phoneNumber }}</td>
                                                            <td>{{ $profiler->created_at->format('F j, Y') }}</td>
                                                            <td><a href="#" class="btn btn-primary">Detail</a></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @else
                                    <h3>No profilers registered</h3>
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

    <!-- Create profiler Modal -->
    <div class="modal fade" id="createProfiler" tabindex="-1" role="dialog" aria-labelledby="profilerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profilerModalLabel">Create profiler</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/create-profiler" method="post">
                    {{ csrf_field() }}
                    <fieldset>
                        <div class="form-group">
                            <div class="form-line">
                                <label class="form-label">Full Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('fullname') is-invalid @enderror"
                                    name="fullname" id="fullname" required>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label class="form-label">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                    id="email" required>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label class="form-label">Password<span class="text-danger">*</span> (Please copy this for
                                    login purpose)</label>
                                <input type="text" name="password" id="password" value="{{ bin2hex(random_bytes(10)) }}"
                                    class="form-control @error('password') is-invalid @enderror" required>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label class="form-label">Phone<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phoneNumber') is-invalid @enderror"
                                    name="phoneNumber" id="phoneNumber">

                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group col-12">
                        <label>Supervisors<span class="text-danger">*</span></label>
                        @if (count($supervisors) > 0)
                            <select class="form-control @error('supervisor') is-invalid @enderror" name="supervisor">
                                @foreach ($supervisors as $supervisor)
                                    <option value="{{ $supervisor->email }}">{{ $supervisor->fullname }}</option>
                                @endforeach
                            </select>

                        @else
                            <h3>No registered supervisor</h3>
                        @endif
                    </div>
                    <div>
                        <button class="btn btn-success" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
