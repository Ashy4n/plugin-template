<?php

declare(strict_types=1);

namespace Template\Services;

use Template\Objects\PluginData;

/**
 * Example service demonstrating modern PHP 8+ features and service patterns.
 */
class ExampleService
{
    public function __construct(
        private readonly PluginData $pluginData,
        private readonly TwigService $twigService
    ) {
    }

    /**
     * Get plugin information.
     */
    public function getPluginInfo(): array
    {
        return [
            'name' => $this->pluginData->name,
            'version' => $this->pluginData->version,
            'description' => $this->pluginData->description,
            'author' => $this->pluginData->author,
            'isDevelopment' => $this->pluginData->isDevelopment(),
        ];
    }

    /**
     * Process data with modern PHP features.
     */
    public function processData(?array $data = null): array
    {
        // Use nullsafe operator
        $processedData = $data?->filter(fn($item) => !empty($item)) ?? [];
        
        // Use array spread operator
        $result = [
            'processed' => true,
            'timestamp' => time(),
            'data' => [...$processedData],
        ];

        // Use match expression (PHP 8+)
        $status = match (count($processedData)) {
            0 => 'empty',
            1 => 'single',
            default => 'multiple',
        };

        $result['status'] = $status;

        return $result;
    }

    /**
     * Validate input using modern PHP features.
     */
    public function validateInput(mixed $input): bool
    {
        // Use match expression for type checking
        return match (true) {
            is_string($input) => !empty(trim($input)),
            is_array($input) => !empty(array_filter($input)),
            is_numeric($input) => $input > 0,
            default => false,
        };
    }

    /**
     * Get formatted plugin data.
     */
    public function getFormattedData(): string
    {
        $info = $this->getPluginInfo();
        
        // Use named arguments (PHP 8+)
        return $this->twigService->render('plugin-info.twig', [
            'info' => $info,
            'timestamp' => time(),
        ]);
    }

    /**
     * Example method using constructor property promotion and readonly properties.
     */
    public function getServiceInfo(): array
    {
        return [
            'pluginName' => $this->pluginData->name,
            'hasTwigService' => $this->twigService instanceof TwigService,
            'phpVersion' => PHP_VERSION,
        ];
    }
}
