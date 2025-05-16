<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UpdateOrderStatusNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Order $order,
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
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->from('admin@bookshop.com', 'Quản trị viên')
                    ->subject('Đã cập nhật trạng thái đơn hàng')
                    ->view('mail.update_order_status', ['order' => $this->order]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [

        ];
    }

    public function toDatabase(object $notifiable)
    {
        return [
            'message' => 'Đã cập nhật trạng thái đơn hàng',
            'order_id' => $this->order->order_id,
            'order_status' => $this->order->status,
            'link' => route('orders')
        ];
    }
}
