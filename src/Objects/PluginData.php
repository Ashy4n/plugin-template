<?php

declare(strict_types=1);

namespace Template\Objects;

/**
 * Central repository for all plugin information and metadata.
 */
final class PluginData
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly string $version,
        public readonly string $description,
        public readonly string $author,
        public readonly string $authorUri,
        public readonly string $pluginUri,
        public readonly string $textDomain,
        public readonly string $domainPath,
        public readonly string $requiresPhp,
        public readonly string $requiresWp,
        public readonly string $license,
        public readonly string $licenseUri,
        public readonly string $network,
        public readonly string $file,
        public readonly string $dir,
        public readonly string $url,
        public readonly string $assetsUrl,
        public readonly string $templatesDir,
        public readonly string $langDir
    ) {
    }

    /**
     * Get plugin basename for WordPress functions.
     */
    public function getBasename(): string
    {
        return plugin_basename($this->file);
    }

    /**
     * Get plugin directory path.
     */
    public function getDir(): string
    {
        return plugin_dir_path($this->file);
    }

    /**
     * Get plugin URL.
     */
    public function getUrl(): string
    {
        return plugin_dir_url($this->file);
    }

    /**
     * Get assets URL.
     */
    public function getAssetsUrl(): string
    {
        return $this->getUrl() . 'assets/';
    }

    /**
     * Get templates directory path.
     */
    public function getTemplatesDir(): string
    {
        return $this->getDir() . 'templates/';
    }

    /**
     * Get language directory path.
     */
    public function getLangDir(): string
    {
        return $this->getDir() . 'lang/';
    }

    /**
     * Check if plugin is in development mode.
     */
    public function isDevelopment(): bool
    {
        return defined('WP_DEBUG') && WP_DEBUG;
    }

    /**
     * Get plugin header data as array.
     */
    public function getHeaderData(): array
    {
        return [
            'Name' => $this->name,
            'PluginURI' => $this->pluginUri,
            'Description' => $this->description,
            'Version' => $this->version,
            'Author' => $this->author,
            'AuthorURI' => $this->authorUri,
            'License' => $this->license,
            'TextDomain' => $this->textDomain,
            'DomainPath' => $this->domainPath,
            'RequiresPHP' => $this->requiresPhp,
            'RequiresWP' => $this->requiresWp,
            'Network' => $this->network,
        ];
    }
}
