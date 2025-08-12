<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Account 
{
    private $id;
    private $balance;

    public function __construct($id, $balance)
    {
        $this->id = $id;
        $this->balance = $balance;
    }

    public static function exists($id) : bool {
        return DB::table('account')->where('id', $id)->exists();
    }

    public static function loadById($id) : Account|null {
        $data = DB::table('account')->where('id', $id)->first();
        return self::load( (array) $data);
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

    public function addToBalance(float $amount) {
        $this->balance = round($this->balance,2) + round($amount,2); 
        $this->balance = round($this->balance,2);    
    }

    public function subtractFromBalance(float $amount) {
        $this->balance = round($this->balance,2) - round($amount,2); 
        $this->balance = round($this->balance,2);  
    }

    public function toArray() {
        return get_object_vars($this);
    }
}
