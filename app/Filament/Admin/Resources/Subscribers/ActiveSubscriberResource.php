<?php

namespace App\Filament\Admin\Resources\Subscribers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use App\Models\Subscriber;
use Filament\Tables\Table;
use App\Enums\PaymentStatusEnum;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Models\SubscriberCompany;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use App\Models\Subscribers\ActiveSubscriber;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\BulkActionGroup;
use Illuminate\Database\Eloquent\Collection;
use Filament\Infolists\Components\ImageEntry;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\Tabs as ComponentsTabs;
use Filament\Infolists\Components\Tabs\Tab as ComponentsTab;
use Filament\Infolists\Components\Section as InfoListSection;
use App\Filament\Admin\Resources\Subscribers\ActiveSubscriberResource\Pages;
use App\Filament\Admin\Resources\Subscribers\ActiveSubscriberResource\RelationManagers;
use App\Filament\Admin\Resources\Subscribers\ActiveSubscriberResource\RelationManagers\CompaniesRelationManager;
use App\Models\SubscriberCompanyCategory;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Get;

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
                    ]),
                Repeater::make('companies')
                    ->relationship()
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
                                Hidden::make('id'),
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
                                    ->maxItems(function ($record) {
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
                    ])
                    ->columnSpanFull()
                    ->addable(false)
                    ->deletable(false)
                    ->reorderable(false)
                    ->reorderableWithDragAndDrop(false)
                    ->collapsed()
                    ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
                        $price_range = explode(' - ', $data['price_range']);
                        $data['minimum'] = $price_range[0];
                        $data['maximum'] = $price_range[1];

                        return $data;
                    })
                    ->mutateRelationshipDataBeforeSaveUsing(function (Get $get, array $data): array {
                        // dd($data);
                        $data['price_range'] = $data['minimum'] . ' - ' . $data['maximum'];
                        if (!is_array($data['socials'])) {
                            $data['socials'] = explode(',', $data['socials']);
                        }
                        // dd($data, $record->payment->plan->categories);
                        $categories = $data['company_categories']; // from form
                        if ($categories) {
                            // delete current company categories
                            $companyCategories = SubscriberCompanyCategory::where('subscriber_company_id', $data['id'])->get();
                            foreach ($companyCategories as $key => $companyCategory) {
                                $companyCategory->delete();
                            }
                            foreach ($categories as $key => $category) {

                                SubscriberCompanyCategory::create([
                                    'subscriber_company_id' => $data['id'],
                                    'category_id' => $category,
                                ]);
                            }
                        }
                        return $data;
                    })
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
                                            Storage::disk('public')->delete($payment->proof_of_payment);
                                            $payment->delete();
                                        }
                                        foreach ($company->blogs as $key => $blog) {
                                            Storage::disk('public')->delete($blog->images);
                                            $blog->forceDelete();
                                            // dd($company,$company->blogs);
                                        }
                                        Storage::disk('public')->delete($company->logo);
                                        Storage::disk('public')->delete($company->image);
                                        $company->companyCategories()->delete();
                                        $company->forceDelete();
                                    }
                                    $record->forceDelete();
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
            //
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
                                RepeatableEntry::make('active_subscribers')
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
                        ComponentsTab::make('Payments')
                            ->schema([
                                RepeatableEntry::make('active_subscribers')
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
