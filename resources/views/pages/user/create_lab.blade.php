@extends('layouts.page')
@section('content')
    <div class="main-content">
        <section class="section">
            <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">
                    <h4 class="page-title m-b-0">Create lab</h4>
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
                                <form method="POST" action="/create-lab" id="wizard_with_validation">
                                    @csrf
                                    <h3>Account Information</h3>
                                    @include('partials.user.messages')
                                    <fieldset>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">lab Full Name</label>
                                                <input type="text"
                                                    class="form-control @error('fullname') is-invalid @enderror"
                                                    name="fullname" id="fullname" required>

                                            </div>
                                        </div>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">lab Email</label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    id="email" required>

                                            </div>
                                        </div>
                                    </fieldset>
                                    <h3>Other Information</h3>
                                    <fieldset>
                                        <div class="row">
                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">lab Phone</label>
                                                    <input type="text"
                                                        class="form-control @error('phoneNumber') is-invalid @enderror"
                                                        name="phoneNumber" id="phoneNumber">

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">State</label>
                                                    <select name="state"
                                                        class="form-control @error('state') is-invalid @enderror" id="state"
                                                        required>
                                                        <option>Lagos</option>
                                                        <option>Kwara</option>
                                                        <option>Oyo</option>
                                                        <option>Abia</option>
                                                        <option>Cross River</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">Country</label>
                                                    <select name="country"
                                                        class="form-control @error('country') is-invalid @enderror"
                                                        id="country" required>
                                                        <option>Nigeria</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">Address</label>
                                                    <input type="text" name="address"
                                                        class="form-control @error('address') is-invalid @enderror"
                                                        id="address" required>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">Region</label>
                                                    <input list="regions" id="region" name="region"
                                                        class="form-control @error('region') is-invalid @enderror"
                                                        placeholder="Select Region" required>
                                                    <datalist id="regions">
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
                                                    <label class="form-label">City</label>
                                                    <input type="text" name="city"
                                                        class="form-control @error('city') is-invalid @enderror" id="city"
                                                        required>

                                                </div>
                                            </div>
                                            <div class="form-group form-float col-12">
                                                <div class="form-line">
                                                    <label class="form-label">Select Lab Admin</label>

                                                    <select required name="admin" id="admin"
                                                        class="form-control @error('admin') is-invalid @enderror">
                                                        @if (count($admins) > 0)
                                                            <option value="" disabled selected hidden>Select an admin for
                                                                this lab</option>
                                                            @foreach ($admins as $admin)
                                                                <option value="{{ $admin->fullname }}">
                                                                    {{ $admin->fullname }}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="" disabled selected hidden> No registered admin
                                                                yet! Please registered an admin first!! </option>
                                                        @endif
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="row">
                                            <div class="form-group form-float col-6">
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
