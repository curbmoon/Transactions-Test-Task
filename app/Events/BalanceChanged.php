<?php

namespace App\Events;

class BalanceChanged extends Event
{
	/* По нему мы будем обновлять баланс пользователя */
	public $user_id;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }
}
