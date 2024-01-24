<?php

namespace App\Filament\Admin\Resources\Subscribers;

use App\Enums\PaymentStatusEnum;
use App\Filament\Admin\Resources\Subscribers\ActiveSubscriberResource\Pages;
use App\Filament\Admin\Resources\Subscribers\ActiveSubscriberResource\RelationManagers;
use App\Filament\Admin\Resources\Subscribers\ActiveSubscriberResource\RelationManagers\CompaniesRelationManager;
use App\Models\Subscriber;
use App\Models\SubscriberCompany;
use App\Models\Subscribers\ActiveSubscriber;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs ;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section as InfoListSection;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Tabs as ComponentsTabs;
use Filament\Infolists\Components\Tabs\Tab as ComponentsTab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class ActiveSubscriberResource extends Resource
{
    protected static ?string $model = Subscriber::class;
    protected static ?string $slug = 'active/subscribers';
    protected static ?string $navigationGroup = 'Subscribers';
    protected static ?string $navigationLabel  = 'Active Subscribers';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::with('companies')
            ->whereHas('companies', function ($query) {
                $query->whereHas('payments', function ($q) {
                    $q->where('latest', true)
                        ->where('status',  PaymentStatusEnum::ACTIVE->value);
                });
            })
            ->count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with('companies')
            ->whereHas('companies', function ($query) {
                $query->whereHas('payments', function ($q) {
                    $q->where('latest', true)
                        ->where('status',  PaymentStatusEnum::ACTIVE->value);
                });
            })
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Owner Information')
                ->schema([
                    TextInput::make('name')
                        ->required(),
                    TextInput::make('email')
                        ->email()
                        ->required(),
                    TextInput::make('phone')
                        ->length(11)
                        ->required(),
                ])

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
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                // ...
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()
                    ->label('Companies'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->name('Soft Delete Selected Subscribers')
                        ->modalHeading('Soft Delete Subscribers')
                        ->modalDescription('Are you sure you want to soft delete these subscribers?'),
                    Tables\Actions\ForceDeleteBulkAction::make('Permanently Delete Selected Subscribers')
                        ->action(function (Collection $records) {
                            try {
                                foreach ($records as $record) {
                                    foreach ($record->companies as $key => $company) {
                                        foreach ($company->payments as $key => $payment) {
                                            Storage::delete($payment->proof_of_payment);
                                            $payment->delete();
                                        }
                                        Storage::delete($company->logo);
                                        Storage::delete($company->image);
                                        $company->companyCategories()->delete();
                                        $company->delete();
                                    }
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
                                dd($th->getMessage());
                                // Notification::make()
                                //     ->danger()
                                //     ->title('Error')
                                //     ->body($th->getMessage())
                                //     ->duration(5000)
                                //     ->send();
                            }
                        })
                        ->modalHeading('Permanently Delete Subscribers')
                        ->modalDescription('Are your sure you want to permanently delete these subscribers?'),
                    Tables\Actions\RestoreBulkAction::make('Restore Delete Selected Subscribers')
                        ->modalHeading('Restore Subscribers')
                        ->modalDescription('Are your sure you want to restore these subscribers?'),
                    // DeleteBulkAction::make('delete')
                    //     ->action(function (Collection $records) {
                    //         try {
                    //             foreach ($records as $record) {
                    //                 $record->delete();
                    //             }
                    //             Notification::make()
                    //                 ->success()
                    //                 ->title('Deleted Subscribers')
                    //                 ->body('Successfully deleted Subscribers.')
                    //                 ->duration(5000)
                    //                 ->send();
                    //             return redirect('admin/active/subscribers');
                    //         } catch (\Throwable $th) {
                    //             Notification::make()
                    //                 ->danger()
                    //                 ->title('Error')
                    //                 ->body($th->getMessage())
                    //                 ->duration(5000)
                    //                 ->send();
                    //         }
                    //     })
                    //     ->icon('heroicon-o-trash')
                    //     ->requiresConfirmation()

                ])
            ])
            ->emptyStateActions([
                // Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CompaniesRelationManager::class
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ComponentsTabs::make('Tabs')
                    ->tabs([
                        ComponentsTab::make('Company Information')
                            ->schema([
                                RepeatableEntry::make('companies')
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
                                        TextEntry::make('companyCategories')
                                            ->getStateUsing(function (SubscriberCompany $record) {
                                                // dd($record);
                                                $categories = array();
                                                foreach ($record->companyCategories as $key => $category) {
                                                    if (!in_array($category->category->name, $categories)) {
                                                        $categories[] = $category->category->name;
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
                        Tab::make('Payments')
                            ->schema([
                                RepeatableEntry::make('companies')
                                    ->schema([
                                        InfoListSection::make()
                                            ->schema([

                                                TextEntry::make('payment.plan.name')
                                                    ->getStateUsing(function ($record) {
                                                        return $record->payment->plan->name;
                                                    })
                                                    ->label('Plan'),
                                                TextEntry::make('payment.total')
                                                    ->getStateUsing(function ($record) {
                                                        return $record->payment->total;
                                                    })
                                                    ->money('PHP')
                                                    ->label('Price'),
                                                TextEntry::make('payment.due_date')
                                                    ->getStateUsing(function ($record) {
                                                        return $record->payment->due_date;
                                                    })
                                                    ->label('Due Date')
                                                    ->date(),
                                                TextEntry::make('payment.payment_method')
                                                    ->getStateUsing(function ($record) {
                                                        return $record->payment->payment_method;
                                                    })
                                                    ->label('Payment Method'),
                                                IconEntry::make('payment.status')
                                                    ->getStateUsing(function ($record) {
                                                        return $record->payment->status;
                                                    })
                                                    ->label('Status')
                                                    ->icon(fn (string $state): string => match ($state) {
                                                        'pending' => 'heroicon-o-clock',
                                                        'active' => 'heroicon-o-check-circle',
                                                        'renewal' => 'heroicon-o-x-circle',
                                                    })
                                                    ->color(fn (string $state): string => match ($state) {
                                                        'pending' => 'info',
                                                        'active' => 'success',
                                                        'renewal' => 'danger',
                                                        default => 'gray',
                                                    }),
                                                ImageEntry::make('payment.proof_of_payment')
                                                    ->getStateUsing(function ($record) {
                                                        return $record->payment->proof_of_payment;
                                                    })
                                                    ->label('Proof of Payment')
                                                    ->height('100%')
                                                    ->width('100%')
                                                    ->columnSpanFull(),
                                            ])
                                            ->columns(3)
                                    ])
                                    ->contained(false)
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
            'edit' => Pages\EditActiveSubscriber::route('/{record}/edit'),
        ];
    }
}
