@extends('layouts.page')
@section('content')
    <div class="main-content">
        <section class="section">
            @include('partials.user.messages')
            <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">
                    <h4 class="page-title m-b-0">labs details</h4>
                </li>
            </ul>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form action="{{ route('update.lab', ['uuid' => $lab->uuid]) }}" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>lab ID</label>
                                            <input type="text" value="{{ $lab->uuid }}" class="form-control" disabled>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Registration Date</label>
                                            <input type="text" value="{{ $lab->created_at->format('F j, Y') }}"
                                                class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>lab Name</label>
                                            <input value="{{ $lab->fullname }}" type="text"
                                                class="form-control @error('fullname') is-invalid @enderror" name="fullname"
                                                id="fullname" required>

                                        </div>
                                        <div class="form-group col-6">
                                            <label>lab Phone</label>
                                            <input type="text" value="{{ $lab->phoneNumber }}"
                                                class="form-control @error('phoneNumber') is-invalid @enderror"
                                                name="phoneNumber" id="phoneNumber" required>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>lab Email</label>
                                            <input type="email" value="{{ $lab->email }}"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                id="email" required>

                                        </div>
                                        <div class="form-group col-6">
                                            <label>Total Samples</label>
                                            <input type="text" value="{{ $lab->supplies }}" class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="form-label">State</label>
                                            <select value="{{ $lab->state }}" name="state"
                                                class="form-control @error('state') is-invalid @enderror" id="state"
                                                required>
                                                <option>Lagos</option>
                                                <option>Kwara</option>
                                                <option>Oyo</option>
                                                <option>Abia</option>
                                                <option>Cross River</option>
                                            </select>

                                        </div>
                                        <div class="form-group col-6">
                                            <div class="form-line">
                                                <label class="form-label">Country</label>
                                                <select value="{{ $lab->country }}" name="country"
                                                    class="form-control @error('country') is-invalid @enderror" id="country"
                                                    required>
                                                    <option>Nigeria</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="form-label">Address</label>
                                            <input value="{{ $lab->address }}" type="text" name="address"
                                                class="form-control @error('address') is-invalid @enderror" id="address"
                                                required>

                                        </div>
                                        <div class="form-group col-6">
                                            <label class="form-label">Region</label>
                                            <input list="regions" id="region" name="region" value="{{ $lab->region }}"
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
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="form-label">City</label>
                                            <input type="text" value="{{ $lab->city }}" name="city"
                                                class="form-control @error('city') is-invalid @enderror"
                                                id="city" required>

                                        </div>
                                        <div class="form-group col-6">
                                            <label class="form-label">Select Lab Admin</label>
                                            <input value="{{ $lab->admin->fullname }}" list="admins" name="admin"
                                                class="form-control @error('admin') is-invalid @enderror"
                                                id="admin" placeholder="Select an admin for this lab" required>
                                            <datalist id="admins">

                                                @if (count($admins) > 0)
                                                    @foreach ($admins as $admin)
                                                        <option value="{{ $admin->fullname }}" />
                                                    @endforeach
                                                @else
                                                    <option
                                                        value="No registered admin yet! Please registered an admin first!!">
                                                @endif
                                            </datalist>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-danger" type="reset" onclick="history.back();">Cancel</button>
                                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
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
