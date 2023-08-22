<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;


class UserAuthenticationTest extends TestCase
{


    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */



     protected function setUp(): void
     {
         parent::setUp();

         $user = User::factory()->create();
         Passport::actingAs($user);


     }




//
public function testUserRegistration(){
//create user
$user = User::factory()->create();
$this->assertJson($user);
// return dd($user->name);

}


public function testUserCanLogin(){
$user=User::factory()->create();
$pass=Passport::actingAs($user);
$this->assertJson($pass);


}






}
