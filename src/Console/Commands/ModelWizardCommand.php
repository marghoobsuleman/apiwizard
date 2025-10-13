<?php

namespace MarghoobSuleman\APIWizard\Console\Commands;

/**
 * Alias command for apiwizard:generate
 * Provides backward compatibility and alternative naming
 */
class ModelWizardCommand extends GenerateAPICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modelwizard:generate
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
    protected $description = 'Generate models, relations, and APIs (alias for apiwizard:generate)';
}
