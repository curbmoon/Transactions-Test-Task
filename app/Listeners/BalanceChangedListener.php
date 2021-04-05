<?php

namespace App\Listeners;

use App\Events\ExampleEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Profile;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Queue\InteractsWithQueue;

class BalanceChangedListener
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
     * @param  \App\Events\ExampleEvent  $event
     * @return void
     */
    public function handle($data)
    {
        if ($data->user_id !== null && !empty($data->user_id))
        {
            $user_id = $data->user_id;
            $profile = Profile::where('user_id', $user_id)->first();
            if ($profile !== null && !empty($profile))
            {
                $balance_sum = Transaction::where('user_id', $user_id)->where('type', '!=', 3)->sum('transactions.value');
                if ($balance_sum !== null && !empty($balance_sum))
                {
                    $profile->balance = $balance_sum;
                    $profile->save();
                    return;
                }
            }
            
            
        }
        
    }
}
