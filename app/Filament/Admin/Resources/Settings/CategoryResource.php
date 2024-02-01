<?php

namespace App\Filament\Admin\Resources\Settings;

use App\Enums\CategoryTypeEnum;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use App\Models\Category;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\Settings\CategoryResource\Pages;
use App\Filament\Admin\Resources\Settings\CategoryResource\Pages\ManageCategories;
use App\Filament\Admin\Resources\Settings\CategoryResource\RelationManagers;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Collection;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationGroup = 'Settings';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->autofocus()
                            ->required()
                            ->placeholder('Enter the category name')
                            ->label('Name')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, Forms\Set $set) =>  $set('slug', Str::slug($state))),
                        Select::make('type')
                            ->options(CategoryTypeEnum::toArray())
                            ->required(),

                        TextInput::make('slug')
                            ->disabled()
                            ->label('Slug')
                            ->dehydrated()
                            ->unique(Category::class, 'slug', ignoreRecord: true),

                    ])
                    ->columns(2),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('#')
                    ->state(
                        static function (Tables\Contracts\HasTable $livewire, \stdClass $rowLoop): string {
                            return (string) ($rowLoop->iteration +
                                ($livewire->getTableRecordsPerPage() * ($livewire->getTablePage() - 1
                                ))
                            );
                        }
                    ),
                TextColumn::make('name')
                ->searchable(),
                TextColumn::make('subscriber.count')
                    ->getStateUsing(function (Category $record) {
                        return $record->companies()->count();
                    }),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                if ($record->companies()->count() > 0) {
                                    Notification::make()
                                        ->danger()
                                        ->title('Error deleting category')
                                        ->body("The category $record->name  has companies")
                                        ->send();
                                } else {
                                    $record->delete();
                                }
                            }
                            Notification::make()
                                ->success()
                                ->title('Successfully trashed')
                                ->body(' Successfully trashed all selected records')
                                ->send();
                        }),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->forceDelete();
                            }
                            Notification::make()
                                ->success()
                                ->title('Successfully Deleted')
                                ->body('Successfully deleted all selected records')
                                ->send();
                        }),
                    Tables\Actions\RestoreBulkAction::make()
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->restore();
                            }
                            Notification::make()
                                ->success()
                                ->title('Successfully Restore')
                                ->body('Successfully restore all selected records')
                                ->send();
                        }),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCategories::route('/'),
        ];
    }
}
