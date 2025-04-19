<?php

namespace App\Filament\Resources\VisitTindakanResource\Pages;

use App\Filament\Resources\VisitTindakanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVisitTindakans extends ListRecords
{
    protected static string $resource = VisitTindakanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
