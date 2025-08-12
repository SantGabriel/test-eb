<?php

namespace App\Services;

use App\Models\Account;

class BalanceService
{
    public function getBalance(string $id)
    {
        $account = Account::loadById($id);
        if ($account) {
            return $account->getBalance();
        }else {
            return false;
        }
    }
}