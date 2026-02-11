<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Product', Product::count()),
            Stat::make('Total Stock', Product::sum('stock')),
            Stat::make('Total Value', 'Rp ' . number_format(Product::query()->sum(DB::raw('price * stock')), 0, ',', '.')),
        ];
    }
}
