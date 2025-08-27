# Modern WordPress Plugin Boilerplate

A comprehensive, modern WordPress plugin boilerplate built with PHP 8+, featuring dependency injection, Twig templating, modern frontend tooling, and best practices for scalable plugin development.

## 🚀 Features

### Core Architecture
- **Object-Oriented Design**: Clean, maintainable architecture using modern PHP 8+ features
- **Dependency Injection**: Full DI container integration with PHP-DI
- **Hookable Interface**: Standardized approach to WordPress hooks with `Hookable` interface
- **PluginData Class**: Centralized plugin information management
- **PHP 8+ Requirement**: Enforces modern PHP features and best practices

### Modern Development Tools
- **Vite + TypeScript**: Modern frontend build system with Hot Module Replacement
- **Sass/SCSS**: Advanced CSS preprocessing with variables and mixins
- **PHPStan**: Static code analysis for PHP
- **PHPUnit**: Comprehensive testing framework
- **PHP CodeSniffer**: Code quality and style enforcement
- **PHP Scoper**: Dependency prefixing to prevent conflicts

### Templating & Frontend
- **Twig Templates**: Secure, flexible templating engine
- **React Components**: Modern JavaScript framework for interactive UIs
- **Responsive Design**: Mobile-first CSS architecture
- **Asset Optimization**: Minified and optimized production builds

### Testing & Quality
- **Unit Tests**: PHPUnit test suite with WordPress function mocking
- **Code Coverage**: Automated test coverage reporting
- **Static Analysis**: PHPStan integration for error detection
- **Code Standards**: PSR-12 and WordPress coding standards

## 📋 Requirements

- PHP 8.0 or higher
- WordPress 5.0 or higher
- Node.js 16+ (for frontend development)
- Composer (for PHP dependencies)

## 🛠️ Installation

### 1. Create a new plugin from this template

```bash
composer create-project ashy4n/plugin-template your-plugin-name
cd your-plugin-name
```

### 2. Install dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Configure your plugin

Run the setup script to configure your plugin:

```bash
composer run setup
```

This will prompt you for:
- Plugin name
- Plugin slug
- Author name
- Author URI
- Plugin URI
- Description

## 🏗️ Project Structure

```
plugin-template/
├── assets-src/                 # Frontend source files
│   ├── components/            # TypeScript/React components
│   ├── styles/               # SCSS files
│   ├── admin.ts              # Admin entry point
│   └── frontend.ts           # Frontend entry point
├── assets/                   # Compiled frontend assets
├── core/                     # Core framework files
├── src/                      # Plugin source code
│   ├── Hooks/               # WordPress hook classes
│   ├── Objects/             # Data objects
│   ├── Services/            # Service classes
│   └── Plugin.php           # Main plugin class
├── templates/               # Twig templates
│   ├── admin/              # Admin templates
│   └── frontend/           # Frontend templates
├── tests/                   # Test files
│   ├── Unit/               # Unit tests
│   └── bootstrap.php       # Test bootstrap
├── lang/                    # Translation files
├── vendor/                  # Composer dependencies
├── node_modules/           # Node.js dependencies
├── composer.json           # PHP dependencies
├── package.json            # Node.js dependencies
├── phpunit.xml            # PHPUnit configuration
├── phpstan.neon           # PHPStan configuration
├── vite.config.ts         # Vite configuration
└── tsconfig.json          # TypeScript configuration
```

## 🔧 Development Workflow

### Frontend Development

```bash
# Start development server with HMR
npm run dev

# Build for production
npm run build

# Type checking
npm run type-check

# Linting
npm run lint
```

### PHP Development

```bash
# Run tests
composer test

# Run tests with coverage
composer run test:coverage

# Static analysis
composer run analyse

# Code style check
composer run cs

# Fix code style issues
composer run cs:fix
```

### Building for Production

```bash
# Build frontend assets
npm run build

# Build PHP with scoped dependencies
composer run build
```

## 🎯 Key Concepts

### Hookable Interface

All classes that interact with WordPress hooks must implement the `Hookable` interface:

```php
<?php

use Template\Hooks\AbstractHookable;

class MyHook extends AbstractHookable
{
    public function hook(): void
    {
        $this->addAction('init', [$this, 'onInit']);
        $this->addFilter('the_content', [$this, 'modifyContent']);
    }

    public function onInit(): void
    {
        // Plugin initialization logic
    }

    public function modifyContent(string $content): string
    {
        // Content modification logic
        return $content;
    }
}
```

### PluginData Class

Centralized plugin information management:

```php
<?php

use Template\Objects\PluginData;

$pluginData = new PluginData(
    name: 'My Plugin',
    slug: 'my-plugin',
    version: '1.0.0',
    // ... other properties
);

// Access plugin information
echo $pluginData->name;
echo $pluginData->getAssetsUrl();
echo $pluginData->getTemplatesDir();
```

### Twig Templating

Secure template rendering with Twig:

```php
<?php

use Template\Services\TwigService;

$twigService = new TwigService($pluginData);
$html = $twigService->render('admin/dashboard.twig', [
    'user' => $currentUser,
    'settings' => $settings,
]);
```

```twig
{# templates/admin/dashboard.twig #}
{% extends "admin/layout.twig" %}

{% block content %}
<div class="plugin-admin">
    <h1>{{ plugin.name }} Dashboard</h1>
    <p>Welcome, {{ user.name }}!</p>
    
    {% for setting in settings %}
        <div class="setting">
            <label>{{ setting.label }}</label>
            <input type="text" value="{{ setting.value }}">
        </div>
    {% endfor %}
</div>
{% endblock %}
```

### Dependency Injection

Services are automatically injected via the DI container:

```php
<?php

use Template\Services\ExampleService;

class MyService
{
    public function __construct(
        private readonly PluginData $pluginData,
        private readonly TwigService $twigService,
        private readonly ExampleService $exampleService
    ) {
    }
}
```

## 🧪 Testing

### Writing Tests

```php
<?php

namespace Template\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Template\Objects\PluginData;

class PluginDataTest extends TestCase
{
    public function testPluginDataProperties(): void
    {
        $pluginData = new PluginData(/* ... */);
        
        $this->assertEquals('Test Plugin', $pluginData->name);
        $this->assertEquals('1.0.0', $pluginData->version);
    }
}
```

### Running Tests

```bash
# Run all tests
composer test

# Run specific test file
./vendor/bin/phpunit tests/Unit/PluginDataTest.php

# Run with coverage report
composer run test:coverage
```

## 📦 Building for Distribution

### 1. Build Frontend Assets

```bash
npm run build
```

### 2. Scope Dependencies

```bash
composer run php-scoper
```

### 3. Create Distribution Package

The build process creates a `build/` directory with:
- Prefixed vendor dependencies
- Compiled frontend assets
- Optimized for production

## 🔒 Security Features

- **Nonce Verification**: Built-in WordPress nonce support
- **Input Sanitization**: Proper escaping and validation
- **Template Security**: Twig auto-escaping
- **Dependency Isolation**: PHP Scoper prevents conflicts

## 🌐 Internationalization

```php
// Load text domain
load_plugin_textdomain($pluginData->textDomain, false, $pluginData->getLangDir());

// Use in templates
esc_html__('Hello World', $pluginData->textDomain);
```

## 📚 Best Practices

### Code Organization
- Use the `Hookable` interface for all WordPress interactions
- Keep services focused and single-purpose
- Use dependency injection for loose coupling
- Follow PSR-12 coding standards

### Performance
- Use asset versioning for cache busting
- Enable Twig caching in production
- Minimize database queries
- Use WordPress transients for caching

### Security
- Always verify nonces for form submissions
- Sanitize and validate all user input
- Use prepared statements for database queries
- Follow WordPress security guidelines

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Ensure all tests pass
6. Submit a pull request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

For support and questions:
- Create an issue on GitHub
- Check the documentation
- Review the example code

## 🔄 Updates

To update the boilerplate:

```bash
composer update
npm update
```

---

Built with ❤️ for the WordPress community
