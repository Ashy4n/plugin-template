<?php

namespace Ashy4n\Core\Objects;

class PluginInfo {
	public string $name;
	public string $version;

	public function __construct( string $name, string $version ) {
		$this->name    = $name;
		$this->version = $version;
	}

	public function get_name() {
		return $this->name;
	}

	public function get_version() {
		return $this->version;
	}
}
