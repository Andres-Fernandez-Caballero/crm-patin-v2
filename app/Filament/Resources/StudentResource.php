<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Payment;
use App\Models\Student;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Log;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Gestión';

    protected static ?string $label = 'Alumnos';



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
                    ->relationship('topics', 'name'),
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

                Tables\Columns\TextColumn::make('state')
                ->badge()
                ->color(function(string $state){
                    switch ($state) {
                            case 'regular':
                                return 'success';
                            case 'pago pendiente':
                                return 'danger';
                            }
                        return 'warning';
                }),

                Tables\Columns\TextColumn::make('topics.name')
                    ->badge()
                    ->label('Disciplinas')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('email')
                //   ->label('Email')
                // ->sortable(),
                //Tables\Columns\TextColumn::make('birth_date')
                //  ->label('Fecha de nacimiento')  
                //->sortable(),
            ])->defaultSort('names', 'asc')
            ->filters([])
            ->actions([
                Tables\Actions\Action::make('form')
                    ->label('Nuev Pago')
                    ->form([
                        Fieldset::make('Facturacion')
                            ->schema([
                                Forms\Components\TextInput::make('total_amount')
                                    ->numeric()
                                    ->label('monto a pagar')
                                    //->afterStateUpdated(fn(GET $get, Set $set, ?string $old) => $get('is_expired')? $set('total_amount', $get('total_amount')* 1.5 ): $set('total_amount', $old) )
                                    ->prefix('ARS$')
                                    ->default(
                                        fn (Student $student) =>
                                        $student->topics()->sum('price')
                                    ),

                                Forms\Components\Toggle::make('is_expirated')
                                    ->label('pago vencido')
                                    ->afterStateUpdated(
                                        fn (Get $get, SET $set, $state) =>
                                        $state ? $set('total_amount', $get('total_amount') * 1.15)
                                            : $set('total_amount', $get('total_amount') / 1.15)
                                    )
                                    ->inline(false)
                                    ->live(onBlur: true),
                            ]),

                        FieldSet::make('fecha')
                            ->schema([
                                Forms\Components\DatePicker::make('payment_date_open')
                                    ->label('Fecha del mes en curso pago')
                                    ->default(Carbon::now()->toISOString()),

                                Forms\Components\DatePicker::make('payment_date_paid')
                                    ->label('fecha de facturacion')

                            ])


                    ])->action(function (array $data, Student $student): void {

                        Payment::create([
                            'total_amount' => $data['total_amount'],
                            'payment_date_open' => $data['payment_date_open'],
                            'student_id' => $student->id
                        ]);
                    }),

                Tables\Actions\EditAction::make()
                    ->label('Editar'), // Cambiar el texto de la acción de edición 
                Tables\Actions\ViewAction::make()
                    ->label('Ver')
                    ->modalHeading('Detalle de alumno'),
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

    //Contador en barra lateral.
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
