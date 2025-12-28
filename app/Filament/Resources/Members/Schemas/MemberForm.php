<?php

namespace App\Filament\Resources\Members\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('church_id')
                    ->relationship('church', 'name')
                    ->required(),
                TextInput::make('congregation_id')
                    ->required()
                    ->numeric(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('cpf'),
                TextInput::make('birth_date'),
                TextInput::make('gender'),
                TextInput::make('photo_path'),
                TextInput::make('street'),
                TextInput::make('number'),
                TextInput::make('complement'),
                TextInput::make('neighborhood'),
                TextInput::make('city'),
                TextInput::make('state'),
                TextInput::make('zip_code'),
                TextInput::make('status')
                    ->required()
                    ->default('visitor'),
                DatePicker::make('baptism_date'),
                DatePicker::make('conversion_date'),
                DatePicker::make('membership_date'),
                TextInput::make('marital_status'),
                Textarea::make('notes')
                    ->columnSpanFull(),
                TextInput::make('password')
                    ->password(),
                DateTimePicker::make('last_login_at'),
            ]);
    }
}
