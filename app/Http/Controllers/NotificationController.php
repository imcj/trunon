<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\AppNotification;

class NotificationController extends Controller
{
/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $assembler = new \App\ViewModel\Assembler\NotificationViewModelAssembler();
        $notifications = AppNotification::withUser($user->id);

        return view('notification/index', [
            "notifications" => $assembler->toViewModelList($notifications),
            "paginator" => (string)$notifications->links()
        ]);
    }

    public function show(Request $request, $id)
    {
        $notification = AppNotification::find($id);
        
        if ($notification->unread) {
            $notification->unread = false;
            $notification->save();
        }
        return view('notification/show', [
            'notification' => $notification
        ]);
    }
}
