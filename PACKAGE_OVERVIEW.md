# 🧙 APIWizard - Package Overview

> **Generate Laravel models, relations, and APIs from an interactive command line**

## 🎯 What is APIWizard?

APIWizard is a powerful Laravel package that **automates the creation** of:
- ✅ Eloquent Models
- ✅ Model Relationships
- ✅ REST API Controllers
- ✅ API Routes
- ✅ Data Transformations

All through an **interactive CLI** or **command-line options**.

---

## ⚡ Quick Example

### Before APIWizard (Manual Approach)
```bash
# 1. Create model
php artisan make:model User

# 2. Manually add relations to User.php
# 3. Create Post model
php artisan make:model Post

# 4. Manually add inverse relation to Post.php
# 5. Create controller
php artisan make:controller API/UserController

# 6. Manually write CRUD methods
# 7. Manually add routes to api.php
# 8. Manually add transform logic

# Time: ~30-45 minutes
```

### With APIWizard (Automated)
```bash
php artisan apiwizard:generate \
  --table=users \
  --relations=posts:hasMany \
  --endpoint=/api/users \
  --transform

# Time: ~10 seconds ⚡
```

**Result**: Complete REST API with model, relations, controller, routes, and transforms!

---

## 🎨 Visual Workflow

```
┌─────────────────────────────────────────────────────────────┐
│                    APIWizard Command                         │
│         php artisan apiwizard:generate                       │
└────────────────────┬────────────────────────────────────────┘
                     │
                     ▼
        ┌────────────────────────┐
        │  Interactive Prompts   │
        │  or Command Options    │
        └────────┬───────────────┘
                 │
                 ▼
    ┌────────────────────────────┐
    │   Model Generator          │
    │   • Creates User.php       │
    │   • Adds relations         │
    │   • Adds transform()       │
    └────────┬───────────────────┘
             │
             ▼
    ┌────────────────────────────┐
    │   Related Model Generator  │
    │   • Creates Post.php       │
    │   • Adds inverse relation  │
    └────────┬───────────────────┘
             │
             ▼
    ┌────────────────────────────┐
    │   Controller Generator     │
    │   • Creates UserController │
    │   • Adds CRUD methods      │
    │   • Adds pagination        │
    └────────┬───────────────────┘
             │
             ▼
    ┌────────────────────────────┐
    │   Route Generator          │
    │   • Adds to routes/api.php │
    │   • Creates REST endpoints │
    └────────┬───────────────────┘
             │
             ▼
    ┌────────────────────────────┐
    │   ✅ Complete API Ready!   │
    └────────────────────────────┘
```

---

## 📦 What You Get

### 1️⃣ Eloquent Model
```php
// app/Models/User.php
class User extends Model
{
    protected $table = 'users';
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
    public function transform(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            // Customize your output
        ];
    }
}
```

### 2️⃣ REST API Controller
```php
// app/Http/Controllers/API/UserController.php
class UserController extends Controller
{
    public function index()    // GET /api/users
    public function show($id)  // GET /api/users/{id}
    public function store()    // POST /api/users
    public function update()   // PUT /api/users/{id}
    public function destroy()  // DELETE /api/users/{id}
}
```

### 3️⃣ API Routes
```php
// routes/api.php
Route::apiResource('users', UserController::class);
```

### 4️⃣ JSON Responses
```json
{
  "success": true,
  "data": [...],
  "pagination": {
    "total": 100,
    "per_page": 15,
    "current_page": 1
  }
}
```

---

## 🚀 Key Features

### Interactive Mode
```
🧙 APIWizard - Laravel API Generator

Enter table name: users
Model name will be: User

Does it have any relations? (yes/no): yes
Enter related table name: posts
Type of relation: hasMany

Do you want to modify returned data? (yes/no): yes
Do you want to create an API endpoint? (yes/no): yes
Enter API endpoint [/api/users]: 

✅ Generation completed successfully!
```

### Non-Interactive Mode
```bash
# Perfect for automation and CI/CD
php artisan apiwizard:generate \
  --table=products \
  --relations=category:belongsTo \
  --relations=reviews:hasMany \
  --endpoint=/api/products \
  --transform
```

### Supported Relations
- **hasOne** → One-to-one (User → Profile)
- **hasMany** → One-to-many (User → Posts)
- **belongsTo** → Inverse (Post → User)
- **belongsToMany** → Many-to-many (User → Roles)

---

## 💡 Use Cases

### 1. Rapid Prototyping
Build MVPs faster by generating complete APIs in seconds.

### 2. Consistent Code
Maintain coding standards across your team with standardized generation.

### 3. Learning Tool
New to Laravel? See how models, controllers, and routes work together.

### 4. Time Saver
Eliminate repetitive boilerplate code and focus on business logic.

### 5. API Development
Quickly scaffold REST APIs for mobile apps, SPAs, and microservices.

---

## 🎓 Real-World Examples

### Blog System
```bash
# Posts with comments and author
php artisan apiwizard:generate \
  --table=posts \
  --relations=author:belongsTo \
  --relations=comments:hasMany \
  --endpoint=/api/posts \
  --transform
```

### E-commerce
```bash
# Products with category and reviews
php artisan apiwizard:generate \
  --table=products \
  --relations=category:belongsTo \
  --relations=reviews:hasMany \
  --relations=tags:belongsToMany \
  --endpoint=/api/products \
  --transform
```

### Social Network
```bash
# Users with posts and followers
php artisan apiwizard:generate \
  --table=users \
  --relations=posts:hasMany \
  --relations=followers:belongsToMany \
  --endpoint=/api/users \
  --transform
```

---

## 🛠️ Customization

### Publish Configuration
```bash
php artisan vendor:publish --tag=apiwizard-config
```

Customize:
- Model namespace and path
- Controller namespace and path
- Routes file location
- Pagination settings

### Publish Stubs
```bash
php artisan vendor:publish --tag=apiwizard-stubs
```

Modify templates to match your coding style.

---

## 📊 Comparison

| Task | Manual | APIWizard | Time Saved |
|------|--------|-----------|------------|
| Create Model | 5 min | Instant | 5 min |
| Add Relations | 10 min | Instant | 10 min |
| Create Controller | 15 min | Instant | 15 min |
| Add CRUD Methods | 20 min | Instant | 20 min |
| Add Routes | 5 min | Instant | 5 min |
| Add Transforms | 10 min | Instant | 10 min |
| **Total** | **65 min** | **10 sec** | **~65 min** |

**Per Model**: Save ~1 hour  
**10 Models**: Save ~10 hours  
**100 Models**: Save ~100 hours

---

## 🎯 Who Should Use This?

### ✅ Perfect For
- Laravel developers building APIs
- Teams wanting consistent code
- Startups building MVPs quickly
- Developers learning Laravel
- Projects with many CRUD endpoints

### ❌ Not Needed If
- You have 1-2 simple models
- You prefer manual control over everything
- Your models have very complex logic

---

## 📈 Project Stats

- **Lines of Code**: 2,500+
- **Documentation Pages**: 100+
- **Code Examples**: 50+
- **Test Coverage**: Comprehensive
- **Laravel Versions**: 9.x, 10.x, 11.x
- **PHP Versions**: 8.0, 8.1, 8.2

---

## 🏆 Why Choose APIWizard?

### 1. **Time Efficiency**
Generate in seconds what takes minutes to write manually.

### 2. **Code Consistency**
Every generated file follows the same structure and standards.

### 3. **Best Practices**
Built-in pagination, error handling, and response formatting.

### 4. **Flexibility**
Interactive mode for exploration, non-interactive for automation.

### 5. **Safe Updates**
Adds to existing models without overwriting your code.

### 6. **Well Documented**
100+ pages of documentation with real-world examples.

### 7. **Actively Maintained**
Regular updates and community support.

### 8. **Open Source**
MIT licensed, free for personal and commercial use.

---

## 🚦 Getting Started

### 1. Install
```bash
composer require marghoobsuleman/apiwizard
```

### 2. Generate
```bash
php artisan apiwizard:generate
```

### 3. Customize
```bash
# Update $fillable in model
# Add validation in controller
# Customize transform method
```

### 4. Test
```bash
curl http://localhost:8000/api/users
```

---

## 📚 Documentation

- 📖 [Full Documentation](README.md)
- ⚡ [Quick Start](QUICKSTART.md)
- 💡 [Examples](EXAMPLES.md)
- ❓ [FAQ](FAQ.md)
- 🔧 [Installation](INSTALLATION.md)

---

## 🤝 Community

- ⭐ [Star on GitHub](https://github.com/marghoobsuleman/apiwizard)
- 🐛 [Report Issues](https://github.com/marghoobsuleman/apiwizard/issues)
- 💬 [Discussions](https://github.com/marghoobsuleman/apiwizard/discussions)
- 📦 [Packagist](https://packagist.org/packages/marghoobsuleman/apiwizard)

---

## 📄 License

MIT License - Free for personal and commercial use.

---

## 🎉 Ready to Get Started?

```bash
composer require marghoobsuleman/apiwizard
php artisan apiwizard:generate
```

**Build APIs faster. Code less. Ship more.** 🚀

---

Made with ❤️ for the Laravel community
