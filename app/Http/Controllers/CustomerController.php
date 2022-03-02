<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Gardener;

class CustomerController extends Controller
{
    public function create_a_customer(Request $request){

        if($request->country){
            $customer = Customer::create([
                'user_id' => $request->user_id,
                'location' => $request->location,
                'country' => $request->country
            ]);
        }else{
            $customer = Customer::create([
                'user_id' => $request->user_id,
                'location' => $request->location,
            ]);
        }

        $created_cust = Customer::find($customer->id);
        $gardeners = Gardener::where(["country" => $created_cust->country, "location" => $created_cust->location])->get();
        
        if($gardeners != null){
            $gardener_list = [];
            
            foreach($gardeners as $gardener){
                array_push($gardener_list, $gardener->id);
            }

            $allocated_gardener_index = array_rand($gardener_list);

            $customer_gardener = $created_cust->update(["gardener_id" => $gardener_list[$allocated_gardener_index]]);
        }

        return response()->json([
            "status" => 200,
            "message" => "customer created successfully",
            "data" => $created_cust
        ]);
    }

    public function remove_customer($id){
        $customer = Customer::find($id);
        $customer->delete();
        return response()->json([
            "status" => 200,
            "message" => "successfully deleted"
        ]);
    }

    public function retrieve_a_customer($id){
        $customer = Customer::find($id);
        if($customer == null){
            return response()->json([
                "status" => 404,
                "message" => "customer not found"
            ]);
        }

        return response()->json([
            "status" => 200,
            "message" => "retrieved successfully",
            "data" => [
                "customer" => $customer,
                "gardener" => $customer->garderner
            ]
        ]);
    }

    public function update_a_customer(Request $request, $id){
        $customer = Customer::find($id);

        if($customer == null){
            return response()->json([
                "status" => 404,
                "message" => "customer not found"
            ]);
        }

        $customer->update($request->all());

        return response()->json([
            "status" => 200,
            "message" => "updated successfully",
            "data" => $customer
        ]);
    }

    public function list_of_customers(){

        return response()->json([
            "status" => 200,
            "message" => "successfully retrieved",
            "data" => Customer::all()
        ]);
    }

    public function list_of_locations(){
        $nigeria = [];
        $kenya = [];

        $customers = Customer::all();

        foreach($customers as $customer){
            if($customer->country == "Nigeria"){
                array_push($nigeria, $customer);
            }else{
                array_push($kenya, $customer);
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
