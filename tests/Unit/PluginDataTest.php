<?php

declare(strict_types=1);

namespace Template\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Template\Objects\PluginData;

class PluginDataTest extends TestCase
{
    private PluginData $pluginData;

    protected function setUp(): void
    {
        $this->pluginData = new PluginData(
            name: 'Test Plugin',
            slug: 'test-plugin',
            version: '1.0.0',
            description: 'A test plugin',
            author: 'Test Author',
            authorUri: 'https://example.com',
            pluginUri: 'https://example.com/plugin',
            textDomain: 'test-plugin',
            domainPath: '/lang',
            requiresPhp: '8.0',
            requiresWp: '5.0',
            license: 'GPL-2.0-or-later',
            licenseUri: 'https://www.gnu.org/licenses/gpl-2.0.html',
            network: '',
            file: __FILE__,
            dir: '/path/to/plugin/',
            url: 'https://example.com/wp-content/plugins/test-plugin/',
            assetsUrl: 'https://example.com/wp-content/plugins/test-plugin/assets/',
            templatesDir: '/path/to/plugin/templates/',
            langDir: '/path/to/plugin/lang/'
        );
    }

    public function testPluginDataProperties(): void
    {
        $this->assertEquals('Test Plugin', $this->pluginData->name);
        $this->assertEquals('test-plugin', $this->pluginData->slug);
        $this->assertEquals('1.0.0', $this->pluginData->version);
        $this->assertEquals('A test plugin', $this->pluginData->description);
        $this->assertEquals('Test Author', $this->pluginData->author);
    }

    public function testGetBasename(): void
    {
        $basename = $this->pluginData->getBasename();
        $this->assertIsString($basename);
        $this->assertStringContainsString('test-plugin', $basename);
    }

    public function testGetDir(): void
    {
        $dir = $this->pluginData->getDir();
        $this->assertIsString($dir);
        $this->assertStringEndsWith('/', $dir);
    }

    public function testGetUrl(): void
    {
        $url = $this->pluginData->getUrl();
        $this->assertIsString($url);
        $this->assertStringEndsWith('/', $url);
    }

    public function testGetAssetsUrl(): void
    {
        $assetsUrl = $this->pluginData->getAssetsUrl();
        $this->assertIsString($assetsUrl);
        $this->assertStringEndsWith('assets/', $assetsUrl);
    }

    public function testGetTemplatesDir(): void
    {
        $templatesDir = $this->pluginData->getTemplatesDir();
        $this->assertIsString($templatesDir);
        $this->assertStringEndsWith('templates/', $templatesDir);
    }

    public function testGetLangDir(): void
    {
        $langDir = $this->pluginData->getLangDir();
        $this->assertIsString($langDir);
        $this->assertStringEndsWith('lang/', $langDir);
    }

    public function testIsDevelopment(): void
    {
        $isDevelopment = $this->pluginData->isDevelopment();
        $this->assertIsBool($isDevelopment);
    }

    public function testGetHeaderData(): void
    {
        $headerData = $this->pluginData->getHeaderData();
        $this->assertIsArray($headerData);
        $this->assertArrayHasKey('Name', $headerData);
        $this->assertArrayHasKey('Version', $headerData);
        $this->assertArrayHasKey('Author', $headerData);
        $this->assertEquals('Test Plugin', $headerData['Name']);
        $this->assertEquals('1.0.0', $headerData['Version']);
        $this->assertEquals('Test Author', $headerData['Author']);
    }
}
