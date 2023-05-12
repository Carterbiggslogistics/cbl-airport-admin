<?php

namespace App\Http\Controllers;

use App\Flight;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback($reference)
    {
        try {
            //code...
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/transaction/verify/".$reference,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer sk_test_ff3a8ca11cc7f69d32fd07eb56cde367ac421938",
                    "Cache-Control: no-cache",
                ),
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            $decode = json_decode($response, true);
            $amount = $decode['data']['amount'] / 100;
            $passengerName = $decode['data']['metadata']['custom_fields'][0]['value'];
            $passengerEmail = $decode['data']['metadata']['custom_fields'][1]['value'];
            $passengerPhone = $decode['data']['metadata']['custom_fields'][2]['value'];
            $passportNumber = $decode['data']['metadata']['custom_fields'][3]['value'];
            $airline = $decode['data']['metadata']['custom_fields'][4]['value'];
            $time = $decode['data']['metadata']['custom_fields'][5]['value'];
            $origin = $decode['data']['metadata']['custom_fields'][6]['value'];
            $paymentType = $decode['data']['authorization']['channel'];
            $reference = $decode['data']['reference'];
            try {
                //code...
                $newFlight = new Flight();
                $newFlight->uuid = Uuid::uuid4();
                $newFlight->passengerName = $passengerName;
                $newFlight->passengerEmail = $passengerEmail;
                $newFlight->passengerPhone = $passengerPhone;
                $newFlight->passportNumber = $passportNumber;
                $newFlight->airline = $airline;
                $newFlight->time = $time;
                $newFlight->origin = $origin;
                $newFlight->amount = $amount;
                $newFlight->paymentType = $paymentType;
                $newFlight->reference = $reference;
                $newFlight->save();
                return redirect('/all-flights')->with('success', 'Flight Successful!');
            } catch (\Throwable $th) {
                throw $th;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
