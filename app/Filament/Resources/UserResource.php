<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ButtonAction;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\IconColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-user-group';

    protected static ?string $navigationLabel = 'Usuários';

    protected static ?string $modelLabel = 'Usuário';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->label('Email'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                    ->label('Senha'),
                Forms\Components\TextInput::make('password_confirmation')
                    ->password()
                    ->same('password')
                    ->label('Confirmação de senha'),
                Forms\Components\Select::make('document_type')
                    ->label('Tipo de Documento')
                    ->options([
                        'CPF' => 'CPF',
                        'CNPJ' => 'CNPJ',
                    ]),
                Forms\Components\TextInput::make('document_number'),
                Forms\Components\TextInput::make('phone')
                    ->label('Telefone'),
                Forms\Components\Toggle::make('status')
                ->label('Status'),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) User::count();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(User::orderByDesc('created_at'))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Nome'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->label('Email'),
                Tables\Columns\TextColumn::make('document_type')->label('Tipo de Documento'),
                Tables\Columns\TextColumn::make('document_number')->label('Documento'),
                Tables\Columns\TextColumn::make('phone')->label('Telefone'),
                IconColumn::make('status')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('Criado em')->dateTime('d/m/Y H:i:s'),
                Tables\Columns\TextColumn::make('updated_at')->label('Atualizado em')->dateTime('d/m/Y H:i:s'),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                Filter::make('name')
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->placeholder('Nome'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query->when($data['name'], fn ($query, $name) => $query->where('name', 'like', "%{$name}%"))),
                TernaryFilter::make('status')
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->iconButton()
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
            //j
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
}
