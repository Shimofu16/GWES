<?php

namespace App\Filament\Admin\Resources\Settings;

use App\Filament\Admin\Resources\Settings\FeedBackResource\Pages;
use App\Filament\Admin\Resources\Settings\FeedBackResource\RelationManagers;
use App\Models\FeedBack;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Infolist;
use Filament\Tables\Columns\ToggleColumn;

class FeedBackResource extends Resource
{
    protected static ?string $model = FeedBack::class;

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email'),
                TextColumn::make('context')
                    ->limit(30),
                ToggleColumn::make('is_visible')
                    ->label('Visibility')
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([

                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->modalDescription('Are you sure you want to trash this feedback')
                    ->successNotificationMessage('Successfully trashed feedback'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->successNotificationMessage('Successfully trashed selected data'),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->successNotificationMessage('Successfully deleted selected data'),
                    Tables\Actions\RestoreBulkAction::make()
                        ->successNotificationMessage('Successfully restore selected data'),

                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
                Section::make()
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('email'),
                        TextEntry::make('context')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
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
            'index' => Pages\ListFeedBacks::route('/'),
            // 'create' => Pages\CreateFeedBack::route('/create'),
            // 'edit' => Pages\EditFeedBack::route('/{record}/edit'),
        ];
    }
}
