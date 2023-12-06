<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Filament\Resources\AccountResource;
use Filament\Resources\Pages\Page;

// use App\Filament\Widgets\StatsOverviewWidget;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;

use Filament\Resources\Forms\Components;
use Filament\Resources\Tables\Table;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Fieldset;

use Filament\Infolists\Concerns\InteractsWithInfolists;

use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Tabs;
use Filament\Support\Enums\IconPosition;

// use Filament\Tables\Actions\Action;

use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AccountResource\RelationManagers;

use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action;

use Filament\Actions\EditAction;

// use App\Actions\ResetStars; //
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Set;

// use Filament\Tables;
// use Filament\Tables\Table;


use App\Livewire\ChangeProduct;
 
use App\Models\{Account, Product, Package, Payment, User};


class ManageAccount extends Page //
{

    // use InteractsWithForms;
    // use InteractsWithInfolists;


    public $user;
    public ?array $data = [];
    // public ?Account $account = null;
    public ?Account $record = null;


    protected static ?string $model = Account::class;

    protected static string $resource = AccountResource::class;

    protected static ?string $slug = 'manage';

    protected static string $view = 'filament.resources.account-resource.pages.manage-account';

  

    public function mount($record)
    {

        // dd($record);//

        $this->user = auth()->user();

        $this->accountInfolist;

        // $this->logsTable;
       
        // $this->account = $record; //Account::find($record);
        $this->record = $record;

       
    }

    public function form(Form $form):Form
    {
        return $form
            ->schema([
               
              ]);
    }
    

    public function logsTable(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('logs.created_at')->label('Time Created'),

                Tables\Columns\TextColumn::make('logs')->label('Info'),
                
                Tables\Columns\TextColumn::make('user.name')->label('Created By'),
            ])
            ->filters([
                //
             ]);
    }

  

    public function accountInfolist(Infolist $infolist): Infolist
    {
        // $accountData = $this->account;

        // dd($accountData);
        return $infolist
                ->record($this->record)
                // ->state([])
            ->schema([
                Tabs::make('Label')
                    ->tabs([
                        Tabs\Tab::make('Acccount Info')
                        ->icon('heroicon-m-adjustments-horizontal')
                        ->iconPosition(IconPosition::After)
                            ->schema([
                                // ...
                                Fieldset::make('Account information')
                                    ->columns(4)
                                    ->schema([
                                        TextEntry::make('account_number')
                                        ->label('Account Number:')
                                        ->copyable()
                                        ->copyMessage('Copied!'),

                                        // TextEntry::make('status')
                                        // ->label('Account Stattus:')
                                        // ->badge()
                                        // ->color(fn (string $state): string => match ($state) {
                                        //     'pending' => 'gray',
                                        //     'suspended' => 'warning',
                                        //     'active' => 'success',
                                        //     'closed' => 'danger',
                                        // }),
                                        TextEntry::make('user.created_at')->label('Date Created:'),
                                        TextEntry::make('user.name')->label('Created By:'),
                                        TextEntry::make('user.updated_at')->label('Last modified:'),
                                    // TextEntry::make('category.name'),
                                    ]),
                                Fieldset::make('Actions')
                                    ->columns(3)
                                    ->schema([

                                        TextEntry::make('status')
                                                    // ->hidden()
                                                    ->label('Account Status:')
                                                    ->badge()
                                                    ->color(fn (string $state): string => match ($state) {
                                                        'pending' => 'gray',
                                                        'suspended' => 'warning',
                                                        'active' => 'success',
                                                        'closed' => 'danger',
                                                    })
                                                    ->prefix('')
                                                    ->hintAction(
                                                                    Action::make('Change account status')
                                                                    ->icon('heroicon-m-x-mark')
                                                                    ->color('warning')
                                                                    // ->columns(2)
                                                                    ->form([
                                                                        Select::make('status')
                                                                            ->label('Account status:')
                                                                            ->options([
                                                                                'pending' => 'Pending',
                                                                                'active' => 'Active',
                                                                                'suspended' => 'Suspended',
                                                                                'closed' => 'Closed',
                                                                            ])
                                                                            ->required(),
                                                                    ])
                                                                    ->action(function (array $data, Account $record): void {
                                                                        // $record->account()->associate($data['id']);
                                                                        $record->save();
                                                                    })
                   
                                                                ),
                                                                            
                                        // ButtonLink::make('edit')->route('platform.systems.users.edit',$this->record)->title(__('Edit')) 
                                    ]),

                            ]),
                        Tabs\Tab::make('Customer Info')
                        ->icon('heroicon-s-user-plus')
                        ->iconPosition(IconPosition::After)
                        
                            ->schema([
                                // ...
                                Fieldset::make('Personal Information')
                                        ->columns(3)
                                        ->schema([
                                        TextEntry::make('customer.first_name')->label('Customer first name:'),
                                        TextEntry::make('customer.last_name')->label('Customer last name:'),
                                       
                                        TextEntry::make('customer.national_id')->label('National ID:'),      
                                        
                                    ]),

                                Fieldset::make('Contact Information')
                                    ->columns(4)
                                    ->schema([
                                        TextEntry::make('customer.primary_phone_number')->label('Primary Phone Number:'),
                                        TextEntry::make('customer.Secondary_phone_number')->label('Secondary Phone Number:'),
                                        TextEntry::make('customer.address')->label('Address:'),
                                        TextEntry::make('customer.email')->label('Email:'),

                                    ]),

                                Fieldset::make('Location')
                                    ->schema([
                                        TextEntry::make('customer.village')->label('Village:'),
                                        TextEntry::make('customer.town')->label('Town:'),

                                    ]),

                                Fieldset::make('Contact Persons')
                                ->columns(4)
                                ->schema([
                                    // ...
                                    TextEntry::make('customer.first_contact_name')->label('First contact person:'),
                                    TextEntry::make('customer.first_contact_number')->label('Phone Number:'),
                                    TextEntry::make('customer.second_contact_name')->label('Second contact person:'),
                                    TextEntry::make('customer.second_contact_number')->label('Phone Number:'),
                                ]),
                        ]),
                            
                        Tabs\Tab::make('Package Info')
                        ->icon('heroicon-m-gift-top')
                        ->iconPosition(IconPosition::After)
                            ->schema([
                                // ...
                                Fieldset::make('Package')
                                    ->columns(3)
                                    ->schema([
                                    
                                        TextEntry::make('package.package_name')->label('Package:'),
                                        TextEntry::make('package.daily_payment')->label('Daily Charge:'),
                                        TextEntry::make('package.total_amount')->label('Amount Payed:'),  //ToDo
                                        TextEntry::make('package.total_amount')->label('Remaining Amount:'),  //ToDo
                                        TextEntry::make('package.total_amount')->label('Total Amount:'),
 
                                    ]),
                               
                                
                                Fieldset::make('Actions')
                                    ->columns(3)
                                    ->schema([
                                    
                                        // ButtonLink::make('edit')->route('platform.systems.users.edit',$this->record)->title(__('Edit')) 
                                    ]),
                            ]),
                        Tabs\Tab::make('Product Info')
                        ->icon('heroicon-s-fire')
                        ->iconPosition(IconPosition::After)
                            ->schema([
                                // ...
                                Fieldset::make('Product')
                                    ->columns(3)
                                    ->schema([
                                        TextEntry::make('product.product_name')->label('Product:'),
                                        TextEntry::make('product.serial_number')
                                        ->label('Serial Number:')
                                        ->copyable()
                                        ->copyMessage('Copied!'),
                                        
                                        TextEntry::make('product.batch_number')->label('MFG:')->dateTime('D d,M,Y'),
                                    
                                    ]),
                                

                                Fieldset::make('Actions')
                                    ->columns(3)
                                    ->schema([

                                         TextEntry::make('serial_number')
                                                    ->label('Product:')
                                                    ->prefix('')
                                                    ->hintAction(
                                                            Action::make('Change Product')
                                                                    ->icon('heroicon-m-x-mark')
                                                                    ->color('warning')
                                                                    // ->columns(2)
                                                                    ->form([
                                                                        Select::make('serial_number')
                                                                            ->label('Product')
                                                                            ->options(Product::query()->pluck('serial_number', 'id'))
                                                                            ->searchable()
                                                                            ->unique()
                                                                            ->required(),
                                                                    ])
                                                                    ->action(function (array $data, Account $record): void {
                                                                        $record->account()->associate($data['id']);
                                                                        $record->save();
                                                                    })
                   
                                                                ),
                                                                                            

                                        ]),
                                    
                            
                            ]),
                        Tabs\Tab::make('Logs')
                        ->icon('heroicon-s-bars-4')
                        ->iconPosition(IconPosition::After)
                            ->schema([
                                // ...
                            ]),
                        Tabs\Tab::make('Notes')
                        ->icon('heroicon-o-eye-dropper')
                        ->iconPosition(IconPosition::After)
                            ->schema([
                                // ...
                            ]),
                    ])
                    ->activeTab(1)

            ]);
    }

    


   
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function view(): View
    {
        
        return view('filament.resources.account-resource.pages.manage-account', compact('user'));
    }

}
