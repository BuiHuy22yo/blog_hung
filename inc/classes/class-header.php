<?php

/**
 * Header
 *
 * @package ctwp
 */

namespace CTWP_THEME\Inc;

use CTWP_THEME\Inc\Traits\Singleton;

class Header {
	use Singleton;

	public function __construct() {
		$this->setup_theme();
	}

	public function setup_theme() {
        add_action('ctwp_header_top', [$this, 'header_top'], 10);
		// before header
		add_action('before_header', [$this, 'open_tag_header'], 10);
		// ctwp_header
		add_action('ctwp_header', [$this, 'header_main'], 10);
		// after_header
		add_action('after_header', [$this, 'close_tag_header'], 100);
	}

	public function open_tag_header()
	{
		$classes = esc_attr( implode( ' ', $this->generate_class_header() ) );

		echo '<header class="'.$classes.'" >';
		echo sprintf('<div class=%s>', esc_attr('container'));
		echo sprintf('<div class=%s>', esc_attr('header-inner'));

	}

	public function close_tag_header()
	{
		echo '</div>';
		echo '</div>';
		echo '</header>';
	}

	public function header_main() {?>
        <div class="header_main_left"><?php get_template_part('template-parts/header/logo'); ?></div>
        <div class="header_main_center"><?php get_template_part('template-parts/header/nav'); ?></div>
        <div class="header_main_right"><?php get_template_part('template-parts/header/toggle'); ?></div>
        <?php
	}

	private function generate_class_header() {
		return apply_filters('class_header', array_map('esc_attr', ['primary-header']) );
	}

    public function header_top()
    {
        ?>
        <div class="header-top">
        <div class="container">
            <div class="header-inner-top d-flex justify-content-end p-2 ">
                <div class="search pe-3"><?php echo 'search' ?></div>
                <div class="account ps-3"><?php echo 'login/sign in' ?></div>
            </div>
        </div>
        </div>
        <?php
    }
}
