<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Exception;

use App\Result;

class Vehicle extends Model
{     
    protected $count, $results;        

    function __construct()
    {        
        $this->count = 0;
        $this->results = [];    
    }

    public function add($description, $id)
    {        
        //array_push($this->results, ['Description' => $description, 'VehicleId' => $id]);
        array_push($this->results, new Result($description, $id));
        $this->count++;
    }    

    public function get($year = '', $make = '', $model = '')
    {
        try{
            
            /// First grab the URL
            $url = self::nhtsaUrl($year, $make, $model);   
            
            $json = $this->getAPIData($url);                        

            /// First we check the amount of results returned
            if(isset($json) && $json->Count > 0){
                /// Ok, we have data! 

                /// Lets cast results only for a matter of lazyness
                $results = $json->Results;

                /// Loop thru all received results
                for($i=0; $i < count($results); $i++){

                    /// The object inside results is of stdClass so we can use its attributes
                    $this->add($results[$i]->VehicleDescription, $results[$i]->VehicleId);

                    /// Any errors, i.e. could not access one of the properties should throw an error
                }                    
            } else throw new Exception("No result or error while fetching API data");                  

            return true;

        } catch (Exception $ex){
            
            return false;
        }        
    }   

    protected function getAPIData($url)
    {            
        $httpClient = new Client();

        /// We are going to call NHTSA API using guzzle            
        $response = $httpClient->get($url,['verify' => false]);                       

        /// Try to decode response
        /// We need to transform NHSTA to string in the process so that we can decode correctly
        /// json_decode expects to be string and guzzle gives us
        $json = json_decode($response->getBody());                  

        /// Verify if json
        if (json_last_error() === JSON_ERROR_NONE) {

            return $json;                                                                 

        } else return null;       
    }

    function toArray() 
    {
        return [
            'Count' => $this->count,
            'Results' => $this->results,
        ];
    }

    public static function nhtsaUrl($year, $make, $model)
    {
        /// Format accordingly from year, make and model provided
        return config('local.nhtsa_base_url')
            . '/modelyear/' . ($year ? $year : '') 
            . '/make/' . ($make ? $make : '')
            .'/model/' . ($model ? $model : '')
            . '?format=json';        
    }
}
