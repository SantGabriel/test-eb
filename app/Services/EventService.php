<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Enum\Operation;
use App\Models\Account;
use App\Models\Event;

class EventService
{
    public function event(Event $event) {
        try {        
            switch ($event->getType()) {
                case Operation::DEPOSIT:
                    return $this->depositEvent($event->getAmount(), $event->getDestination());
                case Operation::WITHDRAW:
                    return $this->withdrawEvent($event->getAmount(), $event->getOrigin());
                case Operation::TRANSFER:
                    return $this->transferEvent($event->getAmount(), $event->getOrigin(), $event->getDestination());
                default:
                    return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    private function depositEvent(float $amount, string $destination) : Account {        
        $exists = Account::exists($destination);
        if ($exists) {
            DB::table('account')
                ->where('id', $destination)
                ->update(['balance' => DB::raw('balance + ' . $amount)]);
            return Account::loadById($destination);
        } else {
            $account = new Account($destination, $amount);
            DB::table('account')->insert([
                'id' => $destination,
                'balance' => $amount
            ]);
            return $account; 
        }
    }

    private function withdrawEvent(float $amount, string $origin): Account|false {    
        $exists = Account::exists($origin, true);
        if(!$exists) return false;
        DB::table('account')
                ->where('id', $origin)
                ->update(['balance' => DB::raw('balance - ' . $amount)]);
        return Account::loadById($origin);
    }

    /**
     * @return array{originAccount:Account,destinationAccount:Account}
     */
    private function transferEvent(float $amount, string $origin, string $destination): array|false {
        return DB::transaction(function () use ($amount, $origin, $destination) {       
            $originAccountExists = Account::exists($origin);
            $destinationAccountExists = Account::exists($destination);
            if(!$originAccountExists) return false;
 
            DB::table('account')
                    ->where('id', $origin)
                    ->update(['balance' => DB::raw('balance - ' . $amount)]);
            if ($destinationAccountExists) {
                DB::table('account')
                        ->where('id', $destination)
                        ->update(['balance' => DB::raw('balance + ' . $amount)]);
            }else {
                DB::table('account')->insert([
                    'id' => $destination,
                    'balance' => $amount
                ]);
            }
            
            return ["originAccount" => Account::loadById($origin), "destinationAccount" => Account::loadById($destination)];
        });
    }
}