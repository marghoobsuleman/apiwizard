# APIWizard - Laravel API Generator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/marghoobsuleman/apiwizard.svg?style=flat-square)](https://packagist.org/packages/marghoobsuleman/apiwizard)
[![Total Downloads](https://img.shields.io/packagist/dt/marghoobsuleman/apiwizard.svg?style=flat-square)](https://packagist.org/packages/marghoobsuleman/apiwizard)

A powerful Laravel package that generates models, relations, and complete REST APIs from an interactive command line interface or via command options.

## ✨ Features

- 🎯 **Interactive CLI** - User-friendly prompts guide you through the generation process
- 🚀 **Quick Generation** - Create models, controllers, and routes in seconds
- 🔗 **Automatic Relations** - Define and generate model relationships effortlessly
- 🔄 **Safe Updates** - Add relations to existing models without overwriting code
- 🎨 **Data Transformation** - Optional transform methods for customizing API responses
- 📦 **Complete REST API** - Generates full CRUD endpoints automatically
- ⚙️ **Non-Interactive Mode** - Use command options for automation and scripting
- 🛠️ **Customizable** - Publish and modify stubs to match your coding style
- 📝 **PSR-4 Compliant** - Follows Laravel and PHP best practices

## 📋 Requirements

- PHP 8.2 or higher
- Laravel 11.x or 12.x

## 📦 Installation

Install the package via Composer:

```bash
composer require marghoobsuleman/apiwizard
```

The package will automatically register its service provider.

### Publish Configuration (Optional)

```bash
php artisan vendor:publish --tag=apiwizard-config
```

### Publish Stubs (Optional)

```bash
php artisan vendor:publish --tag=apiwizard-stubs
```

## 🚀 Usage

### Available Commands

The package provides two commands (both work identically):

```bash
php artisan apiwizard:generate
# OR
php artisan modelwizard:generate
```

### Interactive Mode

Run the command and follow the prompts:

```bash
php artisan apiwizard:generate
```

#### Example Interactive Session:

```
🧙 APIWizard - Laravel API Generator

Enter table name: users
Model name will be: User

Does it have any relations? (yes/no): yes
Enter related table name: posts
Type of relation:
  [0] hasOne
  [1] hasMany
  [2] belongsTo
  [3] belongsToMany
 > 1

✓ Added hasMany relation with posts

Add another relation? (yes/no): no

Do you want to modify returned data (add transform method)? (yes/no): yes

Do you want to create an API endpoint? (yes/no): yes
Enter API endpoint [/api/users]: /api/users

🔨 Generating files...

✓ Model created: /app/Models/User.php
✓ Related model created: /app/Models/Post.php
✓ Controller created: /app/Http/Controllers/API/UserController.php
✓ Routes added to: routes/api.php

✅ Generation completed successfully!
```

### Non-Interactive Mode

Use command options for automation:

```bash
php artisan apiwizard:generate --table=users --relations=posts:hasMany --endpoint=/api/users --transform
```

#### Available Options:

| Option | Description | Example |
|--------|-------------|---------|
| `--table` | Table name (required for non-interactive) | `--table=users` |
| `--relations` | Relations in format "table:type" (can be used multiple times) | `--relations=posts:hasMany --relations=profile:hasOne` |
| `--endpoint` | API endpoint path | `--endpoint=/api/users` |
| `--transform` | Include transform method in model | `--transform` |
| `--no-api` | Skip API generation (model only) | `--no-api` |

#### Examples:

**Generate model with multiple relations:**
```bash
php artisan apiwizard:generate \
  --table=users \
  --relations=posts:hasMany \
  --relations=profile:hasOne \
  --relations=roles:belongsToMany \
  --endpoint=/api/users \
  --transform
```

**Generate model without API:**
```bash
php artisan apiwizard:generate --table=products --no-api
```

**Simple model with API:**
```bash
php artisan apiwizard:generate --table=categories --endpoint=/api/categories
```

## 📚 What Gets Generated

### 1. Model File

Generated at `app/Models/{ModelName}.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';
    
    protected $fillable = [
        // Add your fillable attributes here
    ];

    // Relations
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Transform method (if requested)
    public function transform(): array
    {
        return [
            'id' => $this->id,
            // Add your custom transformations here
        ];
    }
}
```

### 2. Controller File

Generated at `app/Http/Controllers/API/{ModelName}Controller.php`:

```php
<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(15);
        
        return response()->json([
            'success' => true,
            'data' => $users->map(fn($item) => $item->transform()),
            'pagination' => [
                'total' => $users->total(),
                'per_page' => $users->perPage(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
            ],
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $user->transform(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Add your validation rules here
        ]);

        $user = User::create($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            // Add your validation rules here
        ]);

        $user->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => $user,
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
        ]);
    }
}
```

### 3. API Routes

Added to `routes/api.php`:

```php
// UserController routes
Route::apiResource('users', \App\Http\Controllers\API\UserController::class);
```

This creates the following endpoints:
- `GET /api/users` - List all users (paginated)
- `POST /api/users` - Create a new user
- `GET /api/users/{id}` - Show a specific user
- `PUT/PATCH /api/users/{id}` - Update a user
- `DELETE /api/users/{id}` - Delete a user

## ⚙️ Configuration

After publishing the config file, you can customize:

```php
return [
    // Model namespace
    'model_namespace' => 'App\\Models',

    // Controller namespace
    'controller_namespace' => 'App\\Http\\Controllers\\API',

    // Model path
    'model_path' => app_path('Models'),

    // Controller path
    'controller_path' => app_path('Http/Controllers/API'),

    // Routes file
    'routes_file' => base_path('routes/api.php'),

    // Default pagination
    'pagination' => 15,
];
```

## 🎨 Customizing Stubs

Publish the stubs and modify them to match your preferences:

```bash
php artisan vendor:publish --tag=apiwizard-stubs
```

Stubs will be published to `stubs/apiwizard/`:
- `model.stub` - Model template
- `controller.stub` - Controller template

## 🔗 Supported Relation Types

- **hasOne** - One-to-one relationship
- **hasMany** - One-to-many relationship
- **belongsTo** - Inverse of one-to-many
- **belongsToMany** - Many-to-many relationship

## 💡 Tips & Best Practices

1. **Always review generated code** - The package creates a solid foundation, but you should review and customize:
   - Add proper validation rules in controllers
   - Define fillable/guarded attributes in models
   - Customize transform methods for your API responses

2. **Use transform methods** - They provide a clean way to control API output without cluttering controllers

3. **Leverage non-interactive mode** - Perfect for:
   - CI/CD pipelines
   - Seeding multiple models
   - Scripted setups

4. **Customize stubs** - Publish and modify stubs to match your team's coding standards

## 🧪 Testing

Run the tests with:

```bash
composer test
```

## 📝 Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 🔒 Security

If you discover any security-related issues, please email security@example.com instead of using the issue tracker.

## 📄 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## 👏 Credits

- [Marghoob Suleman](https://github.com/marghoobsuleman)
- [All Contributors](../../contributors)

## 🌟 Support

If you find this package helpful, please consider giving it a ⭐️ on GitHub!

---

Made with ❤️ for the Laravel community
