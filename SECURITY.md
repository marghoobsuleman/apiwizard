# Security Policy

## Supported Versions

We release patches for security vulnerabilities for the following versions:

| Version | Supported          |
| ------- | ------------------ |
| 1.x.x   | :white_check_mark: |

## Reporting a Vulnerability

We take the security of APIWizard seriously. If you discover a security vulnerability, please follow these steps:

### 1. Do Not Open a Public Issue

Please **do not** open a public GitHub issue for security vulnerabilities.

### 2. Send a Private Report

Email security details to: **security@example.com**

Include:
- Description of the vulnerability
- Steps to reproduce
- Potential impact
- Suggested fix (if any)
- Your contact information

### 3. Response Timeline

- **Initial Response**: Within 48 hours
- **Status Update**: Within 7 days
- **Fix Timeline**: Depends on severity
  - Critical: 1-7 days
  - High: 7-14 days
  - Medium: 14-30 days
  - Low: 30-90 days

### 4. Disclosure Policy

- We will acknowledge your report within 48 hours
- We will provide regular updates on our progress
- We will notify you when the vulnerability is fixed
- We will publicly disclose the vulnerability after a fix is released
- We will credit you in the security advisory (unless you prefer to remain anonymous)

## Security Best Practices

When using APIWizard, follow these security best practices:

### 1. Validate All Input

Always add validation rules to generated controllers:

```php
$validated = $request->validate([
    'email' => 'required|email|unique:users',
    'password' => 'required|min:8|confirmed',
]);
```

### 2. Protect Sensitive Data

Update the `$hidden` array in models to hide sensitive fields:

```php
protected $hidden = [
    'password',
    'remember_token',
    'api_token',
];
```

### 3. Use Authentication

Protect API routes with authentication middleware:

```php
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
});
```

### 4. Implement Authorization

Add authorization checks in controllers:

```php
public function update(Request $request, $id)
{
    $user = User::findOrFail($id);
    
    // Check authorization
    if ($request->user()->cannot('update', $user)) {
        abort(403);
    }
    
    // ... rest of the code
}
```

### 5. Use Mass Assignment Protection

Always define `$fillable` or `$guarded` in models:

```php
protected $fillable = [
    'name',
    'email',
    // Only fields that should be mass-assignable
];
```

### 6. Sanitize Transform Output

Be careful not to expose sensitive data in transform methods:

```php
public function transform(): array
{
    return [
        'id' => $this->id,
        'name' => $this->name,
        'email' => $this->email,
        // Don't include password, tokens, etc.
    ];
}
```

### 7. Rate Limiting

Implement rate limiting on API routes:

```php
Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    Route::apiResource('users', UserController::class);
});
```

### 8. HTTPS Only

Always use HTTPS in production. Add to `.env`:

```
APP_URL=https://yourdomain.com
```

### 9. CORS Configuration

Configure CORS properly in `config/cors.php`:

```php
'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:3000')],
```

### 10. Keep Dependencies Updated

Regularly update the package and Laravel:

```bash
composer update marghoobsuleman/apiwizard
composer update
```

## Known Security Considerations

### File Generation

- The package creates files in your application directory
- Ensure proper file permissions are set
- Review generated code before committing

### Database Operations

- Generated controllers use Eloquent ORM (safe from SQL injection)
- Always validate and sanitize user input
- Use parameterized queries for raw SQL

### API Endpoints

- Generated endpoints are public by default
- Add authentication and authorization
- Implement rate limiting

## Security Checklist

Before deploying to production:

- [ ] All API routes have authentication
- [ ] Authorization checks are implemented
- [ ] Validation rules are added to all endpoints
- [ ] Sensitive fields are hidden in models
- [ ] Rate limiting is configured
- [ ] HTTPS is enforced
- [ ] CORS is properly configured
- [ ] Mass assignment protection is in place
- [ ] Error messages don't leak sensitive information
- [ ] Dependencies are up to date

## Vulnerability Disclosure Timeline

When a vulnerability is reported:

1. **Day 0**: Vulnerability reported
2. **Day 1-2**: Initial assessment and acknowledgment
3. **Day 3-7**: Investigation and fix development
4. **Day 7-14**: Testing and verification
5. **Day 14-21**: Release preparation
6. **Day 21**: Public disclosure and release

## Hall of Fame

We recognize security researchers who responsibly disclose vulnerabilities:

<!-- Security researchers will be listed here -->

## Contact

- **Security Email**: marghoobsuleman@gmail.com
- **GitHub Issues**: https://github.com/marghoobsuleman/apiwizard/issues
- **Discussions**: https://github.com/marghoobsuleman/apiwizard/discussions

## Additional Resources

- [Laravel Security Best Practices](https://laravel.com/docs/security)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Guide](https://www.php.net/manual/en/security.php)

---

Thank you for helping keep APIWizard and its users safe!
