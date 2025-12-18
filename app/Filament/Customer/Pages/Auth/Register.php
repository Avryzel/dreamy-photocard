<?php

namespace App\Filament\Customer\Pages\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Register extends BaseRegister
{
    public function form(Schema $schema): Schema 
    {
        return $schema
            ->components([
                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Alamat Email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(User::class),

                TextInput::make('nomor_hp')
                    ->label('Nomor HP')
                    ->tel()
                    ->required()
                    ->maxLength(15),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->same('passwordConfirmation'),

                TextInput::make('passwordConfirmation')
                    ->label('Ulangi Password')
                    ->password()
                    ->required(),
            ]);
    }

    protected function handleRegistration(array $data): User
    {
        return User::create([
            'username' => $data['username'],
            'email'    => $data['email'],
            'nomor_hp' => $data['nomor_hp'],
            'password' => Hash::make($data['password']),
            'role'     => 'pelanggan',
            'email_verified_at' => now(),
        ]);
    }

    protected function sendEmailVerificationNotification(Model $user): void
    {
       //
    }
}