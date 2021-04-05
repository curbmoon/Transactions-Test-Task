<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Events\BalanceChanged;
use Illuminate\Support\Facades\Lang;

class Balance extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param $value
     * @return string
     */
    public function getDescription($value) : string
    {
        $text = $value < 0 ? 'Списание' : 'Пополнение';
        $text .= ' на сумму ' . $value . ' '  . Lang::choice('рубль|рубля|рублей', $value, [], 'ru');
        return $text;
    }

    /**
     * Пополнения баланса
     *
     * @return void
     */
    public function TopUpBalance(Request $request)
    {
        $value = rand(1, 10000);
        $example_request_data_array = [
            'user_id' => rand(1, 3),
            'value' => $value,
            'type' => Transaction::TYPE_REFILL,
            'description' => $this->getDescription($value)
        ];
        
        $transaction = Transaction::create($example_request_data_array);
        
        if ($transaction !== null && !empty($transaction)) {
            event(new BalanceChanged($example_request_data_array['user_id']));
        }
    }

    /**
     * Вычитание баланса
     *
     * @return void
     */
    public function ReduceBalance(Request $request)
    {
        $value = rand(-10000, -1);
        $example_request_data_array = [
            'user_id' => rand(1, 3),
            'value' => $value,
            'type' => Transaction::TYPE_DEBIT,
            'description' => $this->getDescription($value)
        ];
        
        $transaction = Transaction::create($example_request_data_array);
        
        if ($transaction !== null && !empty($transaction)) {
            event(new BalanceChanged($example_request_data_array['user_id']));
        }
    }

    /**
     * Отмена транзакции
     *
     * @return void
     */
    public function CancelingTransaction(Request $request)
    {
        $example_transaction_id = 4279;
        $transaction_for_canceling = Transaction::where('id', $example_transaction_id)->first();
        if ($transaction_for_canceling !== null && !empty($transaction_for_canceling)) {
            $user_id = $transaction_for_canceling->user_id;
            $transaction_for_canceling->type = Transaction::TYPE_REFUND;
            $result_save_transaction = $transaction_for_canceling->save();
            if ($result_save_transaction === true) {
                event(new BalanceChanged($user_id));
            }
        }
       
    } 

    //
}
