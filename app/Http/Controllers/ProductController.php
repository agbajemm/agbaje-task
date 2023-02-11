<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $data_path;
    public function __construct()
    {
        $this->data_path = public_path("/products.json"); // The location of the json file holding the data
    }

    public function index(){
        return view('show');
    }

    public function getProducts(){

        // Check if the json file exists
        if (!file_exists($this->data_path)){
           // returns empty array
            return [];
        }else{
            $products = json_decode(file_get_contents($this->data_path));
        }
        return view('Productlist', compact('products'));
    }

    public function save(Request $request){
        if ($request->ajax()){
            // Create New Product

             $new_product = array(
                 "id"       => rand(100000, 900000000),
                "name"      => $request->input('name'),
                 "quantity" => $request->input('quantity'),
                 "price"    => $request->input('price'),
                 "created_at"   => Carbon::now(),
                 "total_value" => $request->input('quantity') * $request->input('price')
             );

             // Check if the json file exists
            if (file_exists($this->data_path) == 00){

                // If this is a new record, we are creating an array inside the json file to hold our message
                $first_record = $new_product;

                $data_to_save = $first_record;

            }else{
                $old_records = json_decode(file_get_contents($this->data_path));
                if ($old_records == null){
                    // array_push will break the app if json_decode returns null.
                    $old_records = [];
                }
                // Now we can add to the array of products
                array_push($old_records, $new_product);
                $data_to_save = $old_records;

            }

            // Let us store the json file
            if (!file_put_contents($this->data_path, json_encode($data_to_save, JSON_PRETTY_PRINT), LOCK_EX)){
                $error = "Error storing data";
            }else{
                return $data_to_save;
            }
        }
    }

    public function delete(Request $request){
        if ($request->ajax()){
            // Check if the json file exists
            $old_records = json_decode(file_get_contents($this->data_path));
            foreach ($old_records as $key => $record) {
                if ($record->id == $request->id){
                    unset($old_records[$key]);
                }
            }

            $data_to_save = $old_records;

            // Let us store the new json file
            if (!file_put_contents($this->data_path, json_encode($data_to_save, JSON_PRETTY_PRINT), LOCK_EX)){
                $error = "Error deleting data";
            }

        }
    }

    public function update(Request $request){
        if ($request->ajax()){

            $new_product = array(
                "id"       => intval($request->id),
                "name"      => $request->input('name'),
                "quantity" => $request->input('quantity'),
                "price"    => $request->input('price'),
                "total_value" => $request->input('quantity') * $request->input('price'),
                "updated_at"   => Carbon::now()
            );

            // Check if the json file exists
            $old_records = json_decode(file_get_contents($this->data_path));
            if ($old_records == null){
                $old_records = [];
            }

            foreach ($old_records as $record){
                if ($record->id == $request->id){
                    $record->name  = $request->input('name');
                    $record->quantity = $request->input('quantity');
                    $record->price   = $request->input('price');
                    $record->total_value = $request->input('quantity') * $request->input('price');
                }
            }

            $data_to_save = $old_records;

            // Let us store the json file
            if (!file_put_contents($this->data_path, json_encode($data_to_save, JSON_PRETTY_PRINT), LOCK_EX)){
                $error = "Error updating data";
            }else{
                return $data_to_save;
            }

            return response($new_product);
        }
    }
}
