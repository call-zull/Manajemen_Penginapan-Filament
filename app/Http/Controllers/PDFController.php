<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class PDFController extends Controller
{
    public function __construct()
    {
        // Set locale to Indonesian
        Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID');
    }


public function invoicepdf($id)
{
    
    $invoice = Invoice::with('room')->find($id);

    if (!$invoice) {
        abort(404, 'Invoice not found');
    }

    $date = Carbon::now()->translatedFormat('l, d F Y H:i'); // Format tanggal dan waktu dalam bahasa Indonesia

    $data = [
        'date' => $date,
        'invoice' => $invoice
    ];

    $timestamp = now()->timestamp; // Mendapatkan timestamp saat ini
    $filename = 'Invoice-Penginapan-' . $timestamp . '.pdf'; // Menambahkan timestamp ke nama file

    $pdf = Pdf::loadView('invoicePDF', $data);

    // return view('invoicePDF');
    // die;
    return $pdf->download($filename); 
}

}