<?php

namespace Aqjw\Shortcuts;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ShortcutsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'shortcuts';

    public static string $viewNamespace = 'shortcuts';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name);

        $package->hasTranslations();
        $package->hasViews(static::$viewNamespace);
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            AlpineComponent::make('shortcuts', __DIR__.'/../resources/dist/shortcuts.js'),
        ], $this->getAssetPackageName());
    }

    protected function getAssetPackageName(): ?string
    {
        return 'aqjw/shortcuts';
    }
}
