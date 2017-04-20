<?php
namespace App\ViewModel\Assembler;

use App\ViewModel\NotificationViewModel;

class NotificationViewModelAssembler
{
    public function toViewModelList($notifications)
    {
        $viewModelList = [];
        foreach ($notifications as $notification) {
            $viewModel = new NotificationViewModel(
                $notification->id,
                $notification->type,
                $notification->subject,
                $notification->content,
                $notification->unread,
                $notification->created_at->diffForHumans()
            );

            $viewModelList[] = $viewModel;
        }

        return $viewModelList;
    }
}
