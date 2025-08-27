.PHONY: help install test test-coverage analyse cs cs-fix build dev clean

# Default target
help: ## Show this help message
	@echo "Modern WordPress Plugin Boilerplate - Available Commands:"
	@echo ""
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

# Installation
install: ## Install all dependencies (PHP and Node.js)
	@echo "Installing PHP dependencies..."
	composer install
	@echo "Installing Node.js dependencies..."
	npm install
	@echo "Installation complete!"

# Testing
test: ## Run PHPUnit tests
	@echo "Running PHPUnit tests..."
	composer test

test-coverage: ## Run PHPUnit tests with coverage report
	@echo "Running PHPUnit tests with coverage..."
	composer run test:coverage
	@echo "Coverage report generated in coverage/ directory"

# Code Quality
analyse: ## Run PHPStan static analysis
	@echo "Running PHPStan analysis..."
	composer run analyse

cs: ## Run PHP CodeSniffer
	@echo "Running PHP CodeSniffer..."
	composer run cs

cs-fix: ## Fix PHP CodeSniffer issues automatically
	@echo "Fixing PHP CodeSniffer issues..."
	composer run cs:fix

lint: ## Run ESLint for frontend code
	@echo "Running ESLint..."
	npm run lint

type-check: ## Run TypeScript type checking
	@echo "Running TypeScript type check..."
	npm run type-check

# Building
build: ## Build frontend assets and scope PHP dependencies
	@echo "Building frontend assets..."
	npm run build
	@echo "Scoping PHP dependencies..."
	composer run php-scoper
	@echo "Build complete! Check the build/ directory"

build-assets: ## Build only frontend assets
	@echo "Building frontend assets..."
	npm run build

build-php: ## Scope only PHP dependencies
	@echo "Scoping PHP dependencies..."
	composer run php-scoper

# Development
dev: ## Start frontend development server
	@echo "Starting development server..."
	npm run dev

# Cleaning
clean: ## Clean build artifacts and cache
	@echo "Cleaning build artifacts..."
	rm -rf assets/
	rm -rf build/
	rm -rf coverage/
	rm -rf .phpunit.cache/
	rm -rf .phpstan.cache/
	rm -rf .sass-cache/
	rm -rf .twig-cache/
	@echo "Clean complete!"

clean-deps: ## Clean dependencies (vendor and node_modules)
	@echo "Cleaning dependencies..."
	rm -rf vendor/
	rm -rf node_modules/
	@echo "Dependencies cleaned!"

# WordPress specific
wp-install: ## Install WordPress for testing (requires WP-CLI)
	@echo "Installing WordPress for testing..."
	wp core download --path=tests/wordpress
	wp config create --path=tests/wordpress --dbname=test_db --dbuser=root --dbpass= --dbhost=localhost
	wp core install --path=tests/wordpress --url=localhost --title="Test Site" --admin_user=admin --admin_password=password --admin_email=admin@example.com

# Quick development workflow
quick-test: ## Quick test run (PHPStan + PHPUnit + ESLint)
	@echo "Running quick test suite..."
	composer run analyse
	composer test
	npm run lint
	@echo "Quick test complete!"

# Production preparation
prod-prep: ## Prepare for production (build + test)
	@echo "Preparing for production..."
	make test
	make analyse
	make cs
	make build
	@echo "Production preparation complete!"

# Docker helpers (if using Docker)
docker-build: ## Build Docker image
	@echo "Building Docker image..."
	docker build -t plugin-template .

docker-test: ## Run tests in Docker
	@echo "Running tests in Docker..."
	docker run --rm plugin-template make test

# Utility
status: ## Show current status
	@echo "=== Plugin Template Status ==="
	@echo "PHP Version: $(shell php -v | head -n1)"
	@echo "Node Version: $(shell node --version)"
	@echo "Composer Version: $(shell composer --version | head -n1)"
	@echo "NPM Version: $(shell npm --version)"
	@echo "=============================="
