<?php

declare(strict_types=1);

namespace AlessandroNuunes\FilamentTabbedDashboard;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentTabbedDashboardServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-tabbed-dashboard';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews();
    }

    public function packageBooted(): void
    {
        // Register Livewire components, FilamentAsset, Events, etc.
    }
}
