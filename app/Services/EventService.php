<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Enum\Operation;
use App\Models\Account;
use App\Models\Event;

class EventService
{
    public function event(Event $event) {
        switch ($event->getType()) {
            case Operation::DEPOSIT:
                return $this->deposit($event->getAmount(), $event->getDestination());
            case Operation::WITHDRAW:
                return $this->withdraw();
            case Operation::TRANSFER:
                return $this->transfer();
            default:
                throw new \Exception("Invalid operation type");
        }
    }

    private function deposit($amout, $destination) : float|bool {
        $accountData = DB::table('account')->where('id', $destination)->first();
        $account = Account::load($accountData);
        if ($account) {
            DB::table('account')
                ->where('id', $destination)
                ->update(['balance' => DB::raw('balance + ' . $amout)]);
            return $account->getBalance() + $amout;
        } else {
            return false;
        }
    }

    private function withdraw() {
        // Logic for withdraw operation
    }

    private function transfer() {
        // Logic for transfer operation
    }
}