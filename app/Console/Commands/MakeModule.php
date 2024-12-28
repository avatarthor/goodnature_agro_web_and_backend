<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModule extends Command
{
    protected $signature = 'make:module {name}';
    protected $description = 'Create a new module with a predefined structure';

    public function handle()
    {
        $name = $this->argument('name');
        $modulePath = base_path("modules/{$name}");

        // Define the directories to create
        $directories = [
            'Config',
            'Database/Migrations',
            'Http/Controllers',
            'Http/Middleware',
            'Models',
            'Providers',
            'Resources/views',
            'Routes',
        ];

        // Create the directories
        foreach ($directories as $dir) {
            File::ensureDirectoryExists("{$modulePath}/{$dir}");
        }

        // Create module.json
        File::put("{$modulePath}/module.json", json_encode([
            'name' => $name,
            'description' => "{$name} module",
            'version' => '1.0.0',
            'autoload' => [
                'psr-4' => [
                    "Modules\\{$name}\\" => ''
                ]
            ]
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // Create composer.json
        File::put("{$modulePath}/composer.json", json_encode([
            'name' => "modules/{$name}",
            'description' => "{$name} module for the application",
            'type' => 'library',
            'autoload' => [
                'psr-4' => [
                    "Modules\\{$name}\\" => ''
                ]
            ],
            'require' => []
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // Create a basic controller
        File::put("{$modulePath}/Http/Controllers/{$name}Controller.php", "<?php\n\nnamespace Modules\\{$name}\\Http\\Controllers;\n\nuse App\Http\Controllers\Controller;\n\nclass {$name}Controller extends Controller\n{\n    public function index()\n    {\n        return view('{$name}::index');\n    }\n}");

        // Create a route file
        File::put("{$modulePath}/Routes/web.php", "<?php\n\nuse Illuminate\Support\Facades\Route;\nuse Modules\\{$name}\\Http\\Controllers\\{$name}Controller;\n\nRoute::prefix('" . strtolower($name) . "')->group(function () {\n    Route::get('/', [{$name}Controller::class, 'index']);\n});");

        // Create a basic view
        File::put("{$modulePath}/Resources/views/index.blade.php", "<h1>{$name} Module</h1>");

        $this->info("Module {$name} created successfully with the predefined structure!");
    }
}
