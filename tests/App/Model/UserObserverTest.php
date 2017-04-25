<?php
namespace App\Model;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Model\Observer\UserObserver;

class UserObserverTest extends \TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->seed("PermissionSeeder");

        Team::create([
            "name" => "Default"
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $user = User::create([
            "name" => "test",
            "password" => "123",
            "email" => "test@example.com"
        ]);

        $user = User::find($user->id);
        foreach ($user->team as $team) {
            $this->assertTrue($team->pivot->role != null);
        }
    }
}
