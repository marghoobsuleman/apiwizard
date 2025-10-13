# Project Structure

Complete overview of the APIWizard package structure and organization.

## Directory Tree

```
api-wizard/
│
├── .github/                          # GitHub specific files
│   └── workflows/
│       └── tests.yml                 # CI/CD pipeline configuration
│
├── config/                           # Package configuration
│   └── apiwizard.php                 # Main configuration file
│
├── src/                              # Source code
│   ├── Console/
│   │   └── Commands/
│   │       ├── GenerateAPICommand.php    # Main generation command
│   │       └── ModelWizardCommand.php    # Alias command
│   │
│   ├── Generators/
│   │   ├── ModelGenerator.php            # Model generation logic
│   │   ├── ControllerGenerator.php       # Controller generation logic
│   │   └── RouteGenerator.php            # Route generation logic
│   │
│   ├── Support/
│   │   └── Helpers.php                   # Helper functions
│   │
│   └── APIWizardServiceProvider.php      # Laravel service provider
│
├── stubs/                            # Code templates
│   ├── model.stub                    # Model template
│   └── controller.stub               # Controller template
│
├── tests/                            # Test suite
│   ├── Feature/
│   │   └── GenerateAPICommandTest.php    # Feature tests
│   └── TestCase.php                  # Base test case
│
├── .editorconfig                     # Editor configuration
├── .gitattributes                    # Git attributes
├── .gitignore                        # Git ignore rules
├── CHANGELOG.md                      # Version history
├── composer.json                     # Package dependencies
├── CONTRIBUTING.md                   # Contribution guidelines
├── EXAMPLES.md                       # Usage examples
├── FAQ.md                            # Frequently asked questions
├── INSTALLATION.md                   # Installation guide
├── LICENSE.md                        # MIT License
├── PACKAGE_SUMMARY.md                # Package overview
├── phpunit.xml                       # PHPUnit configuration
├── QUICKSTART.md                     # Quick start guide
├── README.md                         # Main documentation
├── ROADMAP.md                        # Future plans
└── SECURITY.md                       # Security policy
```

## Core Components

### 1. Commands (`src/Console/Commands/`)

#### GenerateAPICommand.php
**Purpose**: Main artisan command for generating models, relations, and APIs

**Key Methods**:
- `handle()` - Entry point, determines interactive vs non-interactive mode
- `handleInteractive()` - Processes user prompts
- `handleNonInteractive()` - Processes command options
- `askForRelations()` - Interactive relation configuration
- `generateAll()` - Orchestrates the generation process
- `displaySummary()` - Shows generation results

**Responsibilities**:
- User interaction and input validation
- Orchestrating generators
- Displaying progress and results
- Error handling

#### ModelWizardCommand.php
**Purpose**: Alias command extending GenerateAPICommand

**Key Features**:
- Provides alternative command name
- Identical functionality to main command
- Backward compatibility

### 2. Generators (`src/Generators/`)

#### ModelGenerator.php
**Purpose**: Creates and updates model files

**Key Methods**:
- `generate()` - Main generation method
- `createNewModel()` - Creates new model file
- `updateExistingModel()` - Updates existing model
- `addRelation()` - Adds relationship configuration
- `withTransform()` - Enables transform method
- `generateRelationMethods()` - Creates relation methods
- `generateTransformMethod()` - Creates transform method
- `injectRelationMethod()` - Adds relation to existing model
- `injectTransformMethod()` - Adds transform to existing model

**Responsibilities**:
- Model file creation
- Relation method generation
- Transform method generation
- Safe updates to existing models

#### ControllerGenerator.php
**Purpose**: Generates REST API controllers

**Key Methods**:
- `generate()` - Main generation method
- `generateIndexMethod()` - Creates list endpoint
- `generateShowMethod()` - Creates show endpoint
- `generateStoreMethod()` - Creates create endpoint
- `generateUpdateMethod()` - Creates update endpoint
- `generateDestroyMethod()` - Creates delete endpoint

**Responsibilities**:
- Controller file creation
- CRUD method generation
- Response formatting
- Pagination implementation

#### RouteGenerator.php
**Purpose**: Adds routes to routes file

**Key Methods**:
- `generate()` - Main generation method
- `createRoutesFile()` - Creates routes file if missing
- `generateRouteDefinition()` - Creates route code
- `injectRoute()` - Adds route to file

**Responsibilities**:
- Route file management
- Route definition generation
- Duplicate prevention

### 3. Support (`src/Support/`)

#### Helpers.php
**Purpose**: Utility functions used across the package

**Key Methods**:
- `tableToModel()` - Converts table name to model name
- `modelToTable()` - Converts model name to table name
- `getRelationMethodName()` - Determines relation method name
- `parseRelation()` - Parses relation string
- `getDefaultEndpoint()` - Generates default API endpoint
- `isValidRelationType()` - Validates relation type
- `getInverseRelationType()` - Gets inverse relation
- `ensureDirectoryExists()` - Creates directories

**Responsibilities**:
- String manipulation
- Naming conventions
- Validation
- File system operations

### 4. Service Provider (`src/`)

#### APIWizardServiceProvider.php
**Purpose**: Registers package with Laravel

**Key Methods**:
- `register()` - Registers services
- `boot()` - Bootstraps package

**Responsibilities**:
- Command registration
- Configuration publishing
- Stub publishing
- Package initialization

## Configuration (`config/`)

### apiwizard.php
**Purpose**: Package configuration

**Settings**:
- `model_namespace` - Model namespace
- `controller_namespace` - Controller namespace
- `model_path` - Model directory path
- `controller_path` - Controller directory path
- `routes_file` - Routes file location
- `pagination` - Default pagination limit

## Stubs (`stubs/`)

### model.stub
**Purpose**: Template for generated models

**Placeholders**:
- `{{ namespace }}` - Model namespace
- `{{ class }}` - Model class name
- `{{ table }}` - Table name
- `{{ relations }}` - Relation methods
- `{{ transform }}` - Transform method

### controller.stub
**Purpose**: Template for generated controllers

**Placeholders**:
- `{{ namespace }}` - Controller namespace
- `{{ modelNamespace }}` - Model namespace
- `{{ class }}` - Controller class name
- `{{ model }}` - Model class name
- `{{ indexMethod }}` - Index method code
- `{{ showMethod }}` - Show method code
- `{{ storeMethod }}` - Store method code
- `{{ updateMethod }}` - Update method code
- `{{ destroyMethod }}` - Destroy method code

## Tests (`tests/`)

### TestCase.php
**Purpose**: Base test case for package tests

**Features**:
- Orchestra Testbench integration
- Service provider registration
- Test database setup

### Feature/GenerateAPICommandTest.php
**Purpose**: Tests for generation command

**Test Cases**:
- Model generation
- Relation creation
- Transform method inclusion
- API generation
- Input validation

## Documentation Files

### User Documentation
- **README.md** - Main documentation with features and usage
- **QUICKSTART.md** - 5-minute getting started guide
- **INSTALLATION.md** - Detailed installation instructions
- **EXAMPLES.md** - Real-world usage examples
- **FAQ.md** - Frequently asked questions

### Developer Documentation
- **CONTRIBUTING.md** - Contribution guidelines
- **PACKAGE_SUMMARY.md** - Technical overview
- **PROJECT_STRUCTURE.md** - This file
- **ROADMAP.md** - Future plans

### Project Management
- **CHANGELOG.md** - Version history
- **LICENSE.md** - MIT License
- **SECURITY.md** - Security policy

## Configuration Files

### Composer (`composer.json`)
**Purpose**: Package definition and dependencies

**Key Sections**:
- `require` - Runtime dependencies
- `require-dev` - Development dependencies
- `autoload` - PSR-4 autoloading
- `extra.laravel` - Laravel package discovery

### PHPUnit (`phpunit.xml`)
**Purpose**: Test configuration

**Settings**:
- Test suites
- Code coverage
- Bootstrap file

### Editor Config (`.editorconfig`)
**Purpose**: Editor settings for consistent code style

**Settings**:
- Indentation
- Line endings
- Character encoding

### Git (`.gitignore`, `.gitattributes`)
**Purpose**: Git configuration

**Features**:
- Ignore patterns
- Export ignore
- Line ending normalization

## Code Flow

### Interactive Mode Flow
```
User runs command
    ↓
GenerateAPICommand::handle()
    ↓
handleInteractive()
    ↓
Collect user input via prompts
    ↓
generateAll()
    ↓
ModelGenerator::generate()
    ↓
ControllerGenerator::generate() (if API requested)
    ↓
RouteGenerator::generate() (if API requested)
    ↓
displaySummary()
```

### Non-Interactive Mode Flow
```
User runs command with options
    ↓
GenerateAPICommand::handle()
    ↓
handleNonInteractive()
    ↓
Parse command options
    ↓
generateAll()
    ↓
[Same as interactive mode]
```

## Design Patterns

### Used Patterns
1. **Service Provider Pattern** - Laravel integration
2. **Command Pattern** - Artisan commands
3. **Builder Pattern** - Generator configuration
4. **Template Method Pattern** - Stub processing
5. **Strategy Pattern** - Different generation strategies

### SOLID Principles
- **Single Responsibility** - Each class has one purpose
- **Open/Closed** - Extensible via stubs and config
- **Liskov Substitution** - Command inheritance
- **Interface Segregation** - Focused interfaces
- **Dependency Inversion** - Depends on abstractions

## Extension Points

### For Users
1. **Configuration** - Customize paths and namespaces
2. **Stubs** - Modify code templates
3. **Inheritance** - Extend generator classes

### For Contributors
1. **New Generators** - Add new generation types
2. **New Commands** - Add new artisan commands
3. **Helper Methods** - Extend Helpers class
4. **Tests** - Add more test coverage

## Dependencies

### Runtime Dependencies
- `illuminate/support` - Laravel support package
- `illuminate/console` - Laravel console package
- `illuminate/filesystem` - Laravel filesystem package

### Development Dependencies
- `phpunit/phpunit` - Testing framework
- `orchestra/testbench` - Laravel package testing

## File Naming Conventions

- **Classes**: PascalCase (e.g., `ModelGenerator.php`)
- **Config**: snake_case (e.g., `apiwizard.php`)
- **Stubs**: lowercase with extension (e.g., `model.stub`)
- **Documentation**: UPPERCASE (e.g., `README.md`)
- **Tests**: PascalCase with Test suffix (e.g., `GenerateAPICommandTest.php`)

## Namespace Structure

```
APIWizard\
├── Console\Commands\          # Artisan commands
├── Generators\                # Code generators
├── Support\                   # Helper utilities
└── APIWizardServiceProvider   # Service provider
```

---

This structure is designed for:
- **Maintainability** - Clear organization
- **Extensibility** - Easy to add features
- **Testability** - Isolated components
- **Documentation** - Self-explanatory structure
