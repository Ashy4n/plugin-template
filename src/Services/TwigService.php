<?php

declare(strict_types=1);

namespace Template\Services;

use Template\Objects\PluginData;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

/**
 * Service for handling Twig template rendering.
 */
class TwigService
{
    private Environment $twig;
    private PluginData $pluginData;

    public function __construct(PluginData $pluginData)
    {
        $this->pluginData = $pluginData;
        $this->initializeTwig();
    }

    /**
     * Initialize Twig environment.
     */
    private function initializeTwig(): void
    {
        $loader = new FilesystemLoader($this->pluginData->getTemplatesDir());
        
        $this->twig = new Environment($loader, [
            'cache' => $this->pluginData->isDevelopment() ? false : $this->pluginData->getDir() . 'cache/twig',
            'debug' => $this->pluginData->isDevelopment(),
            'auto_reload' => $this->pluginData->isDevelopment(),
            'strict_variables' => true,
        ]);

        // Add debug extension in development mode
        if ($this->pluginData->isDevelopment()) {
            $this->twig->addExtension(new DebugExtension());
        }

        // Add global variables
        $this->twig->addGlobal('plugin', $this->pluginData);
        $this->twig->addGlobal('nonce', wp_create_nonce($this->pluginData->slug));
        $this->twig->addGlobal('ajax_url', admin_url('admin-ajax.php'));
    }

    /**
     * Render a template.
     */
    public function render(string $template, array $context = []): string
    {
        try {
            return $this->twig->render($template, $context);
        } catch (\Throwable $e) {
            error_log('Twig rendering error: ' . $e->getMessage());
            
            if ($this->pluginData->isDevelopment()) {
                throw $e;
            }
            
            return $this->renderErrorTemplate($e->getMessage());
        }
    }

    /**
     * Check if a template exists.
     */
    public function exists(string $template): bool
    {
        return $this->twig->getLoader()->exists($template);
    }

    /**
     * Get the Twig environment.
     */
    public function getTwig(): Environment
    {
        return $this->twig;
    }

    /**
     * Render an error template.
     */
    private function renderErrorTemplate(string $error): string
    {
        return sprintf(
            '<div class="error"><p>%s</p></div>',
            esc_html__('Template rendering error occurred.', $this->pluginData->textDomain)
        );
    }

    /**
     * Clear Twig cache.
     */
    public function clearCache(): void
    {
        if ($this->twig->getCache()) {
            $this->twig->getCache()->clear();
        }
    }
}
