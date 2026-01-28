<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class Notify extends Notification
{
    use Queueable;

    public $data;

    public function __construct($message, $url)
    {
        $this->data['message']  = $message;
        $this->data['url']      = $url;
        $this->data['user_id']  = auth()->user()->id;
        $this->data['name']     = auth()->user()->name;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return  $this->data;
    }
}
