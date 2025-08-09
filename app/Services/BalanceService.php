<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Account;

class BalanceService
{
    public function getBalance($id)
    {
        $data = DB::table('account')->where('id', $id)->first();
        $account = Account::load($data);
        if ($account) {
            return $account->getBalance();
        }else {
            return false;
        }
    }
}