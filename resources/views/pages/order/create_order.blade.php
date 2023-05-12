@extends('layouts.page')
@section('content')
    <div class="main-content">
        <section class="section">
            <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">
                    <h4 class="page-title m-b-0">Sample Pickup Request</h4>
                </li>
                <!--  -->
            </ul>
            <div class="section-body">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            @can('isSuperAdmin')
                                <div class="card-body">
                                    <div>
                                        <a download href="/download-order-info-template" class="btn btn-primary">Download
                                            Template for Upload</a>
                                        <a download href="/download-riders-sheet" class="btn btn-primary">Download Riders
                                            Data</a>
                                        <a download href="/download-lab-export-sheet" class="btn btn-primary">Download Labs
                                            Data</a>
                                        <a download href="/download-user-export-sheet" class="btn btn-primary">Download User
                                            Data</a>
                                    </div>
                                    <br>
                                    <br>
                                    <form action="/order-bulk-import" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @include('partials.user.messages')
                                        <div class="form-group form-float col-12">
                                            <div class="form-line">
                                                <label class="form-label">Upload Care Pack Information <span
                                                        class="text-danger">*</span></label>
                                                <input type="file" name="file"
                                                    class="form-control file @error('file') is-invalid @enderror" id="file"
                                                    required>

                                            </div>
                                        </div>
                                        <button class="btn btn-success" style="float: right" type="submit">Submit</button>
                                    </form>
                                    <br>
                                    <br>
                                    <form method="POST" action="/admin-order" id="wizard_with_validation">
                                        {{ csrf_field() }}
                                        @include('partials.user.messages')
                                        <h3>Request Information</h4>
                                            <fieldset>
                                                <div class="row">
                                                    <div class="form-group form-float col-6">
                                                        <div class="form-line">
                                                            <label class="form-label">Select Pickup Contact<span
                                                                    class="text-danger">*</span>
                                                            </label>
                                                            <input list="names" id="lgaName" name="lgaName"
                                                                class="form-control  @error('lgaName') is-invalid @enderror"
                                                                autocomplete="off" placeholder="Select Pickup Contact"
                                                                onchange="showLGAInfo();" required>
                                                            <datalist id="names">
                                                                @foreach ($lgas as $lga)
                                                                    <option value="{{ $lga->fullname }}">
                                                                @endforeach
                                                            </datalist>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-float col-6">
                                                        <div class="form-line">
                                                            <label class="form-label">Pickup Region<span
                                                                    class="text-danger">*</span></label>

                                                            <input type="text" name="pickupRegion"
                                                                class="form-control pickupRegion @error('pickupRegion') is-invalid @enderror"
                                                                id="lgaPickupRegion" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group form-float col-6">
                                                        <div class="form-line">
                                                            <label class="form-label">Pickup Address<span
                                                                    class="text-danger">*</span></label>

                                                            <input type="text" name="pickupAddress"
                                                                class="form-control pickupAddress @error('pickupAddress') is-invalid @enderror"
                                                                id="lgaPickupAddress" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-float col-6">
                                                        <div class="form-line">
                                                            <label class="form-label">Select Location for Delivery<span
                                                                    class="text-danger"> *</span></label>
                                                            <input list="regions" id="labName" name="labName"
                                                                class="form-control @error('labName') is-invalid @enderror"
                                                                placeholder="Select Delivery Location" onchange="showLabInfo();"
                                                                required>
                                                            <datalist id="regions">
                                                                @foreach ($labs as $lab)
                                                                    <option value="{{ $lab->fullname }}">
                                                                @endforeach
                                                            </datalist>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-float col-6">
                                                        <div class="form-line">
                                                            <label class="form-label">Delivery Region<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" name="deliveryRegion"
                                                                class="form-control @error('deliveryRegion') is-invalid @enderror"
                                                                id="labDeliveryRegion" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-float col-6">
                                                        <div class="form-line">
                                                            <label class="form-label">Delivery Address<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" name="deliveryAddress"
                                                                class="form-control @error('deliveryAddress') is-invalid @enderror"
                                                                id="labDeliveryAddress" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group form-float col-6">
                                                        <div class="form-line">
                                                            <label class="form-label">Delivery Contact name<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" name="deliveryContactName"
                                                                id="labDeliveryContactName"
                                                                class="form-control @error('deliveryContactName') is-invalid @enderror"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-float col-6">
                                                        <div class="form-line">
                                                            <label class="form-label">Delivery Contact Phone<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" name="deliveryContactPhone"
                                                                class="form-control no-resize @error('deliveryContactPhone') is-invalid @enderror"
                                                                id="labDeliveryContactPhone" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <h3>Other Information</h3>
                                            <fieldset>
                                                <div class="row">
                                                    <div class="form-group col-6">
                                                        <div class="form-line">
                                                            <label class="form-label">Quantity
                                                                {{-- <span class="text-danger">*</span> --}}
                                                            </label>
                                                            <input name="quantity"
                                                                class="form-control @error('quantity') is-invalid @enderror"
                                                                id="quantity" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-float col-6">
                                                        <div class="form-line">
                                                            <label class="form-label">Assign a rider<span
                                                                    class="text-danger">*</span></label>
                                                            <select name="rider"
                                                                class="form-control @error('rider') is-invalid @enderror"
                                                                id="rider" required>
                                                                @foreach ($riders as $rider)
                                                                    <option value="{{ $rider->email }}">
                                                                        {{ $rider->firstname }}
                                                                        {{ $rider->lastname }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input id="acceptTerms-2" name="acceptTerms" type="checkbox" required>
                                                <label for="acceptTerms-2">I acknowledge entering all correct information to
                                                    create an order.</label>
                                                <div class="form-group form-float col-12">
                                                    <div class="form-line">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                        <button type="button" class="btn btn-danger" style="float:right;"
                                                            onclick="history.back();">Cancel</button>
                                                    </div>
                                                </div>
                                            </fieldset>
                                    </form>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

    <!-- Script Section -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script>
        var lgas = <?php echo json_encode($lgas); ?> ; //get all lgas from database query
        var labs = <?php echo json_encode($labs); ?> ; //get all labs from database query

        var lgaPickupRegion = document.getElementById('lgaPickupRegion');
        var lgaPickupAddress = document.getElementById('lgaPickupAddress');
        var labDeliveryRegion = document.getElementById('labDeliveryRegion');
        var labDeliveryAddress = document.getElementById('labDeliveryAddress');
        var labDeliveryContactName = document.getElementById('labDeliveryContactName');
        var labDeliveryContactPhone = document.getElementById('labDeliveryContactPhone');
        const showLGAInfo = () => {
            let lgaName = document.getElementById('lgaName').value;
            let lga = (lgas.filter((lga) => lga.fullname === lgaName));
            lgaPickupRegion.value = (lga[0].region);
            lgaPickupAddress.value = (lga[0].address);
        }

        const showLabInfo = () => {
            let labName = document.getElementById('labName').value;
            let lab = (labs.filter((lab) => lab.fullname === labName));
            labDeliveryRegion.value = (lab[0].region);
            labDeliveryAddress.value = (lab[0].address);
            labDeliveryContactName.value = (lab[0].fullname);
            labDeliveryContactPhone.value = lab[0].phoneNumber;
        }

    </script>
@endsection
