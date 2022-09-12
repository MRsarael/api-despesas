<?php

namespace App\Listeners;


use App\EmailQueue;

use Carbon\Carbon;

use App\Events\StoreExpense;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMailStoreExpense
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  StoreExpense  $event
     * @return void
     */
    public function handle(StoreExpense $event)
    {
        $user = $event->getUser();
        $expense = $event->getExpense();
        
        $html = view('messageStoreExpense', [
            'nameUser'           => $user->name,
            'valueExpense'       => $expense->value,
            'descriptionExpense' => $expense->description,
            'dateExpense'        => Carbon::parse($expense->expense_date)->format('d/m/Y'),
            'createdExpense'     => Carbon::parse($expense->created_at)->format('d/m/Y h:i')
        ])->render();

        $from = env('MAIL_USERNAME') ? env('MAIL_USERNAME') : '';

        EmailQueue::insert([
            'from' => $from,
            'to'   => $user->email,
            'body' => $html
        ]);
    }
}
