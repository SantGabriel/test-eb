<?php

use Illuminate\Support\Facades\Route;

Route::get('/reset', function () {
    return response()->json('OKidokey', 200);
});