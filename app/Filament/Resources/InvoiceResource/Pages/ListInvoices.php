<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use Filament\Actions;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\InvoiceResource;

class ListInvoices extends ListRecords
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ButtonAction::make('Cetak Invoice')->color('warning')->url(fn()=> route('download.tes'))->openUrlInNewTab(),
            Actions\CreateAction::make(),
        ];
    }
}