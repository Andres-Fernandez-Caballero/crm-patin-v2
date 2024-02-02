<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    ->label('Student'),
                Tables\Columns\TextColumn::make('student.last_name')
                    ->label('Last Name'),
                Tables\Columns\TextColumn::make('period_start')
                    ->label('Period Start'),
                Tables\Columns\ToggleColumn::make('is_paid')
                    ->label('Is Paid'),
                Tables\Columns\TextColumn::make('topics.name')
                    ->badge()
                    ->label('Topics'),

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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
