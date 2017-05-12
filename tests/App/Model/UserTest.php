<?php
namespace App\Model;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class UserTest extends \TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->seed("DatabaseSeeder");
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDefault()
    {
        $user = User::default();
        $this->assertNotNull($user);
    }
}
