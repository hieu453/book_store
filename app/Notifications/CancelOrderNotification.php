<?php

namespace App\Notifications;

use App\Models\CancelledOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CancelOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public CancelledOrder $cancelledOrder
    )
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->from($this->cancelledOrder->user->email, $this->cancelledOrder->user->name)
                    ->subject('Yêu cầu hoàn hàng')
                    ->view('mail.cancel_order', [ 'cancelled_order' => $this->cancelledOrder ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Bạn có yêu cầu hủy hàng',
            'order_id' => $this->cancelledOrder->order_id,
            'link' => route('admin.orders.cancelled')
        ];
    }
}
