<?php

namespace App\Filament\Admin\Resources\Subscribers;

use App\Enums\SubscriberStatusEnum;
use App\Filament\Admin\Resources\Subscribers\PendingSubscriberResource\Pages;
use App\Filament\Admin\Resources\Subscribers\PendingSubscriberResource\Pages\ListPendingSubscribers;
use App\Filament\Admin\Resources\Subscribers\PendingSubscriberResource\RelationManagers;
use App\Models\SubscriberCompany;
use App\Models\Subscribers\PendingSubscriber;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section as InfoListSection;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendingSubscriberResource extends Resource
{
    protected static ?string $model = SubscriberCompany::class;
    protected static ?string $slug = 'pending/subscribers';

    protected static ?string $navigationGroup = 'Subscribers';
    protected static ?string $navigationLabel  = 'Pending Subscribers';

    // badge
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', '!=', SubscriberStatusEnum::ACTIVE->value)
            ->count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('status', '!=', SubscriberStatusEnum::ACTIVE->value);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Company Logo')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Company Name'),
                TextColumn::make('subscriber.name')
                    ->label('Owner Name'),
                TextColumn::make('phone')
                    ->icon('heroicon-m-phone'),
                TextColumn::make('price_range')
                    ->getStateUsing(function (SubscriberCompany $company) {
                        $price_range = explode(' - ', $company->price_range);
                        return number_format($price_range[0]) . ' - ' . number_format($price_range[1]);
                    })
                    ->label('Price Range'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('set_to_active')
                        ->action(function (Collection $records) {
                            try {
                                foreach ($records as $record) {
                                    $record->update([
                                        'status' => SubscriberStatusEnum::ACTIVE->value,
                                    ]);
                                }
                                Notification::make()
                                    ->success()
                                    ->title('Updated Status')
                                    ->body('Subscribers status successfully changed to active')
                                    ->duration(5000)
                                    ->send();
                                return redirect('admin/pending/subscribers');
                                // return redirect()->route(ListPendingSubscribers::getRouteName());
                            } catch (\Throwable $th) {
                                Notification::make()
                                    ->danger()
                                    ->title('Error Accepting Subscribers')
                                    ->body($th->getMessage())
                                    ->duration(5000)
                                    ->send();
                            }
                        })
                        ->icon('heroicon-o-check-circle')
                        ->color(Color::Emerald)
                        ->requiresConfirmation()
                        ->modalHeading('Accept Subscribers')
                        ->modalDescription('Are you sure you want to accept these subscribers?'),
                    BulkAction::make('set_to_inactive')
                        ->action(function (Collection $records) {
                            try {
                                foreach ($records as $record) {
                                    $record->update([
                                        'status' => SubscriberStatusEnum::INACTIVE->value,
                                    ]);
                                }
                                Notification::make()
                                    ->success()
                                    ->title('Updated Status')
                                    ->body('Subscribers status successfully changed to inactive')
                                    ->duration(5000)
                                    ->send();
                                return redirect('admin/pending/subscribers');
                                // return redirect()->route(ListPendingSubscribers::getRouteName());
                            } catch (\Throwable $th) {
                                Notification::make()
                                    ->danger()
                                    ->title('Error')
                                    ->body($th->getMessage())
                                    ->duration(5000)
                                    ->send();
                            }
                        })
                        ->icon('heroicon-o-x-circle')
                        ->color(Color::Amber)
                        ->requiresConfirmation()
                        ->modalHeading('Update Status')
                        ->modalDescription('Are you sure you want to set inactive status for these subscribers?'),

                    DeleteBulkAction::make('delete')
                        ->action(function (Collection $records) {
                            try {
                                foreach ($records as $record) {
                                    $record->delete();
                                }
                                Notification::make()
                                    ->success()
                                    ->title('Deleted Subscribers')
                                    ->body('Successfully deleted Subscribers.')
                                    ->duration(5000)
                                    ->send();
                                return redirect('admin/pending/subscribers');
                            } catch (\Throwable $th) {
                                Notification::make()
                                    ->danger()
                                    ->title('Error')
                                    ->body($th->getMessage())
                                    ->duration(5000)
                                    ->send();
                            }
                        })
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Subscribers')
                        ->modalDescription('Are your sure you want to delete these subscribers?')
                ]),
            ])
            ->emptyStateActions([
                // Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfoListSection::make('Company Information')
                    ->schema([
                        ImageEntry::make('logo')
                            ->label('Logo')
                            ->height('70px')
                            ->width('70px')
                            ->circular(),
                        TextEntry::make('name')
                            ->label('Name'),
                        TextEntry::make('phone')
                            ->label('Phone'),
                        TextEntry::make('price_range')
                            ->getStateUsing(function ($record) {
                                $string = explode(' - ', $record->price_range);
                                return number_format($string[0]) . ' - ' . number_format($string[1]);
                            })
                            ->label('Price Range'),
                        TextEntry::make('address')
                            ->label('Address')
                            ->columnSpanFull(),
                        TextEntry::make('description')
                            ->label('Description')
                            ->columnSpanFull(),
                        TextEntry::make('categories')
                            ->getStateUsing(function (SubscriberCompany $record) {
                                $categories = array();
                                foreach ($record->categories as $key => $category) {
                                    if (!in_array($category['name'], $categories)) {
                                        $categories[] = $category['name'];
                                    }
                                }
                                return $categories;
                            })
                            ->label('Categories')
                            ->bulleted()
                            ->columnSpan(1),
                        TextEntry::make('socials')
                            ->label('Socials')
                            ->listWithLineBreaks()
                            ->bulleted()
                            ->openUrlInNewTab()
                            ->copyable()
                            ->columnSpan(3),
                    ])
                    ->columns(4),
                InfoListSection::make('Owner Information')
                    ->schema([
                        TextEntry::make('subscriber.name')
                            ->label('Name'),
                        TextEntry::make('subscriber.email')
                            ->icon('heroicon-o-envelope')
                            ->label('Email'),
                        TextEntry::make('subscriber.phone')
                            ->icon('heroicon-m-phone')
                            ->label('Phone'),
                    ])
                    ->columns(3)
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendingSubscribers::route('/'),
            // 'create' => Pages\CreatePendingSubscriber::route('/create'),
            // 'edit' => Pages\EditPendingSubscriber::route('/{record}/edit'),
        ];
    }
}
