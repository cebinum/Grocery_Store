<?php

namespace App\Notifications;

use App\Order;
use App\Sms\SmsNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusNotification extends Notification
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
        $this->sendSms($this->order->phone_number, $this->message);
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
            ->greeting('Hello ' . $this->order->user->name . '!')
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

    public function sendSms($phoneNumber, $message)
    {
        $send = new SmsNotification();
        $send->key = 'RplMEtqoRa58HDR4A9Bh6Kcne';
        $send->message = $message;
        $send->numbers = $phoneNumber;
        $send->sender = 'Di Dwa';
        return  $response = $send->sendMessage();
    }

    public function orderMessage($order)
    {
        switch ($order->status) {
            case (Order::ORDER_RECEIVED):
                $message = 'Thanks for shopping with us. We will let you know when its ready. Order no:' . $order->order_number;
                break;
            case (Order::ORDER_IN_PROCESS):
                $message = 'We are currently processing your order. We will notify you when its ready for delivery' . $order->order_number;
                break;
            case (Order::DELIVERY_IN_PROGRESS):
                $message = 'Your package is being delivered. We will contact you shortly. Order no:' . $order->order_number;
                break;
            case (Order::PACKAGE_DELIVERED):
                $message = 'Your package has been delivered. Thanks for choosing us!. Shop with us next time ' . url('/');
                break;
            default:
                $message = 'Thanks for shopping with us. We will let you know when its ready. Order no:' . $order->order_number;
                break;
        }

        return $message;
    }

    public function orderSubject($order)
    {
        switch ($order->status) {
            case (Order::ORDER_RECEIVED):
                $subject = 'Order Received';
                break;
            case (Order::ORDER_IN_PROCESS):
                $subject = 'Order in Process';
                break;
            case (Order::DELIVERY_IN_PROGRESS):
                $subject = 'Delivery';
                break;
            case (Order::PACKAGE_DELIVERED):
                $subject = 'Package Delivered';
                break;
            default:
                $subject = 'Order Received';
                break;
        }

        return $subject;
    }
}
