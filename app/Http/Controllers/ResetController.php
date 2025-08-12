<?php

namespace App\Http\Controllers;

use App\Services\ResetService;
use Illuminate\Http\Request;

class ResetController
{

    public function __construct(private ResetService $resetService)
    {
    }

    public function reset()
    {
        $this->resetService->reset();
        return response()->json('OK', 200);
    }
}
