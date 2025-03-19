<?php

namespace plugin;

use entity\PluginInfo;

class AbstractPlugin {

	protected PluginInfo $plugin_info;

	public function __construct( PluginInfo $plugin_info ) {
		$this->plugin_info = $plugin_info;
	}
}
