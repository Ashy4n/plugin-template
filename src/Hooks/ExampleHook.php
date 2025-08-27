<?php

declare(strict_types=1);

namespace Template\Hooks;

use Template\Objects\PluginData;

/**
 * Example hook class demonstrating the Hookable interface.
 */
class ExampleHook extends AbstractHookable
{
    /**
     * Register all WordPress hooks for this class.
     */
    public function hook(): void
    {
        // Example: Add action for plugin initialization
        $this->addAction('init', [$this, 'onInit']);
        
        // Example: Add filter for content modification
        $this->addFilter('the_content', [$this, 'modifyContent']);
        
        // Example: Add action for admin menu
        $this->addAction('admin_menu', [$this, 'addAdminMenu']);
    }

    /**
     * Handle plugin initialization.
     */
    public function onInit(): void
    {
        // Load text domain for internationalization
        load_plugin_textdomain(
            $this->pluginData->textDomain,
            false,
            $this->pluginData->getLangDir()
        );
    }

    /**
     * Modify post content.
     */
    public function modifyContent(string $content): string
    {
        // Example: Add a custom message to the end of posts
        if (is_single() && in_the_loop()) {
            $content .= '<p class="plugin-message">' . 
                       esc_html__('This content was processed by our plugin!', $this->pluginData->textDomain) . 
                       '</p>';
        }
        
        return $content;
    }

    /**
     * Add admin menu item.
     */
    public function addAdminMenu(): void
    {
        add_menu_page(
            $this->pluginData->name,
            $this->pluginData->name,
            'manage_options',
            $this->pluginData->slug,
            [$this, 'renderAdminPage'],
            'dashicons-admin-generic',
            30
        );
    }

    /**
     * Render admin page.
     */
    public function renderAdminPage(): void
    {
        // This would typically use a template engine like Twig
        echo '<div class="wrap">';
        echo '<h1>' . esc_html($this->pluginData->name) . '</h1>';
        echo '<div id="plugin-admin-app"></div>';
        echo '</div>';
    }
}
