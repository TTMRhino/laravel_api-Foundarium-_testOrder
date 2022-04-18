<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Cars;
use Tests\TestCase;

class UserTest extends TestCase
{
       
    public function test_userReturnsDataInValidFormat() 
    {
        $this->json('get', 'api/user')
        ->assertStatus(200)
        ->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'name',                       
                        'email',
                        'email_verified_at',
                        'updated_at',
                        'created_at',
                       
                    ]
                ]
            ]
        );
    }

    public function test_userDetail_json()
    {
        $this->json('GET', 'api/user/1')
            ->assertJson(fn (AssertableJson $json) =>
                $json->missing('password')
                ->etc()
            );
    }

    public function test_userGetCarSuccessfully()
    {
        $user = User::create(
            [
                'name' => $this->faker->name,              
                'email' =>$this->faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]
        );

        $car = Cars::create(
            [
                'car_name' => $this->faker->name, 
            ]
        );

        $this->json('get', "api/user/$user->id/getcar/$car->car_name")
        ->assertStatus(200)
        ->assertJsonStructure([
            'message'
         ])
         ->assertExactJson(
             [
                'message' => "Пользователь ". $user->name ." получил машину ".$car->car_name
             ]
                         
        );
        
    }

    public function test_userGetCarFaild()
    {
        $user = User::create(
            [
                'name' => $this->faker->name,              
                'email' =>$this->faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]
        );

        $car = Cars::create(
            [
                'car_name' => $this->faker->name,
                'user_id' => $user->id, 
            ]
        );

        $this->json('get', "api/user/$user->id/getcar/$car->car_name")
        ->assertStatus(200)
        ->assertJsonStructure([
            'error'
         ])
         ->assertExactJson(
             [
                'error' => "Данная машина занята!"
             ]
                         
        );
    }

    public function test_userNotFound() 
    {
        $this->json('get', "api/user/000/getcar/xxx")
        ->assertStatus(404)
        ->assertJsonStructure([
            'message'
         ])
         ->assertExactJson(
            [
               'message' => "Not Found!"
            ]
                        
       );
    }

    public function test_userCarNotFound() 
    {
        $user = User::create(
            [
                'name' => $this->faker->name,              
                'email' =>$this->faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]
        );

        $this->json('get', "api/user/$user->id/getcar/fakeCar")
        ->assertStatus(404)
        ->assertJsonStructure([
            'message'
         ])
         ->assertExactJson(
            [
               'message' => "Not Found!"
            ]
                        
       );
    }

   
}
