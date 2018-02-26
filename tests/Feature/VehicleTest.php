<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleTest extends TestCase
{
    protected $vehicleWithData = ['modelYear' => 2015, 'manufacturer' => 'Audi', 'model' => 'A3'];
    protected $vehicleWithoutData = ['modelYear' => 2015, 'manufacturer' => 'Ford', 'model' => 'Crown Victoria'];    
    protected $vehicleWithInvalidData = ['year' => 2017, 'team' => 'Barcelona', 'player' => 'Messi'];
    protected $vehicleLackingData = ['modelYear' => 2015, 'manufacturer' => 'Audi'];

    protected $vehicleWithoutDataResponse = ['Count' => 0, 'Results' => []];
    protected $vehicleWithDataResponse = ['Count' => 4, 
        'Results' => [
                [
                    'Description' => '2015 Audi A3 4 DR AWD', 
                    'VehicleId' => 9403,
                ],
                [
                    'Description' => '2015 Audi A3 4 DR FWD', 
                    'VehicleId' => 9408,
                ],
                [
                    'Description' => '2015 Audi A3 C AWD', 
                    'VehicleId' => 9405,
                ],
                [
                    'Description' => '2015 Audi A3 C FWD', 
                    'VehicleId' => 9406,
                ],
            ]
        ];
    protected $crashableWithDataResponse = ['Count' => 4, 
        'Results' => [
                [
                    'CrashRating' => '5',
                    'Description' => '2015 Audi A3 4 DR AWD', 
                    'VehicleId' => 9403,
                ],
                [
                    'CrashRating' => '5',
                    'Description' => '2015 Audi A3 4 DR FWD', 
                    'VehicleId' => 9408,
                ],
                [
                    'CrashRating' => 'Not Rated',
                    'Description' => '2015 Audi A3 C AWD', 
                    'VehicleId' => 9405,
                ],
                [
                    'CrashRating' => 'Not Rated',
                    'Description' => '2015 Audi A3 C FWD', 
                    'VehicleId' => 9406,
                ],
            ]
        ];                    
      

    /* ************************************

            RESPONSE WITH DATA EXPECTED 

    ************************************** */    
    public function getVehicle($sent, $status, $expected, $rating = null)
    {                
        $url = $sent . (isset($rating) ? '?withRating=' . $rating : '');        
        
        $response = $this->get($url);

        $response->assertStatus($status)
            ->assertJson($expected);                                                
    }

    public function postVehicle($data, $status, $expected, $rating = null)
    {
        $url = '/vehicles/' . (isset($rating) ? '?withRating=' . $rating : '');

        $response = $this->post($url, $data);

        $response->assertStatus($status)
            ->assertJson($expected);  
    }

        
    public function testGetVehicleWithData()
    {
        $this->getVehicle($this->urlWithData(), 200, $this->vehicleWithDataResponse);
    }

    public function testPostVehicleWithData()
    {
        $this->postVehicle($this->vehicleWithData, 200, $this->vehicleWithDataResponse);
    }

    public function testGetCrashableVehicleWithData()
    {
        $this->getVehicle($this->urlWithData(), 200, $this->crashableWithDataResponse, 'true');
    }

    public function testPostCrashableVehicleWithData()
    {
        $this->postVehicle($this->vehicleWithData, 200, $this->crashableWithDataResponse, 'true');
    }

    public function testGetFalseCrashableVehicleWithData()
    {
        $this->getVehicle($this->urlWithData(), 200, $this->vehicleWithDataResponse, 'false');
    }

    public function testPostFalseCrashableVehicleWithData()
    {
        $this->postVehicle($this->vehicleWithData, 200, $this->vehicleWithDataResponse, 'false');
    }

    public function testGetCrazyCrashableVehicleWithData()
    {
        $this->getVehicle($this->urlWithData(), 200, $this->vehicleWithDataResponse, 'bananas');
    }

    public function testPostCrazyCrashableVehicleWithData()
    {
        $this->postVehicle($this->vehicleWithData, 200, $this->vehicleWithDataResponse, 'bananas');
    }


    /* ************************************

            EMPTY RESPONSE EXPECTED 

    ************************************** */
    public function testGetVehicleWithoutData()
    {
        $this->getVehicle($this->urlWithoutData(), 200, $this->vehicleWithoutDataResponse);
    }

    public function testPostVehicleWithoutData()
    {
        $this->postVehicle($this->vehicleWithoutData, 200, $this->vehicleWithoutDataResponse);
    }

    public function testGetCrashableVehicleWithoutData()
    {
        $this->getVehicle($this->urlWithoutData(), 200, $this->vehicleWithoutDataResponse, 'true');
    }

    public function testPostCrashableVehicleWithoutData()
    {
        $this->postVehicle($this->vehicleWithoutData, 200, $this->vehicleWithoutDataResponse, 'true');
    }

    public function testGetFalseCrashableVehicleWithoutData()
    {
        $this->getVehicle($this->urlWithoutData(), 200, $this->vehicleWithoutDataResponse, 'false');
    }

    public function testPostFalseCrashableVehicleWithoutData()
    {
        $this->postVehicle($this->vehicleWithoutData, 200, $this->vehicleWithoutDataResponse, 'false');
    }

    public function testGetCrazyCrashableVehicleWithoutData()
    {
        $this->getVehicle($this->urlWithoutData(), 200, $this->vehicleWithoutDataResponse, 'bananas');
    }

    public function testPostCrazyCrashableVehicleWithoutData()
    {
        $this->postVehicle($this->vehicleWithoutData, 200, $this->vehicleWithoutDataResponse, 'bananas');
    }


    /* ************************************
            INVALID DATA
            EMPTY RESPONSE EXPECTED 

    ************************************** */
    public function testGetVehicleWithInvalidData()
    {
        $this->getVehicle($this->urlWithInvalidData(), 200, $this->vehicleWithoutDataResponse);
    }

    public function testPostVehicleWithInvalidData()
    {
        $this->postVehicle($this->vehicleWithInvalidData, 200, $this->vehicleWithoutDataResponse);
    }

    public function testGetCrashableVehicleWithInvalidData()
    {
        $this->getVehicle($this->urlWithInvalidData(), 200, $this->vehicleWithoutDataResponse, 'true');
    }

    public function testPostCrashableVehicleWithInvalidData()
    {
        $this->postVehicle($this->vehicleWithInvalidData, 200, $this->vehicleWithoutDataResponse, 'true');
    }

    public function testGetFalseCrashableVehicleWithInvalidData()
    {
        $this->getVehicle($this->urlWithInvalidData(), 200, $this->vehicleWithoutDataResponse, 'false');
    }

    public function testPostFalseCrashableVehicleWithInvalidData()
    {
        $this->postVehicle($this->vehicleWithInvalidData, 200, $this->vehicleWithoutDataResponse, 'false');
    }

    public function testGetCrazyCrashableVehicleWithInvalidData()
    {
        $this->getVehicle($this->urlWithInvalidData(), 200, $this->vehicleWithoutDataResponse, 'bananas');
    }

    public function testPostCrazyCrashableVehicleWithInvalidData()
    {
        $this->postVehicle($this->vehicleWithInvalidData, 200, $this->vehicleWithoutDataResponse, 'bananas');
    }

    /* ************************************

            Extra testing

    ************************************** */
    public function testGetVehicleLackingData()
    {                        
        $response = $this->get($this->urlLackingData());
        $response->assertStatus(404);
    }

    public function testGetCrashableVehicleLackingData()
    {                        
        $response = $this->get($this->urlLackingData() . '?withRating=true');
        $response->assertStatus(404);
    }

    public function testPostVehicleLackingData()
    {                        
        $this->postVehicle($this->vehicleLackingData, 200, $this->vehicleWithoutDataResponse);
    }

    
    /* URL Builders to shorten code */ 
    public function urlWithData()
    {
        return '/vehicles/' . $this->vehicleWithData['modelYear'] . '/' . $this->vehicleWithData['manufacturer'] . '/' . $this->vehicleWithData['model']; 
    }

    public function urlWithoutData()
    {
        return '/vehicles/' . $this->vehicleWithoutData['modelYear'] . '/' . $this->vehicleWithoutData['manufacturer'] . '/' . $this->vehicleWithoutData['model']; 
    }

    public function urlWithInvalidData()
    {
        return '/vehicles/' . $this->vehicleWithInvalidData['year'] . '/' . $this->vehicleWithInvalidData['team'] . '/' . $this->vehicleWithInvalidData['player']; 
    }

    public function urlLackingData()
    {
        return '/vehicles/' . $this->vehicleWithData['modelYear'] . '/' . $this->vehicleWithData['manufacturer']; 
    }
}
