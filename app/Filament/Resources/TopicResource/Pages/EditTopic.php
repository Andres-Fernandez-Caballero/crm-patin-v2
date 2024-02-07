<?php

namespace App\Filament\Resources\TopicResource\Pages;

use App\Filament\Resources\TopicResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTopic extends EditRecord
{
    protected static string $resource = TopicResource::class;
    
    protected function getCreatedNotificationTitle(): ?String
    {   
        return 'Disciplina editada correctamente';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->label('Eliminar disciplina') // Cambiar la etiqueta de la acción de eliminación
            ->successNotificationTitle('Disciplina eliminada correctamente')
            ->modalHeading('Eliminar disciplina')
            ->modalDescription('¿Estás segura? Esta acción es irreversible.')
            ->modalSubmitActionLabel('Si, eliminar')
            ->modalCancelActionLabel('Cancelar')
        ];
    }
}
