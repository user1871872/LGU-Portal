<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PermitGeneratedNotification extends Notification
{
    use Queueable;

    protected $certificate;

    public function __construct($certificate)
    {
        $this->certificate = $certificate;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your permit has been generated. Click here to view it.',
            'certificate_id' => $this->certificate->id,
            'file_url' => asset($this->certificate->file_path), 
        ];
    }
}

