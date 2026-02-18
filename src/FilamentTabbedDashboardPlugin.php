<?php

declare(strict_types=1);

namespace AlessandroNuunes\FilamentTabbedDashboard;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentTabbedDashboardPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-tabbed-dashboard';
    }

    public function register(Panel $panel): void
    {
        // Uso é via trait no Dashboard do app ou estendendo TabbedDashboard.
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return new static;
    }
}
