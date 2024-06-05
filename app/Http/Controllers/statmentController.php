<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
class statmentController extends Controller
{
    protected $array = [];
    public $date_now;
    public $token;
    public function accessToken()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.anb.com.sa/v1/b2b-auth/oauth/accesstoken',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials&client_id=RtvXulyt7sUFalluiEEGCqzFWTAdEO0L&client_secret=ImnkzuqpAwu01Uct',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($response);

        $this->token = $res->access_token;
        return $this->token;
    }

    public function bankBlance(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'account' => 'required',
   
            
        ], [
            'account.required' => "this_field_is_required",

        ]);

        if ($validator->fails()) {
            $messages = $validator->messages()->toArray();

            $validationErrorMessages = [];

            foreach ($messages as $key => $value) {
                $validationErrorMessages[] = [
                    'field'     => $key,
                    'message'   => $value[0]
                ];
            }
            $data = [
                'message' => $validationErrorMessages
            ];

            return response()->json([
                'status'=>'failed',
                'response'=>$data
            ],401);
        }

        $this->accessToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.anb.com.sa/v1/report/account/balance?accountNumber=$req->account",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->token . ''
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }


    public function statment(Request $req)
    {

        
        $validator = Validator::make($req->all(), [
            'account' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            
        ], [
            'account.required' => "this_field_is_required",
            'start_date.required' => "this_field_is_required",
            'end_date.required' => "this_field_is_required",
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages()->toArray();

            $validationErrorMessages = [];

            foreach ($messages as $key => $value) {
                $validationErrorMessages[] = [
                    'field'     => $key,
                    'message'   => $value[0]
                ];
            }
            $data = [
                'message' => $validationErrorMessages
            ];

            return response()->json([
                'status'=>'failed',
                'response'=>$data
            ],201);
        }

        $this->accessToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.anb.com.sa/v1/report/account/statement?accountNumber=$req->account&fromDate=$req->start_date&toDate=$req->end_date&type=JSON",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$this->token.'',
                'Cookie: TS01a57a22=01e0c4dd0d362d790848f524b446cb84995040ff59895708c6613a5f9d1bcc36d90b2ebba62f05829839f20570790fea2012486cc0'
            ),
        ));
        $response = curl_exec($curl);
 
        curl_close($curl);
        $res = json_decode($response);
        return response()->json([
            'status'=>'success',
            'response'=>$res
        ],200);

    }
}
