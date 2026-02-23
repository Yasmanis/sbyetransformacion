<?php

namespace App\Notifications;

use App\Services\BrevoService;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class StandardNotification extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $model;
    protected $mode;
    protected $emailProps;
    protected $view;
    protected $title;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($model, $title = null, $view = null, $mode = ['database'], $emailProps = null)
    {
        $this->model = $model;
        $this->mode = $mode;
        $this->emailProps = $emailProps;
        $this->view = $view;
        $this->title = $title;
        $this->afterCommit();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->mode;
    }

    public function toBrevo($notifiable)
    {
        $brevo = new BrevoService();
        $brevo->sendEmail($this->title, $this->view, $this->emailProps, $notifiable);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [$this->model];
    }
}
