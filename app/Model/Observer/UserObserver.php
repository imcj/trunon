<?php
namespace App\Model\Observer;

use App\User;
use App\Model\Profile;
use App\Model\AppNotification;

class UserObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(User $user)
    {

        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->save();

        AppNotification::create([
            'user_id' => $user->id,
            'type' => 'default',
            'subject' => '欢迎',
            'content' => '有任何问题可以在线咨询。'
        ]);
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        //
    }
}
