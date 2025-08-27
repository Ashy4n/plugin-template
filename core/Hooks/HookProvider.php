<?php

namespace Ashy4n\Core\Hooks;

abstract class HookProvider {

	/** @var Hookable[] */
	private array $hooks = [];

	public function register_hooks() {
		add_action( 'init', [ $this, 'init_hooks' ] );
	}

	public function init_hooks() {
		foreach ( $this->hooks as $hook ) {
			$hook->hook();
		}
	}

	public function register_hook( Hookable $hook ) {
		$this->hooks[] = $hook;
	}
}
