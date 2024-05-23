<?php

namespace App\Notifications;

use App\Models\ChMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUnreadChatMessage extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected ChMessage $message)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject("You've received messages from " . $this->message->sender->name)
            ->greeting("Hi " . $this->message->recipient->username)
            ->line($this->message->sender->username . ' left you messages.');

        $messages = ChMessage::where([
            'from_id' => $this->message->sender->id,
            'to_id' => $this->message->recipient->id,
            'seen' => 0
        ])->get();

        foreach ($messages as $message) {
            $mail->line('- ' . $message->body);
        }

        $mail->action('View and Reply', url('/chatify/' . $this->message->sender->id));

        return $mail;
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
}
