# Publishing Guide

Complete guide for publishing APIWizard to Packagist and maintaining the package.

## Prerequisites

Before publishing, ensure you have:

- [x] GitHub account
- [x] Packagist account (https://packagist.org)
- [x] Git installed locally
- [x] Composer installed locally
- [x] All tests passing
- [x] Documentation complete

## Step 1: Prepare the Package

### 1.1 Verify composer.json

Ensure your `composer.json` is complete:

```json
{
    "name": "marghoobsuleman/apiwizard",
    "description": "Generate Laravel models, relations, and APIs from an interactive command line",
    "keywords": ["laravel", "api", "generator", "model", "relations", "artisan"],
    "type": "library",
    "license": "MIT",
    "authors": [
        {
            "name": "Your Name",
            "email": "your.email@example.com"
        }
    ]
}
```

### 1.2 Run Tests

```bash
composer install
vendor/bin/phpunit
```

Ensure all tests pass before publishing.

### 1.3 Update Documentation

- [ ] README.md is complete
- [ ] CHANGELOG.md is updated
- [ ] Examples are accurate
- [ ] Installation instructions work

### 1.4 Code Quality Checks

```bash
# Check code style (if configured)
vendor/bin/phpcs

# Run static analysis (if configured)
vendor/bin/phpstan analyse
```

## Step 2: Version Control

### 2.1 Create GitHub Repository

1. Go to https://github.com/new
2. Repository name: `laravel-api-wizard`
3. Description: "Generate Laravel models, relations, and APIs from an interactive command line"
4. Public repository
5. Don't initialize with README (you already have one)

### 2.2 Push to GitHub

```bash
# Initialize git (if not already done)
git init

# Add remote
git remote add origin https://github.com/marghoobsuleman/apiwizard.git

# Add all files
git add .

# Commit
git commit -m "Initial commit - v1.0.0"

# Push to GitHub
git branch -M main
git push -u origin main
```

### 2.3 Create First Release

1. Go to your GitHub repository
2. Click "Releases" → "Create a new release"
3. Tag version: `v1.0.0`
4. Release title: `v1.0.0 - Initial Release`
5. Description: Copy from CHANGELOG.md
6. Click "Publish release"

## Step 3: Publish to Packagist

### 3.1 Register on Packagist

1. Go to https://packagist.org
2. Sign up or log in
3. Connect your GitHub account

### 3.2 Submit Package

1. Click "Submit" in top navigation
2. Enter repository URL: `https://github.com/marghoobsuleman/apiwizard`
3. Click "Check"
4. Review package information
5. Click "Submit"

### 3.3 Enable Auto-Update

1. Go to your package page on Packagist
2. Click "Settings"
3. Copy the webhook URL
4. Go to your GitHub repository settings
5. Navigate to "Webhooks" → "Add webhook"
6. Paste the Packagist webhook URL
7. Content type: `application/json`
8. Select "Just the push event"
9. Click "Add webhook"

## Step 4: Verify Installation

Test that your package can be installed:

```bash
# Create a test Laravel project
composer create-project laravel/laravel test-project
cd test-project

# Install your package
composer require marghoobsuleman/apiwizard

# Verify command is available
php artisan list | grep wizard
```

## Step 5: Post-Publication

### 5.1 Add Badges to README

Update README.md with badges:

```markdown
[![Latest Version on Packagist](https://img.shields.io/packagist/v/marghoobsuleman/apiwizard.svg?style=flat-square)](https://packagist.org/packages/marghoobsuleman/apiwizard)
[![Total Downloads](https://img.shields.io/packagist/dt/marghoobsuleman/apiwizard.svg?style=flat-square)](https://packagist.org/packages/marghoobsuleman/apiwizard)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/marghoobsuleman/apiwizard/Tests?label=tests)](https://github.com/marghoobsuleman/apiwizard/actions)
```

### 5.2 Create Documentation Site (Optional)

Consider using:
- GitHub Pages
- ReadTheDocs
- GitBook

### 5.3 Announce Your Package

Share on:
- Twitter/X with #Laravel hashtag
- Reddit r/laravel
- Laravel News (submit link)
- dev.to
- Medium
- Your blog

### 5.4 Submit to Laravel News

1. Go to https://laravel-news.com/submit
2. Submit your package link
3. Include a brief description

## Releasing Updates

### For Patch Releases (1.0.x)

Bug fixes and minor improvements:

```bash
# Update CHANGELOG.md
# Commit changes
git add .
git commit -m "Fix: Description of bug fix"
git push

# Create tag
git tag v1.0.1
git push origin v1.0.1

# Create GitHub release
# Packagist will auto-update via webhook
```

### For Minor Releases (1.x.0)

New features, backward compatible:

```bash
# Update CHANGELOG.md
# Commit changes
git add .
git commit -m "Feature: Description of new feature"
git push

# Create tag
git tag v1.1.0
git push origin v1.1.0

# Create GitHub release
```

### For Major Releases (x.0.0)

Breaking changes:

```bash
# Update CHANGELOG.md with breaking changes
# Update UPGRADE.md with migration guide
# Commit changes
git add .
git commit -m "Release: v2.0.0 with breaking changes"
git push

# Create tag
git tag v2.0.0
git push origin v2.0.0

# Create GitHub release with detailed notes
```

## Semantic Versioning

Follow semantic versioning (semver):

- **MAJOR** (x.0.0): Breaking changes
- **MINOR** (1.x.0): New features, backward compatible
- **PATCH** (1.0.x): Bug fixes, backward compatible

Examples:
- `1.0.0` → `1.0.1`: Bug fix
- `1.0.1` → `1.1.0`: New feature
- `1.1.0` → `2.0.0`: Breaking change

## Maintenance Checklist

### Weekly
- [ ] Review and respond to issues
- [ ] Review pull requests
- [ ] Update dependencies if needed

### Monthly
- [ ] Check for security vulnerabilities
- [ ] Update documentation
- [ ] Review roadmap progress

### Quarterly
- [ ] Plan next release
- [ ] Update dependencies
- [ ] Review and update documentation

## Best Practices

### 1. Keep CHANGELOG Updated

Always update CHANGELOG.md with:
- New features
- Bug fixes
- Breaking changes
- Deprecations

### 2. Write Good Commit Messages

```bash
# Good
git commit -m "Fix: Resolve issue with relation generation"
git commit -m "Feature: Add support for polymorphic relations"
git commit -m "Docs: Update installation guide"

# Bad
git commit -m "fix stuff"
git commit -m "update"
```

### 3. Tag Releases Properly

```bash
# Always use 'v' prefix
git tag v1.0.0  # Good
git tag 1.0.0   # Bad
```

### 4. Write Detailed Release Notes

Include:
- What's new
- What's fixed
- Breaking changes
- Upgrade instructions
- Contributors

### 5. Respond to Issues Promptly

- Acknowledge within 48 hours
- Provide helpful responses
- Close resolved issues
- Label issues appropriately

## Troubleshooting

### Package Not Found on Packagist

1. Check repository is public
2. Verify composer.json is valid
3. Wait a few minutes for indexing
4. Check Packagist for errors

### Auto-Update Not Working

1. Verify webhook is configured
2. Check webhook delivery in GitHub
3. Manually update on Packagist if needed

### Installation Fails

1. Check minimum requirements
2. Verify dependencies are correct
3. Test in fresh Laravel installation

## Security

### Reporting Vulnerabilities

- Never discuss security issues publicly
- Use SECURITY.md guidelines
- Patch quickly and release

### Security Releases

```bash
# For security patches
git tag v1.0.2
git push origin v1.0.2

# Announce on:
# - GitHub Security Advisory
# - Package README
# - Twitter/X
```

## Support Channels

Set up support channels:

1. **GitHub Issues** - Bug reports and feature requests
2. **GitHub Discussions** - Questions and community
3. **Email** - Direct support
4. **Discord/Slack** - Real-time chat (optional)

## Metrics to Track

Monitor:
- Download count (Packagist)
- GitHub stars
- Open issues
- Pull requests
- Community engagement

## Legal

Ensure you have:
- [ ] LICENSE.md file
- [ ] Copyright notices
- [ ] Contributor agreements (if needed)

## Checklist Before Publishing

- [ ] All tests pass
- [ ] Documentation is complete
- [ ] CHANGELOG is updated
- [ ] composer.json is correct
- [ ] LICENSE is included
- [ ] README has installation instructions
- [ ] Code is formatted properly
- [ ] No sensitive data in repository
- [ ] .gitignore is configured
- [ ] GitHub repository is created
- [ ] First release is tagged
- [ ] Packagist account is ready

## After Publishing

- [ ] Verify package appears on Packagist
- [ ] Test installation in fresh project
- [ ] Share announcement
- [ ] Monitor for issues
- [ ] Respond to community feedback

## Resources

- **Packagist**: https://packagist.org
- **Semantic Versioning**: https://semver.org
- **Laravel Package Development**: https://laravel.com/docs/packages
- **Keep a Changelog**: https://keepachangelog.com

---

**Congratulations!** Your package is now published and available to the Laravel community! 🎉

Remember: Publishing is just the beginning. The real work is maintaining and improving the package based on community feedback.
