<?php

namespace App\Filament\Customer\Resources;

use App\Filament\Customer\Resources\MsPhotocardResource\Pages;
use App\Models\MsPhotocard;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\Layout\View; 
use BackedEnum; 
use Filament\Schemas\Schema; // <--- 1. UBAH INI (Dulu Filament\Forms\Form)

class MsPhotocardResource extends Resource
{
    protected static ?string $model = MsPhotocard::class;

    // Definisi Icon yang ketat (Sesuai error sebelumnya)
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Belanja Photocard';
    protected static ?string $pluralModelLabel = 'Katalog Photocard';

    // 2. UBAH FUNGSI FORM JADI SCHEMA (Wajib di v4)
    public static function form(Schema $schema): Schema
    {
        return $schema->components([]); // Kosongkan karena customer gak input data
    }

    public static function table(Table $table): Table
    {
        return $table
            ->contentGrid([
                'default' => 1,
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
            ])
            ->columns([
                // Memanggil file blade custom kita
                View::make('filament.customer.photocard-card')
            ])
            ->actions([])
            ->bulkActions([])
            ->recordUrl(null);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMsPhotocards::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canViewAny(): bool
    {
        return true; 
    }
}