<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\TextInput::make('names')
                    ->label('Nombres')
                    ->required(),
                Forms\Components\TextInput::make('last_name')
                    ->label('Apellidos')
                    ->required(),
                Forms\Components\TextInput::make('dni')
                    ->label('DNI')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->required(),
                    Forms\Components\Select::make('topics')
                    ->label('Disciplinas')
                    ->preload()
                    ->multiple()
                    ->relationship('topics', 'name')
                    ,
                Forms\Components\DatePicker::make('birth_date')
                    ->label('Fecha de nacimiento')
                    ->required(),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('names')
                    ->label('Nombres')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Apellidos')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dni')
                    ->label('DNI')
                    ->searchable()
                    ->sortable(),

                    Tables\Columns\TextColumn::make('topics.name')
                    ->badge()
                    ->label('Disciplinas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->sortable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->label('Fecha de nacimiento')  
                    ->sortable(),
            ])
            ->filters([
                
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar') // Cambiar el texto de la acción de edición
                

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->label('Eliminar patinador') // Cambiar la etiqueta de la acción de eliminación
                    ->successNotificationTitle('Usuario eliminado correctamente')
                    ->modalDescription('¿Estás segura? Esta acción es irreversible.')
                    ->modalHeading('Eliminar patinador')
                    ->modalCancelActionLabel('Cancelar')
                    ->modalSubmitActionLabel('Si, eliminar')    
                ])->label('Acciones') // Cambiar la etiqueta del grupo de acciones
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
