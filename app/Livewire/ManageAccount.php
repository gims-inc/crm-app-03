<?php

namespace App\Livewire;

use App\Models\Account;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;

use Livewire\Component;

class ManageAccount extends Component implements HasForms, HasActions
{

    use InteractsWithActions;
    use InteractsWithForms;


    public function render()
    {
        return view('livewire.manage-account');
    }
}
