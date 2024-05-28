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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-m-building-office';

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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_urut')
                ->label('No')
                ->getStateUsing(function ($rowLoop, $record) {
                    return $rowLoop->iteration;
                }),
                Tables\Columns\TextColumn::make('No_Kamar')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type.Name')
                    ->label('Tipe Kamar')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('Harga')
                    ->prefix('Rp. ')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('Is_People')
                    ->label('Diisi')
                    ->boolean(),
                Tables\Columns\IconColumn::make('Is_Clean')
                    ->label('Dibersihkan')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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