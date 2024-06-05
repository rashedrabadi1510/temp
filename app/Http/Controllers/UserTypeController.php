<?php

namespace App\Http\Controllers;

use App\Models\user_type;
use App\Models\userType;
use App\Traits\CustomTrait;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;
use Validator;
class UserTypeController extends Controller
{
    public function index(){
        $data=user_type::get();
        if(Count($data) > 0)
        {
            $message=[
                'status'=>true,
                'data'=>$data
            ];
            return  CustomTrait::SuccessJson($message);
        }else{
            $message=[
                'status'=>false,
                'message'=>'no data to retrive'
            ];
            return CustomTrait::ErrorJson($message);
        }
    }

    // byId
    public function byId(Request $req){
        $data = user_type::where(['id' => $req->id, 'status' => 1])->first()->toArray();
        return  CustomTrait::SuccessJson($data);
        }
    


    public function delete(Request $req)
    {
        $id=$req->id;
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
        $data=user_type::where('id',$id)->delete();
        if($data){
            $message=[
                'status'=>true,
                'message'=>'Sucess Delete'
            ];
            return CustomTrait::SuccessJson($message);
        }else{
            $message=[
                'status'=>false,
                'message'=>'there is find error'
            ];
            return CustomTrait::ErrorJson($message);
        }

    }


    public function update(Request $req){
        $id=$req->id;
        $validator = Validator::make($req->all(), [
            'id' => 'required',
            'title' => 'required',
            'ar_title' => 'required',
            'status' => 'required',
            'position' => 'required',


        ], [
            'id.required' => "this_field_is_required",
            'title.required' => "this_field_is_required",
            'ar_title.required' => "this_field_is_required",
            'status.required' => "this_field_is_required",
            'position.required' => "this_field_is_required",
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

        try {
               $data = user_type::find($req->id);
               $data->update([
                'title'=>$req->title,
                'ar_title'=>$req->ar_title,
                'status'=>$req->status,
                'position'=>$req->position,
               ]);
               $message=[
                   'status'=>true,
                   'message'=>'Sucess update'
               ];
               return CustomTrait::SuccessJson($message);
        } catch (\Throwable $th) {
            $message=[
                'status'=>false,
                'message'=>'Sucess update'
            ];
            return CustomTrait::ErrorJson($message);
        }
    }
    public function insert(Request $req){

        $validator = Validator::make($req->all(), [
            'title' => 'required',
            'ar_title' => 'required',
            'status' => 'required',
            'position' => 'required',
        ], [
            'title.required' => "this_field_is_required",
            'ar_title.required' => "this_field_is_required",
            'status.required' => "this_field_is_required",
            'position.required' => "this_field_is_required",
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

        try {
               $data = new user_type();
               
               $data->title=$req->title;
               $data->ar_title=$req->ar_title;
               $data->status=$req->status;
               $data->position=$req->position;
               $data->save();
               $message=[
                   'status'=>true,
                   'message'=>'Succees added'
               ];
               return CustomTrait::SuccessJson($message);
        } catch (\Throwable $th) {
            $message=[
                'status'=>false,
                'message'=>'failed add'
            ];
            return CustomTrait::ErrorJson($message);
        }
    }
}
