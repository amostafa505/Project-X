<?php

namespace App\Filament\Tenant\Resources\Hospital\Order\Pages;

use App\Filament\Tenant\Resources\Hospital\Order\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
