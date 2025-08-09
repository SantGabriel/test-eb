<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ResetService
{
    
    public function reset() {
        DB::table('operations')->truncate();
    }
}