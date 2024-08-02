<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use SplSubject;

class ReservationNotification extends Notification
{
    use Queueable;

    public $reservation;
    /**
     * Create a new notification instance.
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        if($this->reservation->status == 'Created'){
            $subject = 'Your reservation has been created successfully';
            $greeting = 'your reservation has been created successfully.';
            $line = 'Head to your campus at ' . $this->reservation->campus->town->name . ' to pick up your book.';
        }elseif($this->reservation->status == 'Picked up'){
            $subject = 'You have picked up your book, your reservation is in progress';
            $greeting = 'your reservation is in progress';
            $line = 'Return your book before the expiration date on ' . Carbon::parse($this->reservation->expiration_date)->format('d-m-Y');
        }elseif($this->reservation->status == 'Cancelled'){
            $subject = 'Your reservation has been cancelled successfully';
            $greeting = 'your reservation has been cancelled successfully.';
            $line = 'For any questions or issues with your reservation, please contact the administration of your respective campus.';
        }else{
            $subject = 'You have successfully completed your reservation';
            $greeting = 'You have returned the book to the library';
            $line = 'For any questions or issues with your reservation, please contact the administration of your respective campus.';
        }

        return (new MailMessage)
                    ->subject($subject)
                    ->greeting('Hello ' . $this->reservation->user->name . ' ' . $greeting)
                    ->line($line)
                    ->action('View my reservation', url('/api/reservations/' . $this->reservation->id))
                    ->line('Thank you for using our application!');
    }
}
