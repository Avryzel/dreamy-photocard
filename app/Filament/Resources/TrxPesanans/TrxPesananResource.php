<?php

namespace App\Filament\Resources\TrxPesanans;

use App\Filament\Resources\TrxPesanans\Pages;
use App\Models\TrxPesanan;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TrxPesananResource extends Resource
{
    protected static ?string $model = TrxPesanan::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingCart;
    protected static ?string $navigationLabel = 'Orders';
    protected static ?string $modelLabel = 'Order';

    public static function canAccess(): bool
    {
        if (! Auth::check()) return false;
        return Auth::user()->role === 'admin';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('idUser') 
                    ->label('Customer')
                    ->relationship('user', 'username')
                    ->disabled()
                    ->required(),

                TextInput::make('total_harga')
                    ->label('Total Transaksi')
                    ->prefix('Rp')
                    ->numeric()
                    ->disabled()
                    ->required(),

                Select::make('status_pesanan') 
                    ->label('Status')
                    ->options([
                        'PERMINTAAN' => 'PERMINTAAN',
                        'DIPROSES'   => 'DIPROSES',
                        'DIKIRIM'    => 'DIKIRIM',
                        'SELESAI'    => 'SELESAI',
                        'DIBATALKAN' => 'DIBATALKAN',
                    ])
                    ->required()
                    ->native(false),

                TextInput::make('nomor_resi') 
                    ->label('Nomor Resi')
                    ->placeholder('Masukkan Nomor Resi...')
                    ->visible(fn ($get) => in_array($get('status_pesanan'), ['DIKIRIM', 'SELESAI']))
                    ->columnSpanFull(),

                Repeater::make('details')
                    ->relationship('details')
                    ->schema([
                        Select::make('idPhotocard')
                            ->label('Photocard')
                            ->relationship('photocard', 'nama_pc')
                            ->disabled(),

                        TextInput::make('jumlah')
                            ->label('Qty')
                            ->disabled(),

                        TextInput::make('harga_per_item')
                            ->label('Harga Satuan')
                            ->prefix('Rp')
                            ->disabled(),
                    ])
                    ->addable(false)
                    ->deletable(false)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.username')
                    ->label('Customer')
                    ->searchable(),

                TextColumn::make('total_harga')
                    ->money('IDR', locale: 'id'),

                TextColumn::make('nomor_resi')
                    ->label('Resi')
                    ->icon('heroicon-m-truck')
                    ->placeholder('-'),

                TextColumn::make('status_pesanan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'PERMINTAAN' => 'gray',
                        'DIPROSES'   => 'warning',
                        'DIKIRIM'    => 'info',
                        'SELESAI'    => 'success',
                        'DIBATALKAN' => 'danger',
                        default      => 'gray',
                    }),

                TextColumn::make('tanggal_pemesanan')
                    ->date()
                    ->label('Tanggal'),
            ])
            ->defaultSort('tanggal_pemesanan', 'desc')
            ->actions([
                EditAction::make(),
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
            'index' => Pages\ListTrxPesanans::route('/'),
            'edit' => Pages\EditTrxPesanan::route('/{record}/edit'),
        ];
    }
}