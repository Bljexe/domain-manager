<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DomainResource\Pages;
use App\Filament\Resources\DomainResource\RelationManagers;
use App\Models\Domain;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;

class DomainResource extends Resource
{
    protected static ?string $model = Domain::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationLabel = 'Domínios';

    protected static ?string $modelLabel = 'Domínio';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Usuário')
                    ->relationship('user', 'name'),
                Forms\Components\Select::make('provider_id')
                    ->label('Provedor')
                    ->relationship('provider', 'name'),
                Forms\Components\TextInput::make('reference')
                    ->label('Referência')
                    ->disabled(),
                Forms\Components\TextInput::make('url')
                    ->label('URL'),
                Forms\Components\TextInput::make('ip')
                    ->label('IP'),
                    Forms\Components\Toggle::make('status')
                    ->label('Status'),
                Forms\Components\Toggle::make('ssl')
                    ->label('SSL'),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Domain::count();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reference')
                    ->label('Referência')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuário')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('provider.name')
                    ->label('Provedor')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('url') 
                    ->label('URL')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip')
                    ->label('IP')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('ssl')
                    ->boolean(),
                IconColumn::make('status')
                    ->boolean()

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListDomains::route('/'),
            'create' => Pages\CreateDomain::route('/create'),
            'edit' => Pages\EditDomain::route('/{record}/edit'),
        ];
    }
}
