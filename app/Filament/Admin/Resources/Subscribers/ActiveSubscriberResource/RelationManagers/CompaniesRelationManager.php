<?php

namespace App\Filament\Admin\Resources\Subscribers\ActiveSubscriberResource\RelationManagers;

use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompaniesRelationManager extends RelationManager
{
    protected static string $relationship = 'companies';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        dd($data);
        $data['categories'] = auth()->id();


        return $data;
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('logo')
                    ->image()
                    ->required(),
                FileUpload::make('image')
                    ->image()
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('phone')
                    ->required()
                    ->length(11),
                Textarea::make('address')
                    ->rows(5)
                    ->required(),
                Select::make('categories')
                    ->label('Categories')
                    ->required()
                    ->multiple()
                    ->searchable()
                    ->options(Category::pluck('name', 'id')),

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
                // CheckboxList::make('technologies')
                //     ->options(Category::pluck('name', 'id'))
                //     ->searchable()
                //     ->columns(2)
                //     ->gridDirection('row'),
                Textarea::make('description')
                    ->rows(10)
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('socials')
                    ->required()
                    ->columnSpanFull(),


            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('price_range'),
            ])
            ->filters([
                //
            ])
            // ->headerActions([
            //     Tables\Actions\CreateAction::make(),
            // ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }
}
