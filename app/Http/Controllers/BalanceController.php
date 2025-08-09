<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BalanceService;

class BalanceController
{

    public function __construct(private BalanceService $balanceService)
    {
    }

    public function getBalance(Request $request)
    {        
        $balance = $this->balanceService->getBalance($request->query('account_id'));
        if($balance !== false) {
            return response()->json($balance, 200);
        }else {
            return response()->json(0, 404);
        }
    }
}
