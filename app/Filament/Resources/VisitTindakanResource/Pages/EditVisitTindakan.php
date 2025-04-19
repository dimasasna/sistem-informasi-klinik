<?php

namespace App\Filament\Resources\VisitTindakanResource\Pages;

use App\Filament\Resources\VisitTindakanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVisitTindakan extends EditRecord
{
    protected static string $resource = VisitTindakanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
