<?php
namespace App\Model;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Model\Profile;

class ProfileTest extends \TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        User::create([
            "name" => "CJ",
            "email" => 'i@imcj.me',
            'password' => bcrypt('123')
        ]);

        $user = \App\User::with('Profile')->first();
        $this->assertEquals("https://www.gravatar.com/avatar/d5d0e732e1f63c9521604162b3d0ae47?s=80",
            $user->profile->avatar());
    }
}
