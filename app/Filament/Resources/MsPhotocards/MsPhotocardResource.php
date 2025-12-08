<?php

namespace App\Filament\Resources\MsPhotocards;

use App\Filament\Resources\MsPhotocards\Pages\ManageMsPhotocards;
use App\Models\MsPhotocard;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

use Filament\Forms;
use Filament\Forms\Form;


use Filament\Tables;
use Filament\Tables\Table;

class MsPhotocardResource extends Resource {
    protected static ?string $model = MsPhotocard::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'nama_pc';

    protected static ?string $modelLabel = 'Photocard';
    protected static ?string $pluralModelLabel = 'Photocard';

    public static function form(Schema $schema): Schema {
        return $schema
            ->components([
                Forms\Components\Select::make('idGroupBand')
                    ->relationship('groupBand', 'nama_group') 
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Grup Band'),

                Forms\Components\TextInput::make('nama_pc')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Photocard'),

                Forms\Components\TextInput::make('harga_pc')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->label('Harga'),

                Forms\Components\TextInput::make('stock_pc')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->label('Stok'),

                Forms\Components\Textarea::make('deskripsi_pc')
                    ->label('Deskripsi')
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('foto_pc')
                    ->image()
                    ->directory('photocards')
                    ->label('Foto Produk')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('foto_pc')
                    ->label('Foto'),

                \Filament\Tables\Columns\TextColumn::make('nama_pc')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),

                \Filament\Tables\Columns\TextColumn::make('groupBand.nama_group')
                    ->label('Band')
                    ->sortable()
                    ->searchable(),

                \Filament\Tables\Columns\TextColumn::make('harga_pc')
                    ->money('IDR')
                    ->label('Harga')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('stock_pc')
                    ->numeric()
                    ->label('Stok'),
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

    public static function getPages(): array {
        return [
            'index' => ManageMsPhotocards::route('/'),
        ];
    }
}