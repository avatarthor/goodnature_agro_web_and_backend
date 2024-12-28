<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use ZipArchive;

class ModuleController extends Controller
{
    protected $modulesPath;

    public function __construct()
    {
        $this->modulesPath = base_path('modules');
        // Create modules directory if it doesn't exist
        if (!File::exists($this->modulesPath)) {
            File::makeDirectory($this->modulesPath, 0755, true);
        }
    }

    public function index()
    {
        $modules = $this->getInstalledModules();
        return view('modules.index', compact('modules'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'module_zip' => 'required|file|mimes:zip'
        ]);

        try {
            $zip = new ZipArchive;
            $file = $request->file('module_zip');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/temp'), $fileName);

            $zipPath = storage_path("app/temp/{$fileName}");

            if ($zip->open($zipPath) === TRUE) {
                $moduleFolder = trim($zip->getNameIndex(0), '/');

                // Extract to modules directory
                $zip->extractTo($this->modulesPath);
                $zip->close();

                // Clean up
                File::delete($zipPath);

                // Register the service provider
                $this->registerModuleServiceProvider($moduleFolder);

                // Run module migrations if they exist
                $migrationPath = $this->modulesPath . '/' . $moduleFolder . '/Database/Migrations';
                if (File::exists($migrationPath)) {
                    Artisan::call('migrate', [
                        '--path' => "modules/{$moduleFolder}/Database/Migrations",
                        '--force' => true
                    ]);
                }

                return redirect()->route('modules.index')
                    ->with('success', 'Module uploaded and installed successfully');
            }

            return back()->with('error', 'Failed to open zip file');

        } catch (\Exception $e) {
            return back()->with('error', 'Error installing module: ' . $e->getMessage());
        }
    }

    public function toggleStatus($moduleName)
    {
        try {
            $moduleJsonPath = $this->modulesPath . '/' . $moduleName . '/module.json';

            if (!File::exists($moduleJsonPath)) {
                throw new \Exception('Module configuration not found');
            }

            $config = json_decode(File::get($moduleJsonPath), true);
            $config['active'] = !($config['active'] ?? false);

            File::put($moduleJsonPath, json_encode($config, JSON_PRETTY_PRINT));

            $status = $config['active'] ? 'activated' : 'deactivated';
            return redirect()->route('modules.index')
                ->with('success', "Module {$status} successfully");

        } catch (\Exception $e) {
            return back()->with('error', 'Error toggling module status: ' . $e->getMessage());
        }
    }

    public function destroy($moduleName)
    {
        try {
            $modulePath = $this->modulesPath . '/' . $moduleName;

            if (!File::exists($modulePath)) {
                throw new \Exception('Module not found');
            }

            // Remove the service provider first
            $this->removeModuleServiceProvider($moduleName);

            // Run module uninstall migration if exists
            $uninstallMigration = $modulePath . '/Database/Migrations/uninstall.php';
            if (File::exists($uninstallMigration)) {
                require_once $uninstallMigration;
                $className = 'UninstallModule' . ucfirst($moduleName);
                if (class_exists($className)) {
                    $migration = new $className();
                    $migration->down();
                }
            }

            // Remove migration records from the migrations table
            $this->removeMigrationRecords($moduleName);

            // Delete module directory
            File::deleteDirectory($modulePath);

            return redirect()->route('modules.index')
                ->with('success', 'Module deleted successfully');

        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting module: ' . $e->getMessage());
        }
    }

    protected function removeMigrationRecords($moduleName)
    {
        // Get the migration files for the module
        $migrationPath = $this->modulesPath . '/' . $moduleName . '/Database/Migrations';
        if (File::exists($migrationPath)) {
            $migrations = File::files($migrationPath);
            foreach ($migrations as $migration) {
                // Get the migration name without the file extension
                $migrationName = pathinfo($migration->getFilename(), PATHINFO_FILENAME);
                // Remove the migration record from the migrations table
                \DB::table('migrations')->where('migration', $migrationName)->delete();
            }
        }
    }

    protected function getInstalledModules()
    {
        $modules = [];

        if (File::exists($this->modulesPath)) {
            $directories = File::directories($this->modulesPath);

            foreach ($directories as $directory) {
                $moduleName = basename($directory);
                $configPath = $directory . '/module.json';

                if (File::exists($configPath)) {
                    $config = json_decode(File::get($configPath), true);
                    $modules[] = [
                        'name' => $moduleName,
                        'description' => $config['description'] ?? '',
                        'version' => $config['version'] ?? '1.0.0',
                        'active' => $config['active'] ?? false
                    ];
                }
            }
        }

        return $modules;
    }

    protected function registerModuleServiceProvider($moduleName)
    {
        try {
            $configPath = config_path('app.php');
            if (!File::exists($configPath)) {
                throw new \Exception('Config file not found');
            }

            $content = File::get($configPath);

            // Create the provider class strings
            $providers = [
                "Modules\\{$moduleName}\\Providers\\{$moduleName}ServiceProvider::class",
            ];

            // Find the providers array section
            if (preg_match("/'providers'\s*=>\s*\[(.*?)\],/s", $content, $matches)) {
                // Get existing providers content
                $providersContent = $matches[1];

                // Add new providers before the last closing bracket
                $updatedProviders = rtrim($providersContent);
                foreach ($providers as $provider) {
                    if (strpos($content, $provider) === false) {
                        $updatedProviders .= "\n        " . $provider . ",";
                    }
                }
                $updatedProviders .= "\n    ";

                // Replace old providers content with updated one
                $newContent = str_replace($matches[1], $updatedProviders, $content);

                // Validate before saving
                if ($this->validateConfigSyntax($newContent)) {
                    File::put($configPath, $newContent);
                    return true;
                }
            }

            throw new \Exception('Could not locate providers array in config/app.php');

        } catch (\Exception $e) {
            \Log::error("Failed to register module provider: " . $e->getMessage());
            throw $e;
        }
    }

    protected function removeModuleServiceProvider($moduleName)
    {
        try {
            $configPath = config_path('app.php');
            if (!File::exists($configPath)) {
                throw new \Exception('Config file not found');
            }

            $content = File::get($configPath);

            // Define providers to remove
            $providers = [
                "Modules\\{$moduleName}\\Providers\\{$moduleName}ServiceProvider::class",
                "Modules\\{$moduleName}\\Providers\\RouteServiceProvider::class"
            ];

            foreach ($providers as $provider) {
                // Remove the provider and any trailing comma
                $pattern = "/\s*" . preg_quote($provider, '/') . ",?\s*/";
                $content = preg_replace($pattern, '', $content);
            }

            // Clean up any double commas and empty lines
            $content = preg_replace("/,\s*,/", ",", $content);
            $content = preg_replace("/\n\s*\n/", "\n", $content); // Remove extra new lines

            // Validate before saving
            if ($this->validateConfigSyntax($content)) {
                File::put($configPath, $content);
                return true;
            }

            throw new \Exception('Failed to validate modified config file');

        } catch (\Exception $e) {
            \Log::error("Failed to remove module provider: " . $e->getMessage());
            throw $e;
        }
    }

    protected function validateConfigSyntax($content)
    {
        try {
            // Create a temporary file
            $tempFile = storage_path('app/temp/config_validate.php');
            File::put($tempFile, $content);

            // Try to include the file
            include $tempFile;

            // Clean up
            File::delete($tempFile);

            return true;
        } catch (\Throwable $e) {
            \Log::error("Config validation failed: " . $e->getMessage());
            if (File::exists($tempFile)) {
                File::delete($tempFile);
            }
            return false;
        }
    }
}
