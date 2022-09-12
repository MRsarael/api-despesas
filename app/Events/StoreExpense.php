<?php

namespace App\Events;

use App\User;
use App\Expenses;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreExpense
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $user;
    private $expense;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Expenses $expense)
    {
        $this->user = $user;
        $this->expense = $expense;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    public function getUser() : User
    {
        return $this->user;
    }

    public function getExpense() : Expenses
    {
        return $this->expense;
    }
}
