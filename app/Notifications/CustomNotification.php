<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class CustomNotification
{

    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toDatabase($notifiable);

        return $notifiable->routeNotificationFor('database')->create([
            'id' => $notification->id,

            //customize here
//            'answer_id' => $data['answer_id'], //<-- comes from toDatabase() Method below
            'created_by'=> \Auth::user()->id,
            'data' => $data,
            'type' => get_class($notification),
            'notify_id' => $data['notify_id']
//            'read_at' => null,
        ]);
    }

}