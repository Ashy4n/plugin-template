<?php

declare(strict_types=1);

namespace Template\Hooks;

/**
 * Interface for classes that interact with WordPress hooks.
 * All classes that use add_action or add_filter must implement this interface.
 */
interface Hookable
{
    /**
     * Register all WordPress hooks (actions and filters) for this class.
     * This method should be called during plugin initialization.
     */
    public function hook(): void;

    /**
     * Get the priority for this hookable class.
     * Lower numbers correspond with earlier execution.
     */
    public function getPriority(): int;

    /**
     * Get the number of accepted arguments for this hookable class.
     */
    public function getAcceptedArgs(): int;
}
