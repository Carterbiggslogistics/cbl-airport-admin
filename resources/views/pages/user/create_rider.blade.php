@extends('layouts.page')
@section('content')
    <div class="main-content">
        <section class="section">
            <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">
                    <h4 class="page-title m-b-0">Register Rider</h4>
                </li>
                <!--  -->
            </ul>
            <div class="section-body">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body">
                                <form method="POST" action="/create-rider" id="wizard_with_validation">
                                    {{ csrf_field() }}
                                    <h3>Personal Details</h3>
                                    @include('partials.user.messages')
                                    <fieldset>
                                        <div class="row">
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">First Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('firstname') is-invalid @enderror"
                                                        name="firstname" id="firstname" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Last Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('lastname') is-invalid @enderror"
                                                        name="lastname" id="lastname" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Middle Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('middlename') is-invalid @enderror"
                                                        name="middlename" id="middlename" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Email <span
                                                            class="text-danger">*</span></label>
                                                    <input type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email" id="email" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Staff ID <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('staffId') is-invalid @enderror"
                                                        name="staffId" id="staffId" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Gender <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control @error('gender') is-invalid @enderror"
                                                        name="gender" id="gender" required>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Phone Number <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number"
                                                        class="form-control @error('phoneNumber') is-invalid @enderror"
                                                        name="phoneNumber" id="phoneNumber" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Date Of Birth <span
                                                            class="text-danger">*</span></label>
                                                    <input type="date"
                                                        class="form-control @error('dob') is-invalid @enderror" name="dob"
                                                        id="dob" required>

                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <h3>Employment Details</h3>
                                    <fieldset>
                                        <div class="row">
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Designation <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('designation') is-invalid @enderror"
                                                        name="designation" id="designation" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Employment Status <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('employmentStatus') is-invalid @enderror"
                                                        name="employmentStatus" id="employmentStatus" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Location <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('location') is-invalid @enderror"
                                                        name="location" id="location" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Employment Date <span
                                                            class="text-danger">*</span></label>
                                                    <input type="date"
                                                        class="form-control @error('employmentDate') is-invalid @enderror"
                                                        name="employmentDate" id="employmentDate" required>

                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <h3>Emergency Details</h3>
                                    <fieldset>
                                        <div class="row">
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Emergency Contact Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('emergencyContactName') is-invalid @enderror"
                                                        name="emergencyContactName" id="emergencyContactName" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Emergency Contact Number <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('emergencyContactNumber') is-invalid @enderror"
                                                        name="emergencyContactNumber" id="emergencyContactNumber" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Emergency Contact Name 2 <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('emergencyContactNameTwo') is-invalid @enderror"
                                                        name="emergencyContactNameTwo" id="emergencyContactNameTwo"
                                                        required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Emergency Contact Number 2 <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('emergencyContactNumberTwo') is-invalid @enderror"
                                                        name="emergencyContactNumberTwo" id="emergencyContactNumberTwo"
                                                        required>

                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <h3>Next Of Kin</h3>
                                    <fieldset>
                                        <div class="row">
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Next of kin name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('NOKName') is-invalid @enderror"
                                                        name="NOKName" id="NOKName" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Next of kin address <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('NOKAddress') is-invalid @enderror"
                                                        name="NOKAddress" id="NOKAddress" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Next of kin phone <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('NOKPhone') is-invalid @enderror"
                                                        name="NOKPhone" id="NOKPhone" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Guarantor Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('guarantorName') is-invalid @enderror"
                                                        name="guarantorName" id="guarantorName" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Guarantor Address <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('guarantorAddress') is-invalid @enderror"
                                                        name="guarantorAddress" id="guarantorAddress" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Guarantor Phone <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('guarantorPhone') is-invalid @enderror"
                                                        name="guarantorPhone" id="guarantorPhone" required>

                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <h3>Bank Details</h3>
                                    <fieldset>
                                        <div class="row">
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Bank Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('bankName') is-invalid @enderror"
                                                        name="bankName" id="bankName" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Staff Salary <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('staffSalary') is-invalid @enderror"
                                                        name="staffSalary" id="staffSalary" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Bank Account Number <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number"
                                                        class="form-control @error('bankAccNumber') is-invalid @enderror"
                                                        name="bankAccNumber" id="bankAccNumber" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">PFA Number</label>
                                                    <input type="number"
                                                        class="form-control @error('PFANumber') is-invalid @enderror"
                                                        name="PFANumber" id="PFANumber">

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">RSA Number</label>
                                                    <input type="text"
                                                        class="form-control @error('RSANumber') is-invalid @enderror"
                                                        name="RSANumber" id="RSANumber">

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">PFA Code</label>
                                                    <input type="text"
                                                        class="form-control @error('PFACode') is-invalid @enderror"
                                                        name="PFACode" id="PFACode">

                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <h3>Additional Info</h3>
                                    <fieldset>
                                        <div class="row">
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Drivers License Number <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('driversLicense') is-invalid @enderror"
                                                        name="driversLicense" id="driversLicense" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Insurance Date</label>
                                                    <input type="date"
                                                        class="form-control @error('insuranceDate') is-invalid @enderror"
                                                        name="insuranceDate" id="insuranceDate">

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Expiry Date <span
                                                            class="text-danger">*</span></label>
                                                    <input type="date"
                                                        class="form-control @error('expiryDate') is-invalid @enderror"
                                                        name="expiryDate" id="expiryDate" required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Pre-employment Test Result</label>
                                                    <input type="text"
                                                        class="form-control @error('PTR') is-invalid @enderror" name="PTR"
                                                        id="PTR">

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Pre-employment Result Date</label>
                                                    <input type="date"
                                                        class="form-control @error('PRD') is-invalid @enderror" name="PRD"
                                                        id="PRD">

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-line">
                                                    <label class="form-label">Date set for Pre-employment Test</label>
                                                    <input type="date"
                                                        class="form-control @error('DSFPT') is-invalid @enderror"
                                                        name="DSFPT" id="DSFPT">

                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <h3 class="h3">Password Information</h3>
                                    <small>Please copy this password</small>
                                    <fieldset>
                                        <div class="form-group col-lg-6">
                                            <label for="password">Password</label>
                                            <input value="{{ Str::random(30) }}" class="form-control" type="text"
                                                name="password" id="password" required disabled>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="row">
                                            <div class="form-group form-float col-lg-6 col-md-12 col-sm-12 col-xs-12 col-6">
                                                <div class="form-line">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
