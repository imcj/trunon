<?php
namespace App\Model;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Model\AppNotification;

class AppNotificationTest extends \TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->seed("UserSeeder");
        $this->seed("AppNotificationSeeder");
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = \App\User::with('Profile')->first();
        $notification = AppNotification::create([
            'user_id' => $user->id,
            'subject' => 'hello',
            'content' => 'hello notification.',
            'type' => 'news'
        ]);

        $this->assertEquals('hello notification.', $notification->content);

        $notifications = AppNotification::withUser($user->id);
        $this->assertEquals(15, count($notifications));
    }
}
