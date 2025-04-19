<?php

namespace App\Filament\Resources\VisitObatResource\Pages;

use App\Filament\Resources\VisitObatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVisitObats extends ListRecords
{
    protected static string $resource = VisitObatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
