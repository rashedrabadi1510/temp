<?php

namespace App\Http\Controllers;
use DB;
use App\Traits\CustomTrait;
use Illuminate\Http\Request;
use App\Models\Page;
use Exception;
use Illuminate\Support\Facades\Log;

class PageConttroller extends Controller
{




    
    public function insert(Request $req)
    {


        // try {

            $page = new Page;
            $page->title = $req->title;
            $page->ar_title = $req->ar_title;
            $page->description = $req->description;
            $page->ar_description = $req->ar_description;
            $page->status = $req->status;
            $page->position = $req->position;
            $page->image = $req->image;
            $page->save();

        // } catch (Exception $e) {

        //     Log::channel('product')->info($e->getMessage());

            // $data = [
            //     'message' => "something went wronge"
            // ];

            // return  CustomTrait::ErrorJson($data);
        // }


   


        $data = [
            'message' => "Page Added"
        ];

        return  CustomTrait::SuccessJson($data);
    }





    public function GetById($id)
    {

        $product = Page::select('id', 'title', 'ar_title','description','ar_description','image',
        'status','position')->where(['id' => $id, 'status' => 1])->orderBy('position', 'ASC')->first()->toArray();


        return  CustomTrait::SuccessJson($product);
    }
    public function getPagesParameters(){

        $product = DB::table('pages_parameters')->get();


        return  CustomTrait::SuccessJson($product);
    }




    public function list()
    {


        $data = Page::select('id', 'title','ar_title','description','ar_description',
        'status','position')->where('status', 1)->orderBy('position', 'ASC')->get()->toArray();


        return  CustomTrait::SuccessJson($data);
    }
    public function add_pagesparam(Request $req){
        if(empty($req->id)){
            
        $data=array('keyword'=>$req->keyword,"replace_with"=>$req->replace_keyword);
        DB::table('pages_parameters')->insert($data);
        }else {
         //   echo $req->id;
            $data=array('keyword'=>$req->keyword,"replace_with"=>$req->replace_keyword);
            DB::table('pages_parameters')->where('id',(int)$req->id)->update($data);

        }


        $data = [
            'message' => "Page Updated"
        ];


        return  CustomTrait::SuccessJson($data);
    }
    
    public function deleteparams(Request $req){
        if(!empty($req->id)){
        
        DB::table('pages_parameters')->where("id",$req->id)->delete();
        }

        $data = [
            'message' => "Params deleted"
        ];


        return  CustomTrait::SuccessJson($data);
    }
    public function update(Request $req)
    {

    

        // try {

            $page = Page::find($req->id);
            $page->title = $req->title;
            $page->ar_title = $req->ar_title;
            $page->description = $req->description;
            $page->ar_description = $req->ar_description;
            $page->status = $req->status;
            $page->position = $req->position;
            $page->image = $req->image;
            $page->save();


        // } catch (Exception $e) {

        //     Log::channel('product')->info($e->getMessage());

        //     $data = [
        //         'message' => "something went wronge"
        //     ];
        //     return  CustomTrait::ErrorJson($data);
        // }

 
        $data = [
            'message' => "Page Updated"
        ];


        return  CustomTrait::SuccessJson($data);
    }







    // function delete(Request $req)
    // {


    //     $sql = "SELECT * FROM product_details WHERE product_id = $req->id";
    //     $info = DB::select(DB::raw($sql));


    //     if (count($info)) {


    //         $data = [
    //             'message' => "This is refered in other table"
    //         ];
    //         return  CustomTrait::ErrorJson($data);
    //     } else {


    //         try {

    //             $evo = Product::find($req->id);
    //             $evo->status = 3;
    //             $evo->save();
    //         } catch (Exception $e) {

    //             Log::channel('product')->info($e->getMessage());

    //             $data = [
    //                 'message' => "something went wronge"
    //             ];
    //             return  CustomTrait::ErrorJson($data);
    //         }

    //         $data = [
    //             'message' => 'Product Attribute Deleted'
    //         ];

    //         return  CustomTrait::SuccessJson($data);
    //     }
    // }






}
