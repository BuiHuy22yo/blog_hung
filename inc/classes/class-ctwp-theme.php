<?php

/**
 * CTWP_THEME
 *
 * @package Ctwp
 */

namespace CTWP_THEME\Inc;

use CTWP_THEME\Inc\Traits\Singleton;

class CTWP_THEME
{
	use Singleton;

	/**
	 * __construct
	 *
	 * @return void
	 */
	protected function __construct()
	{

		// Load class.
		Assets::get_instance();
		Menus::get_instance();
		Sidebars::get_instance();
		Hooks::get_instance();
		Optimize_Core::get_instance();
		Disable::get_instance();
		Filter::get_instance();
		Header::get_instance();
		Footer::get_instance();
		$this->setup_hooks();
	}

	/**
	 * setup_hooks
	 *
	 * @return void
	 */
	protected function setup_hooks()
	{

		/**
		 * Actions.
		 */
		add_action('after_setup_theme', [$this, 'setup_theme']);
		if (function_exists('get_field') && get_field('minify_html',"option")) {
			add_action('get_header', [$this, 'html_compression_start']);
		}
	}

	/**
	 * html_compression_finish
	 *
	 * @return void
	 */
	public function html_compression_finish($html)
	{
		return new Html_Compression($html);;
	}


	public function html_compression_start()
	{
		ob_start([$this, 'html_compression_finish']);
	}

	/**
	 * Setup theme.
	 *
	 * @return void
	 */
	public function setup_theme()
	{

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/**
		 * Custom logo.
		 *
		 * @see Adding custom logo
		 * @link https://developer.wordpress.org/themes/functionality/custom-logo/#adding-custom-logo-support-to-your-theme
		 */
		add_theme_support(
			'custom-logo',
			[
				'header-text' => [
					'site-title',
					'site-description',
				],
				'height'      => 100,
				'width'       => 400,
				'flex-height' => true,
				'flex-width'  => true,
			]
		);

		/**
		 * Adds Custom background panel to customizer.
		 *
		 * @see Enable Custom Backgrounds
		 * @link https://developer.wordpress.org/themes/functionality/custom-backgrounds/#enable-custom-backgrounds
		 */
		add_theme_support(
			'custom-background',
			[
				'default-color' => 'ffffff',
				'default-image' => '',
				'default-repeat' => 'no-repeat',
			]
		);

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * Adding this will allow you to select the featured image on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		add_theme_support('post-formats', array('aside', 'gallery'));


		/**
		 * Register image sizes.
		 */
		add_image_size('featured-thumbnail', 350, 233, true);


		// Add theme support for selective refresh for widgets.
		/**
		 * WordPress 4.5 includes a new Customizer framework called selective refresh
		 *
		 * Selective refresh is a hybrid preview mechanism that has the performance benefit of not having to refresh the entire preview window.
		 *
		 * @link https://make.wordpress.org/core/2016/03/22/implementing-selective-refresh-support-for-widgets/
		 */
		add_theme_support('customize-selective-refresh-widgets');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/**
		 * Switch default core markup for search form, comment form, comment-list, gallery, caption, script and style
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			[
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
			]
		);

		// Remove the core block patterns
		remove_theme_support('core-block-patterns');

		/**
		 * Set the maximum allowed width for any content in the theme,
		 * like oEmbeds and images added to posts
		 *
		 * @see Content Width
		 * @link https://codex.wordpress.org/Content_Width
		 */
		global $content_width;
		if (!isset($content_width)) {
			$content_width = 1240;
		}
	}
}
