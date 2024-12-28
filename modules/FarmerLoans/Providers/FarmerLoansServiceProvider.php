<?php

namespace Modules\FarmerLoans\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Modules\FarmerLoans\Models\FarmerLoan;


class FarmerLoansServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerViews();
        $this->registerConfig();
        $this->loadMigrationsFrom(module_path('FarmerLoans', 'Database/Migrations'));
        $this->registerSidebarItems();
        $this->registerDashboardStats();
        $this->registerFarmerDetailView();

    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    protected function registerConfig()
    {
        $this->publishes([
            module_path('FarmerLoans', 'Config/config.php') => config_path('farmerloans.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('FarmerLoans', 'Config/config.php'), 'farmerloans'
        );
    }

    protected function registerViews()
    {
        $this->loadViewsFrom(module_path('FarmerLoans', 'Resources/views'), 'farmerloans');
    }

    protected function registerSidebarItems()
    {
        // Register sidebar items only if module is active
        $moduleJson = module_path('FarmerLoans', 'module.json');
        if (File::exists($moduleJson)) {
            $config = json_decode(File::get($moduleJson), true);
            if ($config['active'] ?? false) {
                View::composer('components.sidebar', function ($view) {
                    $currentSidebarItems = $view->getData()['sidebarItems'] ?? [];

                    $loanItems = [
                        'Farmer Loans Module' => [
                            [
                                'title' => 'All Loans',
                                'route' => 'farmer-loans.index',
                                'icon' => 'hugeicons:money-send-square'
                            ],
                            [
                                'title' => 'Disburse Loan',
                                'route' => 'farmer-loans.create',
                                'icon' => 'hugeicons:invoice-03'
                            ]
                        ]
                    ];

                    // Ensure $currentSidebarItems is an array before merging
                    if (!is_array($currentSidebarItems)) {
                        $currentSidebarItems = [];
                    }

                    $mergedItems = array_merge($currentSidebarItems, $loanItems);
                    $view->with('sidebarItems', $mergedItems);
                });
            }
        }
    }

    protected function registerDashboardStats()
    {
        View::composer('dashboard', function ($view) {
            $moduleJson = module_path('FarmerLoans', 'module.json');
            if (File::exists($moduleJson)) {
                $config = json_decode(File::get($moduleJson), true);

                // Initialize loan-related data with null values
                $data = $view->getData();
                $data['isLoanModuleActive'] = false;
                $data['totalLoans'] = 0;
                $data['weeklyNewLoans'] = 0;
                $data['totalLoanAmount'] = 0;
                $data['weeklyNewLoanAmount'] = 0;
                $data['loanStats'] = [];

                if ($config['active'] ?? false) {
                    $weekStart = Carbon::now()->startOfWeek();
                    $weekEnd = Carbon::now()->endOfWeek();

                    $data['isLoanModuleActive'] = true;
                    $data['totalLoans'] = FarmerLoan::count();
                    $data['weeklyNewLoans'] = FarmerLoan::whereBetween('created_at', [$weekStart, $weekEnd])->count();
                    $data['totalLoanAmount'] = FarmerLoan::where('status', 'approved')->sum('loan_amount');
                    $data['weeklyNewLoanAmount'] = FarmerLoan::where('status', 'approved')
                        ->whereBetween('created_at', [$weekStart, $weekEnd])
                        ->sum('loan_amount');

                    $data['loanStats'] = FarmerLoan::selectRaw('status, count(*) as total')
                        ->groupBy('status')
                        ->pluck('total', 'status')
                        ->toArray();
                }

                $view->with($data);
            }
        });
    }

    protected function registerFarmerDetailView()
    {
        View::composer(['farmers.show'], function ($view) {
            $moduleJson = module_path('FarmerLoans', 'module.json');
            if (File::exists($moduleJson)) {
                $config = json_decode(File::get($moduleJson), true);

                // Get existing view data
                $data = $view->getData();

                // Add loan module data
                $data['isLoanModuleActive'] = $config['active'] ?? false;

                // If the module is active, ensure the farmer's loans are loaded
                if ($data['isLoanModuleActive'] && isset($data['farmer'])) {
                    $data['farmer']->load('farmerLoans');
                }

                $view->with($data);
            }
        });
    }

    protected function getPublishableViewPaths(): array
    {
        return [
            module_path('FarmerLoans', 'Resources/views'),
        ];
    }
}
