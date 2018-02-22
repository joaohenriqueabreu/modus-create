<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $description, $id, $rating;

    function __construct($description, $id)
    {
        $this->description = $description;
        $this->id = $id;
    }

    
  public function __get($property) {
    if (property_exists($this, $property)) {
      return $this->$property;
    }
  }

  public function __set($property, $value) {
    if (property_exists($this, $property)) {
      $this->$property = $value;
    }

    return $this;
  }

    function toArray() 
    {
        if(isset($this->rating)){
            return [
                'CrashRating' => $this->rating,
                'Description' => $this->description,
                'VehicleId' => $this->id,            
            ];
        } else {
            return [
                'Description' => $this->description,
                'VehicleId' => $this->id,            
            ];
        }        
    }
}
