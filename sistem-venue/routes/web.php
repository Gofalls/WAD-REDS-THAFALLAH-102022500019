<?php

use App\Http\Controllers\LapanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('lapangan.index');
});

Route::resource('lapangan', LapanganController::class)->parameters([
    'lapangan' => 'id'
]);