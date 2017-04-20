<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Model\AppNotification;

class AppNotificationDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::all() as $user) {
            // for ($i = 0; $i < 100; $i++) {
                AppNotification::create([
                    'user_id' => $user->id,
                    'subject' => 'hello',
                    'content' => '你好，这是第一条消息通知.',
                    'type' => 'default'
                ]);
            // }
        }
    }
}
