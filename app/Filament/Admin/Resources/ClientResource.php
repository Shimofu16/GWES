<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ClientResource\Pages;
use App\Filament\Admin\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?int $navigationSort = 4;

    // protected static ?string $navigationGroup = 'Clients';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
                TextColumn::make('groom.name')
                    ->label('Groom`s Name'),
                TextColumn::make('groom.birthday')
                    ->date()
                    ->label('Groom`s Birthday'),
                TextColumn::make('groom.age')
                    ->label('Groom`s Age'),
                TextColumn::make('bride.name')
                    ->label('Bride`s Name'),
                TextColumn::make('bride.birthday')
                    ->date()
                    ->label('Bride`s Birthday'),
                TextColumn::make('bride.age')
                    ->label('Bride`s Age'),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->delete();
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
                                $record->events()->delete();
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->schema([
                        RepeatableEntry::make('events')
                            ->schema([
                                TextEntry::make('coordinator_name')
                                    ->inlineLabel()
                                    ->columnSpanFull(),
                                TextEntry::make('date_start')
                                    ->dateTime('F j, Y h:i A'),
                                TextEntry::make('date_end')
                                    ->dateTime('F j, Y h:i A'),
                                TextEntry::make('address')
                                    ->columnSpanFull(),

                            ])
                            ->contained(false)
                            ->columns(2)
                    ])
                    ->columnSpanFull()
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
            'index' => Pages\ListClients::route('/'),
        ];
    }
}
