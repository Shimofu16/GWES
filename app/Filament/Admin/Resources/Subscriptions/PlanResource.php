<?php

namespace App\Filament\Admin\Resources\Subscriptions;

use App\Enums\BillingCycleEnum;
use App\Enums\PlanTypeEnum;
use App\Filament\Admin\Resources\Subscriptions\PlanResource\Pages;
use App\Filament\Admin\Resources\Subscriptions\PlanResource\RelationManagers;
use App\Models\Category;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationGroup = 'Subscriptions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Plan Info.')
                            ->schema([
                                TextInput::make('name')
                                    ->required(),
                                TextInput::make('price')
                                    ->integer()
                                    ->required(),
                                TextInput::make('categories')
                                    ->integer()
                                    ->required()
                                    ->helperText('Total of categories subscribers can add'),
                                TextInput::make('duration')
                                    ->integer()
                                    ->required()
                                    ->helperText('Months / Years depends on billing cycle'),
                                Select::make('billing_cycle')
                                    ->options(BillingCycleEnum::toArray())
                                    ->required(),
                                Select::make('type')
                                    ->options(PlanTypeEnum::toArray())
                                    ->required(),
                                // Select::make('categories')
                                //     ->multiple()
                                //     ->searchable()
                                //     ->options(Category::query()->pluck('name','id'))
                                //     ->columnSpanFull()
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('price')
                    ->money('PHP'),
                TextColumn::make('categories'),
                TextColumn::make('duration')
                    ->getStateUsing(function (Plan $record) {
                        $billing_cycle = ($record->billing_cycle === "monthly") ? 'Months' : 'Years';
                        $duration = $record->duration . ' ' . $billing_cycle;
                        return $duration;
                    }),
                TextColumn::make('type'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePlans::route('/'),
        ];
    }
}
