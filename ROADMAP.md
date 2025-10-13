# APIWizard Roadmap

This document outlines the planned features and improvements for future versions of APIWizard.

## Version 1.0.0 (Current) ✅

- [x] Interactive CLI for model generation
- [x] Non-interactive mode with command options
- [x] Support for hasOne, hasMany, belongsTo, belongsToMany relations
- [x] Transform methods for data customization
- [x] Automatic controller generation
- [x] REST API endpoint generation
- [x] Route registration
- [x] Configurable namespaces and paths
- [x] Publishable stubs
- [x] Comprehensive documentation
- [x] Command alias support

## Version 1.1.0 (Planned) 🎯

### Features
- [ ] **API Resource Generation** - Generate Laravel API Resources instead of transform methods
- [ ] **Request Validation Classes** - Generate FormRequest classes with validation rules
- [ ] **Factory Generation** - Create model factories for testing
- [ ] **Seeder Generation** - Generate database seeders
- [ ] **Migration Hints** - Suggest migration structure based on model

### Improvements
- [ ] Better error handling and user feedback
- [ ] Progress indicators for long operations
- [ ] Dry-run mode to preview changes
- [ ] Rollback functionality
- [ ] Interactive relation configuration (foreign keys, pivot tables)

## Version 1.2.0 (Future) 🚀

### Features
- [ ] **Policy Generation** - Create authorization policies
- [ ] **Test Generation** - Generate PHPUnit/Pest tests for APIs
- [ ] **API Documentation** - Generate OpenAPI/Swagger documentation
- [ ] **GraphQL Support** - Option to generate GraphQL schemas
- [ ] **Event/Listener Generation** - Create model events and listeners

### Improvements
- [ ] Batch generation (multiple models at once)
- [ ] Import from existing database schema
- [ ] Visual relationship diagram
- [ ] Configuration wizard
- [ ] Template marketplace

## Version 2.0.0 (Long-term) 🌟

### Major Features
- [ ] **GUI Interface** - Web-based interface for generation
- [ ] **API Versioning** - Built-in support for API versions
- [ ] **Multi-tenancy Support** - Generate multi-tenant ready code
- [ ] **Microservices Support** - Generate service-oriented code
- [ ] **Real-time Features** - WebSocket/Broadcasting support
- [ ] **Advanced Caching** - Built-in caching strategies

### Enterprise Features
- [ ] **Team Collaboration** - Share configurations across team
- [ ] **Code Templates** - Organization-specific templates
- [ ] **Audit Logging** - Track all generated code
- [ ] **Integration Hub** - Connect with external services
- [ ] **Advanced Analytics** - Usage statistics and insights

## Community Requests 💡

Features requested by the community (vote on GitHub):

- [ ] Support for polymorphic relations
- [ ] Generate API middleware
- [ ] Support for MongoDB/NoSQL
- [ ] Generate Postman collections
- [ ] Integration with Laravel Sanctum/Passport
- [ ] Generate API rate limiting rules
- [ ] Support for nested resources
- [ ] Generate API transformers (Fractal)
- [ ] Support for soft deletes
- [ ] Generate model observers

## Technical Improvements 🔧

### Code Quality
- [ ] Increase test coverage to 90%+
- [ ] Add static analysis (PHPStan level 8)
- [ ] Implement code style checks (PHP CS Fixer)
- [ ] Add mutation testing
- [ ] Performance benchmarks

### Documentation
- [ ] Video tutorials
- [ ] Interactive playground
- [ ] More real-world examples
- [ ] Cookbook/recipes section
- [ ] API reference documentation

### DevOps
- [ ] Automated releases
- [ ] Changelog automation
- [ ] Dependency updates automation
- [ ] Performance monitoring
- [ ] Usage analytics (opt-in)

## Breaking Changes (v2.0.0)

Potential breaking changes being considered:

- Minimum PHP version: 8.1
- Minimum Laravel version: 10.x
- Default to API Resources instead of transform methods
- New configuration structure
- Command signature changes
- Stub format changes

## How to Contribute

Want to help shape the future of APIWizard?

1. **Vote on Features** - Star issues on GitHub for features you want
2. **Submit Ideas** - Open a discussion with your feature request
3. **Contribute Code** - Pick an item from the roadmap and submit a PR
4. **Sponsor Development** - Support the project financially
5. **Share Feedback** - Tell us what works and what doesn't

## Release Schedule

- **Minor versions** (1.x.0): Every 2-3 months
- **Patch versions** (1.0.x): As needed for bugs
- **Major versions** (2.0.0): Yearly or when breaking changes accumulate

## Deprecation Policy

- Features marked as deprecated will be removed in the next major version
- Minimum 6 months notice before removal
- Migration guides provided for breaking changes
- Legacy support available for enterprise users

## Current Focus

**Q4 2024 - Q1 2025:**
- Stabilize v1.0.0
- Gather community feedback
- Fix bugs and improve documentation
- Plan v1.1.0 features

**Q2 2025:**
- Release v1.1.0 with API Resources and Request Validation
- Improve testing and code quality
- Expand documentation

**Q3-Q4 2025:**
- Release v1.2.0 with Policy and Test generation
- Begin planning v2.0.0
- Explore GUI interface

## Feedback

Have suggestions for the roadmap?

- 💬 [Start a Discussion](https://github.com/marghoobsuleman/apiwizard/discussions)
- 🐛 [Open an Issue](https://github.com/marghoobsuleman/apiwizard/issues)
- 📧 Email: marghoobsuleman@gmail.com

---

**Last Updated**: October 2024  
**Next Review**: January 2025

This roadmap is subject to change based on community feedback and project priorities.
