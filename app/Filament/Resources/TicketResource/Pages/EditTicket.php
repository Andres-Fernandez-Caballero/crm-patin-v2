<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->successNotificationTitle('Cuota eliminada correctamente')
            ->modalHeading('Eliminar cuota')
            ->modalDescription('¿Estás segura? Esta acción es irreversible.')
            ->modalSubmitActionLabel('Si, eliminar')
            ->modalCancelActionLabel('Cancelar')
        ];
    }
}
