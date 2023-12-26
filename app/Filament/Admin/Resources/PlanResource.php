<?php

namespace App\Filament\Admin\Resources;

use App\Enums\BillingCycleEnum;
use App\Enums\PlanStatusEnum;
use Filament\Forms;
use App\Models\Plan;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\PlanResource\Pages;
use App\Filament\Admin\Resources\PlanResource\RelationManagers;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    // protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    Section::make('Plan Details')
                        ->schema([
                            Select::make('billing_cycle')
                                ->options(BillingCycleEnum::toArray())
                                ->required(),
                            TextInput::make('duration')
                                ->autofocus()
                                ->required()
                                ->numeric()
                                ->placeholder('Enter the plan duration'),
                            MarkdownEditor::make('description')
                                ->columnSpanFull()
                                ->required(),
                        ])
                        ->columns(2),
                ]),
                Group::make([
                    Section::make('Plan Pricing')
                        ->schema([
                            TextInput::make('price')
                                ->autofocus()
                                ->required()
                                ->numeric()
                                ->placeholder('Enter the plan price')
                                ->label('Price'),
                            Toggle::make('is_visible')
                                ->required()
                                ->default(true)
                                ->label('Visibility'),
                        ])
                        ->columns(2),
                ]),
            ]);
    }
    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $data['name'] = $data['duration'] . ' ' . (($data['billing_cycle'] == "monthly") ? 'month' : 'year') . ($data['duration'] > 1 ? 's' : '');

    //     return $data;
    // }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('description')
                    ->sortable()
                    ->limit(40),
                TextColumn::make('price')
                    ->money('PHP')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('billing_cycle'),
                IconColumn::make('is_visible')
                    ->boolean(),
            ])
            ->filters([
                Filter::make('is_visible')
                    ->query(function (Builder $query) {
                        $query->where('is_visible', true);
                    })
                    ->toggle(),
                SelectFilter::make('billing_cycle')
                    ->options(BillingCycleEnum::toArray())
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
