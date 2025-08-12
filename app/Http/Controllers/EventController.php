<?php

namespace App\Http\Controllers;

use App\Enum\Operation;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;
use App\Models\Account;

class EventController
{
    public function __construct(private EventService $eventService)
    {
    }

    public function event(Request $request)
    {
        $event = Event::load($request->all());
        $eventResult = $this->eventService->event($event);
        if($eventResult !== false){
            if($event->getType() === Operation::DEPOSIT) {               
                /** 
                 * @var Account $eventResult
                 * */
                $response = $this->depositResponse($eventResult);
            }else if($event->getType() === Operation::WITHDRAW){           
                /** 
                 * @var Account $eventResult
                 * */
                $response = $this->withdrawResponse($eventResult);
            }else if($event->getType() === Operation::TRANSFER){           
                /** 
                 * @var array{originAccount:Account,destinationAccount:Account} $eventResult
                 * */
                $response = $this->transferResponse($eventResult['originAccount'], $eventResult['destinationAccount']);
            }else {
                return response()->json(0, 409);
            }
            return response()->json($response, 201);
        }else{
            return response()->json(0, 404);
        }
    }

    private function depositResponse(Account $account) {       
        return ["destination" => $account->toArray()];
    }

    private function withdrawResponse(Account $account) {        
        return ["origin" => $account->toArray()];
    }

    private function transferResponse(Account $originAccount, Account $destinationAccount) {        
        return ["origin" => $originAccount->toArray(), "destination" => $destinationAccount->toArray()];
    }
}
