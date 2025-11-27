<?php

namespace App\Filament\Resources\MsGrupBands;

use App\Filament\Resources\MsGrupBands\Pages\ManageMsGrupBands;
use App\Models\MsGrupBand;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class MsGrupBandResource extends Resource
{
    protected static ?string $model = MsGrupBand::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama_group';

   protected static ?string $modelLabel = 'Group Band';
    protected static ?string $pluralModelLabel = 'Group Photocard';

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
                TextInput::make('nama_group')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_group')
            ->columns([
                TextColumn::make('nama_group')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
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
