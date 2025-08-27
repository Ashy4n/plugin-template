<?php

namespace Ashy4n\Core\Scripts;

class Setup {

	private const FILES_TO_REMOVE = [
		'LICENSE',
	];

	public function run(): void {
		$this->removeReduntantFiles();
		$this->prepareComposerJson();
		$this->renamePlugin();
	}

	private function removeReduntantFiles(): void {
		foreach ( self::FILES_TO_REMOVE as $file ) {
			unlink( __DIR__ . '/../../' . $file );
		}
	}

	private function prepareComposerJson(): void {
	}

	private function renamePlugin(): void {
		$currentDir = getcwd();

		$pluginSlug = basename( $currentDir );

		$pluginName = str_replace( '-', ' ', $pluginSlug );
		$pluginName = ucwords( $pluginName );

		$pluginFile = $currentDir . '/plugin-template.php';

		if ( file_exists( $pluginFile ) ) {
			$contents = file_get_contents( $pluginFile );
			$contents = str_replace( [ '{PLUGIN_NAME}', '{TEXT_DOMAIN}' ], [ $pluginName, $pluginSlug ], $contents );
			file_put_contents( $pluginFile, $contents );
		}

		rename( $currentDir . '/plugin-template.php', $currentDir . '/' . $pluginSlug . '.php' );
	}
}
