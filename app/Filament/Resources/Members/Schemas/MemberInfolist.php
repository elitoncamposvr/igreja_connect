<?php

namespace App\Filament\Resources\Members\Schemas;

use App\Models\Member;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MemberInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('church.name')
                    ->label('Church'),
                TextEntry::make('congregation_id')
                    ->numeric(),
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address')
                    ->placeholder('-'),
                TextEntry::make('phone')
                    ->placeholder('-'),
                TextEntry::make('cpf')
                    ->placeholder('-'),
                TextEntry::make('birth_date')
                    ->placeholder('-'),
                TextEntry::make('gender')
                    ->placeholder('-'),
                TextEntry::make('photo_path')
                    ->placeholder('-'),
                TextEntry::make('street')
                    ->placeholder('-'),
                TextEntry::make('number')
                    ->placeholder('-'),
                TextEntry::make('complement')
                    ->placeholder('-'),
                TextEntry::make('neighborhood')
                    ->placeholder('-'),
                TextEntry::make('city')
                    ->placeholder('-'),
                TextEntry::make('state')
                    ->placeholder('-'),
                TextEntry::make('zip_code')
                    ->placeholder('-'),
                TextEntry::make('status'),
                TextEntry::make('baptism_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('conversion_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('membership_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('marital_status')
                    ->placeholder('-'),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('last_login_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Member $record): bool => $record->trashed()),
            ]);
    }
}
