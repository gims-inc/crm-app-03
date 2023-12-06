<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

use Illuminate\Database\Eloquent\Model;

class ManageCustomers extends ManageRecords
{
    protected static string $resource = CustomerResource::class;
    

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['staff_id'] = auth()->id();
        return $data;
    }

    // protected function handleRecordCreation(array $data): Model
    // {
    //     return static::getModel()::create($data);
    // }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
