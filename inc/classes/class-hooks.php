<?php

/**
* Hook
*
* @package Ctwp
*/

namespace CTWP_THEME\Inc;

use CTWP_THEME\Inc\Traits\Singleton;

class Hooks {

	use Singleton;

	protected function __construct() {

		// load class.
		$this->setup_hooks();
	}

	protected function setup_hooks() {

		/**
		 * Actions.
		 */
		
	}
}