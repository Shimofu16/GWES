<?php

namespace App\Filament\Admin\Resources;

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
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    protected static ?string $navigationGroup = 'Manage Website';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    Section::make('Plan Details')
                        ->schema([
                            // TextInput::make('name')
                            //     ->autofocus()
                            //     ->required()
                            //     ->placeholder('Enter the plan name')
                            //     ->label('Name')
                            //     ->live(onBlur: true)
                            //     ->afterStateUpdated(fn ($state, Forms\Set $set) =>  $set('slug', Str::slug($state))),
                            // TextInput::make('slug')
                            //     ->disabled()
                            //     ->label('Slug')
                            //     ->dehydrated()
                            //     ->required()
                            //     ->unique(Plan::class, 'slug', ignoreRecord: true),
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
                                ->label('Price'),
                            Toggle::make('is_visible')
                                ->required()
                                ->default(true)
                                ->label('Visibility'),
                        ])
                        ->columns(2),
                    Section::make('Plan Duration')
                        ->schema([
                            DatePicker::make('from')
                                ->required()
                                ->label('From')
                                ->rules(['after:today']),
                            DatePicker::make('to')
                                ->required()
                                ->label('To')
                                ->rules(['after:today']),
                        ])
                        ->columns(2),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Availability')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('description')
                    ->sortable()
                    ->limit(40),
                IconColumn::make('is_visible')
                    ->label('Visibility')
                    ->boolean(),
                TextColumn::make('price')
                    ->money('PHP')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('discount_price')
                    ->money('PHP')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('discount_percentage')
                    ->getStateUsing(function ($record) {
                        return number_format($record->discount_percentage) . '%';
                    })
                    ->sortable()
                    ->searchable(),


            ])
            ->filters([
                Filter::make('is_visible')
                    ->label('Visibility')
                    ->toggle(),
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
            // 'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
