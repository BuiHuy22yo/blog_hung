<?php

/**
 * Disable
 *
 * @package Ctwp
 */

namespace CTWP_THEME\Inc;

use CTWP_THEME\Inc\Traits\Singleton;

class Disable
{
    use Singleton;

    protected function __construct()
    {

        // load class.
        $this->setup_hooks();
    }

    protected function setup_hooks()
    {

        add_action('wp_print_styles', array($this, 'vnvd_deregister_styles_block_wordpress'), 100);
        add_action('do_feed_rss2', array($this, 'vnvd_wpb_disable_feed'), 1);
        add_action('init', array($this, 'vnvd_stop_loading_wp_embed'));
        add_action('init', array($this, 'vnvd_disable_emojis'));;
        add_action('init', array($this, 'vnvd_disable_embeds'), 9999);
        
        add_filter( 'show_admin_bar', '__return_false' );
        add_filter('style_loader_src', array($this, 'vnvd_remove_cssjs_ver'), 10, 2);
        add_filter('script_loader_src', array($this, 'vnvd_remove_cssjs_ver'), 10, 2);
        // add_filter('jpeg_quality', array($this, 'vnvd_regenerate_thumbnail_quality'));
        add_filter( 'xmlrpc_enabled', '__return_false' );

        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'rsd_link');
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
    }

    public function vnvd_deregister_styles_block_wordpress()
    {
        wp_dequeue_style('wp-block-library');
        wp_deregister_style('wc-block-style');
        wp_dequeue_style('wp-block-library-theme');
    }
    public function vnvd_remove_cssjs_ver($src)
    {
        if (strpos($src, '?ver='))
            $src = remove_query_arg('ver', $src);
        return $src;
    }

    public function vnvd_wpb_disable_feed()
    {
        wp_die(__('Tính năng RSS Feed đã bị vô hiệu hóa. Vui lòng truy cập <a href="' . get_bloginfo('url') . '">trang chủ</a> để xem danh sách bài viết!', 'vietnv-disable'));
    }
    public function vnvd_stop_loading_wp_embed()
    {
        if (!is_admin()) {
            wp_deregister_script('wp-embed');
        }
    }
    public function vnvd_regenerate_thumbnail_quality()
    {
        return 100;
    }
    public function vnvd_disable_emojis()
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
    }
    public function vnvd_disable_embeds()
    {
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
    }
}
