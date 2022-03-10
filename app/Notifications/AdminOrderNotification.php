<?php

namespace App\Notifications;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminOrderNotification extends Notification
{
    use Queueable;

    protected $order;

    protected $subject;

    protected $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->message = $this->orderMessage($order);
        $this->subject = $this->orderSubject($order);
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
        return (new MailMessage)
            ->subject($this->subject)
            ->greeting('Hello Admin!')
            ->line($this->message)
            ->action('Order Details', url('order/' . $this->order->order_number))
            ->line('Thank you for choosing us!');
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

    public function orderMessage($order)
    {
        switch ($order->status) {
            case (Order::ORDER_RECEIVED):
                $message = 'We have a new order from ' . $this->order->user->name . '. Order number:' . $order->order_number;
                break;
            case (Order::ORDER_IN_PROCESS):
                $message = 'Order number:' . $order->order_number . ' is currently being processed';
                break;
            case (Order::DELIVERY_IN_PROGRESS):
                $message = 'Package is on the way to be delivered to ' . $this->order->user->name . ' Order no:' . $order->order_number;
                break;
            case (Order::PACKAGE_DELIVERED):
                $message = 'Package has been delivered to ' . $this->order->user->name;
                break;
            default:
                $message = 'We have a new order from ' . $this->order->user->name . '. Order number:' . $order->order_number;
                break;
        }

        return $message;
    }

    public function orderSubject($order)
    {
        switch ($order->status) {
            case (Order::ORDER_RECEIVED):
                $subject = 'New Order';
                break;
            case (Order::ORDER_IN_PROCESS):
                $subject = 'Order in Process';
                break;
            case (Order::DELIVERY_IN_PROGRESS):
                $subject = 'Delivery In Progress';
                break;
            case (Order::PACKAGE_DELIVERED):
                $subject = 'Package Delivered';
                break;
            default:
                $subject = 'New Order';
                break;
        }

        return $subject;
    }
}
