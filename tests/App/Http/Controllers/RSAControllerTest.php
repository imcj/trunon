<?php

namespace App\Http\Controllers;

use App\Model\RSA;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RSAControllerTest extends \TestCase
{
    private $user;

    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create([
//            'id' => 1,
            'email' => rand() . "@imcj.me",
            'name' => rand(),
        ]);
    }

    /**
     *
     * @return void
     */
    public function testCreate()
    {
        $response = $this->actingAs($this->user)
            ->get('/rsa/create');
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $response = $this->actingAs($this->user)
            ->post('/rsa', array(
                'private_key' => 'test private key',
                'public_key' => null,
                'title' => 'test'
        ));

        $rsa = RSA::where("user_id", $this->user->id)->first();

        $response->assertRedirect('/rsa');
    }

    public function testUpdate()
    {

    }
}
