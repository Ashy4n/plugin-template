<?php

namespace Ashy4n\Core\Scripts;

class Setup {
	public static function run() {
		echo 'Hello World!';
		// remove License file
		unlink( __DIR__ . '/../../LICENSE' );
	}
}
