<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Item;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\URL;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $activeNavigationIcon = 'heroicon-m-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Repeater::make('items')
                    ->relationship('items')
                    ->columnSpanFull()
                    ->collapsible()
                    ->itemLabel(function (array $state){
                        $item = Item::where('id', $state['item_id'])->first();
                        return $state['item_id'] ? $item->name . ($state['quantity'] ? ' (x' . $state['quantity'] . ') | रु. ' . $state['sub_total'] : '' ) : null;
                    }) 
                    ->schema([
                        Select::make('item_id')
                            ->required()
                            ->relationship('item', 'name')
                            ->searchable()
                            ->preload()
                            ->live(onBlur: true)
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                            ->columnSpan([
                                'md' => '8',
                            ]),
                        TextInput::make('quantity')
                            ->required()
                            ->numeric()
                            ->inputMode('decimal')
                            ->disabled(fn(Get $get) => !$get('item_id'))
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                $item = Item::where('id', $get('item_id'))->first();
                                $price = $item->price;
                                $sub_total = $price * $state;
                                $set('sub_total', $sub_total);

                                $items = $get('../../items');

                                $main_sub_total = array_reduce($items, function ($carry, $item) {
                                    return $carry + $item['sub_total'];
                                }, 0);

                                $set('../../sub_total', $main_sub_total);
                                $set('../../grand_total', $main_sub_total);
                                // $main_sub_total = sum($sub_totals['sub_total']);
                                // dd($main_sub_total);
                            })
                            ->step(0.50)
                            ->columnSpan([
                                'md' => '2',
                            ]),
                        TextInput::make('sub_total')
                            ->dehydrated()
                            ->prefix('रु')
                            ->disabled()
                            ->dehydrated()
                            ->columnSpan([
                                'md' => '2',
                            ])
                    ])->columns(12),
                Forms\Components\TextInput::make('sub_total')
                    ->required()
                    ->prefix('रु')
                    ->disabled()
                    ->dehydrated()
                    ->numeric(),
                Forms\Components\TextInput::make('grand_total')
                    ->required()
                    ->prefix('रु')
                    ->disabled()
                    ->dehydrated()
                    ->numeric(),
                Section::make('Payments')
                    ->schema([
                        Forms\Components\Select::make('payment_method')
                        ->options([
                            'esewa' => 'eSewa',
                            'fonepay' => 'FonePay',
                            'cash' => 'Cash',
                        ])
                        ->required()
                        ->default('cash'),
                        Forms\Components\TextInput::make('received_amount')
                            ->required()
                            ->prefix('रु')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                $grand_total = $get('grand_total');
                                $return_amount = $state ? $state - $grand_total : null;
                                $set('return_amount', $return_amount);
                            })
                            ->numeric(),
                        Forms\Components\TextInput::make('return_amount')
                            ->required()
                            ->prefix('रु')
                            ->disabled()
                            ->dehydrated()
                            ->numeric(),
                    ])
                    ->hidden(fn(Get $get) => !$get('grand_total'))
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('items.item.name')
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->badge(),
                Tables\Columns\TextColumn::make('sub_total')
                    ->prefix('रु ')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grand_total')
                    ->prefix('रु ')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('Print Invoice')
                    ->url(function (Model $record) {
                        return URL::route('invoice.print', ['order' => $record]);
                    }, shouldOpenInNewTab: true)
                    ->button()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
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
            'index' => Pages\ListOrders::route('/'),
            // 'create' => Pages\CreateOrder::route('/create'),
            // 'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
