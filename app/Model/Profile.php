<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Profile extends Model
{
    public function avatar()
    {
        $hash = md5($this->user->email);
        return "https://www.gravatar.com/avatar/${hash}?s=80";
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
