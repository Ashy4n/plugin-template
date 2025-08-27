<?php

namespace Ashy4n\Core\Plugin;

use Ashy4n\Core\Objects\PluginInfo;

abstract class AbstractPlugin {

	protected PluginInfo $plugin_info;

	public function __construct( PluginInfo $plugin_info ) {
		$this->plugin_info = $plugin_info;
	}
}
