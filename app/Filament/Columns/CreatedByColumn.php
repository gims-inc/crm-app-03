<?php

namespace App\Filament\Columns;

use Filament\Tables\Columns\Column;

class CreatedByColumn extends Column
{
    // public function view(): string
    // {
    //     return 'custom-columns.created-by'; // Replace with the actual view path.
    // }
    
    public function getValue($record)
    {
        $user = \App\Models\User::find($record->staff_id);

        if ($user) {
            return $user->name;
        }

        return '';
    }
}
