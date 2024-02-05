<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Facturacion';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }
  
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.names')
                    ->label('Nombre'),
                Tables\Columns\TextColumn::make('student.last_name')
                    ->label('Apellido'),
                Tables\Columns\TextColumn::make('period_start')
                ->searchable()
                    ->label('Cuota'),
                Tables\Columns\ToggleColumn::make('is_paid')
                    ->label('¿Pagó?'),
                Tables\Columns\TextColumn::make('topics.name')
                    ->badge()
                    ->label('Disciplinas'),

            ])
            ->filters([
                // get students by current month

                Filter::make('period_start')
                    ->label('Mes en Curso')
                    ->toggle()
                    ->default()
                    ->query(
                        function (Builder $query) {
                            $query->whereMonth('period_start', now()->month);
                        }
                    ),
                SelectFilter::make('mensual')
                ->label('mes')
                ->options([
                    1 => 'Enero',
                    2 => 'Febrero'
                ])
                ->native(false)
                ->query(
                    function(Builder $query){
                        $query->whereMonth('period_start',2);
                    }
                ),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar') // Cambiar el texto de la acción de edición
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->label('Eliminar cuota') // Cambiar la etiqueta de la acción de eliminación
                    ->successNotificationTitle('Cuota eliminada correctamente')
                    ->modalDescription('¿Estás segura? Esta acción es irreversible.')
                    ->modalHeading('Eliminar cuota')
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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
