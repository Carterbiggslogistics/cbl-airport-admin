@extends('layouts.page')
@section('content')
    <div class="main-content">
        <section class="section">
            <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">
                    <h4 class="page-title m-b-0">Enter passenger information</h4>
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
                                    <a href="/download-flight-info-template" class="btn btn-success">Download Template for
                                        Upload</a>
                                </div>
                                <br>
                                <br>
                                <form action="/upload-flight" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    @include('partials.user.messages')
                                    <div class="form-group form-float col-12">
                                        <div class="form-line">
                                            <label class="form-label">Upload Passenger Information<span
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
                                <form id="" action="/create-flight" method="POST">
                                    {{ csrf_field() }}
                                    {{-- <script src="https://js.paystack.co/v1/inline.js">
                                    </script> --}}
                                    <h4>Enter Passenger Information</h4>
                                    <fieldset>
                                        <div class="row">
                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">Passenger full name<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="passengerName"
                                                        class="form-control passengerName @error('passengerName') is-invalid @enderror"
                                                        id="passengerName" required>
                                                </div>
                                            </div>
                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">Passenger Email</label>
                                                    <input type="text" name="passengerEmail"
                                                        class="form-control passengerEmail @error('passengerEmail') is-invalid @enderror"
                                                        id="passengerEmail">
                                                </div>
                                            </div>
                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">Passenger number<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="passengerPhone"
                                                        class="form-control passengerPhone @error('passengerPhone') is-invalid @enderror"
                                                        id="passengerPhone" required>
                                                </div>
                                            </div>
                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">Passport number<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="passportNumber"
                                                        class="form-control passportNumber @error('passportNumber') is-invalid @enderror"
                                                        id="passportNumber" required>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <h3>Flight Information</h3>
                                    <fieldset>
                                        <div class="row">
                                          <div class="form-group form-float col-12">
                                              <div class="form-line">
                                                  <label class="form-label">Airport<span class="text-danger">
                                                          *</span></label>
                                                  <select name="airport" class="form-control @error('airport') is-invalid @enderror" id="airport" required>
                                                      <option value="">Select Airport</option>
                                                      <option value="Lagos">Lagos</option>
                                                      <option value="Abuja">Abuja</option>
                                                      <option value="Kano">Kano</option>
                                                      <option value="Enugu">Enugu</option>
                                                      <option value="Port Harcourt">Port Harcourt</option>
                                                  </select>
                                              </div>
                                          </div>
                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">Airline<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="airline"
                                                        class="form-control airline @error('airline') is-invalid @enderror"
                                                        id="airline" required>
                                                </div>
                                            </div>
                                            <div class="form-group form-float col-6">
                                                <label class="form-label">Time of arrival<span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">

                                                    <input type="time" name="time"
                                                        class="form-control time @error('time') is-invalid @enderror"
                                                        id="time" required>
                                                    <div class="input-group-append">
                                                        <select name="moment"
                                                            class="form-control @error('moment') is-invalid @enderror"
                                                            id="moment" required>
                                                            <option value="AM">AM</option>
                                                            <option value="PM">PM</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="form-label">Origin<span class="text-danger"> *</span></label>
                                                <input list="countries" name="origin"
                                                    placeholder="Country the flight is coming from" id="origin"
                                                    class="form-control" required>
                                                <datalist id="countries">
                                                    <option value="Afghanistan" />
                                                    <option value="Albania" />
                                                    <option value="Algeria" />
                                                    <option value="American Samoa" />
                                                    <option value="Andorra" />
                                                    <option value="Angola" />
                                                    <option value="Anguilla" />
                                                    <option value="Antarctica" />
                                                    <option value="Antigua and Barbuda" />
                                                    <option value="Argentina" />
                                                    <option value="Armenia" />
                                                    <option value="Aruba" />
                                                    <option value="Australia" />
                                                    <option value="Austria" />
                                                    <option value="Azerbaijan" />
                                                    <option value="Bahamas" />
                                                    <option value="Bahrain" />
                                                    <option value="Bangladesh" />
                                                    <option value="Barbados" />
                                                    <option value="Belarus" />
                                                    <option value="Belgium" />
                                                    <option value="Belize" />
                                                    <option value="Benin" />
                                                    <option value="Bermuda" />
                                                    <option value="Bhutan" />
                                                    <option value="Bolivia" />
                                                    <option value="Bosnia and Herzegovina" />
                                                    <option value="Botswana" />
                                                    <option value="Bouvet Island" />
                                                    <option value="Brazil" />
                                                    <option value="British Indian Ocean Territory" />
                                                    <option value="Brunei Darussalam" />
                                                    <option value="Bulgaria" />
                                                    <option value="Burkina Faso" />
                                                    <option value="Burundi" />
                                                    <option value="Cambodia" />
                                                    <option value="Cameroon" />
                                                    <option value="Canada" />
                                                    <option value="Cape Verde" />
                                                    <option value="Cayman Islands" />
                                                    <option value="Central African Republic" />
                                                    <option value="Chad" />
                                                    <option value="Chile" />
                                                    <option value="China" />
                                                    <option value="Christmas Island" />
                                                    <option value="Cocos (Keeling) Islands" />
                                                    <option value="Colombia" />
                                                    <option value="Comoros" />
                                                    <option value="Congo" />
                                                    <option value="Congo, The Democratic Republic of The" />
                                                    <option value="Cook Islands" />
                                                    <option value="Costa Rica" />
                                                    <option value="Cote D'ivoire" />
                                                    <option value="Croatia" />
                                                    <option value="Cuba" />
                                                    <option value="Cyprus" />
                                                    <option value="Czech Republic" />
                                                    <option value="Denmark" />
                                                    <option value="Djibouti" />
                                                    <option value="Dominica" />
                                                    <option value="Dominican Republic" />
                                                    <option value="Ecuador" />
                                                    <option value="Egypt" />
                                                    <option value="El Salvador" />
                                                    <option value="Equatorial Guinea" />
                                                    <option value="Eritrea" />
                                                    <option value="Estonia" />
                                                    <option value="Ethiopia" />
                                                    <option value="Falkland Islands (Malvinas)" />
                                                    <option value="Faroe Islands" />
                                                    <option value="Fiji" />
                                                    <option value="Finland" />
                                                    <option value="France" />
                                                    <option value="French Guiana" />
                                                    <option value="French Polynesia" />
                                                    <option value="French Southern Territories" />
                                                    <option value="Gabon" />
                                                    <option value="Gambia" />
                                                    <option value="Georgia" />
                                                    <option value="Germany" />
                                                    <option value="Ghana" />
                                                    <option value="Gibraltar" />
                                                    <option value="Greece" />
                                                    <option value="Greenland" />
                                                    <option value="Grenada" />
                                                    <option value="Guadeloupe" />
                                                    <option value="Guam" />
                                                    <option value="Guatemala" />
                                                    <option value="Guinea" />
                                                    <option value="Guinea-bissau" />
                                                    <option value="Guyana" />
                                                    <option value="Haiti" />
                                                    <option value="Heard Island and Mcdonald Islands" />
                                                    <option value="Holy See (Vatican City State)" />
                                                    <option value="Honduras" />
                                                    <option value="Hong Kong" />
                                                    <option value="Hungary" />
                                                    <option value="Iceland" />
                                                    <option value="India" />
                                                    <option value="Indonesia" />
                                                    <option value="Iran, Islamic Republic of" />
                                                    <option value="Iraq" />
                                                    <option value="Ireland" />
                                                    <option value="Israel" />
                                                    <option value="Italy" />
                                                    <option value="Jamaica" />
                                                    <option value="Japan" />
                                                    <option value="Jordan" />
                                                    <option value="Kazakhstan" />
                                                    <option value="Kenya" />
                                                    <option value="Kiribati" />
                                                    <option value="Korea, Democratic People's Republic of" />
                                                    <option value="Korea, Republic of" />
                                                    <option value="Kuwait" />
                                                    <option value="Kyrgyzstan" />
                                                    <option value="Lao People's Democratic Republic" />
                                                    <option value="Latvia" />
                                                    <option value="Lebanon" />
                                                    <option value="Lesotho" />
                                                    <option value="Liberia" />
                                                    <option value="Libyan Arab Jamahiriya" />
                                                    <option value="Liechtenstein" />
                                                    <option value="Lithuania" />
                                                    <option value="Luxembourg" />
                                                    <option value="Macao" />
                                                    <option value="Macedonia, The Former Yugoslav Republic of" />
                                                    <option value="Madagascar" />
                                                    <option value="Malawi" />
                                                    <option value="Malaysia" />
                                                    <option value="Maldives" />
                                                    <option value="Mali" />
                                                    <option value="Malta" />
                                                    <option value="Marshall Islands" />
                                                    <option value="Martinique" />
                                                    <option value="Mauritania" />
                                                    <option value="Mauritius" />
                                                    <option value="Mayotte" />
                                                    <option value="Mexico" />
                                                    <option value="Micronesia, Federated States of" />
                                                    <option value="Moldova, Republic of" />
                                                    <option value="Monaco" />
                                                    <option value="Mongolia" />
                                                    <option value="Montserrat" />
                                                    <option value="Morocco" />
                                                    <option value="Mozambique" />
                                                    <option value="Myanmar" />
                                                    <option value="Namibia" />
                                                    <option value="Nauru" />
                                                    <option value="Nepal" />
                                                    <option value="Netherlands" />
                                                    <option value="Netherlands Antilles" />
                                                    <option value="New Caledonia" />
                                                    <option value="New Zealand" />
                                                    <option value="Nicaragua" />
                                                    <option value="Niger" />
                                                    <option value="Nigeria" />
                                                    <option value="Niue" />
                                                    <option value="Norfolk Island" />
                                                    <option value="Northern Mariana Islands" />
                                                    <option value="Norway" />
                                                    <option value="Oman" />
                                                    <option value="Pakistan" />
                                                    <option value="Palau" />
                                                    <option value="Palestinian Territory, Occupied" />
                                                    <option value="Panama" />
                                                    <option value="Papua New Guinea" />
                                                    <option value="Paraguay" />
                                                    <option value="Peru" />
                                                    <option value="Philippines" />
                                                    <option value="Pitcairn" />
                                                    <option value="Poland" />
                                                    <option value="Portugal" />
                                                    <option value="Puerto Rico" />
                                                    <option value="Qatar" />
                                                    <option value="Reunion" />
                                                    <option value="Romania" />
                                                    <option value="Russian Federation" />
                                                    <option value="Rwanda" />
                                                    <option value="Saint Helena" />
                                                    <option value="Saint Kitts and Nevis" />
                                                    <option value="Saint Lucia" />
                                                    <option value="Saint Pierre and Miquelon" />
                                                    <option value="Saint Vincent and The Grenadines" />
                                                    <option value="Samoa" />
                                                    <option value="San Marino" />
                                                    <option value="Sao Tome and Principe" />
                                                    <option value="Saudi Arabia" />
                                                    <option value="Senegal" />
                                                    <option value="Serbia and Montenegro" />
                                                    <option value="Seychelles" />
                                                    <option value="Sierra Leone" />
                                                    <option value="Singapore" />
                                                    <option value="Slovakia" />
                                                    <option value="Slovenia" />
                                                    <option value="Solomon Islands" />
                                                    <option value="Somalia" />
                                                    <option value="South Africa" />
                                                    <option value="South Georgia and The South Sandwich Islands" />
                                                    <option value="Spain" />
                                                    <option value="Sri Lanka" />
                                                    <option value="Sudan" />
                                                    <option value="Suriname" />
                                                    <option value="Svalbard and Jan Mayen" />
                                                    <option value="Swaziland" />
                                                    <option value="Sweden" />
                                                    <option value="Switzerland" />
                                                    <option value="Syrian Arab Republic" />
                                                    <option value="Taiwan, Province of China" />
                                                    <option value="Tajikistan" />
                                                    <option value="Tanzania, United Republic of" />
                                                    <option value="Thailand" />
                                                    <option value="Timor-leste" />
                                                    <option value="Togo" />
                                                    <option value="Tokelau" />
                                                    <option value="Tonga" />
                                                    <option value="Trinidad and Tobago" />
                                                    <option value="Tunisia" />
                                                    <option value="Turkey" />
                                                    <option value="Turkmenistan" />
                                                    <option value="Turks and Caicos Islands" />
                                                    <option value="Tuvalu" />
                                                    <option value="Uganda" />
                                                    <option value="Ukraine" />
                                                    <option value="United Arab Emirates" />
                                                    <option value="United Kingdom" />
                                                    <option value="United States" />
                                                    <option value="United States Minor Outlying Islands" />
                                                    <option value="Uruguay" />
                                                    <option value="Uzbekistan" />
                                                    <option value="Vanuatu" />
                                                    <option value="Venezuela" />
                                                    <option value="Viet Nam" />
                                                    <option value="Virgin Islands, British" />
                                                    <option value="Virgin Islands, U.S" />
                                                    <option value="Wallis and Futuna" />
                                                    <option value="Western Sahara" />
                                                    <option value="Yemen" />
                                                    <option value="Zambia" />
                                                    <option value="Zimbabwe" />
                                                </datalist>
                                            </div>
                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">Payment type<span class="text-danger">
                                                            *</span></label>
                                                    <select name="paymentType" class="form-control @error('paymentType') is-invalid @enderror" id="paymentType" required>
                                                        <option value="">Select Payment Type</option>
                                                        <option value="POS">POS</option>
                                                        <option value="CASH">CASH</option>
                                                        <option value="TRANSFER">TRANSFER</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <label class="form-label">Amount<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="amount" class="form-control amount @error('amount') is-invalid @enderror" id="amount" required>
                                                </div>
                                            </div>
                                            <div class="form-group form-float col-6">
                                                <label class="form-label">Date of arrival<span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">

                                                    <input type="date" name="dateOfArrival"
                                                        class="form-control dateOfArrival @error('dateOfArrival') is-invalid @enderror" id="dateOfArrival" required>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <input id="acceptTerms-2" name="acceptTerms"
                                            type="checkbox" required>
                                        <label for="acceptTerms-2">I agree with the Terms and Conditions.</label> --}}
                                        <div class="row">
                                            <div class="form-group form-float col-6">
                                                <div class="form-line">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
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

    <!-- Script Section -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script>
        let amount = 51400;
        var flightForm = document.getElementById('flightForm');
        flightForm.addEventListener('submit', payWithPaystack, false);

        function payWithPaystack(e) {
            e.preventDefault();
            var handler = PaystackPop.setup({
                amount: amount *
                    100, // the amount value is multiplied by 100 to convert to the lowest currency unit
                key: 'pk_test_ad11304f43dd83da7426ebc49e193cd6a033bcd4', // Replace with your public key
                email: document.getElementById('passengerEmail').value,
                currency: 'NGN', // Use GHS for Ghana Cedis or USD for US Dollars
                passengerName: document.getElementById('passengerName').value,
                passengerPhone: document.getElementById('passengerPhone').value,
                ref: '' + Math.floor((Math.random() * 1000000000) +
                    1), // Replace with a reference you generated
                metadata: {
                    custom_fields: [{
                            display_name: "Passenger Name",
                            variable_name: "passengerName",
                            value: document.getElementById('passengerName')
                                .value
                        },
                        {
                            display_name: "Passenger Email",
                            variable_name: "passengerEmail",
                            value: document.getElementById('passengerEmail')
                                .value
                        },
                        {
                            display_name: "Passenger Phone",
                            variable_name: "passengerPhone",
                            value: document.getElementById('passengerPhone')
                                .value
                        },
                        {
                            display_name: "Passport Number",
                            variable_name: "passportNumber",
                            value: document.getElementById('passportNumber')
                                .value
                        },
                        {
                            display_name: "Airline",
                            variable_name: "airline",
                            value: document.getElementById('airline').value
                        },
                        {
                            display_name: "Time of arrival",
                            variable_name: "time",
                            value: document.getElementById('time').value
                        },
                        {
                            display_name: "Origin",
                            variable_name: "origin",
                            value: document.getElementById('origin').value
                        },
                    ]
                },
                callback: function(response) {
                    //this happens after the payment is completed successfully
                    var reference = response.reference;
                    alert('You have successfully made payment!');
                    window.location.href = '/verify-transactions/' +
                        reference
                },
                onClose: function() {
                    alert('Transaction was not completed, window closed.');
                },
            });
            handler.openIframe();
        }

    </script>
@endsection
