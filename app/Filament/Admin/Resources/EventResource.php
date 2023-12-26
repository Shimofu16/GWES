<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\EventResource\Pages;
use App\Filament\Admin\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Section as InfoListSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\Card;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    // protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Clients';

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
                TextColumn::make('client.groom.name')
                    ->label('Groom'),
                TextColumn::make('client.bride.name')
                    ->label('Bride'),
                TextColumn::make('coordinator_name')
                    ->label('Coordinator'),
                TextColumn::make('type')
                    ->label('Type'),
                TextColumn::make('Date')
                    ->label('Date')
                    ->getStateUsing(function (Event $record) {
                        return date('F d, Y h:m A', strtotime($record->date_start)) . ' - ' . date('F d, Y h:m A', strtotime($record->date_end));
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            // 'create' => Pages\CreateEvent::route('/create'),
            // 'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([

                InfoListSection::make('Client Information')
                    ->schema([
                        TextEntry::make('')
                            ->label('Groom`s')
                            ->inlineLabel()
                            ->columnSpanFull(),
                        TextEntry::make('client.groom.name')
                            ->label('Name:')
                            ->inlineLabel()
                            ->columnSpan(1),
                        TextEntry::make('client.groom.birthday')
                            ->label('Birthday:')
                            ->inlineLabel()
                            ->columnSpan(1),
                        TextEntry::make('client.groom.age')
                            ->label('Age:')
                            ->inlineLabel()
                            ->columnSpan(1),
                        TextEntry::make('')
                            ->label('Bride`s')
                            ->inlineLabel()
                            ->columnSpanFull(),
                        TextEntry::make('client.bride.name')
                            ->label('Name:')
                            ->inlineLabel()
                            ->columnSpan(1),
                        TextEntry::make('client.bride.birthday')
                            ->label('Birthday:')
                            ->inlineLabel()
                            ->columnSpan(1),
                        TextEntry::make('client.bride.age')
                            ->label('Age:')
                            ->inlineLabel()
                            ->columnSpan(1),
                    ])
                    ->columns(3),
                InfoListSection::make('Event Information')
                    ->schema([
                        TextEntry::make('coordinator_name')
                            ->label('Coordinator:')
                            ->inlineLabel(),
                        TextEntry::make('type')
                            ->label('Type:')
                            ->inlineLabel(),
                        TextEntry::make('address')
                            ->label('Address:')
                            ->inlineLabel()
                            ->columnSpanFull(),
                        TextEntry::make('date')
                            ->label('Date:')
                            ->getStateUsing(function (Event $record) {
                                return date('F d, Y h:m A', strtotime($record->date_start)) . ' - ' . date('F d, Y h:m A', strtotime($record->date_end));
                            })
                            ->inlineLabel()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

            ]);
    }
}
