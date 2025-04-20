<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Admin';
    public static function shouldRegisterNavigation(): bool
    {
        // Hanya role admin yang bisa mengakses resource ini
        return auth()->user()->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Nama Pengguna')
                    ->placeholder('Masukkan nama pengguna'),
                TextInput::make('email')
                    ->required()
                    ->label('Email')
                    ->placeholder('Masukkan email pengguna')
                    ->email()
                    ->maxLength(255),
                TextInput::make('password')
                    ->required()
                    ->label('Password')
                    ->placeholder('Masukkan password pengguna')
                    ->password()
                    ->minLength(8)
                    ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                    ->confirmed('password_confirmation')
                    ->maxLength(255),
                TextInput::make('password_confirmation')
                    ->label('Konfirmasi Password')
                    ->placeholder('Masukkan konfirmasi password pengguna')
                    ->password()
                    ->dehydrated(false)
                    ->maxLength(255),
                Select::make('role')
                    ->required()
                    ->label('Role')
                    ->placeholder('Pilih role pengguna')
                    ->options([
                        'admin' => 'Admin',
                        'dokter' => 'Dokter',
                        'petugas_pendaftaran' => 'Petugas Pendaftaran',
                        'kasir' => 'Kasir',
                    ])
                    ->reactive()
                    ->afterStateUpdated(function ($state) {
                        return $state;
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Pengguna')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('role')
                    ->label('Role')
                    ->searchable()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'admin';
    }
    public static function canCreate(): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()->role === 'admin';
    }
}
