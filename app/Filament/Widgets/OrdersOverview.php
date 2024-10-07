<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class OrdersOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';
    protected function getStats(): array
    {
        $grandTotalSum = Order::sum('grand_total');
        $earnings = $grandTotalSum * 0.85;
        $toProvide = $grandTotalSum - $earnings;
        return [
            Card::make('Total Sales', 'Rs. ' . number_format($grandTotalSum, 2))
                ->description('Sum of all grand totals')
                ->color('success'),
            Card::make('Total Earning', 'Rs. ' . number_format($earnings, 2))
                ->description('Earnings so far')
                ->color('success'),
            Card::make('To Provide', 'Rs. ' . number_format($earnings, 2))
                ->description('Amount to deposit to Mice Events.')
                ->color('success'),
        ];
    }
}
