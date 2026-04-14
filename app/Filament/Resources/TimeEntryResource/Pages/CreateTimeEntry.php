<?php

namespace App\Filament\Resources\TimeEntryResource\Pages;

use App\Filament\Resources\TimeEntryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTimeEntry extends CreateRecord
{
    protected static string $resource = TimeEntryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Se è un Operator, forza user_id al proprio ID (il campo è nascosto nel form)
        if (auth()->user()->isOperator()) {
            $data['user_id'] = auth()->id();
        }

        return $data;
    }
}
