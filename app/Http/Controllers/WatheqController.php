<?php

namespace App\Http\Controllers;

use App\Models\watheq;
use App\Traits\CustomTrait;
use Illuminate\Http\Request;
use Validator;
class WatheqController extends Controller
{
    public function getDataById(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'id' => 'required',


        ], [
            'id.required' => "this_field_is_required",

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

            return CustomTrait::ErrorJson($data);
        }
         $id=$req->id;
        $data = watheq::where('user_id', $id)->get();

        if(Count($data)>0)
        {

            return CustomTrait::SuccessJson($data);
        }else
        {

            return CustomTrait::ErrorJson($data);
        }
    }
}
