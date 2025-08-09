<?php

namespace App\Models;

class Account 
{
    private $id;
    private $balance;

    public function __construct($id, $balance)
    {
        $this->id = $id;
        $this->balance = $balance;
    }

    public static function load($data) : Account|null
    {
        if (!$data) {
            return null;
        }
        $id = $data['id'];
        $balance = $data['balance'];

        return new Account($id, $balance);
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getBalance() : float
    {
        return $this->balance;
    }
}
