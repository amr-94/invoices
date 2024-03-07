<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class message_notification extends Notification
{
    use Queueable;
    protected $user;
    protected $tomessage;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $tomessage ,User $user)
    {
        //
        $this->user = $user;
        $this->tomessage= $tomessage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            //
        ];
    }

    public function todatabase($notifiable)
    {
        return [
            //
            'title'=> 'تم ارسال رسالة جديدة',
             'body' => __(":user has send message to you",[
                'user'=>$this->user->name
             ]),
             'user'=> $this->user->name,
             'url' => route('admin.allmessage')
        ];
    }
}
