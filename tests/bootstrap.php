<?php

declare(strict_types=1);

// Load Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Mock WordPress functions for testing
if (!function_exists('wp_create_nonce')) {
    function wp_create_nonce(string $action = '-1'): string {
        return 'test_nonce_' . $action;
    }
}

if (!function_exists('wp_verify_nonce')) {
    function wp_verify_nonce(string $nonce, string $action = '-1'): bool {
        return $nonce === 'test_nonce_' . $action;
    }
}

if (!function_exists('esc_html')) {
    function esc_html(string $text): string {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('esc_html__')) {
    function esc_html__(string $text, string $domain = 'default'): string {
        return esc_html($text);
    }
}

if (!function_exists('plugin_dir_path')) {
    function plugin_dir_path(string $file): string {
        return dirname($file) . '/';
    }
}

if (!function_exists('plugin_dir_url')) {
    function plugin_dir_url(string $file): string {
        return 'http://example.com/wp-content/plugins/plugin-name/';
    }
}

if (!function_exists('plugin_basename')) {
    function plugin_basename(string $file): string {
        return basename(dirname($file)) . '/' . basename($file);
    }
}

if (!function_exists('add_action')) {
    function add_action(string $hook_name, callable $callback, int $priority = 10, int $accepted_args = 1): void {
        // Mock implementation
    }
}

if (!function_exists('add_filter')) {
    function add_filter(string $hook_name, callable $callback, int $priority = 10, int $accepted_args = 1): void {
        // Mock implementation
    }
}

if (!function_exists('load_plugin_textdomain')) {
    function load_plugin_textdomain(string $domain, bool $deprecated = false, string $plugin_rel_path = ''): bool {
        return true;
    }
}

if (!function_exists('is_single')) {
    function is_single(): bool {
        return true;
    }
}

if (!function_exists('in_the_loop')) {
    function in_the_loop(): bool {
        return true;
    }
}

if (!function_exists('add_menu_page')) {
    function add_menu_page(
        string $page_title,
        string $menu_title,
        string $capability,
        string $menu_slug,
        callable $function = null,
        string $icon_url = '',
        int $position = null
    ): string {
        return $menu_slug;
    }
}

if (!function_exists('wp_enqueue_script')) {
    function wp_enqueue_script(
        string $handle,
        string $src = '',
        array $deps = [],
        string|bool|null $ver = false,
        bool $in_footer = false
    ): void {
        // Mock implementation
    }
}

if (!function_exists('wp_enqueue_style')) {
    function wp_enqueue_style(
        string $handle,
        string $src = '',
        array $deps = [],
        string|bool|null $ver = false,
        string $media = 'all'
    ): void {
        // Mock implementation
    }
}

if (!function_exists('wp_localize_script')) {
    function wp_localize_script(string $handle, string $object_name, array $l10n): bool {
        return true;
    }
}

if (!function_exists('admin_url')) {
    function admin_url(string $path = ''): string {
        return 'http://example.com/wp-admin/' . $path;
    }
}

if (!function_exists('error_log')) {
    function error_log(string $message, int $message_type = 0, string $destination = null, string $extra_headers = null): bool {
        return true;
    }
}

if (!function_exists('deactivate_plugins')) {
    function deactivate_plugins(string|array $plugins, bool $silent = false, bool $network_wide = null): void {
        // Mock implementation
    }
}

// Define constants if not already defined
if (!defined('ABSPATH')) {
    define('ABSPATH', '/var/www/html/');
}

if (!defined('WP_DEBUG')) {
    define('WP_DEBUG', true);
}
