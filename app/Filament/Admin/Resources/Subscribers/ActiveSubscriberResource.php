<?php

namespace App\Filament\Admin\Resources\Subscribers;

use App\Enums\SubscriberStatusEnum;
use App\Filament\Admin\Resources\Subscribers\ActiveSubscriberResource\Pages;
use App\Filament\Admin\Resources\Subscribers\ActiveSubscriberResource\RelationManagers;
use App\Models\Subscriber;
use App\Models\SubscriberCompany;
use App\Models\Subscribers\ActiveSubscriber;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActiveSubscriberResource extends Resource
{
    protected static ?string $model = Subscriber::class;
    protected static ?string $slug = 'active/subscribers';
    protected static ?string $navigationGroup = 'Subscribers';
    protected static ?string $navigationLabel  = 'Active Subscribers';

    // badge
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::with('companies')
            ->whereHas('companies', function ($query) {
                $query->where('status', SubscriberStatusEnum::ACTIVE->value);
            })
            ->count();
    }
    // query
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('companies')
            ->whereHas('companies', function ($query) {
                $query->where('status', SubscriberStatusEnum::ACTIVE->value);
            });
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
                TextColumn::make('name')
                    ->label('Owner`s Name')
                    ->searchable(),
                TextColumn::make('phone')
                    ->icon('heroicon-m-phone'),
                TextColumn::make('email')
                    ->icon('heroicon-o-envelope'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()
                    ->label('Companies'),
            ])
            ->bulkActions([
                DeleteBulkAction::make('delete')
                    ->action(function (Collection $records) {
                        try {
                            foreach ($records as $record) {
                                $record->companies()->delete();
                                $record->delete();
                            }
                            Notification::make()
                                ->success()
                                ->title('Deleted Subscribers')
                                ->body('Successfully deleted Subscribers.')
                                ->duration(5000)
                                ->send();
                            return redirect('admin/active/subscribers');
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
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Company Information')
                            ->schema([
                                RepeatableEntry::make('active_companies')
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
                                            ->columnSpanFull(),
                                        TextEntry::make('socials')
                                            ->label('Socials')
                                            ->listWithLineBreaks()
                                            ->bulleted()
                                            ->openUrlInNewTab()
                                            ->copyable()
                                            ->columnSpanFull(),

                                    ])
                                    ->columns(4)
                                    // ->contained(false)
                                    ->label('')
                            ]),
                        Tab::make('Plan / Payments')
                            ->schema([
                                RepeatableEntry::make('active_companies')
                                    ->schema([
                                        TextEntry::make('plan.name')
                                            ->label('Plan'),
                                        TextEntry::make('plan.price')
                                            ->money('PHP')
                                            ->label('Price'),
                                        TextEntry::make('due_date')
                                            ->label('Due Date')
                                            ->date(),
                                        TextEntry::make('payment_method')
                                            ->label('Payment Method'),
                                        IconEntry::make('status')
                                            ->label('Status')
                                            ->icon(fn (string $state): string => match ($state) {
                                                'pending' => 'heroicon-o-clock',
                                                'active' => 'heroicon-o-check-circle',
                                                'inactive' => 'heroicon-o-x-circle',
                                            })
                                            ->color(fn (string $state): string => match ($state) {
                                                'pending' => 'info',
                                                'active' => 'success',
                                                'inactive' => 'danger',
                                                default => 'gray',
                                            }),
                                        ImageEntry::make('proof_of_payment')
                                            ->label('Proof of Payment')
                                            ->height('100%')
                                            ->width('100%')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(3)
                                    ->label('')
                            ]),
                    ])
                    ->contained(false)
                    ->columnSpanFull(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActiveSubscribers::route('/'),
            // 'create' => Pages\CreateActiveSubscriber::route('/create'),
            // 'edit' => Pages\EditActiveSubscriber::route('/{record}/edit'),
        ];
    }
}
