<?php

declare(strict_types=1);

if (!\defined('ABSPATH')) {
    die;
}

// Enforce PHP 8.0+ requirement
if (\PHP_VERSION_ID < 80000) {
    add_action('admin_notices', function (): void {
        printf(
            '<div class="notice notice-error"><p>%s</p></div>',
            esc_html__('This plugin requires PHP 8.0 or higher. Please update your PHP version.', 'plugin-template')
        );
    });
    
    // Deactivate the plugin
    add_action('admin_init', function (): void {
        deactivate_plugins(plugin_basename(__FILE__));
    });
    
    return;
}

// Load Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Initialize the plugin
try {
    $container = \Ashy4n\Core\Service::getContainer();
    $plugin = $container->get(\Template\Plugin::class);
    $plugin->init();
} catch (\Throwable $e) {
    // Log error and show admin notice
    error_log('Plugin initialization error: ' . $e->getMessage());
    
    add_action('admin_notices', function () use ($e): void {
        printf(
            '<div class="notice notice-error"><p>%s</p></div>',
            esc_html__('Plugin initialization failed. Please check the error logs.', 'plugin-template')
        );
    });
}
