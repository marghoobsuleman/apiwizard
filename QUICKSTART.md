# Quick Start Guide

Get up and running with APIWizard in 5 minutes!

## Installation

```bash
composer require marghoobsuleman/apiwizard
```

## Your First API in 3 Steps

### Step 1: Run the Command

```bash
php artisan apiwizard:generate
```

### Step 2: Answer the Prompts

```
Enter table name: products
Does it have any relations? (yes/no): no
Do you want to modify returned data? (yes/no): yes
Do you want to create an API endpoint? (yes/no): yes
Enter API endpoint [/api/products]: /api/products
```

### Step 3: Test Your API

```bash
# Create a product
curl -X POST http://localhost:8000/api/products \
  -H "Content-Type: application/json" \
  -d '{"name":"Test Product","price":99.99}'

# Get all products
curl http://localhost:8000/api/products

# Get single product
curl http://localhost:8000/api/products/1

# Update product
curl -X PUT http://localhost:8000/api/products/1 \
  -H "Content-Type: application/json" \
  -d '{"price":89.99}'

# Delete product
curl -X DELETE http://localhost:8000/api/products/1
```

## Common Use Cases

### Blog System

```bash
# Posts
php artisan apiwizard:generate \
  --table=posts \
  --relations=author:belongsTo \
  --relations=comments:hasMany \
  --endpoint=/api/posts \
  --transform

# Comments
php artisan apiwizard:generate \
  --table=comments \
  --relations=post:belongsTo \
  --relations=user:belongsTo \
  --endpoint=/api/comments
```

### E-commerce

```bash
# Products
php artisan apiwizard:generate \
  --table=products \
  --relations=category:belongsTo \
  --relations=reviews:hasMany \
  --endpoint=/api/products \
  --transform

# Orders
php artisan apiwizard:generate \
  --table=orders \
  --relations=user:belongsTo \
  --relations=items:hasMany \
  --endpoint=/api/orders \
  --transform
```

### Social Network

```bash
# Users
php artisan apiwizard:generate \
  --table=users \
  --relations=posts:hasMany \
  --relations=followers:belongsToMany \
  --endpoint=/api/users \
  --transform

# Posts
php artisan apiwizard:generate \
  --table=posts \
  --relations=user:belongsTo \
  --relations=likes:hasMany \
  --relations=comments:hasMany \
  --endpoint=/api/posts \
  --transform
```

## Next Steps

1. **Add Validation** - Update validation rules in your controllers
2. **Customize Transforms** - Modify the `transform()` method in your models
3. **Add Authentication** - Protect routes with middleware
4. **Add Tests** - Write tests for your API endpoints

## Need Help?

- 📖 [Full Documentation](README.md)
- 💡 [More Examples](EXAMPLES.md)
- 🐛 [Report Issues](https://github.com/marghoobsuleman/apiwizard/issues)

Happy coding! 🚀
