<?php

namespace App\Filament\Resources\MsGrupBands;

use App\Filament\Resources\MsGrupBands\Pages\ManageMsGrupBands;
use App\Models\MsGrupBand;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class MsGrupBandResource extends Resource
{
    protected static ?string $model = MsGrupBand::class;

    protected static ?string $navigationLabel = 'Kategori Produk';
    protected static ?string $pluralLabel = 'Kategori Produk';
    protected static ?string $modelLabel = 'Kategori';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function canAccess(): bool
    {
        if (! Auth::check()) {
            return false;
        }
        return Auth::user()->role === 'admin';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('logo')
                    ->label('Group Logo')
                    ->directory('logo-grup')
                    ->image()
                    ->imageEditor()
                    ->columnSpanFull(),

                TextInput::make('nama_group')
                    ->label('Nama Kategori')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_group')
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular(),

                TextColumn::make('nama_group')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMsGrupBands::route('/'),
        ];
    }
}