<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Share empty sidebar items array with all views
        View::share('sidebarItems', []);

        // Register the sidebar composer
        View::composer('layouts.sidebar', function ($view) {
            $modules = $this->getActiveModules();
            $sidebarItems = [];

            foreach ($modules as $module) {
                if (method_exists($module['provider'], 'getSidebarItems')) {
                    $items = $module['provider']->getSidebarItems();
                    $sidebarItems = array_merge($sidebarItems, $items);
                }
            }

            $view->with('sidebarItems', $sidebarItems);
        });
    }

    protected function getActiveModules()
    {
        $modules = [];
        $modulesPath = base_path('modules');

        if (!File::exists($modulesPath)) {
            return $modules;
        }

        foreach (File::directories($modulesPath) as $moduleDir) {
            $moduleName = basename($moduleDir);
            $moduleJsonPath = $moduleDir . '/module.json';

            if (File::exists($moduleJsonPath)) {
                $config = json_decode(File::get($moduleJsonPath), true);

                if ($config['active'] ?? false) {
                    $providerClass = "Modules\\{$moduleName}\\Providers\\{$moduleName}ServiceProvider";
                    if (class_exists($providerClass)) {
                        $provider = app($providerClass);
                        $modules[] = [
                            'name' => $moduleName,
                            'provider' => $provider
                        ];
                    }
                }
            }
        }

        return $modules;
    }
}
