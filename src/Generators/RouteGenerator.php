<?php

namespace MarghoobSuleman\APIWizard\Generators;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RouteGenerator
{
    protected string $endpoint;
    protected string $controllerName;
    protected string $controllerNamespace;
    protected string $routesFile;

    public function __construct(string $endpoint, string $controllerName, string $controllerNamespace)
    {
        $this->endpoint = $endpoint;
        $this->controllerName = $controllerName;
        $this->controllerNamespace = $controllerNamespace;
        $this->routesFile = config('apiwizard.routes_file', base_path('routes/api.php'));
    }

    public function generate(): bool
    {
        if (!File::exists($this->routesFile)) {
            // Create routes file if it doesn't exist
            $this->createRoutesFile();
        }

        $content = File::get($this->routesFile);
        $routeDefinition = $this->generateRouteDefinition();

        // Check if route already exists
        if (str_contains($content, $this->endpoint)) {
            return false; // Route already exists
        }

        // Add route to file
        $content = $this->injectRoute($content, $routeDefinition);
        File::put($this->routesFile, $content);

        return true;
    }

    protected function createRoutesFile(): void
    {
        $content = <<<'PHP'
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
|
*/

PHP;

        File::put($this->routesFile, $content);
    }

    protected function generateRouteDefinition(): string
    {
        $fullControllerClass = $this->controllerNamespace . '\\' . $this->controllerName;
        $endpoint = ltrim($this->endpoint, '/');

        return <<<PHP

// {$this->controllerName} routes
Route::apiResource('{$endpoint}', \\{$fullControllerClass}::class);
PHP;
    }

    protected function injectRoute(string $content, string $routeDefinition): string
    {
        // Add route at the end of the file
        return rtrim($content) . "\n" . $routeDefinition . "\n";
    }
}
