<?php

use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('download', [PDFController::class, 'downloadpdf'])->name('download.tes');
Route::get('download/{id}', [PDFController::class, 'invoicepdf'])->name('download.pdf');