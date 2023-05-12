@extends('layouts.page')
@section('content')
    <div class="main-content">
        <section class="section">
            <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">
                    <h4 class="page-title m-b-0">Care Pack Request</h4>
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
                                <div>
                                    <a download href="/download-pack-info-template" class="btn btn-success">Download
                                        Template for Upload</a>
                                    <a download href="/download-warehouse-sheet" class="btn btn-success">Download Warehouses
                                        Data</a>
                                    <a download href="/download-riders-sheet" class="btn btn-success">Download Riders
                                        Data</a>
                                </div>
                                <br>
                                <br>
                                <form action="/pack-bulk-import" method="post" enctype="multipart/form-data">
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
                                <form method="POST" action="/pack-request">
                                    @csrf
                                    @include('partials.user.messages')
                                    <h3>Request Information</h3>
                                    <fieldset>
                                        <div class="row">
                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">Description<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="description"
                                                        class="form-control @error('description') is-invalid @enderror"
                                                        id="description" required placeholder="Eg: Request for ABC LGA ">

                                                </div>
                                            </div>

                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">Assign Riders</label>
                                                    <select class="form-control 
                                                                {{ count($riders) == 0 ? 'text-danger is-invalid' : '' }} 
                                                                @error('rider') is-invalid @enderror" name="rider"
                                                        required>
                                                        <option value="" selected hidden>
                                                            {{ count($riders) > 0 ? '-- Assign Rider --' : 'No registered rider' }}
                                                        </option>
                                                        @foreach ($riders as $rider)
                                                            <option value="{{ $rider->id }}">{{ $rider->fullname }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">Warehouse</label>
                                                    <select
                                                        class="form-control 
                                                                @error('warehouse') is-invalid @enderror
                                                                {{ count($warehouses) == 0 ? 'text-danger is-invalid' : '' }}"
                                                        name="warehouse" id="warehouse" required>
                                                        <option value="" selected hidden>
                                                            {{ count($riders) > 0 ? '-- Select warehouse --' : 'No registered warehouse' }}
                                                        </option>
                                                        @foreach ($warehouses as $warehouse)
                                                            <option value="{{ $warehouse->id }}">
                                                                {{ $warehouse->location }}
                                                                [{{ $warehouse->noOfCarePacks }}]</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">Quantity<span class="text-danger">
                                                            *</span></label>
                                                    <input type="number" name="quantity"
                                                        class="form-control no-resize @error('quantity') is-invalid @enderror"
                                                        id="quantity" required>

                                                </div>
                                            </div>

                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">Pickup Region<span class="text-danger">
                                                            *</span></label>
                                                    <input list="pickupRegions" id="pickupRegion" name="pickupRegion"
                                                        class="form-control @error('pickupRegion') is-invalid @enderror"
                                                        placeholder="Select Region" required>
                                                    <datalist id="pickupRegions">
                                                        <option value="Abraham Adesanya Estate (Lagos)" />
                                                        <option value="Abule Egba (Lagos)" />
                                                        <option value="Ago (Lagos)" />
                                                        <option value="Ajah market (Lagos)" />
                                                        <option value="Akoka-unilag (Lagos)" />
                                                        <option value="Akoka (Lagos)" />
                                                        <option value="Alimosho" />
                                                        <option value="Alapere" /> 
                                                        <option value="Oworonshoki" /> 
                                                        <option value="Awoyaya" />
                                                        <option value="Lagos Island (Idumota)"   />
                                                        <option value="Ojota" />
                                                        <option value="Ojo" />
                                                        <option value="Iyanapaja" />
                                                        <option value="Merian " />
                                                        <option value="Shasha" />
                                                        <option value="Egbeda " />
                                                        <option value="Amuwo odofin (Lagos)" />
                                                        <option value="Anthony (Lagos)" />
                                                        <option value="Anthony village (Lagos)" />
                                                        <option value="Apapa (Lagos)" />
                                                        <option value="Badore (Lagos)" />
                                                        <option value="Banana island (Lagos)" />
                                                        <option value="Dolphin Estate (Lagos)" />
                                                        <option value="Dopemu (Lagos)" />
                                                        <option value="E-centre Food Court (Lagos)" />
                                                        <option value="Eko Atlantic City (Lagos)" />
                                                        <option value="Fadeyi (Lagos)" />
                                                        <option value="Festac Town (Lagos)" />
                                                        <option value="Gbagada (Lagos)" />
                                                        <option value="Gowon Estate (Lagos)" />
                                                        <option value="Idimu 2 (Lagos)" />
                                                        <option value="Igbo Efon (Lagos)" />
                                                        <option value="Ijegun (Lagos)" />
                                                        <option value="Ikeja-Alausa (Lagos)" />
                                                        <option value="Ikeja-GRA (Lagos)" />
                                                        <option value="Ikeja-Oba Akran (Lagos)" />
                                                        <option value="Ikeja-Opebi (Lagos)" />
                                                        <option value="Ikeja Allen Avenue (Lagos)" />
                                                        <option value="Ikeja Local Airport (Lagos)" />
                                                        <option value="Ikeja Maryland (Lagos)" />
                                                        <option value="Ikeja Mobolaji Bank Anthony (Lagos)" />
                                                        <option value="Ikorodu-Central (Lagos)" />
                                                        <option value="Ikota (Lagos)" />
                                                        <option value="Ikota Shopping Complex (Lagos)" />
                                                        <option value="Ikotun (Lagos)" />
                                                        <option value="Ikoyi-Awolowo (Lagos)" />
                                                        <option value="Ikoyi-Bourdillon (Lagos)" />
                                                        <option value="Ikoyi (Lagos)" />
                                                        <option value="Ilupeju (Lagos)" />
                                                        <option value="Isolo (Lagos)" />
                                                        <option value="Jibowu-Fadeyi (Lagos)" />
                                                        <option value="Jumia ikeja (Lagos)" />
                                                        <option value="Ketu (Lagos)" />
                                                        <option value="Lagos Island (Lagos)" />
                                                        <option value="LCC (Lagos)" />
                                                        <option value="Lekki-Chevron (Lagos)" />
                                                        <option value="Lekki-Elegushi (Lagos)" />
                                                        <option value="Lekki 4th and 5th Roundabout (Lagos)" />
                                                        <option value="Lekki Elf (Lagos)" />
                                                        <option value="Lekki Phase 1 (Lagos)" />
                                                        <option value="Magodo Phase 1 (Lagos)" />
                                                        <option value="Magodo Phase 2 (Lagos)" />
                                                        <option value="Marina (Lagos)" />
                                                        <option value="Marina Express (Lagos)" />
                                                        <option value="Novare Lekki Mall (Lagos)" />
                                                        <option value="Obalende (Lagos)" />
                                                        <option value="Obanikoro (Lagos)" />
                                                        <option value="Ogba (Lagos)" />
                                                        <option value="Ogudu (Lagos)" />
                                                        <option value="Okota (Lagos)" />
                                                        <option value="Oluwaninshola (Lagos)" />
                                                        <option value="Omole Phase 1 (Lagos)" />
                                                        <option value="Onike (Lagos)" />
                                                        <option value="Oniru (Lagos)" />
                                                        <option value="Orile-Iganmu (Lagos)" />
                                                        <option value="Oshodi Isolo (Lagos)" />
                                                        <option value="Sangotedo-Abijo (Lagos)" />
                                                        <option value="Sangotedo-Lagoonside (Lagos)" />
                                                        <option value="Satellite Town (Lagos)" />
                                                        <option value="Surulere-Aguda (Lagos)" />
                                                        <option value="Surulere-Bode Thomas (Lagos)" />
                                                        <option value="Surulere Idi Araba (Lagos)" />
                                                        <option value="Surulere - Ojuelegba (Lagos)" />
                                                        <option value="Surulere-Stadium (Lagos)" />
                                                        <option value="VGC (Lagos)" />
                                                        <option value="Victoria Island (Lagos)" />
                                                        <option value="Yaba-Abule Ijesha (Lagos)" />
                                                        <option value="Yaba-Alagomeji (Lagos)" />
                                                        <option value="Yaba-Ebute Meta (Lagos)" />
                                                        <option value="Yaba-Makoju (Lagos)" />
                                                        <option value="Yaba-Sabo (Lagos)" />
                                                    </datalist>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">Pickup Address<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="pickupAddress"
                                                        class="form-control  @error('pickupAddress') is-invalid @enderror"
                                                        id="pickupAddress" required>

                                                </div>
                                            </div>

                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">Delivery Region<span
                                                            class="text-danger">*</span></label>
                                                    <input list="deliveryRegions" id="deliveryRegion" name="deliveryRegion"
                                                        class="form-control @error('deliveryRegion') is-invalid @enderror"
                                                        placeholder="Select Region" required>
                                                    <datalist id="deliveryRegions">
                                                        <option value="Abraham Adesanya Estate (Lagos)" />
                                                        <option value="Abule Egba (Lagos)" />
                                                        <option value="Ago (Lagos)" />
                                                        <option value="Ajah market (Lagos)" />
                                                        <option value="Akoka-unilag (Lagos)" />
                                                        <option value="Akoka (Lagos)" />
                                                        <option value="Alimosho" />
                                                        <option value="Alapere" /> 
                                                        <option value="Oworonshoki" /> 
                                                        <option value="Awoyaya" />
                                                        <option value="Lagos Island (Idumota)"   />
                                                        <option value="Ojota" />
                                                        <option value="Ojo" />
                                                        <option value="Iyanapaja" />
                                                        <option value="Merian " />
                                                        <option value="Shasha" />
                                                        <option value="Egbeda " />
                                                        <option value="Amuwo odofin (Lagos)" />
                                                        <option value="Anthony (Lagos)" />
                                                        <option value="Anthony village (Lagos)" />
                                                        <option value="Apapa (Lagos)" />
                                                        <option value="Badore (Lagos)" />
                                                        <option value="Banana island (Lagos)" />
                                                        <option value="Dolphin Estate (Lagos)" />
                                                        <option value="Dopemu (Lagos)" />
                                                        <option value="E-centre Food Court (Lagos)" />
                                                        <option value="Eko Atlantic City (Lagos)" />
                                                        <option value="Fadeyi (Lagos)" />
                                                        <option value="Festac Town (Lagos)" />
                                                        <option value="Gbagada (Lagos)" />
                                                        <option value="Gowon Estate (Lagos)" />
                                                        <option value="Idimu 2 (Lagos)" />
                                                        <option value="Igbo Efon (Lagos)" />
                                                        <option value="Ijegun (Lagos)" />
                                                        <option value="Ikeja-Alausa (Lagos)" />
                                                        <option value="Ikeja-GRA (Lagos)" />
                                                        <option value="Ikeja-Oba Akran (Lagos)" />
                                                        <option value="Ikeja-Opebi (Lagos)" />
                                                        <option value="Ikeja Allen Avenue (Lagos)" />
                                                        <option value="Ikeja Local Airport (Lagos)" />
                                                        <option value="Ikeja Maryland (Lagos)" />
                                                        <option value="Ikeja Mobolaji Bank Anthony (Lagos)" />
                                                        <option value="Ikorodu-Central (Lagos)" />
                                                        <option value="Ikota (Lagos)" />
                                                        <option value="Ikota Shopping Complex (Lagos)" />
                                                        <option value="Ikotun (Lagos)" />
                                                        <option value="Ikoyi-Awolowo (Lagos)" />
                                                        <option value="Ikoyi-Bourdillon (Lagos)" />
                                                        <option value="Ikoyi (Lagos)" />
                                                        <option value="Ilupeju (Lagos)" />
                                                        <option value="Isolo (Lagos)" />
                                                        <option value="Jibowu-Fadeyi (Lagos)" />
                                                        <option value="Jumia ikeja (Lagos)" />
                                                        <option value="Ketu (Lagos)" />
                                                        <option value="Lagos Island (Lagos)" />
                                                        <option value="LCC (Lagos)" />
                                                        <option value="Lekki-Chevron (Lagos)" />
                                                        <option value="Lekki-Elegushi (Lagos)" />
                                                        <option value="Lekki 4th and 5th Roundabout (Lagos)" />
                                                        <option value="Lekki Elf (Lagos)" />
                                                        <option value="Lekki Phase 1 (Lagos)" />
                                                        <option value="Magodo Phase 1 (Lagos)" />
                                                        <option value="Magodo Phase 2 (Lagos)" />
                                                        <option value="Marina (Lagos)" />
                                                        <option value="Marina Express (Lagos)" />
                                                        <option value="Novare Lekki Mall (Lagos)" />
                                                        <option value="Obalende (Lagos)" />
                                                        <option value="Obanikoro (Lagos)" />
                                                        <option value="Ogba (Lagos)" />
                                                        <option value="Ogudu (Lagos)" />
                                                        <option value="Okota (Lagos)" />
                                                        <option value="Oluwaninshola (Lagos)" />
                                                        <option value="Omole Phase 1 (Lagos)" />
                                                        <option value="Onike (Lagos)" />
                                                        <option value="Oniru (Lagos)" />
                                                        <option value="Orile-Iganmu (Lagos)" />
                                                        <option value="Oshodi Isolo (Lagos)" />
                                                        <option value="Sangotedo-Abijo (Lagos)" />
                                                        <option value="Sangotedo-Lagoonside (Lagos)" />
                                                        <option value="Satellite Town (Lagos)" />
                                                        <option value="Surulere-Aguda (Lagos)" />
                                                        <option value="Surulere-Bode Thomas (Lagos)" />
                                                        <option value="Surulere Idi Araba (Lagos)" />
                                                        <option value="Surulere - Ojuelegba (Lagos)" />
                                                        <option value="Surulere-Stadium (Lagos)" />
                                                        <option value="VGC (Lagos)" />
                                                        <option value="Victoria Island (Lagos)" />
                                                        <option value="Yaba-Abule Ijesha (Lagos)" />
                                                        <option value="Yaba-Alagomeji (Lagos)" />
                                                        <option value="Yaba-Ebute Meta (Lagos)" />
                                                        <option value="Yaba-Makoju (Lagos)" />
                                                        <option value="Yaba-Sabo (Lagos)" />
                                                    </datalist>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">Delivery Address<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="deliveryAddress"
                                                        class="form-control @error('deliveryAddress') is-invalid @enderror"
                                                        id="deliveryAddress" required>

                                                </div>
                                            </div>


                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">Delivery Contact name<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="deliveryContactName" id="deliveryContactName"
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
                                                        id="deliveryContactPhone" required>

                                                </div>
                                            </div>
                                    </fieldset>
                                    <fieldset>
                                        <input id="acceptTerms-2" name="acceptTerms" type="checkbox" required>
                                        <label for="acceptTerms-2">I agree with the Terms and Conditions.</label>
                                        <div class="form-group form-float col-6">
                                            <div class="form-line">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="button" class="btn btn-danger" style="float:right;"
                                                    onclick="history.back();">Cancel</button>
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
