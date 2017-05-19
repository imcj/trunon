<?php
namespace App\Model;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Model\Team;

class TeamTest extends \TestCase
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
        $team = Team::default();
        $this->assertNotNull($team);
    }
}
