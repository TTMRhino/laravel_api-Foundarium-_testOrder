<?php
    
namespace Tests\Controllers;
    
use Illuminate\Http\Response;
use Tests\TestCase;
    
class UserControllerTests extends TestCase {
    
    public function testIndexReturnsDataInValidFormat() {
    
    $this->json('get', 'api/user')
         ->assertStatus(Response::HTTP_OK)
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
    
}