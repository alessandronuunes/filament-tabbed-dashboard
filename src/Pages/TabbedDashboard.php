<?php

declare(strict_types=1);

namespace AlessandroNuunes\FilamentTabbedDashboard\Pages;

use AlessandroNuunes\FilamentTabbedDashboard\HasTabbedDashboard;
use Filament\Pages\Dashboard;

class TabbedDashboard extends Dashboard
{
    use HasTabbedDashboard;

    protected static string $view = 'filament-tabbed-dashboard::filament.pages.tabbed-dashboard';

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getTabDefinitions(): array
    {
        return [];
    }

    public function getView(): string
    {
        return static::$view;
    }

    public function mount(): void
    {
        parent::mount();
        $this->mountHasTabbedDashboard();
    }
}
