<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use App\Models\Room;
use App\Models\Type;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $currentDate = Carbon::now();

        // Kamar siap jual (tidak ada pengunjung atau tidak ada tamu) dan sudah dibersihkan
        $roomsReadyForSale = Room::whereDoesntHave('invoices', function ($query) use ($currentDate) {
            $query->where('check_out', '>', $currentDate);
        })
            ->where('Is_Clean', true)
            ->count();

        // Kamar terpakai (ada pengunjung dan belum lewat tanggal checkout)
        $roomsOccupied = Room::whereHas('invoices', function ($query) use ($currentDate) {
            $query->where('check_out', '>', $currentDate);
        })
            ->count();

        // Kamar belum dibersihkan (tidak ada pengunjung namun belum dibersihkan)
        $roomsNotCleaned = Room::whereDoesntHave('invoices', function ($query) use ($currentDate) {
            $query->where('check_out', '>', $currentDate);
        })
            ->where('Is_Clean', false)
            ->count();

        return [
            Stat::make('types', Type::query()->count())
                ->label('Tipe Kamar')
                ->description('Jumlah Jenis Tipe Kamar')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('success'),

            Stat::make('rooms', Room::query()->count())
                ->label('Total Kamar')
                ->description('Jumlah Kamar Penginapan')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('success'),

            Stat::make('roomsReadyForSale', $roomsReadyForSale)
                ->label('Kamar Siap Jual')
                ->description('Jumlah Kamar yang Kosong dan Siap untuk Dijual')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('warning'),

            Stat::make('roomsOccupied', $roomsOccupied)
                ->label('Kamar Terpakai')
                ->description('Kamar yang Sedang Dihuni')
                ->descriptionIcon('heroicon-m-user')
                ->color('info'),

            Stat::make('roomsNotCleaned', $roomsNotCleaned)
                ->label('Kamar Belum Dibersihkan')
                ->description('Jumlah Kamar yang Belum Dibersihkan')
                ->descriptionIcon('heroicon-m-trash')
                ->color('danger'),

            Stat::make('invoices', Invoice::query()->count())
                ->label('Invoice Tercetak')
                ->description('Total Invoice yang telah dibuat')
                ->descriptionIcon('heroicon-m-printer')
                ->color('grey'),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }
}