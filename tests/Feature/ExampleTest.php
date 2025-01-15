<?php
namespace Tests\Feature;

use App\Models\User;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Masuresh124\AuthIdle\Http\Middleware\AuthIdleMiddleware;
use Tests\TestCase;

class ExampleTest extends TestCase
{

    public function test_the_middleware_inactivity()
    {
        $user =  User::factory()->create();

        session()->put('authIdleLastActivityTime',time()-61);
       $response=  $this->actingAs($user)
        ->get('auth-idle');

         $this->assertEquals('http://localhost/login' , $response->getTargetUrl());
    }

    public function test_the_middleware_activity()
    {
        $user =  User::factory()->create();

         session()->put('authIdleLastActivityTime',time());
         $response=  $this->actingAs($user)
        ->get('auth-idle');

        $response->assertStatus(200);

    }

}
