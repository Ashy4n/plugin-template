<?php

declare(strict_types=1);

namespace Template;

use Ashy4n\Core\Plugin\AbstractPlugin;
use Template\Objects\PluginData;
use Template\Hooks\Hookable;
use Template\Services\ExampleService;
use Template\Services\TwigService;
use DI\Container;

/**
 * Main plugin class implementing the modern WordPress plugin architecture.
 */
class Plugin extends AbstractPlugin
{
    private PluginData $pluginData;
    private Container $container;
    private array $hookables = [];

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->initializePluginData();
        $this->registerServices();
        $this->registerHookables();
    }

    /**
     * Initialize the plugin.
     */
    public function init(): void
    {
        // Register all hooks
        foreach ($this->hookables as $hookable) {
            $hookable->hook();
        }

        // Enqueue assets
        $this->enqueueAssets();
    }

    /**
     * Initialize plugin data.
     */
    private function initializePluginData(): void
    {
        $this->pluginData = new PluginData(
            name: '{PLUGIN_NAME}',
            slug: '{PLUGIN_SLUG}',
            version: '1.0.0',
            description: 'A modern WordPress plugin built with best practices.',
            author: '{PLUGIN_AUTHOR}',
            authorUri: '{PLUGIN_AUTHOR_URI}',
            pluginUri: '{PLUGIN_URI}',
            textDomain: '{TEXT_DOMAIN}',
            domainPath: '/lang',
            requiresPhp: '8.0',
            requiresWp: '5.0',
            license: 'GPL-2.0-or-later',
            licenseUri: 'https://www.gnu.org/licenses/gpl-2.0.html',
            network: '',
            file: __FILE__,
            dir: plugin_dir_path(__FILE__),
            url: plugin_dir_url(__FILE__),
            assetsUrl: plugin_dir_url(__FILE__) . 'assets/',
            templatesDir: plugin_dir_path(__FILE__) . 'templates/',
            langDir: plugin_dir_path(__FILE__) . 'lang/'
        );
    }

    /**
     * Register services in the DI container.
     */
    private function registerServices(): void
    {
        // Register plugin data
        $this->container->set(PluginData::class, $this->pluginData);

        // Register Twig service
        $this->container->set(TwigService::class, function (Container $container) {
            return new TwigService($container->get(PluginData::class));
        });

        // Register example service
        $this->container->set(ExampleService::class, function (Container $container) {
            return new ExampleService(
                $container->get(PluginData::class),
                $container->get(TwigService::class)
            );
        });
    }

    /**
     * Register hookable classes.
     */
    private function registerHookables(): void
    {
        // Register hookable classes
        $this->hookables[] = $this->container->get(\Template\Hooks\ExampleHook::class);
        
        // Add more hookable classes here as needed
        // $this->hookables[] = $this->container->get(\Template\Hooks\AdminHook::class);
        // $this->hookables[] = $this->container->get(\Template\Hooks\FrontendHook::class);
    }

    /**
     * Enqueue frontend and admin assets.
     */
    private function enqueueAssets(): void
    {
        // Enqueue admin assets
        add_action('admin_enqueue_scripts', function (): void {
            $this->enqueueAdminAssets();
        });

        // Enqueue frontend assets
        add_action('wp_enqueue_scripts', function (): void {
            $this->enqueueFrontendAssets();
        });
    }

    /**
     * Enqueue admin assets.
     */
    private function enqueueAdminAssets(): void
    {
        $assetUrl = $this->pluginData->getAssetsUrl();
        $version = $this->pluginData->isDevelopment() ? time() : $this->pluginData->version;

        wp_enqueue_script(
            $this->pluginData->slug . '-admin',
            $assetUrl . 'admin.js',
            ['jquery'],
            $version,
            true
        );

        wp_enqueue_style(
            $this->pluginData->slug . '-admin',
            $assetUrl . 'admin.css',
            [],
            $version
        );

        // Localize script for AJAX
        wp_localize_script($this->pluginData->slug . '-admin', 'pluginAdmin', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce($this->pluginData->slug . '_admin_nonce'),
            'pluginUrl' => $this->pluginData->getUrl(),
        ]);
    }

    /**
     * Enqueue frontend assets.
     */
    private function enqueueFrontendAssets(): void
    {
        $assetUrl = $this->pluginData->getAssetsUrl();
        $version = $this->pluginData->isDevelopment() ? time() : $this->pluginData->version;

        wp_enqueue_script(
            $this->pluginData->slug . '-frontend',
            $assetUrl . 'frontend.js',
            ['jquery'],
            $version,
            true
        );

        wp_enqueue_style(
            $this->pluginData->slug . '-frontend',
            $assetUrl . 'frontend.css',
            [],
            $version
        );

        // Localize script for AJAX
        wp_localize_script($this->pluginData->slug . '-frontend', 'pluginFrontend', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce($this->pluginData->slug . '_frontend_nonce'),
            'pluginUrl' => $this->pluginData->getUrl(),
        ]);
    }

    /**
     * Get plugin data.
     */
    public function getPluginData(): PluginData
    {
        return $this->pluginData;
    }

    /**
     * Get DI container.
     */
    public function getContainer(): Container
    {
        return $this->container;
    }
}
