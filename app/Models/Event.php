<?php

namespace App\Models;

use App\Enum\Operation;

class Event 
{
    public function __construct(
        private Operation $type,
        private float $amount,
        private string|null $origin = null,
        private string|null $destination = null)
    {
    }

    public static function load($data) : Event
    {
        $type = Operation::from($data['type']);
        $amount = $data['amount'];
        $origin = $data['origin'] ?? null;
        $destination = $data['destination'] ?? null;

        return new Event($type, $amount, $origin, $destination);
        
    }

    public function getType(): Operation
    {
        return $this->type;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }
}