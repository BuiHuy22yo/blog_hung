<?php

/**
 * Filter
 *
 * @package ctwp
 */

namespace CTWP_THEME\Inc;

use CTWP_THEME\Inc\Traits\Singleton;

class Filter {
	use Singleton;

	public function __construct() {
		$this->setup_theme();
	}

	public function setup_theme() {
		add_filter( 'body_class', [$this, 'generate_class_on_body'] );
		add_filter( 'class_header', [$this, 'generate_class_on_header'] );
		if ( class_exists( 'woocommerce' ) ) {
			add_filter( 'woocommerce_enqueue_styles', [$this, 'jk_dequeue_styles'] );

		}
	}

	public function jk_dequeue_styles( $enqueue_styles ) {
		unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
		unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
		unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
		return $enqueue_styles;
	}

	public function generate_class_on_body($classes) {
		global $post;
		$post_id = $post->ID;

		if (!$post_id) {
			return $classes;
		}

		$class_body = '';

		if ( function_exists('get_field') ) {
			$class_body = array( get_field('class_body', $post_id) );
		}

		if ( $class_body == '' ) {
			return $classes;
		}

		return array_merge( $classes, $class_body );
	}

	public function generate_class_on_header($classes) {
		global $post;
		$post_id = $post->ID;

		if (!$post_id) {
			return $classes;
		}

		$class_header = '';

		if ( function_exists('get_field') ) {
			$class_header = array( get_field('class_header', $post_id) );
		}

		if ( $class_header == '' ) {
			return $classes;
		}

		return array_merge( $classes, $class_header );
	}
}
?>
