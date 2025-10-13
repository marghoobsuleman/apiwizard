<?php

namespace MarghoobSuleman\APIWizard\Console\Commands;

use Illuminate\Console\Command;
use MarghoobSuleman\APIWizard\Generators\ModelGenerator;
use MarghoobSuleman\APIWizard\Generators\ControllerGenerator;
use MarghoobSuleman\APIWizard\Generators\RouteGenerator;
use Illuminate\Support\Str;

class GenerateAPICommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apiwizard:generate
                            {--table= : The table name}
                            {--relations=* : Relations in format "table:relationType"}
                            {--endpoint= : API endpoint path}
                            {--transform : Include transform method}
                            {--no-api : Skip API generation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate models, relations, and APIs interactively or via options';

    protected string $tableName;
    protected string $modelName;
    protected array $relations = [];
    protected bool $hasTransform = false;
    protected bool $createAPI = true;
    protected string $endpoint = '';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🧙 APIWizard - Laravel API Generator');
        $this->newLine();

        // Check if running in non-interactive mode
        if ($this->hasOptions()) {
            return $this->handleNonInteractive();
        }

        // Interactive mode
        return $this->handleInteractive();
    }

    /**
     * Check if command has options provided.
     */
    protected function hasOptions(): bool
    {
        return $this->option('table') !== null;
    }

    /**
     * Handle non-interactive mode with options.
     */
    protected function handleNonInteractive(): int
    {
        $this->tableName = $this->option('table');
        $this->modelName = Str::studly(Str::singular($this->tableName));

        // Parse relations
        $relationsOption = $this->option('relations');
        if (!empty($relationsOption)) {
            foreach ($relationsOption as $relation) {
                if (str_contains($relation, ':')) {
                    [$table, $type] = explode(':', $relation, 2);
                    $this->relations[] = [
                        'table' => $table,
                        'type' => $type,
                    ];
                }
            }
        }

        $this->hasTransform = $this->option('transform');
        $this->createAPI = !$this->option('no-api');
        $this->endpoint = $this->option('endpoint') ?: '/api/' . Str::plural(Str::kebab($this->modelName));

        return $this->generateAll();
    }

    /**
     * Handle interactive mode with prompts.
     */
    protected function handleInteractive(): int
    {
        // Ask for table name
        $this->tableName = $this->ask('Enter table name');
        
        if (empty($this->tableName)) {
            $this->error('Table name is required!');
            return self::FAILURE;
        }

        $this->modelName = Str::studly(Str::singular($this->tableName));
        $this->info("Model name will be: {$this->modelName}");
        $this->newLine();

        // Ask about relations
        $hasRelations = $this->confirm('Does it have any relations?', false);

        if ($hasRelations) {
            $this->askForRelations();
        }

        // Ask about data transformation
        $this->hasTransform = $this->confirm('Do you want to modify returned data (add transform method)?', false);

        // Ask about API endpoint
        $this->createAPI = $this->confirm('Do you want to create an API endpoint?', true);

        if ($this->createAPI) {
            $defaultEndpoint = '/' . Str::plural(Str::kebab($this->modelName));
            $this->endpoint = $this->ask('Enter API endpoint', $defaultEndpoint);
        }

        return $this->generateAll();
    }

    /**
     * Ask for relations interactively.
     */
    protected function askForRelations(): void
    {
        do {
            $relatedTable = $this->ask('Enter related table name');
            
            if (empty($relatedTable)) {
                break;
            }

            $relationType = $this->choice(
                'Type of relation',
                ['hasOne', 'hasMany', 'belongsTo', 'belongsToMany'],
                1
            );

            $this->relations[] = [
                'table' => $relatedTable,
                'type' => $relationType,
            ];

            $this->info("✓ Added {$relationType} relation with {$relatedTable}");
            $this->newLine();

            $addMore = $this->confirm('Add another relation?', false);
        } while ($addMore);
    }

    /**
     * Generate all components.
     */
    protected function generateAll(): int
    {
        $this->newLine();
        $this->info('🔨 Generating files...');
        $this->newLine();

        try {
            // Generate main model
            $modelGenerator = new ModelGenerator($this->modelName, $this->tableName);
            
            if ($this->hasTransform) {
                $modelGenerator->withTransform(true);
            }

            // Add relations
            foreach ($this->relations as $relation) {
                $relatedModelName = Str::studly(Str::singular($relation['table']));
                $modelGenerator->addRelation($relatedModelName, $relation['type']);

                // Generate related model if it doesn't exist
                $this->generateRelatedModel($relation['table'], $relatedModelName);
            }

            $modelPath = $modelGenerator->generate();
            $this->info("✓ Model created: {$modelPath}");

            // Generate controller and routes if API is requested
            if ($this->createAPI) {
                $this->generateAPI($modelGenerator);
            }

            $this->newLine();
            $this->info('✅ Generation completed successfully!');
            $this->newLine();

            // Display summary
            $this->displaySummary();

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return self::FAILURE;
        }
    }

    /**
     * Generate related model.
     */
    protected function generateRelatedModel(string $tableName, string $modelName): void
    {
        $modelPath = config('apiwizard.model_path', app_path('Models')) . '/' . $modelName . '.php';

        if (!file_exists($modelPath)) {
            $relatedGenerator = new ModelGenerator($modelName, $tableName);
            $path = $relatedGenerator->generate();
            $this->info("✓ Related model created: {$path}");
        }
    }

    /**
     * Generate API components (controller and routes).
     */
    protected function generateAPI(ModelGenerator $modelGenerator): void
    {
        // Generate controller
        $controllerGenerator = new ControllerGenerator(
            $modelGenerator->getModelName(),
            $modelGenerator->getNamespace(),
            $this->hasTransform
        );

        $controllerPath = $controllerGenerator->generate();
        $this->info("✓ Controller created: {$controllerPath}");

        // Generate routes
        $routeGenerator = new RouteGenerator(
            $this->endpoint,
            $controllerGenerator->getControllerName(),
            $controllerGenerator->getNamespace()
        );

        if ($routeGenerator->generate()) {
            $this->info("✓ Routes added to: " . config('apiwizard.routes_file', 'routes/api.php'));
        } else {
            $this->warn("⚠ Route already exists for: {$this->endpoint}");
        }
    }

    /**
     * Display generation summary.
     */
    protected function displaySummary(): void
    {
        $this->info('📋 Summary:');
        $this->table(
            ['Component', 'Details'],
            [
                ['Table', $this->tableName],
                ['Model', $this->modelName],
                ['Relations', count($this->relations) > 0 ? implode(', ', array_map(fn($r) => "{$r['table']} ({$r['type']})", $this->relations)) : 'None'],
                ['Transform', $this->hasTransform ? 'Yes' : 'No'],
                ['API Endpoint', $this->createAPI ? $this->endpoint : 'Not created'],
            ]
        );

        if ($this->createAPI) {
            $this->newLine();
            $this->info('🚀 Available API endpoints:');
            $endpoint = ltrim($this->endpoint, '/');
            $this->line("  GET    /{$endpoint}           - List all");
            $this->line("  POST   /{$endpoint}           - Create new");
            $this->line("  GET    /{$endpoint}/{id}      - Show single");
            $this->line("  PUT    /{$endpoint}/{id}      - Update");
            $this->line("  DELETE /{$endpoint}/{id}      - Delete");
        }

        $this->newLine();
        $this->info('💡 Next steps:');
        $this->line('  1. Update the $fillable array in your model');
        $this->line('  2. Add validation rules in the controller');
        if ($this->hasTransform) {
            $this->line('  3. Customize the transform() method in your model');
        }
    }
}
