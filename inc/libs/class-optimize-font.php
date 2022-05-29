<?php

/**
* Optimize_Google_Font
*
* @package Ctwp
*/

namespace CTWP_THEME\Inc;

class Optimize_Google_Font {
    /**
     * @var array
     */

    public function __construct() {
        $this->setup_hooks();
    }
    protected function setup_hooks() {
        add_filter( 'style_loader_tag',  [ $this, 'async_css' ], 10, 3 );
        add_action( 'wp_head', [ $this, 'preload' ], 1 );
        add_filter( 'wp_resource_hints', [ $this, 'resource_hints' ], 10, 2 );
	}

    /**
     * Load Google Fonts Asynchrously
     * 
     * @see https://www.filamentgroup.com/lab/load-css-simpler/
     */
    public function async_css( $html, $handle, $href ) {
        if (
            ! empty( $this->options['handle'] ) &&
            $handle !== $this->options['handle']
        ) {
            return $html;
        }

        if ( false === strpos( $href, 'fonts.googleapis.com/css' ) ) {
            return $html;
        }

        if ( false !== strpos( $html, "media='all'" ) ) {
            return str_replace(
                "media='all'",
                "media='print' onload=\"this.media='all'\"",
                $html
            );
        }

        return str_replace(
            "rel='stylesheet'",
            "rel='stylesheet' media='print' onload=\"this.media='all'\"",
            $html
        );
    }

    /**
     * Add preload link for Google Fonts
     */
    public function preload() {
        if ( empty( $this->options['href'] ) ) {
            return;
        }
        ?>

        <link rel='preload' as='style' href='<?php echo esc_url( $this->options['href'] ); ?>'>

        <?php
    }

    /**
     * Add resource hints for Google Fonts
     */
    public function resource_hints( $urls, $relation_type ) {
        if ( 'preconnect' === $relation_type ) {
            $urls[] = [
                'href' => 'https://fonts.gstatic.com',
                'crossorigin'
            ];
        }

        return $urls;
    }
}

new Optimize_Google_Font();