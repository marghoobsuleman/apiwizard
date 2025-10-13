# APIWizard Examples

This document provides practical examples of using APIWizard in various scenarios.

## Table of Contents

- [Basic Examples](#basic-examples)
- [Advanced Examples](#advanced-examples)
- [Real-World Scenarios](#real-world-scenarios)
- [API Response Examples](#api-response-examples)

## Basic Examples

### Example 1: Simple Blog Post Model

**Interactive Mode:**
```bash
php artisan apiwizard:generate
```

```
Enter table name: posts
Model name will be: Post

Does it have any relations? (yes/no): no
Do you want to modify returned data (add transform method)? (yes/no): yes
Do you want to create an API endpoint? (yes/no): yes
Enter API endpoint [/api/posts]: /api/posts
```

**Non-Interactive Mode:**
```bash
php artisan apiwizard:generate --table=posts --endpoint=/api/posts --transform
```

**Generated Model:**
```php
class Post extends Model
{
    protected $table = 'posts';
    
    public function transform(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
```

### Example 2: User with Profile (One-to-One)

```bash
php artisan apiwizard:generate \
  --table=users \
  --relations=profile:hasOne \
  --endpoint=/api/users \
  --transform
```

**Generated Relations:**
```php
// In User model
public function profile()
{
    return $this->hasOne(Profile::class);
}

// In Profile model (auto-generated)
public function user()
{
    return $this->belongsTo(User::class);
}
```

### Example 3: Category with Products (One-to-Many)

```bash
php artisan apiwizard:generate \
  --table=categories \
  --relations=products:hasMany \
  --endpoint=/api/categories \
  --transform
```

## Advanced Examples

### Example 4: Complex E-commerce Product

```bash
php artisan apiwizard:generate \
  --table=products \
  --relations=category:belongsTo \
  --relations=reviews:hasMany \
  --relations=tags:belongsToMany \
  --endpoint=/api/products \
  --transform
```

**Customize the transform method:**
```php
public function transform(): array
{
    return [
        'id' => $this->id,
        'name' => $this->name,
        'price' => number_format($this->price, 2),
        'category' => $this->category?->name,
        'reviews_count' => $this->reviews()->count(),
        'average_rating' => $this->reviews()->avg('rating'),
        'tags' => $this->tags->pluck('name'),
        'in_stock' => $this->stock > 0,
    ];
}
```

### Example 5: Social Media Post with Multiple Relations

```bash
php artisan apiwizard:generate \
  --table=posts \
  --relations=user:belongsTo \
  --relations=comments:hasMany \
  --relations=likes:hasMany \
  --relations=tags:belongsToMany \
  --endpoint=/api/posts \
  --transform
```

**Enhanced Controller with Eager Loading:**
```php
public function index()
{
    $posts = Post::with(['user', 'comments', 'likes', 'tags'])
        ->paginate(15);
    
    return response()->json([
        'success' => true,
        'data' => $posts->map(fn($item) => $item->transform()),
        'pagination' => [
            'total' => $posts->total(),
            'per_page' => $posts->perPage(),
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage(),
        ],
    ]);
}
```

### Example 6: Multi-Tenant Application

```bash
# Generate tenant model
php artisan apiwizard:generate \
  --table=tenants \
  --relations=users:hasMany \
  --relations=projects:hasMany \
  --endpoint=/api/tenants \
  --transform

# Generate project model
php artisan apiwizard:generate \
  --table=projects \
  --relations=tenant:belongsTo \
  --relations=tasks:hasMany \
  --endpoint=/api/projects \
  --transform
```

### Example 7: Adding Relations to Existing Models

**Scenario**: You already have a `User` model, but now you want to add new relations without recreating the model.

**Initial State** - Existing User model:
```php
// app/Models/User.php (existing)
class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password'];
    
    // Only has this relation
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
```

**Add New Relations**:
```bash
# Add posts and comments relations to existing User model
php artisan apiwizard:generate \
  --table=users \
  --relations=posts:hasMany \
  --relations=comments:hasMany \
  --no-api
```

**Result** - Updated User model:
```php
// app/Models/User.php (updated safely)
class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password'];
    
    // Existing relation (preserved)
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    
    // New relations added automatically
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
```

**What Happened**:
- ✅ Existing model was **not overwritten**
- ✅ Existing `profile()` relation was **preserved**
- ✅ New `posts()` and `comments()` relations were **added**
- ✅ Related models (`Post` and `Comment`) were **created automatically**
- ✅ Inverse relations were **added to related models**

**Use Cases**:
1. **Incremental Development** - Add relations as your application grows
2. **Safe Updates** - No risk of losing existing code
3. **Team Collaboration** - Multiple developers can add relations independently
4. **Refactoring** - Gradually improve model relationships

**Pro Tip**: You can also add a transform method to an existing model:
```bash
php artisan apiwizard:generate \
  --table=users \
  --transform \
  --no-api
```

This will add the `transform()` method to your existing User model without affecting anything else.

## Real-World Scenarios

### Scenario 1: Building a Task Management System

```bash
# 1. Generate Projects
php artisan apiwizard:generate \
  --table=projects \
  --relations=tasks:hasMany \
  --relations=users:belongsToMany \
  --endpoint=/api/projects \
  --transform

# 2. Generate Tasks
php artisan apiwizard:generate \
  --table=tasks \
  --relations=project:belongsTo \
  --relations=assignee:belongsTo \
  --relations=comments:hasMany \
  --endpoint=/api/tasks \
  --transform

# 3. Generate Comments
php artisan apiwizard:generate \
  --table=comments \
  --relations=task:belongsTo \
  --relations=user:belongsTo \
  --endpoint=/api/comments
```

### Scenario 2: E-Learning Platform

```bash
# Courses
php artisan apiwizard:generate \
  --table=courses \
  --relations=instructor:belongsTo \
  --relations=lessons:hasMany \
  --relations=students:belongsToMany \
  --endpoint=/api/courses \
  --transform

# Lessons
php artisan apiwizard:generate \
  --table=lessons \
  --relations=course:belongsTo \
  --relations=videos:hasMany \
  --endpoint=/api/lessons \
  --transform

# Enrollments
php artisan apiwizard:generate \
  --table=enrollments \
  --relations=student:belongsTo \
  --relations=course:belongsTo \
  --endpoint=/api/enrollments
```

### Scenario 3: Inventory Management

```bash
# Warehouses
php artisan apiwizard:generate \
  --table=warehouses \
  --relations=products:belongsToMany \
  --endpoint=/api/warehouses

# Products
php artisan apiwizard:generate \
  --table=products \
  --relations=category:belongsTo \
  --relations=supplier:belongsTo \
  --relations=warehouses:belongsToMany \
  --endpoint=/api/products \
  --transform

# Orders
php artisan apiwizard:generate \
  --table=orders \
  --relations=customer:belongsTo \
  --relations=items:hasMany \
  --endpoint=/api/orders \
  --transform
```

## API Response Examples

### List Response (with pagination)

**Request:**
```bash
GET /api/products
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Laptop",
      "price": "999.99",
      "category": "Electronics",
      "in_stock": true
    },
    {
      "id": 2,
      "name": "Mouse",
      "price": "29.99",
      "category": "Accessories",
      "in_stock": true
    }
  ],
  "pagination": {
    "total": 50,
    "per_page": 15,
    "current_page": 1,
    "last_page": 4
  }
}
```

### Single Resource Response

**Request:**
```bash
GET /api/products/1
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Laptop",
    "price": "999.99",
    "category": "Electronics",
    "reviews_count": 45,
    "average_rating": 4.5,
    "tags": ["tech", "portable", "work"],
    "in_stock": true
  }
}
```

### Create Response

**Request:**
```bash
POST /api/products
Content-Type: application/json

{
  "name": "Keyboard",
  "price": 79.99,
  "category_id": 2
}
```

**Response:**
```json
{
  "success": true,
  "message": "Product created successfully",
  "data": {
    "id": 51,
    "name": "Keyboard",
    "price": 79.99,
    "category_id": 2,
    "created_at": "2024-10-12T10:30:00.000000Z",
    "updated_at": "2024-10-12T10:30:00.000000Z"
  }
}
```

### Update Response

**Request:**
```bash
PUT /api/products/51
Content-Type: application/json

{
  "price": 69.99
}
```

**Response:**
```json
{
  "success": true,
  "message": "Product updated successfully",
  "data": {
    "id": 51,
    "name": "Keyboard",
    "price": 69.99,
    "category_id": 2,
    "updated_at": "2024-10-12T11:00:00.000000Z"
  }
}
```

### Delete Response

**Request:**
```bash
DELETE /api/products/51
```

**Response:**
```json
{
  "success": true,
  "message": "Product deleted successfully"
}
```

## Tips for Customization

### 1. Add Validation Rules

After generation, update the controller:

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'stock' => 'required|integer|min:0',
    ]);

    $product = Product::create($validated);
    
    return response()->json([
        'success' => true,
        'message' => 'Product created successfully',
        'data' => $product,
    ], 201);
}
```

### 2. Add Middleware

Protect routes with authentication:

```php
// In routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', \App\Http\Controllers\API\ProductController::class);
});
```

### 3. Add Filtering and Sorting

Enhance the index method:

```php
public function index(Request $request)
{
    $query = Product::query();
    
    // Filtering
    if ($request->has('category_id')) {
        $query->where('category_id', $request->category_id);
    }
    
    // Sorting
    $sortBy = $request->get('sort_by', 'created_at');
    $sortOrder = $request->get('sort_order', 'desc');
    $query->orderBy($sortBy, $sortOrder);
    
    $products = $query->paginate(15);
    
    return response()->json([
        'success' => true,
        'data' => $products->map(fn($item) => $item->transform()),
        'pagination' => [
            'total' => $products->total(),
            'per_page' => $products->perPage(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
        ],
    ]);
}
```

---

For more examples and use cases, visit the [GitHub repository](https://github.com/marghoobsuleman/apiwizard).
