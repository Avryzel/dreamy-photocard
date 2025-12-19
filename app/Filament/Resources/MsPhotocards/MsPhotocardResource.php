<?php

namespace App\Filament\Resources\MsPhotocards;

use App\Models\MsPhotocard;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Schemas\Schema;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class MsPhotocardResource extends Resource
{
    protected static ?string $model = MsPhotocard::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Photocards';
    protected static ?string $modelLabel = 'Photocard';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Upload Foto
                FileUpload::make('foto_pc')
                    ->label('Foto Photocard')
                    ->image()
                    ->disk('public')
                    ->directory('photocards')
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('nama_pc')
                    ->label('Nama Photocard')
                    ->required()
                    ->maxLength(255),

                Select::make('idGroupBand')
                    ->label('Group / Artis')
                    ->relationship('groupBand', 'nama_group')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('harga_pc')
                    ->label('Harga (Rp)')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                TextInput::make('stock_pc')
                    ->label('Stok')
                    ->numeric()
                    ->default(1)
                    ->required(),

                Textarea::make('deskripsi_pc')
                    ->label('Deskripsi Lengkap')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto_pc')
                    ->label('Foto')
                    ->disk('public'),
                
                TextColumn::make('nama_pc')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('groupBand.nama_group')
                    ->label('Group')
                    ->sortable(),

                TextColumn::make('harga_pc')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('stock_pc')
                    ->label('Stok'),
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
            'index' => Pages\ManageMsPhotocards::route('/'),
        ];
    }
}