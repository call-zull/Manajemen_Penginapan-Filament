<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use App\Models\Room;
use App\Models\Type;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Hitung jumlah kamar siap jual (Is_People false dan Is_Clean true)
        // $roomsReadyForSale = 

        return [
            Stat::make('Rooms', Type::query()->count())
                ->label('Tipe Kamar')
                ->description('Jumlah Jenis Tipe Kamar')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('success'),
            Stat::make('Rooms', Room::query()->count())
                ->label('Total Kamar')
                ->description('Jumlah Kamar Penginapan')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('success'),
            Stat::make('Siap Jual', Room::where('Is_People', false)->where('Is_Clean', true)->count())
                ->label('Kamar Siap Jual')
                ->description('Jumlah Kamar yang Kosong dan Siap untuk Dijual')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('warning'),
            Stat::make('Terpakai', Room::where('Is_People', true)->count())
                ->label('Kamar Terpakai')
                ->description('Kamar yang Sedang Dihuni')
                ->descriptionIcon('heroicon-m-user')
                ->color('info'),
            Stat::make('Kotor', Room::where('Is_People', false)->where('Is_Clean', false)->count())
                ->label('Kamar Belum Dibersihkan')
                ->description('Jumlah Kamar yang Belum Dibersihkan')
                ->descriptionIcon('heroicon-m-trash')
                ->color('danger'),
            Stat::make('Invoice', Invoice::query()->count())
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