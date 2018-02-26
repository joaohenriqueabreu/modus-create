<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Exception;

use App\Vehicle;
use App\Result;

class CrashableVehicle extends Vehicle
{
    
    function toArray() 
    {
        return [            
            'Count' => $this->count,
            'Results' => $this->results,
        ];
    }

    public function get($year = '', $make = '', $model = '')
    {
        try{
            /// Call parent to fill Vehicle variables
            if(parent::get($year, $make, $model)){

                /// Now we will iterate over vehicle ids to get the crash rating
                foreach($this->results as $result){                    
                    $result->rating = $this->getCrashRating($result->id);                    
                }

            } else throw new Exception("No API data or error");

            return true;

        } catch (Exception $ex){            

            /// Oh no, there was something wrong. Abort!
            return false;
        }    
    }

    public function getCrashRating($id)
    {
        
        /// First grab the URL        
        $url = self::nhtsaCrashUrl($id);                

        /// Get the API data
        $json = $this->getAPIData($url);

        /// Verify if found something
        if(isset($json) && $json->Count > 0){
            
            /// Yey we did!

            $results = $json->Results;
            
            /// Initialize with the out case
            $rating = 'Not Rated';

            /// It should only be 1 result
            for($i=0; $i < count($results); $i++){
                $rating = $results[$i]->OverallRating;
            }

            return $rating;

        } else return null; /// If it is not found, do not set it, cause toArray will not print it out
            
    }

    public static function nhtsaCrashUrl($id)
    {
        /// Format accordingly from year, make and model provided
        return config('local.nhtsa_base_url')
            . '/VehicleId/' . ($id ? $id : '')             
            . '?format=json';        
    }

    public static function validateCrashRating($rating)
    {
        return in_array($rating, ['Not Rated', '0', '1', '2', '3', '4', '5']);
    }    
}
