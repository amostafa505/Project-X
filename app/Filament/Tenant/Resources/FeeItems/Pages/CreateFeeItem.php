<?php

namespace App\Filament\Tenant\Resources\FeeItems\Pages;

use App\Filament\Tenant\Resources\FeeItems\FeeItemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFeeItem extends CreateRecord
{
    protected static string $resource = FeeItemResource::class;
}
