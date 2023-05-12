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
                            <div class="card-header">
                                {{-- <button class="btn btn-success mr-1" type="submit">View
                                    Order Assigned History</button> --}}
                                <a href="/update-rider/{{ $rider->uuid }}" class="btn btn-info mr-1" type="reset">Edit
                                    Details</a>
                                {{-- <button class="btn btn-primary mr-1" type="reset">View
                                    Currently Assigned</button> --}}
                                <button value="{{ $rider->id }}" class="btn btn-danger" type="button" id="deleteRider"
                                    data-toggle="modal" data-target="#deleteRiderModal">Delete Rider</button>
                                <!-- <button class="btn btn-secondary" type="reset"></button> -->
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>ID</label>
                                        <input type="text" value="{{ $rider->uuid }}" disabled class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Registration Date</label>
                                        <input type="text" value="{{ $rider->created_at->format('F j, Y') }}" disabled
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Name</label>
                                        <input type="text" value="{{ $rider->fullname }}" disabled class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Phone</label>
                                        <input type="text" value="{{ $rider->phoneNumber }}" disabled
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Email</label>
                                        <input type="text" value="{{ $rider->email }}" disabled class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Staff ID</label>
                                        <input type="text" value="{{ $rider->staffId }}" disabled class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Gender</label>
                                        <input type="text" value="{{ $rider->gender }}" disabled class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Date Of Birth</label>
                                        <input type="text" value="{{ $rider->dob }}" disabled class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Designation</label>
                                        <input type="text" value="{{ $rider->designation }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Location</label>
                                        <input type="text" value="{{ $rider->location }}" disabled class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Employment Status</label>
                                        <input type="text" value="{{ $rider->employmentStatus }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Employment Date</label>
                                        <input type="text" value="{{ $rider->employmentDate }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Emergency Contact Name</label>
                                        <input type="text" value="{{ $rider->emergencyContactName }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Emergency Contact Number</label>
                                        <input type="text" value="{{ $rider->emergencyContactNumber }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Emergency Contact NAme Two</label>
                                        <input type="text" value="{{ $rider->emergencyContactNameTwo }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Emergency Contact Number Two</label>
                                        <input type="text" value="{{ $rider->emergencyContactNumberTwo }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Next Of Kin Name</label>
                                        <input type="text" value="{{ $rider->NOKName }}" disabled class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Next Of Kin Phone</label>
                                        <input type="text" value="{{ $rider->NOKPhone }}" disabled class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Next Of Kin Address</label>
                                        <input type="text" value="{{ $rider->NOKAddress }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Guarantor Name</label>
                                        <input type="text" value="{{ $rider->guarantorName }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Guarantor Address</label>
                                        <input type="text" value="{{ $rider->guarantorAddress }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Guarantor Phone</label>
                                        <input type="text" value="{{ $rider->guarantorPhone }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Bank Name</label>
                                        <input type="text" value="{{ $rider->bankName }}" disabled class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Staff Salary</label>
                                        <input type="text" value="{{ $rider->staffSalary }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>BAnk Account Number</label>
                                        <input type="text" value="{{ $rider->bankAccNumber }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>PFA Number</label>
                                        <input type="text" value="{{ $rider->PFANumber }}" disabled class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>RSA Number</label>
                                        <input type="text" value="{{ $rider->RSANumber }}" disabled class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>PFA Code</label>
                                        <input type="text" value="{{ $rider->PFACode }}" disabled class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Driver's License</label>
                                        <input type="text" value="{{ $rider->driversLicense }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Expiry Date</label>
                                        <input type="text" value="{{ $rider->expiryDate }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Insurance Date</label>
                                        <input type="text" value="{{ $rider->insuranceDate }}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Pre-employment Test Result (PTR)</label>
                                        <input type="text" value="{{ $rider->PTR }}" disabled class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Pre-employment Result Date (PRD)</label>
                                        <input type="text" value="{{ $rider->PRD }}" disabled class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Date set for Pre-employment Test (DSFPT)</label>
                                        <input type="text" value="{{ $rider->DSFPT }}" disabled class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-danger" type="reset" onclick="history.back();">Cancel</button>
                                <button class="btn btn-primary mr-1" type="submit">Submit</button>
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
    {{-- Delete Rider Modal --}}
    <div class="modal fade" id="deleteRiderModal" tabindex="-1" role="dialog" aria-labelledby="deleteRiderModalLabel"
        aria-hidden="true">
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
                            <form action="/delete-rider" class="m-0" method="post">
                                <input type="text" name="id" value="{{ $rider->id }}" hidden>
                                @csrf
                                <button type="submit" style="width: 100px;" class="btn btn-primary">Continue</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script>
        $('#deleteRider').on('click', (e) => {
            if (confirm('Are you sure you want to delete this rider?')) {
                e.preventDefault();
                let id = $('#deleteRider').val()
                // Ajax request
                $.ajax({
                    url: '{{ url(' / delete - rider ') }}',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id
                    },
                    success: function(data) {
                        alert(data)
                        window.location.replace('/manage-rider');
                    },
                    error: function(error) {
                        console.error(error)
                        return
                    }
                });
            } else {
                close()
            }
        })

    </script>
@endsection
