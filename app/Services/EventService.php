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
                return $this->depositEvent($event->getAmount(), $event->getDestination());
            case Operation::WITHDRAW:
                return $this->withdrawEvent($event->getAmount(), $event->getOrigin());
            case Operation::TRANSFER:
                return $this->transferEvent($event->getAmount(), $event->getOrigin(), $event->getDestination());
            default:
                throw new \Exception("Invalid operation type");
        }
    }

    private function depositEvent(float $amount, int $destination) : Account {        
        $account = Account::loadById($destination);
        if ($account) {
            $account->addToBalance($amount);
            DB::table('account')
                ->where('id', $destination)
                ->update(['balance' => DB::raw('balance + ' . $amount)]);
            return $account;
        } else {
            $account = new Account($destination, $amount);
            DB::table('account')->insert([
                'id' => $destination,
                'balance' => $amount
            ]);
            return $account; 
        }
    }

    private function withdrawEvent(float $amount, int $origin): Account|false {
        $account = Account::loadById($origin);
        if(!isset($account)) return false;
        $account->subtractFromBalance($amount);  
        DB::table('account')
                ->where('id', $origin)
                ->update(['balance' => DB::raw('balance - ' . $amount)]);
        return $account;
    }

    /**
     * @return array{originAccount:Account,destinationAccount:Account}
     */
    private function transferEvent(float $amount, int $origin, int $destination): array|false {
        $originAccount = Account::loadById($origin);
        $destinationAccount = Account::loadById($destination);
        if(!isset($originAccount) || !isset($destinationAccount)) return false;

        $destinationAccount->addToBalance($amount); 
        DB::table('account')
                ->where('id', $destination)
                ->update(['balance' => DB::raw('balance + ' . $amount)]);

        $originAccount->subtractFromBalance($amount);  
        DB::table('account')
                ->where('id', $origin)
                ->update(['balance' => DB::raw('balance - ' . $amount)]);
        
        return ["originAccount" => $originAccount, "destinationAccount" => $destinationAccount];
    }
}