<?php

namespace MarghoobSuleman\APIWizard\Generators;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ControllerGenerator
{
    protected string $controllerName;
    protected string $modelName;
    protected string $modelNamespace;
    protected bool $hasTransform;
    protected string $controllerPath;
    protected string $namespace;

    public function __construct(string $modelName, string $modelNamespace, bool $hasTransform = false)
    {
        $this->modelName = Str::studly(Str::singular($modelName));
        $this->controllerName = $this->modelName . 'Controller';
        $this->modelNamespace = $modelNamespace;
        $this->hasTransform = $hasTransform;
        $this->controllerPath = config('apiwizard.controller_path', app_path('Http/Controllers/API'));
        $this->namespace = config('apiwizard.controller_namespace', 'App\\Http\\Controllers\\API');
    }

    public function generate(): string
    {
        $filePath = $this->controllerPath . '/' . $this->controllerName . '.php';

        // Ensure directory exists
        if (!File::isDirectory($this->controllerPath)) {
            File::makeDirectory($this->controllerPath, 0755, true);
        }

        $stub = $this->getStub();
        $content = $this->replaceStubVariables($stub);

        File::put($filePath, $content);

        return $filePath;
    }

    protected function getStub(): string
    {
        $stubPath = base_path('stubs/apiwizard/controller.stub');

        if (File::exists($stubPath)) {
            return File::get($stubPath);
        }

        return File::get(__DIR__ . '/../../stubs/controller.stub');
    }

    protected function replaceStubVariables(string $stub): string
    {
        $modelVariable = Str::camel($this->modelName);
        $modelVariablePlural = Str::camel(Str::plural($this->modelName));

        $replacements = [
            '{{ namespace }}' => $this->namespace,
            '{{ modelNamespace }}' => $this->modelNamespace,
            '{{ class }}' => $this->controllerName,
            '{{ model }}' => $this->modelName,
            '{{ modelVariable }}' => $modelVariable,
            '{{ modelVariablePlural }}' => $modelVariablePlural,
            '{{ indexMethod }}' => $this->generateIndexMethod(),
            '{{ showMethod }}' => $this->generateShowMethod(),
            '{{ storeMethod }}' => $this->generateStoreMethod(),
            '{{ updateMethod }}' => $this->generateUpdateMethod(),
            '{{ destroyMethod }}' => $this->generateDestroyMethod(),
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $stub);
    }

    protected function generateIndexMethod(): string
    {
        $modelVariable = Str::camel(Str::plural($this->modelName));
        $pagination = config('apiwizard.pagination', 15);

        if ($this->hasTransform) {
            return <<<PHP
    public function index()
    {
        \${$modelVariable} = {$this->modelName}::paginate({$pagination});
        
        return response()->json([
            'success' => true,
            'data' => \${$modelVariable}->map(fn(\$item) => \$item->transform()),
            'pagination' => [
                'total' => \${$modelVariable}->total(),
                'per_page' => \${$modelVariable}->perPage(),
                'current_page' => \${$modelVariable}->currentPage(),
                'last_page' => \${$modelVariable}->lastPage(),
            ],
        ]);
    }
PHP;
        }

        return <<<PHP
    public function index()
    {
        \${$modelVariable} = {$this->modelName}::paginate({$pagination});
        
        return response()->json([
            'success' => true,
            'data' => \${$modelVariable}->items(),
            'pagination' => [
                'total' => \${$modelVariable}->total(),
                'per_page' => \${$modelVariable}->perPage(),
                'current_page' => \${$modelVariable}->currentPage(),
                'last_page' => \${$modelVariable}->lastPage(),
            ],
        ]);
    }
PHP;
    }

    protected function generateShowMethod(): string
    {
        $modelVariable = Str::camel($this->modelName);

        if ($this->hasTransform) {
            return <<<PHP
    public function show(\$id)
    {
        \${$modelVariable} = {$this->modelName}::findOrFail(\$id);
        
        return response()->json([
            'success' => true,
            'data' => \${$modelVariable}->transform(),
        ]);
    }
PHP;
        }

        return <<<PHP
    public function show(\$id)
    {
        \${$modelVariable} = {$this->modelName}::findOrFail(\$id);
        
        return response()->json([
            'success' => true,
            'data' => \${$modelVariable},
        ]);
    }
PHP;
    }

    protected function generateStoreMethod(): string
    {
        $modelVariable = Str::camel($this->modelName);

        return <<<PHP
    public function store(Request \$request)
    {
        \$validated = \$request->validate([
            // Add your validation rules here
        ]);

        \${$modelVariable} = {$this->modelName}::create(\$validated);
        
        return response()->json([
            'success' => true,
            'message' => '{$this->modelName} created successfully',
            'data' => \${$modelVariable},
        ], 201);
    }
PHP;
    }

    protected function generateUpdateMethod(): string
    {
        $modelVariable = Str::camel($this->modelName);

        return <<<PHP
    public function update(Request \$request, \$id)
    {
        \${$modelVariable} = {$this->modelName}::findOrFail(\$id);
        
        \$validated = \$request->validate([
            // Add your validation rules here
        ]);

        \${$modelVariable}->update(\$validated);
        
        return response()->json([
            'success' => true,
            'message' => '{$this->modelName} updated successfully',
            'data' => \${$modelVariable},
        ]);
    }
PHP;
    }

    protected function generateDestroyMethod(): string
    {
        $modelVariable = Str::camel($this->modelName);

        return <<<PHP
    public function destroy(\$id)
    {
        \${$modelVariable} = {$this->modelName}::findOrFail(\$id);
        \${$modelVariable}->delete();
        
        return response()->json([
            'success' => true,
            'message' => '{$this->modelName} deleted successfully',
        ]);
    }
PHP;
    }

    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }
}
