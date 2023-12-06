<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;

// use Filament\Pages\Actions\CreateAction;
// use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Fieldset;

// use App\Filament\Resources\CustomerResource\Forms\CreateCustomerForm;
// use Filament\Forms;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationGroup = 'Main';

    protected static ?string $navigationIcon = 'heroicon-m-user-group';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create($data);
    }

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $data['staff_id'] = auth()->id();

    //     // $phoneNumbers = (Object)[
    //     //     'primary' => $data['primary_number'],
    //     //     'secondary' => $data['secondary_number'],
    //     // ];
    
    //     // // Assign the combined phone numbers to the 'phone_number' field
    //     // $data['phone_number'] = $phoneNumbers;

    //     // $Primary_contact_person = (Object)[
    //     //     'name' => $data['first_contact_name'],
    //     //     'number' => $data['first_contact_number'],
    //     // ];

    //     // $data['first_contact'] = $Primary_contact_person;
        
    //     // $secondary_contact_person = (Object)[
    //     //     'name' => $data['second_contact_name'],
    //     //     'number' => $data['second_contact_number'],
    //     // ];
      
    //     // $data['second_contact'] = $secondary_contact_person;

    //     // unset($data['primary_number']);
    //     // unset($data['secondary_number']);
    //     // unset($data['first_contact_name']);
    //     // unset($data['first_contact_number']);
    //     // unset($data['second_contact_name']);
    //     // unset($data['second_contact_number']);
    //     return $data;
    // }

    public static function form(Form $form): Form
    {
        return $form
        ->columns(2)
        ->schema([
            // First Fieldset
            Fieldset::make('Personal Information')
            ->columns(2)
            ->schema([
                Forms\Components\TextInput::make('first_name')->autocapitalize()->required(),
                Forms\Components\TextInput::make('last_name')->autocapitalize()->required(),
                Forms\Components\TextInput::make('other_name')->autocapitalize(),
                Forms\Components\TextInput::make('national_id')->required(),
                Forms\Components\TextInput::make('email')->email()->required(),
                Forms\Components\TextInput::make('address')->required(),
                Forms\Components\TextInput::make('primary_phone_number')
                    ->tel()
                    ->placeholder('0700123456')
                    ->required(),
                Forms\Components\TextInput::make('secondary_phone_number')
                    ->tel()
                    ->placeholder('0700123456'),
            ]),
        
            // Second Fieldset
            
            Fieldset::make('Contact Persons')
            ->columns(2)
            ->schema([
                Forms\Components\TextInput::make('first_contact_name')->autocapitalize()->required(),
                Forms\Components\TextInput::make('first_contact_number')
                    ->tel()
                    ->placeholder('0700123456')
                    ->required(),
                Forms\Components\TextInput::make('second_contact_name')->autocapitalize(),
                Forms\Components\TextInput::make('second_contact_number')
                    ->tel()
                    ->placeholder('0700123456'),
            ]),
        
            // Third Fieldset
            Fieldset::make('Location Information')
            ->columns(2)
            ->schema([
                // Forms\Components\TextInput::make('longitude'),
                // Forms\Components\TextInput::make('latitude'),
                Forms\Components\TextInput::make('town')->autocapitalize()->required(),
                Forms\Components\TextInput::make('village')->autocapitalize()->required(),
                // Forms\Components\TextInput::make('staff_id')->hidden(),
                // Forms\Components\TextInput::make('account_number'),
            ]),
        
            
        ]);
        
            
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('account.account_number')->label('Accounts'),
                Tables\Columns\TextColumn::make('first_name'),
                Tables\Columns\TextColumn::make('last_name')->searchable(),
                Tables\Columns\TextColumn::make('national_id')->searchable(),
                // Tables\Columns\TextColumn::make('account_nmber'),
                Tables\Columns\TextColumn::make('address'),
                Tables\Columns\TextColumn::make('primary_phone_number')->searchable(),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('town'),
                Tables\Columns\TextColumn::make('village'),
                
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([

                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
        ];
    }    
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
