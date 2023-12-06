<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountResource\Pages;
use App\Filament\Resources\AccountResource\RelationManagers;

use App\Models\Account;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\ViewField;

use Filament\Tables\Actions\Action;

// use Filament\Resources\Tables\Table;
// use Filament\Tables\RecordActions\Link;

use App\Utilz\Utils;


class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static ?string $navigationGroup = 'Main';

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static string $view = 'filament.accounts.manage-account';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {

        $accountNumber = Utils::generateUniqueAccountNumber();

        return $form
        ->columns(1)
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Assign acount number')
                    ->columns(2)
                    ->schema([
                        // ...
                        TextInput::make('account_number')
                                    ->default($accountNumber),
                    ]),
                Wizard\Step::make('Assign Package')
                ->columns(2)
                    ->schema([
                        // ...
                        Select::make('package_id')
                            ->relationship(name: 'package', titleAttribute: 'package_name')
                            ->searchable()
                            ->preload(),
                    ]),
                Wizard\Step::make('Assign product')
                    ->columns(2)
                    ->schema([
                        // ...
                        Select::make('product_id')
                            ->relationship(name: 'product', titleAttribute: 'serial_number')
                            ->searchable()
                            ->preload()
                            ->unique(),
                    ]),
                Wizard\Step::make('Assign customer')
                    ->columns(2)
                    ->schema([
                        // ...
                        Select::make('customer_id')
                            ->relationship(name: 'customer', titleAttribute: 'national_id')
                            ->searchable()
                            ->preload(),
                    ]),
                Wizard\Step::make('Activate')
                    ->columns(1)
                    ->schema([
                        Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'active' => 'Active',
                            'suspended' => 'Suspended',
                            'closed' => 'Closed',
                         ]),
                        ]),
                    ]),            
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('account_number')->searchable(),
                // Tables\Columns\TextColumn::make('customer.first_name'.'customer.last_name')->label('Customer')->searchable(),
                Tables\Columns\TextColumn::make('customer.national_id')->label('Customer Id')->searchable(),
                Tables\Columns\TextColumn::make('package.package_name')->label('Package'),
                Tables\Columns\TextColumn::make('product.product_name')->label('Product'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('user.name')->label('Created By'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\ViewAction::make(),
                Action::make('view')
                    ->color('success')
                    ->icon('heroicon-o-document-text')
                    ->label('Manage')
                    ->url(fn ($record) => static::getUrl('manage', ['record' => $record])),
                    // ->getUrl('/{record}/manage'),
                    // ->url(fn (Account $record): string => route('accounts.manage', $record)), //ToDo
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // protected function getTableActions(): array
    // {
    //     return [
    //         Tables\Actions\ActionGroup::make([
    //             Tables\Actions\ViewAction::make(),
    //             Tables\Actions\EditAction::make(),
    //             Tables\Actions\DeleteAction::make(),
    //         ]),
    //     ];
    // }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            // 'view' => Pages\ViewAccount::route('/{record}'),
            'manage' => Pages\ManageAccount::route('/{record}/manage'),
            // 'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }

}
