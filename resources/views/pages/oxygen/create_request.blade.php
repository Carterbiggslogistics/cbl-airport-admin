@extends('layouts.page')
@section('content')
    <div class="main-content">
        <section class="section">
            <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">
                    <h4 class="page-title m-b-0">Create Oxygen Request</h4>
                </li>
            </ul>
            <div class="section-body">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body">
                                <form method="POST" action="/oxygen/request/create" id="wizard_with_validation">
                                    @csrf
                                    @include('partials.user.messages')
                                    <fieldset>
                                        <legend>Plant and Client</legend>

                                        <div class="row">
                                            <div class="form-group form-float col-md-6">
                                                <div class="form-line">
                                                    <label class="form-label" for="plant">Plant <span
                                                            class="text-danger">*</span></label>
                                                    <select
                                                        class="form-control {{ count($oxygenPlants) == 0 ? 'is-invalid text-danger' : '' }} @error('plant') is-invalid @enderror"
                                                        name="plant" id="plant" required>
                                                        <option value="" selected hidden>
                                                            {{ count($oxygenPlants) == 0 ? 'No Plant Created' : '-- Select Oxygen Plant --' }}
                                                        </option>
                                                        @foreach ($oxygenPlants as $plant)
                                                            <option value="{{ $plant->id }}">{{ $plant->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group form-float col-md-6">
                                                <div class="form-line">
                                                    <label class="form-label" for="client">Client <span
                                                            class="text-danger">*</span></label>
                                                    <select
                                                        class="form-control {{ count($oxygenClients) == 0 ? 'is-invalid text-danger' : '' }} @error('client') is-invalid @enderror"
                                                        name="client" id="client" required>
                                                        <option value="" selected hidden>
                                                            {{ count($oxygenClients) == 0 ? 'No Client Created' : '-- Select Oxygen Client --' }}
                                                        </option>
                                                        @foreach ($oxygenClients as $client)
                                                            <option value="{{ $client->id }}">{{ $client->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </fieldset>

                                    <fieldset>
                                        <legend>Oxygen Supplies</legend>
                                        <oxygen-request-supplies-input-group :sizes="{{ $oxygenSizes }}" />

                                    </fieldset>
                                    <fieldset>
                                        <div class="row">
                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                                                </div>
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
{{-- @section('prescript')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection --}}
