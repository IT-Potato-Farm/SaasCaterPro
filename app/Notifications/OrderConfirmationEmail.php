<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmationEmail extends Notification implements ShouldQueue
{
    use Queueable;
    protected $order;
    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
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
        $url = url(route('order.show', $this->order->id));
        return (new MailMessage)
            ->subject('Booking Confirmation - #' . $this->order->id)
            ->greeting('Thank you for your booking!')
            ->line('We are pleased to confirm your booking has been received and is now being processed.')
            ->line('Booking Details:')
            ->line('Event Type: ' . $this->order->event_type)
            ->line('Event Date: ' . \Carbon\Carbon::parse($this->order->event_date)->format('F d, Y'))
            ->line('Total Amount: ₱' . number_format($this->order->total, 2))
            ->action('View Booking Details', $url)
            ->line('If you have any questions or need to make changes to your booking, please contact us.')
            ->line('Thank you for choosing our services!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'event_type' => $this->order->event_type,
            'event_date' => $this->order->event_date,
            'total' => $this->order->total,
        ];
    }
}
