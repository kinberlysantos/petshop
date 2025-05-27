<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TreatmentResource\Pages;
use App\Filament\Resources\TreatmentResource\RelationManagers;
use App\Models\Treatment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TreatmentResource extends Resource
{
    protected static ?string $model = Treatment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    #[\Override]
    public static function getModelLabel(): string
    {
        return __('Treatment');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Select::make('patient_id')
                ->relationship('patient', 'name')
                ->label('Paciente')
                ->searchable()
                ->preload()
                ->required(),
                Forms\Components\TextInput::make('description')
                ->label('Descrição')
                ->required()
                ->maxLength(255)
                ->columnSpan('full'),
            Forms\Components\Textarea::make('notes')
                ->label('Observações')
                ->maxLength(65535)
                ->columnSpan('full'),
            Forms\Components\TextInput::make('price')
                ->label('Preço')
                ->numeric()
                ->required()
                ->prefix('R$')
                ->maxValue(42949672.95),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('patient.name')
                    ->label('Paciente')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição'),
                Tables\Columns\TextColumn::make('notes')
                    ->label('Observações'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Preço')
                    ->money('BRL')
                    ->sortable(),
                    Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime(),
                    
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
            'index' => Pages\ListTreatments::route('/'),
            'create' => Pages\CreateTreatment::route('/create'),
            'edit' => Pages\EditTreatment::route('/{record}/edit'),
        ];
    }
}
