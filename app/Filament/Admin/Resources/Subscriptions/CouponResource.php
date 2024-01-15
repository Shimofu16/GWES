<?php

namespace App\Filament\Admin\Resources\Subscriptions;

use App\Enums\DiscountTypeEnum;
use App\Filament\Admin\Resources\Subscriptions\CouponResource\Pages;
use App\Filament\Admin\Resources\Subscriptions\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationGroup = 'Subscriptions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('code')
                            ->unique()
                            ->required(),
                        Select::make('discount_type')
                            ->options(DiscountTypeEnum::toArray())
                            ->required(),
                        TextInput::make('discount_value')
                            ->helperText('If you’ve selected ‘Percentage’ or ‘Fixed Amount’ as your discount type, please specify the discount value you wish to apply.'),
                        TextInput::make('subscription_duration')
                            ->helperText('If you’ve chosen ‘Free Subscription’ as your discount type, please enter the duration of the subscription in months.'),
                        DatePicker::make('expiry_date')
                            ->helperText('If you want the coupon to have no expiration date, please leave this field blank.'),
                        TextInput::make('max_redemptions')
                            ->numeric()
                            ->required()
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->searchable(),
                TextColumn::make('discount_type'),
                TextColumn::make('discount_type'),
                TextColumn::make('Value / Duration')
                    ->getStateUsing(function (Coupon $record) {
                        $value = '';
                        if ($record->discount_value != 0.00) {
                            $value = $record->discount_value;
                        }
                        if ($record->subscription_duration) {
                            $format = ($record->subscription_duration > 1) ? 's' : '';
                            $value =  "{$record->subscription_duration} Month{$format}";
                        }
                        return $value;
                    }),
                TextColumn::make('max_redemptions'),
                TextColumn::make('redemption_count'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCoupons::route('/'),
        ];
    }
}
