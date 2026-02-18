<?php

declare(strict_types=1);

namespace AlessandroNuunes\FilamentTabbedDashboard\Pages;

use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class SettingsPage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string $view = 'filament-tabbed-dashboard::filament.pages.settings-page';
}
