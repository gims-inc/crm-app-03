<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;

use App\Models\Product;
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
use App\Utilz\Utils;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'Technical';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        $batchNumber = Utils::setBatchNumber();
        $serialNumber = Utils::setSerialNumberTwo();

        return $form
            ->columns(1)
            ->schema([
                //
                Select::make('product_name')
                        ->required()
                        ->options([
                            'BATTERY' => 'Battery',
                            'LAMP' => 'Lamp',
                            // 'SOLAR' => 'Solar',
                         ]),
                Forms\Components\TextInput::make('serial_number')
                                            ->required()
                                            ->unique()
                                            ->default($serialNumber),
                Forms\Components\TextInput::make('batch_number')
                                        ->required()
                                        ->default($batchNumber),
                Forms\Components\TextInput::make('where_at')
                                            ->required()
                                            ->datalist([
                                               'production',
                                               'repairs',
                                               'field',
                                            ])
                // Forms\Components\TextInput::make('staff_id')->email()->required(),
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('product_name'),
                Tables\Columns\TextColumn::make('serial_number')->searchable(),
                Tables\Columns\TextColumn::make('batch_number'),
                Tables\Columns\TextColumn::make('where_at'),
                Tables\Columns\TextColumn::make('account.account_number')->label('Account'),// ToDo
                Tables\Columns\TextColumn::make('user.name')->label('Created By'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            // 'view' => Pages\ViewProduct::route('/{record}'),
            // 'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }    
}
