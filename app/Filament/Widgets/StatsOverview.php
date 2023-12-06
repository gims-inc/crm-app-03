<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget\Card;

use App\Models\Customer;
use App\Models\Account;
use App\Models\Product;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //
            Card::make('Total Customers', Customer::query()->count())->color('success'),
            Card::make('Total Accounts', Account::query()->count()),
            Card::make('Total Products', Product::query()->count()),
            Card::make('Total  Field Products', Product::query()->where('where_at','field')->count()),
        ];
    }

}
