<?php

/**
 * Assets
 *
 * @package Ctwp
 */

namespace CTWP_THEME\Inc;

use CTWP_THEME\Inc\Traits\Singleton;

class Assets
{
	use Singleton;

	protected function __construct()
	{

		// load class.
		$this->setup_hooks();
	}

	protected function setup_hooks()
	{

		/**
		 * Actions.
		 */
		add_action('wp_enqueue_scripts', [$this, 'register_styles']);
		add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
	}

	public function register_styles()
	{
		wp_enqueue_style( 'cct-style', CTWP_BUILD_URI . '/css/main.css', array(), false, "all" );
	}

	public function register_scripts()
	{
	    wp_enqueue_script( 'main-script', CTWP_BUILD_URI . '/js/main.js', array( 'jquery' ), false, true );
        wp_localize_script( 'main-script', 'main_script', array(
		 		'ajax_url' => admin_url( 'admin-ajax.php' ),
		 	) );
	}
}
