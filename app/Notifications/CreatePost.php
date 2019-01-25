<?php

namespace App\Notifications;

use App\Models\Cores\Cores_user;
use Faker\Provider\DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\CustomNotification;
class CreatePost extends Notification
{
    use Queueable;

    protected $content;
    protected $file;
    protected $ou;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($content, $file, $ou, $notify_id)
    {
        $this->content = $content;
        $this->file = $file;
        $this->ou = $ou;
        $this->notify_id = $notify_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [CustomNotification::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

//    public function toMail($notifiable)
//    {
//        return (new MailMessage)
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', url('/'))
//                    ->line('Thank you for using our application!');
//    }

    // in your notification
    public function toDatabase($notifiable)
    {
        return [
            'content' => $this->content,
            'file' => $this->file,
            'ou' => $this->ou,
            'notify_id' => $this->notify_id,

        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'content' => $this->content,
            'file' => 'abc'
        ];
    }
}
