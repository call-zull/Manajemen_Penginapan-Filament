<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-m-building-office';

    protected static ?string $navigationLabel = 'Kamar';

    protected static ?string $pluralModelLabel = 'Kamar';
    protected static ?string $modelLabel = 'Kamar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('No_Kamar')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type_id')
                    ->relationship('type', 'Name')
                    ->label('Tipe Kamar')
                    ->required(),
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\TextInput::make('Harga')
                            ->required()
                            ->label('Harga Kamar')
                            ->numeric(),
                        Forms\Components\Toggle::make('Is_People')
                            ->label('Diisi')
                            ->required(),
                        Forms\Components\Toggle::make('Is_Clean')
                            ->label('Dibersihkan')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    TextColumn::make('No_Kamar')
                        ->label('Nomor Kamar')
                        ->searchable()
                        ->getStateUsing(function ($record) {
                            return 'No Kamar : ' . $record->No_Kamar;
                        }),
                    TextColumn::make('type.Name')
                        ->label('Tipe Kamar')
                        ->sortable()
                        ->getStateUsing(function ($record) {
                            return 'Tipe Kamar : ' . $record->type->Name;
                        }),
                    TextColumn::make('Harga')
                        ->label('Harga')
                        ->prefix('Rp. ')
                        ->numeric()
                        ->sortable(),
                    TextColumn::make('Is_People')
                        ->label('Diisi')
                        ->getStateUsing(function ($record) {
                            return $record->Is_People ? 'Kamar Diisi' : 'Kamar Kosong';
                        }),
                    TextColumn::make('Is_Clean')
                        ->label('Dibersihkan')
                        ->getStateUsing(function ($record) {
                            return $record->Is_Clean ? 'Kamar Dibersihkan' : 'Kamar Belum dibersihkan';
                        }),
                    TextColumn::make('invoices.name_customer')
                        ->label('Nama Pengunjung')
                        ->sortable()
                        ->getStateUsing(function ($record) {
                            $customerName = optional($record->invoices->last())->name_customer;
                            return 'Pengunjung : ' . ($customerName ?? 'Tidak Ada');
                        }),
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 2,
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}