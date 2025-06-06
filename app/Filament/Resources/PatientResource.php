<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    #[\Override]
    public static function getModelLabel(): string
    {
        return __('Patient');
    }
    public static function getPluralModelLabel(): string
    {
        return __('Patients');
    }

    public static function form(Form $form): Form
    {
        return $form
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('type')
                        ->label('Tipo')
                        ->options([
                        'gato' => 'Gato',
                        'cachorro' => 'Cachorro',
                        'coelho' => 'Coelho',
                        ])
                        ->required(),
                    Forms\Components\DatePicker::make('date_of_birth')
                        ->label('Data de nascimento')
                        ->required()
                        ->maxDate(now()),
                        Forms\Components\Select::make('owner_id')
                        ->relationship('owner', 'name')
                        ->label('Proprietário')
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Endereço de email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('Número de telefone')
                            ->tel()
                            ->required(),
                        ])
                        ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo'),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->label('Data de nascimento')
                    ->sortable(),
                Tables\Columns\TextColumn::make('owner.name')
                    ->label('Proprietário')
                    ->searchable(),
            ])
            ->filters([
                //
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipo')
                ->options([
                    'gato' => 'Gato',
                    'cachorro' => 'Cachorro',
                    'coelho' => 'Coelho',
                
                ])
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
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
