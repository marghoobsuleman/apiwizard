# Changelog

All notable changes to `apiwizard` will be documented in this file.

## [1.0.0] - 2024-10-12

### Added
- Initial release
- Interactive CLI for generating models, relations, and APIs
- Non-interactive mode with command options
- Support for hasOne, hasMany, belongsTo, and belongsToMany relations
- Optional transform methods for data customization
- Automatic controller and route generation
- Complete REST API endpoints (index, show, store, update, destroy)
- Configurable namespaces and paths
- Publishable configuration and stubs
- Comprehensive documentation
- PSR-4 autoloading
- Laravel 9.x, 10.x, 11.x and 12.x support

### Features
- `php artisan apiwizard:generate` - Interactive mode
- `--table` option for table name
- `--relations` option for defining relationships
- `--endpoint` option for custom API endpoints
- `--transform` flag for adding transform methods
- `--no-api` flag for model-only generation
- Automatic related model generation
- Smart model updating (adds relations to existing models)
- Pagination support in API responses
- Standardized JSON response format
