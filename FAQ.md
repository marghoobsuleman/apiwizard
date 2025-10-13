# Frequently Asked Questions (FAQ)

## General Questions

### Q: What is APIWizard?
**A:** APIWizard is a Laravel package that automates the creation of models, relationships, controllers, and REST API endpoints through an interactive or command-line interface.

### Q: Is it free to use?
**A:** Yes! APIWizard is open-source and released under the MIT License, making it free for both personal and commercial projects.

### Q: Which Laravel versions are supported?
**A:** APIWizard supports Laravel 9.x, 10.x, and 11.x with PHP 8.0 or higher.

## Installation & Setup

### Q: How do I install APIWizard?
**A:** Simply run `composer require marghoobsuleman/apiwizard` in your Laravel project.

### Q: Do I need to register the service provider manually?
**A:** No, Laravel's package auto-discovery will automatically register the service provider.

### Q: Can I customize the generated code?
**A:** Yes! Publish the stubs with `php artisan vendor:publish --tag=apiwizard-stubs` and modify them to match your preferences.

### Q: Where are the generated files stored?
**A:** By default:
- Models: `app/Models/`
- Controllers: `app/Http/Controllers/API/`
- Routes: `routes/api.php`

You can customize these paths in the configuration file.

## Usage Questions

### Q: What's the difference between `apiwizard:generate` and `modelwizard:generate`?
**A:** They're identical commands. `modelwizard:generate` is an alias provided for convenience and backward compatibility.

### Q: Can I use this in non-interactive mode for automation?
**A:** Yes! Use command options like `--table=users --relations=posts:hasMany --endpoint=/api/users`

### Q: What if I only want to generate a model without an API?
**A:** Use the `--no-api` flag: `php artisan apiwizard:generate --table=users --no-api`

### Q: Can I add multiple relations at once?
**A:** Yes! Use the `--relations` option multiple times:
```bash
php artisan apiwizard:generate \
  --table=users \
  --relations=posts:hasMany \
  --relations=profile:hasOne \
  --relations=roles:belongsToMany
```

### Q: What happens if a model already exists?
**A:** The generator will update the existing model by adding new relations without overwriting existing code. Your existing relations, methods, and properties are preserved.

### Q: Can I add relations to an existing model without recreating it?
**A:** Yes! Simply run the command with the existing table name and new relations. The package will safely inject the new relation methods into your existing model:
```bash
php artisan apiwizard:generate \
  --table=users \
  --relations=posts:hasMany \
  --relations=comments:hasMany \
  --no-api
```
Your existing code, including other relations and methods, will be preserved. See [Example 7 in EXAMPLES.md](EXAMPLES.md#example-7-adding-relations-to-existing-models) for a detailed walkthrough.

### Q: Can I generate models for existing database tables?
**A:** Yes! Just provide the table name, and the package will create the model. However, you'll need to manually add the `$fillable` attributes based on your table columns.

## Relations

### Q: What relation types are supported?
**A:** APIWizard supports:
- `hasOne` - One-to-one relationship
- `hasMany` - One-to-many relationship
- `belongsTo` - Inverse of one-to-many
- `belongsToMany` - Many-to-many relationship

### Q: Does it create pivot tables for belongsToMany relations?
**A:** No, you need to create the pivot table migration manually. The package only generates the model relationship methods.

### Q: Can I specify custom foreign keys?
**A:** Not directly through the command. After generation, you can manually edit the relationship methods to add custom foreign keys:
```php
public function posts()
{
    return $this->hasMany(Post::class, 'author_id', 'id');
}
```

### Q: Are inverse relations created automatically?
**A:** Yes! When you create a relation, the package automatically generates the related model if it doesn't exist.

## Transform Methods

### Q: What is a transform method?
**A:** A transform method allows you to customize the data structure returned by your API, providing a clean way to format responses without cluttering controllers.

### Q: When should I use transform methods?
**A:** Use them when you need to:
- Format dates or numbers
- Hide sensitive fields
- Include computed properties
- Restructure nested relationships
- Add custom attributes

### Q: Can I skip the transform method?
**A:** Yes! Simply answer "no" when prompted or omit the `--transform` flag in non-interactive mode.

## API Generation

### Q: What endpoints are created?
**A:** A complete REST API with:
- `GET /api/resource` - List all (paginated)
- `POST /api/resource` - Create new
- `GET /api/resource/{id}` - Show single
- `PUT/PATCH /api/resource/{id}` - Update
- `DELETE /api/resource/{id}` - Delete

### Q: How do I add authentication to generated APIs?
**A:** Add middleware to your routes:
```php
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
});
```

### Q: Can I customize the API response format?
**A:** Yes! Edit the generated controller or publish and modify the controller stub.

### Q: How do I add validation rules?
**A:** After generation, update the controller methods with your validation rules:
```php
$validated = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
]);
```

### Q: Is pagination automatic?
**A:** Yes! The `index` method includes pagination by default (15 items per page). You can customize this in the config file.

## Customization

### Q: Can I change the default namespace?
**A:** Yes! Publish the config file and update the namespaces:
```bash
php artisan vendor:publish --tag=apiwizard-config
```

### Q: How do I customize the generated code structure?
**A:** Publish the stubs and modify them:
```bash
php artisan vendor:publish --tag=apiwizard-stubs
```

### Q: Can I use this with a custom directory structure?
**A:** Yes! Update the paths in `config/apiwizard.php` to match your structure.

### Q: Can I change the pagination limit?
**A:** Yes! Update the `pagination` value in the config file or modify the controller after generation.

## Troubleshooting

### Q: The command is not found after installation
**A:** Try:
1. `composer dump-autoload`
2. `php artisan cache:clear`
3. `php artisan config:clear`

### Q: Generated files have wrong namespaces
**A:** Publish and update the configuration file with correct namespaces for your project.

### Q: Permission denied when creating files
**A:** Ensure your directories are writable:
```bash
chmod -R 755 app/Models
chmod -R 755 app/Http/Controllers
```

### Q: Routes are not working
**A:** Make sure your `routes/api.php` is loaded in `RouteServiceProvider` and check that the route prefix is correct (usually `/api`).

### Q: Generated controller has errors
**A:** Ensure all required imports are present. The package adds necessary imports, but if you've customized stubs, verify the imports are correct.

## Best Practices

### Q: Should I commit generated files to version control?
**A:** Yes! Generated files are part of your application code and should be committed.

### Q: Should I modify generated files?
**A:** Yes! The generated code is a starting point. You should:
- Add validation rules
- Update `$fillable` attributes
- Customize transform methods
- Add business logic
- Implement authorization

### Q: How do I handle API versioning?
**A:** Create separate route files for each version and update the `routes_file` config accordingly, or use route prefixes:
```php
Route::prefix('v1')->group(function () {
    Route::apiResource('users', UserController::class);
});
```

### Q: Should I use transform methods or API Resources?
**A:** Both are valid approaches:
- **Transform methods**: Simpler, built into models, good for basic transformations
- **API Resources**: More powerful, better for complex scenarios, Laravel's recommended approach

You can use transform methods initially and migrate to API Resources as your needs grow.

## Performance

### Q: Does this package affect runtime performance?
**A:** No! The package only runs during development when you execute the command. Generated code has no performance overhead.

### Q: Should I eager load relations?
**A:** Yes! For better performance, add eager loading in your controller:
```php
$users = User::with(['posts', 'profile'])->paginate(15);
```

## Contributing

### Q: How can I contribute?
**A:** Check out [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines on submitting issues, pull requests, and improvements.

### Q: I found a bug, what should I do?
**A:** Please open an issue on GitHub with:
- Laravel version
- PHP version
- Package version
- Steps to reproduce
- Expected vs actual behavior

### Q: Can I request new features?
**A:** Absolutely! Open a feature request on GitHub with a detailed description of the feature and use case.

## Support

### Q: Where can I get help?
**A:** 
- 📖 Read the [documentation](README.md)
- 💡 Check [examples](EXAMPLES.md)
- 🐛 [Open an issue](https://github.com/marghoobsuleman/apiwizard/issues)
- 💬 [Start a discussion](https://github.com/marghoobsuleman/apiwizard/discussions)

### Q: Is commercial support available?
**A:** Contact the maintainers for commercial support options.

---

**Still have questions?** Open an issue on GitHub or start a discussion!
