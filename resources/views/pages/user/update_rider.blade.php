@extends('layouts.page')
@section('content')
<div class="main-content">
    <section class="section">
        <ul class="breadcrumb breadcrumb-style ">
            <li class="breadcrumb-item">
                <h4 class="page-title m-b-0">Rider details</h4>
            </li>
        </ul>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="/update-rider/{{$rider->id}}" method="post">
                            {{ csrf_field() }}
                            <div class="card-body">
                                @include('partials.user.messages')
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="fullname" value="{{$rider->fullname}}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Phone <span class="text-danger">*</span></label>
                                        <input type="text" name="phoneNumber" value="{{$rider->phoneNumber}}"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <input type="text" name="email" value="{{$rider->email}}" class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Staff ID <span class="text-danger">*</span></label>
                                        <input type="text" name="staffId" value="{{$rider->staffId}}"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Gender <span class="text-danger">*</span></label>
                                        <input type="text" name="gender" value="{{$rider->gender}}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Date Of Birth <span class="text-danger">*</span></label>
                                        <input type="text" name="dob" value="{{$rider->dob}}" class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Designation <span class="text-danger">*</span></label>
                                        <input type="text" name="designation" value="{{$rider->designation}}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Location <span class="text-danger">*</span></label>
                                        <input type="text" name="location" value="{{$rider->location}}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Employment Status <span class="text-danger">*</span></label>
                                        <input type="text" name="employmentStatus" value="{{$rider->employmentStatus}}"
                                            class="form-control"> required
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Employment Date <span class="text-danger">*</span></label>
                                        <input type="text" name="employmentDate" value="{{$rider->employmentDate}}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Emergency Contact Name <span class="text-danger">*</span></label>
                                        <input type="text" name="emergencyContactName"
                                            value="{{$rider->emergencyContactName}}" class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Emergency Contact Number <span class="text-danger">*</span></label>
                                        <input type="text" name="emergencyContactNumber"
                                            value="{{$rider->emergencyContactNumber}}" class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Emergency Contact NAme Two <span class="text-danger">*</span></label>
                                        <input type="text" name="emergencyContactNameTwo"
                                            value="{{$rider->emergencyContactNameTwo}}" class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Emergency Contact Number Two <span class="text-danger">*</span></label>
                                        <input type="text" name="emergencyContactNumberTwo"
                                            value="{{$rider->emergencyContactNumberTwo}}" class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Next Of Kin Name <span class="text-danger">*</span></label>
                                        <input type="text" name="NOKName" value="{{$rider->NOKName}}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Next Of Kin Phone <span class="text-danger">*</span></label>
                                        <input type="text" name="NOKPhone" value="{{$rider->NOKPhone}}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Next Of Kin Address <span class="text-danger">*</span></label>
                                        <input type="text" name="NOKAddress" value="{{$rider->NOKAddress}}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Guarantor Name <span class="text-danger">*</span></label>
                                        <input type="text" name="guarantorName" value="{{$rider->guarantorName}}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Guarantor Address <span class="text-danger">*</span></label>
                                        <input type="text" name="guarantorAddress" value="{{$rider->guarantorAddress}}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Guarantor Phone <span class="text-danger">*</span></label>
                                        <input type="text" name="guarantorPhone" value="{{$rider->guarantorPhone}}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Bank Name <span class="text-danger">*</span></label>
                                        <input type="text" name="bankName" value="{{$rider->bankName}}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Staff Salary <span class="text-danger">*</span></label>
                                        <input type="text" name="staffSalary" value="{{$rider->staffSalary}}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>BAnk Account Number <span class="text-danger">*</span></label>
                                        <input type="text" name="bankAccNumber" value="{{$rider->bankAccNumber}}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>PFA Number</label>
                                        <input type="text" name="PFANumber" value="{{$rider->PFANumber}}"
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>RSA Number</label>
                                        <input type="text" name="RSANumber" value="{{$rider->RSANumber}}"
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>PFA Code</label>
                                        <input type="text" name="PFACode" value="{{$rider->PFACode}}"
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Driver's License <span class="text-danger">*</span></label>
                                        <input type="text" name="driversLicense" value="{{$rider->driversLicense}}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Expiry Date <span class="text-danger">*</span></label>
                                        <input type="text" name="expiryDate" value="{{$rider->expiryDate}}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Insurance Date</label>
                                        <input type="text" name="insuranceDate" value="{{$rider->insuranceDate}}"
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Pre-employment Test Result (PTR)</label>
                                        <input type="text" name="PTR" value="{{$rider->PTR}}" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Pre-employment Result Date (PRD)</label>
                                        <input type="text" name="PRD" value="{{$rider->PRD}}" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Date set for Pre-employment Test (DSFPT)</label>
                                        <input type="text" name="DSFPT" value="{{$rider->DSFPT}}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-danger" type="reset" onclick="history.back();">Cancel</button>
                                <button class="btn btn-primary mr-1" type="submit">Submit</button>
                            </div>
                        </form>
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
@endsection