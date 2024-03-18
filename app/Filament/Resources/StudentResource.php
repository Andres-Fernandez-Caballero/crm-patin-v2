<?php

namespace App\Filament\Resources;

use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
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
use Filament\Tables\Actions\BulkAction;
use Illuminate\Support\Facades\Log;

use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Title;
use PHPUnit\TestRunner\TestResult\Collector;

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
                    ->native(false)
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
        return $table->paginated(false)
            
            ->columns([
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Apellidos')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('names')
                    ->label('Nombres')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dni')
                    ->label('DNI')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\SelectColumn::make('state')
                    ->label('Estado de pago')
                    ->selectablePlaceholder(false)
                    ->options([
                        'regular' => 'regular',
                        'pago pendiente' => 'pago pendiente',
                        'inactivo' => 'inactivo',
                    ])
                    ->searchable(),


                Tables\Columns\TextColumn::make('topics.name')
                    ->badge()
                    ->label('Disciplinas')
                    ->searchable(),
            ])->defaultSort('last_name', 'asc')

            ->filters([
                // get students by current month
                Filter::make('payment_date_paid')
                    ->label('Pagos pendientes')
                    ->checkbox()
                    ->default()
                    ->default(true)
                    ->query(fn (Builder $query) => $query->where('state', 'pago pendiente')),
                //Mostrar los estudiantes inactivos
                Filter::make('state')
                    ->label('Mostrar Inactivos')
                    ->checkbox()
                    ->default(false)
                    ->query(fn (Builder $query) => $query->where('state', 'inactivo')),

            ])
            ->actions([
                Tables\Actions\Action::make('form')
                    ->label('Nuevo Pago')
                    ->hidden(fn (Student $student) => $student->state != 'pago pendiente')
                    ->modalDescription(fn (Student $student) => 'Cuota de ' . $student->names . ' ' . $student->last_name)
                    ->form([

                        Fieldset::make('Facturacion')
                            ->schema([
                                Forms\Components\TextInput::make('total_amount')
                                    ->numeric()
                                    ->label('Monto a pagar')
                                    ->prefix('ARS$')
                                    ->default(
                                        fn (Student $student) =>
                                        $student->topics()->sum('price')
                                    ),

                                Forms\Components\Toggle::make('is_expirated')
                                    ->onIcon('heroicon-m-currency-dollar')
                                    ->offIcon('heroicon-m-currency-dollar')
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->label('Pago vencido')
                                    ->afterStateUpdated(
                                        fn (Get $get, SET $set, $state) =>
                                        $state ? $set('total_amount', $get('total_amount') * 1.1)
                                            : $set('total_amount', $get('total_amount') / 1.1)
                                    )
                                    ->inline(false)
                                    ->live(onBlur: true),

                                Forms\Components\Toggle::make('month_expirated')
                                    ->onIcon('heroicon-m-currency-dollar')
                                    ->offIcon('heroicon-m-currency-dollar')
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->label('Mes vencido')
                                    ->afterStateUpdated(
                                        fn (Get $get, SET $set, $state) =>
                                        $state ? $set('total_amount', $get('total_amount') * 1.2)
                                            : $set('total_amount', $get('total_amount') / 1.2)
                                    )
                                    ->inline(false)
                                    ->live(onBlur: true),
                            ]),

                        FieldSet::make('Fecha')
                            ->schema([
                                Forms\Components\DatePicker::make('payment_date_open')
                                    ->label('Mes abonado')->default(Carbon::now()->toISOString()),

                                Forms\Components\DatePicker::make('payment_date_paid')
                                    ->label('Fecha de cobro')
                                    ->required()

                            ])


                    ])
                    ->action(function (array $data, Student $student): void {

                        Payment::create([
                            'total_amount' => $data['total_amount'],
                            'payment_date_open' => $data['payment_date_open'],
                            'student_id' => $student->id
                        ]);
                        $student->update(['state' => 'regular']);
                    }),

                Tables\Actions\EditAction::make()
                    ->label('Editar'), // Cambiar el texto de la acción de edición 
                Tables\Actions\ViewAction::make()
                    ->label('Ver')
                    ->modalHeading('Detalle de alumno'),
            ])
            ->bulkActions([
                ExportBulkAction::make()
                ->label('Exportar a excel.'),

                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('setInactive')
                        ->icon('heroicon-o-arrow-path')
                        ->label('Establecer pagos pendientes')
                        ->color('warning')
                        ->action(
                            fn (Collection $students) => $students->where('state', '!=', 'inactivo')->each(fn (Student $student) => $student->update(['state' => 'pago pendiente']))
                        ),
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
