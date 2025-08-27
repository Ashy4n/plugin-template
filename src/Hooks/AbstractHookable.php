<?php

declare(strict_types=1);

namespace Template\Hooks;

use Template\Objects\PluginData;

/**
 * Abstract base class for hookable classes.
 * Provides common functionality for classes that interact with WordPress hooks.
 */
abstract class AbstractHookable implements Hookable
{
    protected PluginData $pluginData;

    public function __construct(PluginData $pluginData)
    {
        $this->pluginData = $pluginData;
    }

    /**
     * Get the priority for this hookable class.
     * Override this method to change the default priority.
     */
    public function getPriority(): int
    {
        return 10;
    }

    /**
     * Get the number of accepted arguments for this hookable class.
     * Override this method to change the default number of accepted arguments.
     */
    public function getAcceptedArgs(): int
    {
        return 1;
    }

    /**
     * Add an action hook.
     */
    protected function addAction(string $hook, callable $callback, ?int $priority = null, ?int $acceptedArgs = null): void
    {
        add_action(
            $hook,
            $callback,
            $priority ?? $this->getPriority(),
            $acceptedArgs ?? $this->getAcceptedArgs()
        );
    }

    /**
     * Add a filter hook.
     */
    protected function addFilter(string $hook, callable $callback, ?int $priority = null, ?int $acceptedArgs = null): void
    {
        add_filter(
            $hook,
            $callback,
            $priority ?? $this->getPriority(),
            $acceptedArgs ?? $this->getAcceptedArgs()
        );
    }

    /**
     * Remove an action hook.
     */
    protected function removeAction(string $hook, callable $callback, ?int $priority = null): void
    {
        remove_action($hook, $callback, $priority ?? $this->getPriority());
    }

    /**
     * Remove a filter hook.
     */
    protected function removeFilter(string $hook, callable $callback, ?int $priority = null): void
    {
        remove_filter($hook, $callback, $priority ?? $this->getPriority());
    }

    /**
     * Get plugin data.
     */
    protected function getPluginData(): PluginData
    {
        return $this->pluginData;
    }
}
