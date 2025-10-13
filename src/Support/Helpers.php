<?php

namespace MarghoobSuleman\APIWizard\Support;

use Illuminate\Support\Str;

class Helpers
{
    /**
     * Convert table name to model name.
     */
    public static function tableToModel(string $tableName): string
    {
        return Str::studly(Str::singular($tableName));
    }

    /**
     * Convert model name to table name.
     */
    public static function modelToTable(string $modelName): string
    {
        return Str::snake(Str::plural($modelName));
    }

    /**
     * Get relation method name based on relation type.
     */
    public static function getRelationMethodName(string $relatedModel, string $relationType): string
    {
        return match ($relationType) {
            'hasOne', 'belongsTo' => Str::camel(Str::singular($relatedModel)),
            'hasMany', 'belongsToMany' => Str::camel(Str::plural($relatedModel)),
            default => Str::camel($relatedModel),
        };
    }

    /**
     * Parse relation string (e.g., "posts:hasMany").
     */
    public static function parseRelation(string $relation): ?array
    {
        if (!str_contains($relation, ':')) {
            return null;
        }

        [$table, $type] = explode(':', $relation, 2);

        if (!in_array($type, ['hasOne', 'hasMany', 'belongsTo', 'belongsToMany'])) {
            return null;
        }

        return [
            'table' => trim($table),
            'type' => trim($type),
        ];
    }

    /**
     * Get default endpoint for a model.
     */
    public static function getDefaultEndpoint(string $modelName): string
    {
        return '/api/' . Str::plural(Str::kebab($modelName));
    }

    /**
     * Check if a file contains a specific method.
     */
    public static function fileContainsMethod(string $filePath, string $methodName): bool
    {
        if (!file_exists($filePath)) {
            return false;
        }

        $content = file_get_contents($filePath);
        return str_contains($content, "function {$methodName}(");
    }

    /**
     * Validate relation type.
     */
    public static function isValidRelationType(string $type): bool
    {
        return in_array($type, ['hasOne', 'hasMany', 'belongsTo', 'belongsToMany']);
    }

    /**
     * Get inverse relation type.
     */
    public static function getInverseRelationType(string $relationType): string
    {
        return match ($relationType) {
            'hasOne' => 'belongsTo',
            'hasMany' => 'belongsTo',
            'belongsTo' => 'hasMany',
            'belongsToMany' => 'belongsToMany',
            default => 'belongsTo',
        };
    }

    /**
     * Format file size for display.
     */
    public static function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }

    /**
     * Ensure directory exists.
     */
    public static function ensureDirectoryExists(string $path): void
    {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }
}
