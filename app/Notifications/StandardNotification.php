<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class StandardNotification extends Notification
{
    use Queueable;

    protected $model;
    protected $via;
    protected $emailProps;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($model, $via = ['database'], $emailProps = null)
    {
        $this->model = $model;
        $this->via = $via;
        $this->emailProps = $emailProps;
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
        return $this->via;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $email = (new MailMessage)
            ->from(env('MAIL_FROM_ADDRESS'))
            ->greeting('Hola!')
            ->line($this->emailProps['title']);
        if (isset($this->emailProps)) {
            if (isset($this->emailProps['url'])) {
                $email = $email->line('Por favor click sobre el siguiente botón para más información');
                $email = $email->action('Ver', $this->emailProps['url']);
            }
            if (isset($this->emailProps['attachments'])) {
                $email = $email->attachMany($this->emailProps['attachments']);
            }
        }
        $email = $email->line('Gracias por utilizar nuestra aplicación!');
        return $email;
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