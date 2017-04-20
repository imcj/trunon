<?php
namespace App\Http\ViewComposer;

use Illuminate\View\View;
use App\Model\AppNotification;
use Illuminate\Http\Request;

class UnreadsViewComposer
{
    public function compose(View $view)
    {
        $unreads = 0;
        $user = \Auth::user();
        if ($user) {
            $unreads = AppNotification::where('user_id', $user->id)
                ->count();
        }

        $view->with('unreads', $unreads);
        $view->with('hasUnreads', $unreads > 0);
    }
}