<?php

namespace Modules\FarmerInputs\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Modules\FarmerInputs\Models\FarmerInput;

class FarmerInputsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerViews();
        $this->registerConfig();
        $this->loadMigrationsFrom(module_path('FarmerInputs', 'Database/Migrations'));
        $this->registerSidebarItems();
        $this->registerDashboardStats();
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    protected function registerConfig()
    {
        $this->publishes([
            module_path('FarmerInputs', 'Config/config.php') => config_path('farmerinputs.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('FarmerInputs', 'Config/config.php'), 'farmerinputs'
        );
    }

    protected function registerViews()
    {
        $this->loadViewsFrom(module_path('FarmerInputs', 'Resources/views'), 'farmerinputs');
    }

    protected function registerSidebarItems()
    {
        // Register sidebar items only if module is active
        $moduleJson = module_path('FarmerInputs', 'module.json');
        if (File::exists($moduleJson)) {
            $config = json_decode(File::get($moduleJson), true);
            if ($config['active'] ?? false) {
                View::composer('components.sidebar', function ($view) {
                    $currentSidebarItems = $view->getData()['sidebarItems'] ?? [];

                    $inputItems = [
                        'Farmer Inputs Module' => [
                            [
                                'title' => 'All Distributed Inputs',
                                'route' => 'farmer-inputs.index',
                                'icon' => 'fe:vector'
                            ],
                            [
                                'title' => 'Distribute Inputs',
                                'route' => 'farmer-inputs.create',
                                'icon' => 'solar:pie-chart-outline'
                            ]
                        ]
                    ];

                    // Ensure $currentSidebarItems is an array before merging
                    if (!is_array($currentSidebarItems)) {
                        $currentSidebarItems = [];
                    }

                    $mergedItems = array_merge($currentSidebarItems, $inputItems);
                    $view->with('sidebarItems', $mergedItems);
                });
            }
        }
    }

    protected function registerDashboardStats()
    {
        View::composer('dashboard', function ($view) {
            $moduleJson = module_path('FarmerInputs', 'module.json');
            if (File::exists($moduleJson)) {
                $config = json_decode(File::get($moduleJson), true);

                // Initialize input-related data with null values
                $data = $view->getData();
                $data['isInputModuleActive'] = false;
                $data['totalInputs'] = 0;
                $data['weeklyNewInputs'] = 0;

                if ($config['active'] ?? false) {
                    $weekStart = Carbon::now()->startOfWeek();
                    $weekEnd = Carbon::now()->endOfWeek();

                    $data['isInputModuleActive'] = true;
                    $data['totalInputs'] = FarmerInput::sum('quantity');
                    $data['weeklyNewInputs'] = FarmerInput::whereBetween('created_at', [$weekStart, $weekEnd])
                        ->sum('quantity');
                }

                $view->with($data);
            }
        });
    }

    protected function getPublishableViewPaths(): array
    {
        return [
            module_path('FarmerInputs', 'Resources/views'),
        ];
    }
}
