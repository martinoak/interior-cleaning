<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function exportCustomers(): StreamedResponse
    {
        $invoices = Invoice::orderBy('date', 'desc')->get();

        $file = fopen('php://temp', 'w');

        foreach ($invoices as $invoice) {
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, [
                utf8_decode($invoice->type),
                $invoice->date,
                $invoice->name,
                $invoice->price,
                $invoice->worker
            ], ';');
        }

        rewind($file);
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="customers.csv"',
        ];

        return response()->stream(function () use ($file) {
            fpassthru($file);
        }, 200, $headers);
    }
}
