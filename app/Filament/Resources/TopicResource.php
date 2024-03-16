<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TopicResource\Pages;
use App\Filament\Resources\TopicResource\RelationManagers;
use App\Models\Topic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TopicResource extends Resource
{
    protected static ?string $model = Topic::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Gestión';

    protected static ?string $label = 'Disciplinas';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nombre')
                ->required(),
            Forms\Components\TextInput::make('price')
                ->label('Precio')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->label('Nombre')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('students_count')->counts('students')
            ->label('Cantidad de alumnos'),
            
            
            Tables\Columns\TextColumn::make('price')
                ->label('Precio')
                ->searchable()
                ->sortable(),
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->label('Editar'), // Cambiar el texto de la acción de edición
                Tables\Actions\DeleteAction::make()
                ->label('Eliminar disciplina') // Cambiar la etiqueta de la acción de eliminación
                        ->successNotificationTitle('Disciplina eliminada correctamente')
                        ->modalDescription('¿Estás segura? Esta acción es irreversible.')
                        ->modalHeading('Eliminar disciplina')
                        ->modalCancelActionLabel('Cancelar')
                        ->modalSubmitActionLabel('Si, eliminar')
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->label('Eliminar disciplina') // Cambiar la etiqueta de la acción de eliminación
                    ->successNotificationTitle('Disciplina eliminada correctamente')
                    ->modalDescription('¿Estás segura? Esta acción es irreversible.')
                    ->modalHeading('Eliminar disciplina')
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
            'index' => Pages\ListTopics::route('/'),
            'create' => Pages\CreateTopic::route('/create'),
            'edit' => Pages\EditTopic::route('/{record}/edit'),
        ];
    }

    
    //Contador en barra lateral.
    public static function getNavigationBadge(): ?string
    {
        return static ::getModel()::count();
    }
}
