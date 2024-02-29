<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Log;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $label = 'Cuotas';

    protected static ?string $navigationGroup = 'Facturacion';

    public static function formCreatePayment(): array
    {
        // pendiente
        return [];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->relationship('student.name')
                    ->preload(),
                Forms\Components\TextInput::make('total_amount')
                    ->numeric()
                    ->label('Monto a pagar')
                    //->afterStateUpdated(fn(GET $get, Set $set, ?string $old) => $get('is_expired')? $set('total_amount', $get('total_amount')* 1.5 ): $set('total_amount', $old) )
                    ->prefix('ARS$')
                    ->default(
                        fn (Student $student) =>
                        $student->topics()->sum('price')
                    ),

                Forms\Components\Toggle::make('is_expirated')
                    ->label('Pago vencido')
                    ->afterStateUpdated(
                        fn (Get $get, SET $set, $state) =>
                        $state ? $set('total_amount', $get('total_amount') * 1.15)
                            : $set('total_amount', $get('total_amount') / 1.15)
                    )
                    ->inline(false)
                    ->live(onBlur: true),

                Forms\Components\DatePicker::make('payment_date_open')
                    ->label('Mes abonado.')
                    ->default(Carbon::now()->toISOString()),

                Forms\Components\DatePicker::make('payment_date_paid')
                    ->label('Fecha de cobro.')



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.last_name')
                ->label ('Apellido')
                ->searchable()
                ->sortable(),

                TextColumn::make('student.names')
                ->label ('Alumno')
                ->searchable()
                ->sortable(),

                TextColumn::make('is_paid')
                ->label ('Estado de pago')
                    ->color(function (string $state) {
                        
                        switch ($state) {
                            case 'pago':
                                return 'success';
                            case 'pendiente':
                                return 'danger';
                        }
                    })
            ])->defaultSort('student.last_name', 'asc')
            ->filters([
                Filter::make('pago pendiente')
                    ->query(fn (Builder $query) => $query->where('payment_date_paid', null))
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
