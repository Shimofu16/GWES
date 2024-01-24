<?php

namespace App\Filament\Admin\Resources\Subscribers;

use App\Enums\PaymentStatusEnum;
use App\Filament\Admin\Resources\Subscribers\PendingSubscriberResource\Pages;
use App\Filament\Admin\Resources\Subscribers\PendingSubscriberResource\Pages\ListPendingSubscribers;
use App\Filament\Admin\Resources\Subscribers\PendingSubscriberResource\RelationManagers;
use App\Models\Category;
use App\Models\SubscriberCompany;
use App\Models\Subscribers\PendingSubscriber;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section as InfoListSection;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Tabs\Tab;
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
        return static::getModel()::query()
            ->with('payments')
            ->whereHas('payments', function ($query) {
                $query->where('latest', true)
                    ->where('status', '!=', PaymentStatusEnum::ACTIVE->value);
            })
            ->count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with('payments', 'companyCategories')
            ->whereHas('payments', function ($query) {
                $query->where('latest', true)
                    ->where('status', '!=', PaymentStatusEnum::ACTIVE->value);
            });
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(function ($record) {
                    return $record->name . ' Information';
                })
                    ->schema([
                        FileUpload::make('logo')
                            ->image()
                            ->avatar()
                            ->disk('public')
                            ->directory('companies/logos')
                            ->required(),
                        FileUpload::make('image')
                            ->image()
                            ->disk('public')
                            ->directory('companies/images')
                            ->required(),
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('phone')
                            ->required()
                            ->length(11),
                        Textarea::make('address')
                            ->rows(5)
                            ->required(),
                        Select::make('company_categories')
                            ->label('Categories')
                            ->multiple()
                            ->searchable()
                            ->options(Category::pluck('name', 'id'))
                            ->maxItems(function($record){
                                return $record->payment->plan->categories;
                            })
                            ->maxItemsMessage('You reach the maximum categories you can input.')
                            ->helperText(function ($record) {
                                return  'Note: Selecting categories here will change the current categories of the company.
                             No of allowed categories : ' . $record->payment->plan->categories;
                            }),
                        Fieldset::make('Price Range')
                            ->schema([
                                TextInput::make('minimum')
                                    ->numeric()
                                    ->required(),
                                TextInput::make('maximum')
                                    ->numeric()
                                    ->required(),
                            ])
                            ->columns(2),
                        Textarea::make('description')
                            ->rows(10)
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('socials')
                            ->required()
                            ->columnSpanFull()
                         
                        //     ->helperText('Note:  Please ensure that each link is followed by a comma also remove https://. Note that a maximum
                        // of 3 social media links will be accepted.'),
                    ])
                    ->columns(2),


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
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('set_status_to_active')
                        ->action(function (Collection $records) {
                            try {
                                foreach ($records as $record) {
                                    $record->payments()
                                        ->where('latest', true)
                                        ->where('status', '!=', PaymentStatusEnum::ACTIVE->value)
                                        ->first()
                                        ->update([
                                            'status' => PaymentStatusEnum::ACTIVE->value,
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
                    BulkAction::make('set_status_to_renewal')
                        ->action(function (Collection $records) {
                            try {
                                foreach ($records as $record) {
                                    $record->payments()
                                        ->where('latest', true)
                                        ->where('status', '!=', PaymentStatusEnum::ACTIVE->value)
                                        ->first()
                                        ->update([
                                            'status' => PaymentStatusEnum::RENEWAL->value,
                                        ]);
                                }
                                Notification::make()
                                    ->success()
                                    ->title('Updated Status')
                                    ->body('Subscribers status successfully changed to renewal')
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
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Company Information')
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
                            ]),
                        Tab::make('Payments')
                            ->schema([
                                InfoListSection::make()
                                    ->schema([
                                        TextEntry::make('payment.plan.name')
                                            ->label('Plan'),
                                        TextEntry::make('payment.total')
                                            ->money('PHP')
                                            ->label('Price'),
                                        TextEntry::make('payment.due_date')
                                            ->label('Due Date')
                                            ->date(),
                                        TextEntry::make('payment.payment_method')
                                            ->label('Payment Method'),
                                        IconEntry::make('payment.status')
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
                                            ->label('Proof of Payment')
                                            ->height('100%')
                                            ->width('100%')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(3)
                            ])
                    ])
                    ->contained(false)
                    ->columnSpanFull(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendingSubscribers::route('/'),
            // 'create' => Pages\CreatePendingSubscriber::route('/create'),
            'edit' => Pages\EditPendingSubscriber::route('/{record}/edit'),
        ];
    }
}
