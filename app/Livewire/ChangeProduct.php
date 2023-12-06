<?php

namespace App\Livewire;

use Filament\Actions\Action;
// use Filament\Infolists\Components\Actions;
// use Filament\Infolists\Components\Actions\Action;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;

use Filament\Forms\Components\TextInput;

use Livewire\Component;

class ChangeProduct extends Component implements HasForms, HasActions
{

    use InteractsWithActions;
    use InteractsWithForms;



    public function render()
    {
        return view('livewire.change-product');
    }


    public static function editAction(): Action
    {
        return 
        // ActionGroup::make([
        //     Action::make('view'),
        //     Action::make('edit'),
        //     Action::make('delete'),
        // ]);
        
        Action::make('Change product')
            ->form([
                // ...
                TextInput::make('product_id')
                            ->required(),
            ])
            // ...
            ->action(function (array $arguments) {
                // $account = Account::find($arguments['account']);
    
                // ...
    
                // $this->replaceMountedAction('publish', $arguments);
            });
    }
}
