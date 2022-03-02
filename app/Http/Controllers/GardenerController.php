<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Gardener;

class GardenerController extends Controller
{
    public function register_gardener(Request $request){

        if($request->country){
            $gardener = Gardener::create([
                'user_id' => $request->user_id,
                'location' => $request->location,
                'country' => $request->country
            ]);
        }else{
            $gardener = Gardener::create([
                'user_id' => $request->user_id,
                'location' => $request->location,
            ]);
        }

        return response()->json([
            "status" => 201,
            "message" => "new gardener added",
            "data" => Gardener::find($gardener->id)
        ]);
    }

    public function remove_gardener($id){
        $gardener = Gardener::find($id);
        $gardener->delete();
        return response()->json([
            "status" => 200,
            "message" => "successfully deleted"
        ]);
    }

    public function retrieve_a_gardener($id){
        $gardener = Gardener::find($id);
        if($gardener == null){
            return response()->json([
                "status" => 404,
                "message" => "gardener not found"
            ]);
        }

        return response()->json([
            "status" => 200,
            "message" => "retrieved successfully",
            "data" => $gardener
        ]);
    }

    public function update_a_gardener(Request $request, $id){
        $gardener = Gardener::find($id);

        if($gardener == null){
            return response()->json([
                "status" => 404,
                "message" => "gardener not found"
            ]);
        }

        $gardener->update($request->all());
        return response()->json([
            "status" => 200,
            "message" => "updated successfully",
            "data" => $gardener
        ]);
    }

    public function list_of_gardeners(){
        $nigeria = [];
        $kenya = [];

        $all_gardeners = Gardener::all();

        foreach($all_gardeners as $gardener){
            if($gardener->country == "Nigeria"){
                array_push($nigeria, ["gardener" => $gardener, "no_of_customers" => count(Gardener::find($gardener->id)->customer)]);
            }else{
                array_push($kenya, ["gardener" => $gardener, "no_of_customers" => count(Gardener::find($gardener->id)->customer)]);
            }
        }

        return response()->json([
            "status" => 200,
            "message" => "successfully retrieved",
            "data" => [
                "Nigeria" => $nigeria,
                "Kenya" => $kenya
            ]
        ]);
    }
}
