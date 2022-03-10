<?php

namespace App\Listeners;

use App\Events\OrderStatus;
use App\Notifications\AdminOrderNotification;
use App\Notifications\OrderStatusNotification;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderStatusNotification implements ShouldQueue
{
    use InteractsWithQueue;

    protected $admins;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserRepository $repo)
    {
        $this->admins = $repo->admins();
    }

    /**
     * Handle the event.
     *
     * @param  OrderStatus  $event
     * @return void
     */
    public function handle(OrderStatus $event)
    {

        Notification::send($event->order->user, new OrderStatusNotification($event->order));

        Notification::send($this->admins, new AdminOrderNotification($event->order));
    }
}
