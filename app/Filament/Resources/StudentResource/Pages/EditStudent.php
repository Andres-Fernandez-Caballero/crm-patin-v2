<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;
 

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->label('Eliminar patinador') // Cambiar la etiqueta de la acción de eliminación
            ->successNotificationTitle('Usuario eliminado correctamente')
            ->modalHeading('Eliminar patinador')
            ->modalDescription('¿Estás segura? Esta acción es irreversible.')
            ->modalSubmitActionLabel('Si, eliminar')
            ->modalCancelActionLabel('Cancelar')
        ];
    }
}
