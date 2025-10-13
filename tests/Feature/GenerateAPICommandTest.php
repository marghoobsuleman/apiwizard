<?php

namespace MarghoobSuleman\APIWizard\Tests\Feature;

use MarghoobSuleman\APIWizard\Tests\TestCase;
use Illuminate\Support\Facades\File;

class GenerateAPICommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Clean up any test files
        $this->cleanupTestFiles();
    }

    protected function tearDown(): void
    {
        // Clean up after tests
        $this->cleanupTestFiles();
        
        parent::tearDown();
    }

    protected function cleanupTestFiles(): void
    {
        $modelPath = app_path('Models/TestModel.php');
        $controllerPath = app_path('Http/Controllers/API/TestModelController.php');
        
        if (File::exists($modelPath)) {
            File::delete($modelPath);
        }
        
        if (File::exists($controllerPath)) {
            File::delete($controllerPath);
        }
    }

    /** @test */
    public function it_can_generate_model_with_non_interactive_mode()
    {
        $this->artisan('apiwizard:generate', [
            '--table' => 'test_models',
            '--no-api' => true,
        ])->assertExitCode(0);

        $this->assertTrue(File::exists(app_path('Models/TestModel.php')));
    }

    /** @test */
    public function it_can_generate_model_with_relations()
    {
        $this->artisan('apiwizard:generate', [
            '--table' => 'test_models',
            '--relations' => ['posts:hasMany'],
            '--no-api' => true,
        ])->assertExitCode(0);

        $modelContent = File::get(app_path('Models/TestModel.php'));
        $this->assertStringContainsString('function posts()', $modelContent);
        $this->assertStringContainsString('hasMany', $modelContent);
    }

    /** @test */
    public function it_can_generate_model_with_transform_method()
    {
        $this->artisan('apiwizard:generate', [
            '--table' => 'test_models',
            '--transform' => true,
            '--no-api' => true,
        ])->assertExitCode(0);

        $modelContent = File::get(app_path('Models/TestModel.php'));
        $this->assertStringContainsString('function transform()', $modelContent);
    }

    /** @test */
    public function it_can_generate_complete_api()
    {
        $this->artisan('apiwizard:generate', [
            '--table' => 'test_models',
            '--endpoint' => '/api/test-models',
        ])->assertExitCode(0);

        $this->assertTrue(File::exists(app_path('Models/TestModel.php')));
        $this->assertTrue(File::exists(app_path('Http/Controllers/API/TestModelController.php')));
    }

    /** @test */
    public function it_requires_table_name_in_non_interactive_mode()
    {
        $this->artisan('apiwizard:generate')
            ->expectsQuestion('Enter table name', '')
            ->assertExitCode(1);
    }
}
