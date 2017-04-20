<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Model\AppNotification;

class AppNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::with('Profile')->first();
        for ($i = 0; $i < 100; $i++) {
            $notification = AppNotification::create([
                'user_id' => $user->id,
                'subject' => 'hello',
                'content' => 'hello notification.',
                'type' => 'news'
            ]);
        }
    }
}
