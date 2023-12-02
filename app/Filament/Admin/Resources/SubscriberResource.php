<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use App\Models\Subscriber;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\SubscriberResource\Pages;
use Filament\Infolists\Components\Section as InfolistSection;
use App\Filament\Admin\Resources\SubscriberResource\RelationManagers;
use App\Models\Plan;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;

class SubscriberResource extends Resource
{
    protected static ?string $model = Subscriber::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Manage Clients';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    Section::make('Personal Information')
                        ->schema([
                            TextInput::make('name')
                                ->required(),
                            TextInput::make('email')
                                ->required()
                                ->email(),
                            TextInput::make('phone')
                                ->required(),
                        ]),
                    Section::make('Company Information')
                        ->schema([
                            FileUpload::make('company_logo')
                                ->label('Logo')
                                ->image()
                                ->disk('public')
                                ->directory('logos')
                                ->imageEditor()
                                ->avatar()
                                ->columnSpanFull(),
                            TextInput::make('company_name')
                                ->label('Name')
                                ->required(),
                            TextInput::make('company_phone')
                                ->label('Phone')
                                ->required(),
                            TextInput::make('company_price_range')
                                ->label('Price Range')
                                ->placeholder('10000 - 25000')
                                ->required(),
                            TextInput::make('company_address')
                                ->label('Address')
                                ->required(),
                            MarkdownEditor::make('company_description')
                                ->label('Description')
                                ->required()
                                ->columnSpanFull(),

                        ])
                        ->columns(2),
                ]),
                Group::make([
                    Section::make('')
                        ->schema([
                            // CheckboxList::make('categories')
                            //     ->options(Category::pluck('name', 'id'))
                            //     ->columns(4)
                            //     ->searchable()
                            //     ->searchPrompt('Search for a category')
                            //     ->noSearchResultsMessage('No categories found.')
                            Select::make('categories')
                                ->options(Category::pluck('name', 'id'))
                                ->multiple()
                                ->searchable(),
                            Select::make('plan_id')
                                ->options(Plan::pluck('name', 'id'))
                                ->searchable(),

                        ])
                ]),


            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email')
                    ->icon('heroicon-m-envelope'),
                TextColumn::make('phone')
                    ->icon('heroicon-m-phone'),

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
            'index' => Pages\ListSubscribers::route('/'),
            'create' => Pages\CreateSubscriber::route('/create'),
            'edit' => Pages\EditSubscriber::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            InfolistSection::make('Company Information')
                ->schema([
                    ImageEntry::make('company.logo')
                        ->square(),
                    TextEntry::make('company.name')
                        ->label('Name'),
                    TextEntry::make('company.phone')
                        ->label('Phone'),
                    TextEntry::make('company.price_range')
                        ->getStateUsing(function (Subscriber $record) {
                            $string = explode(' - ', $record->company->price_range);
                            return number_format($string[0]) . ' - ' . number_format($string[1]);
                        })
                        ->label('Price Range'),
                    TextEntry::make('company.address')
                        ->label('Address')
                        ->columnSpanFull(),
                    TextEntry::make('company.description')
                        ->label('Description')
                        ->columnSpanFull(),

                ])
                ->columns(4),
            InfolistSection::make('Other')
                ->schema([
                    TextEntry::make('company.socials')
                        ->label('Socials')
                        ->listWithLineBreaks()
                        ->bulleted(),
                    TextEntry::make('company.categories')
                        ->getStateUsing(function (Subscriber $record) {
                            $categories = array();
                            foreach ($record->company->categories as $key => $category) {
                                if (!in_array($category['name'], $categories)) {
                                    $categories[] = $category['name'];
                                }
                            }
                            return implode(', ', $categories);
                        })
                        ->label('Categories')
                        ->listWithLineBreaks()
                        ->bulleted(),
                ]),
        ]);
    }
}
