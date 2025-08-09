<?php

namespace App\Enum;

enum Operation: string
{
    case DEPOSIT = 'deposit';
    case WITHDRAW = 'withdraw';
    case TRANSFER = 'transfer';
    case BALANCE = 'balance';
    case RESET = 'reset';
}
