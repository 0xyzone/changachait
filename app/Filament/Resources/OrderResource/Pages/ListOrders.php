<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Filament\Actions;
use App\Filament\Exports\OrderExporter;
use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Exports\Enums\ExportFormat;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ExportAction::make()
                ->exporter(OrderExporter::class)
                ->formats([
                    ExportFormat::Csv,
                ]),
        ];
    }
}
