<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResetController
{
    public function reset()
    {
        return response()->json(['OK'], 200);
    }
}
