<?php

namespace App\Filament\Admin\Pages;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Pages\Dashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class AdminDashboard extends Dashboard
{
    // use HasFiltersForm;
    protected static ?int $navigationSort = -2;
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $routePath = 'dashboard';
    protected static ?string $title = 'Dashboard';

    // public function filtersForm(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Section::make()
    //                 ->schema([
    //                     DatePicker::make('startDate'),
    //                     DatePicker::make('endDate'),
    //                     // ...
    //                 ])
    //                 ->columns(3),
    //         ]);
    // }
}
