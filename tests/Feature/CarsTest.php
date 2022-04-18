<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Cars;
use Tests\TestCase;

class CarsTest extends TestCase
{
    public function test_carsReturnsDataInValidFormat()
    {
        $this->json('get', 'api/cars')
        ->assertStatus(200)
        ->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'car_name',                       
                        'user_id',                      
                    ]
                ]
            ]
        );

    }

    public function test_carsDetail()
    {
        $car = Cars::create(
            [
                'car_name' => $this->faker->name,                
            ]
        );

        $this->json('GET', "api/cars/$car->id")
        ->assertStatus(200)
        ->assertExactJson(
            [
                'data' => [
                    "id" => $car->id,
                    "car_name" => $car->car_name,
                    "user_id" => null 
                ]             
               
            ]
                        
       );
    }

}
