<?php

namespace MarghoobSuleman\APIWizard\Generators;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ModelGenerator
{
    protected string $modelName;
    protected string $tableName;
    protected array $relations = [];
    protected bool $hasTransform = false;
    protected string $modelPath;
    protected string $namespace;

    public function __construct(string $modelName, string $tableName)
    {
        $this->modelName = Str::studly(Str::singular($modelName));
        $this->tableName = $tableName;
        $this->modelPath = config('apiwizard.model_path', app_path('Models'));
        $this->namespace = config('apiwizard.model_namespace', 'App\\Models');
    }

    public function addRelation(string $relatedModel, string $relationType): self
    {
        $this->relations[] = [
            'model' => Str::studly(Str::singular($relatedModel)),
            'type' => $relationType,
        ];

        return $this;
    }

    public function withTransform(bool $hasTransform = true): self
    {
        $this->hasTransform = $hasTransform;
        return $this;
    }

    public function generate(): string
    {
        $filePath = $this->modelPath . '/' . $this->modelName . '.php';

        // Check if model already exists
        if (File::exists($filePath)) {
            // Update existing model
            return $this->updateExistingModel($filePath);
        }

        // Create new model
        return $this->createNewModel($filePath);
    }

    protected function createNewModel(string $filePath): string
    {
        $stub = $this->getStub();
        $content = $this->replaceStubVariables($stub);

        // Ensure directory exists
        if (!File::isDirectory($this->modelPath)) {
            File::makeDirectory($this->modelPath, 0755, true);
        }

        File::put($filePath, $content);

        return $filePath;
    }

    protected function updateExistingModel(string $filePath): string
    {
        $content = File::get($filePath);

        // Add relations to existing model
        foreach ($this->relations as $relation) {
            if (!$this->hasRelationMethod($content, $relation['type'], $relation['model'])) {
                $content = $this->injectRelationMethod($content, $relation);
            }
        }

        // Add transform method if needed
        if ($this->hasTransform && !str_contains($content, 'function transform(')) {
            $content = $this->injectTransformMethod($content);
        }

        File::put($filePath, $content);

        return $filePath;
    }

    protected function getStub(): string
    {
        $stubPath = base_path('stubs/apiwizard/model.stub');

        if (File::exists($stubPath)) {
            return File::get($stubPath);
        }

        return File::get(__DIR__ . '/../../stubs/model.stub');
    }

    protected function replaceStubVariables(string $stub): string
    {
        $replacements = [
            '{{ namespace }}' => $this->namespace,
            '{{ class }}' => $this->modelName,
            '{{ table }}' => $this->tableName,
            '{{ relations }}' => $this->generateRelationMethods(),
            '{{ transform }}' => $this->hasTransform ? $this->generateTransformMethod() : '',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $stub);
    }

    protected function generateRelationMethods(): string
    {
        if (empty($this->relations)) {
            return '';
        }

        $methods = [];

        foreach ($this->relations as $relation) {
            $methods[] = $this->generateRelationMethod($relation);
        }

        return "\n" . implode("\n\n", $methods);
    }

    protected function generateRelationMethod(array $relation): string
    {
        $relatedModel = $relation['model'];
        $relationType = $relation['type'];
        $methodName = $this->getRelationMethodName($relatedModel, $relationType);

        $template = match ($relationType) {
            'hasOne' => "    public function {$methodName}()\n    {\n        return \$this->hasOne({$relatedModel}::class);\n    }",
            'hasMany' => "    public function {$methodName}()\n    {\n        return \$this->hasMany({$relatedModel}::class);\n    }",
            'belongsTo' => "    public function {$methodName}()\n    {\n        return \$this->belongsTo({$relatedModel}::class);\n    }",
            'belongsToMany' => "    public function {$methodName}()\n    {\n        return \$this->belongsToMany({$relatedModel}::class);\n    }",
            default => '',
        };

        return $template;
    }

    protected function getRelationMethodName(string $relatedModel, string $relationType): string
    {
        return match ($relationType) {
            'hasOne', 'belongsTo' => Str::camel(Str::singular($relatedModel)),
            'hasMany', 'belongsToMany' => Str::camel(Str::plural($relatedModel)),
            default => Str::camel($relatedModel),
        };
    }

    protected function generateTransformMethod(): string
    {
        return <<<'PHP'

    /**
     * Transform the model data for API response.
     *
     * @return array
     */
    public function transform(): array
    {
        return [
            'id' => $this->id,
            // Add your custom transformations here
        ];
    }
PHP;
    }

    protected function hasRelationMethod(string $content, string $relationType, string $relatedModel): bool
    {
        $methodName = $this->getRelationMethodName($relatedModel, $relationType);
        return str_contains($content, "function {$methodName}(");
    }

    protected function injectRelationMethod(string $content, array $relation): string
    {
        $method = $this->generateRelationMethod($relation);

        // Find the last closing brace of the class
        $lastBracePos = strrpos($content, '}');

        if ($lastBracePos !== false) {
            $content = substr_replace($content, "\n" . $method . "\n}\n", $lastBracePos, 1);
        }

        return $content;
    }

    protected function injectTransformMethod(string $content): string
    {
        $method = $this->generateTransformMethod();

        // Find the last closing brace of the class
        $lastBracePos = strrpos($content, '}');

        if ($lastBracePos !== false) {
            $content = substr_replace($content, $method . "\n}\n", $lastBracePos, 1);
        }

        return $content;
    }

    public function getModelName(): string
    {
        return $this->modelName;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }
}
