<?php

namespace App\Filament\Admin\Resources\Settings;

use App\Enums\PaymentStatusEnum;
use App\Filament\Admin\Resources\Settings\BlogResource\Pages;
use App\Filament\Admin\Resources\Settings\BlogResource\RelationManagers;
use App\Models\Blog;
use App\Models\SubscriberCompany;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationGroup = 'Settings';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                        DatePicker::make('date')
                            ->required(),
                        Select::make('subscriber_company_id')
                            ->options(
                                function () {
                                    return SubscriberCompany::with('payments')
                                        ->whereHas('payments', function ($query) {
                                            $query->where('latest', true)
                                                ->where('status',PaymentStatusEnum::ACTIVE->value);
                                        })
                                        ->pluck('name', 'id');
                                }
                            )
                            ->label('Company')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->required()
                            ->columnSpanFull(),
                        FileUpload::make('images')
                            ->required()
                            ->image()
                            ->directory('blogs')
                            // ->multiple()
                            ->imageEditor()
                            ->columnSpanFull()

                    ])
                    ->columns(2)
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ComponentsSection::make()
                    ->schema([
                        TextEntry::make('title'),
                        TextEntry::make('date')
                            ->date(),
                        TextEntry::make('company.name'),
                        TextEntry::make('description')
                            ->columnSpanFull(),
                        ImageEntry::make('images')
                            ->columnSpanFull(),
                    ])
                    ->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company.name')
                    ->searchable(),
                TextColumn::make('title'),
                TextColumn::make('date')
                    ->date(),
                TextColumn::make('description')
                    ->limit(30)
                    ->words(20)
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
                ViewAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make()
                        ->action(function (Collection $records) {
                            foreach ($records as $key => $record) {
                                Storage::disk('public')->delete($record->images);
                                $record->forceDelete();
                            }
                        }),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBlogs::route('/'),
        ];
    }
}
