<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

use App\Vehicle;
use App\CrashableVehicle;
use App\Http\Resources\VehicleResource;


class VehicleController extends Controller
{

    public function postVehicle(Request $request)    
    {
        try{
            /// Let's check for the provided params
            ///$input = $request->all();

            /// Initialize variables            
            /// Validate if it has the input
            $year = $request->has('modelYear') ? urldecode($request->modelYear) : '';
            $make = $request->has('manufacturer') ? urldecode($request->manufacturer) : '';
            $model = $request->has('model') ? urldecode($request->model) : '';                         

            /// Check for withRating query string
            if($request->has('withRating') && $request->withRating === 'true')
                return $this->processCrashRating($year, $make, $model);
            else 
                return $this->processVehicle($year, $make, $model);
            
        } catch (Exception $ex){                        

            /// On general errors we should return a empty response                         
            return response()->json(new Vehicle());            
        }
                
    }

    public function getVehicle(Request $request, $year, $make, $model)
    {        
        try {
            /// Decode variables escaping URL
            $year = urldecode($year);
            $make = urldecode($make);
            $model = urldecode($model);            

            /// Check for withRating query string            
            if($request->has('withRating') && $request->withRating === 'true')                
                return $this->processCrashRating($year,$make,$model);
            else 
                return $this->processVehicle($year,$make,$model);        

        } catch (Exception $ex){
            /// On general errors we should return a empty response                         
            return response()->json(new Vehicle());            
        }
        
    }

    private function processCrashRating($year, $make, $model)
    {
        try {
            //$vehicle = CrashableVehicle::get($year, $make, $model);
            $vehicle = new CrashableVehicle();

            if($vehicle->get($year, $make, $model))
                /// We were able to process all records
                /// We can now return vehicle
                /// Even if there is no results $vehicle is an empty Vehicle object
                return response()->json($vehicle);
            else                             
                /// We did not get any data
                return response()->json(new CrashableVehicle());

        } catch (Exception $ex){            

            /// On general errors we should return a empty response                         
            return response()->json(new Vehicle());            
        }
    }

    private function processVehicle($year, $make, $model)
    {                
        try {
                //$vehicle = Vehicle::get($year, $make, $model);
                $vehicle = new Vehicle();
                    
                /// Get data from API
                if($vehicle->get($year, $make, $model))
                    /// We were able to process all records
                    /// We can now return vehicle
                    /// Even if there is no results $vehicle is an empty Vehicle object
                    return response()->json($vehicle);                 
                else                                                                                           
                    /// We did not get any data
                    return response()->json(new Vehicle());            

        } catch (Exception $ex){            
        
            /// On general errors we should return a empty response                         
            return response()->json(new Vehicle());            
        }        
    }    
}
