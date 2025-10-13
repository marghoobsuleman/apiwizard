# Installation Guide

Complete guide for installing and configuring APIWizard in your Laravel project.

## Requirements

Before installing APIWizard, ensure your system meets these requirements:

- **PHP**: 8.0 or higher
- **Laravel**: 9.x, 10.x, or 11.x
- **Composer**: Latest version recommended

## Installation Steps

### Step 1: Install via Composer

```bash
composer require marghoobsuleman/apiwizard
```

### Step 2: Verify Installation

Check that the package is installed correctly:

```bash
php artisan list | grep wizard
```

You should see:
```
apiwizard:generate    Generate models, relations, and APIs
modelwizard:generate  Generate models, relations, and APIs (alias)
```

### Step 3: Publish Configuration (Optional)

If you want to customize the package configuration:

```bash
php artisan vendor:publish --tag=apiwizard-config
```

This creates `config/apiwizard.php` where you can customize:
- Model namespace and path
- Controller namespace and path
- Routes file location
- Default pagination settings

### Step 4: Publish Stubs (Optional)

To customize the generated code templates:

```bash
php artisan vendor:publish --tag=apiwizard-stubs
```

This creates stub files in `stubs/apiwizard/` that you can modify.

## Configuration

### Default Configuration

The package works out of the box with Laravel's default structure:

```php
return [
    'model_namespace' => 'App\\Models',
    'controller_namespace' => 'App\\Http\\Controllers\\API',
    'model_path' => app_path('Models'),
    'controller_path' => app_path('Http/Controllers/API'),
    'routes_file' => base_path('routes/api.php'),
    'pagination' => 15,
];
```

### Custom Configuration

If your project uses a different structure, update `config/apiwizard.php`:

```php
return [
    // Custom model location
    'model_namespace' => 'Domain\\Models',
    'model_path' => base_path('src/Domain/Models'),
    
    // Custom controller location
    'controller_namespace' => 'App\\Api\\Controllers',
    'controller_path' => app_path('Api/Controllers'),
    
    // Custom routes file
    'routes_file' => base_path('routes/api-v1.php'),
    
    // Custom pagination
    'pagination' => 20,
];
```

## Verification

### Test the Installation

Run a simple test to ensure everything works:

```bash
php artisan apiwizard:generate --table=test_items --no-api
```

This should create a `TestItem` model in your models directory.

### Clean Up Test Files

Remove the test model:

```bash
rm app/Models/TestItem.php
```

## Troubleshooting

### Command Not Found

If the command is not available:

1. Clear the cache:
```bash
php artisan cache:clear
php artisan config:clear
```

2. Regenerate autoload files:
```bash
composer dump-autoload
```

3. Check if the service provider is registered:
```bash
php artisan about
```

### Permission Issues

If you encounter permission errors:

```bash
# Make sure directories are writable
chmod -R 755 app/Models
chmod -R 755 app/Http/Controllers
```

### Namespace Issues

If generated files have incorrect namespaces:

1. Publish and update the configuration:
```bash
php artisan vendor:publish --tag=apiwizard-config
```

2. Update namespaces in `config/apiwizard.php`

3. Regenerate files

## Updating

To update to the latest version:

```bash
composer update marghoobsuleman/apiwizard
```

After updating, you may want to republish the configuration:

```bash
php artisan vendor:publish --tag=apiwizard-config --force
```

## Uninstallation

To remove the package:

1. Remove via Composer:
```bash
composer remove marghoobsuleman/apiwizard
```

2. Remove published files (optional):
```bash
rm config/apiwizard.php
rm -rf stubs/apiwizard
```

## Next Steps

- 📖 Read the [Quick Start Guide](QUICKSTART.md)
- 💡 Check out [Examples](EXAMPLES.md)
- 📚 Review the full [Documentation](README.md)

## Getting Help

- 📝 [GitHub Issues](https://github.com/marghoobsuleman/apiwizard/issues)
- 💬 [Discussions](https://github.com/marghoobsuleman/apiwizard/discussions)
- 📧 Email: marghoobsuleman@gmail.com

## System Requirements Check

Run this command to check your system:

```bash
php -v  # Check PHP version
php artisan --version  # Check Laravel version
composer --version  # Check Composer version
```

Minimum versions:
- PHP: 8.0.0
- Laravel: 9.0.0
- Composer: 2.0.0

---

Happy coding! 🚀
