<?php

if ( ! defined( 'CTWP_DIR_PATH' ) ) {
    define( 'CTWP_DIR_PATH', untrailingslashit( get_template_directory() ) );
}

if ( ! defined( 'CTWP_DIR_URI' ) ) {
    define( 'CTWP_DIR_URI', untrailingslashit( get_template_directory_uri() ) );
}

if ( ! defined( 'CTWP_BUILD_URI' ) ) {
    define( 'CTWP_BUILD_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/build' );
}

if ( ! defined( 'CTWP_BUILD_PATH' ) ) {
    define( 'CTWP_BUILD_PATH', untrailingslashit( get_template_directory() ) . '/assets/build' );
}

//if ( ! defined( 'CTWP_BUILD_JS_URI' ) ) {
//    define( 'CTWP_BUILD_JS_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/js' );
//}
//
//if ( ! defined( 'CTWP_BUILD_JS_DIR_PATH' ) ) {
//    define( 'CTWP_BUILD_JS_DIR_PATH', untrailingslashit( get_template_directory() ) . '/assets/js' );
//}

//if ( ! defined( 'CTWP_BUILD_IMG_URI' ) ) {
//    define( 'CTWP_BUILD_IMG_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/img' );
//}

//if ( ! defined( 'CTWP_BUILD_CSS_URI' ) ) {
//    define( 'CTWP_BUILD_CSS_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/css' );
//}
//
//if ( ! defined( 'CTWP_BUILD_CSS_DIR_PATH' ) ) {
//    define( 'CTWP_BUILD_CSS_DIR_PATH', untrailingslashit( get_template_directory() ) . '/assets/css' );
//}
require_once CTWP_DIR_PATH . '/inc/libs/class-html-compression.php';
require_once CTWP_DIR_PATH . '/inc/helpers/autoloader.php';
require_once CTWP_DIR_PATH . '/inc/helpers/template-tags.php';
require_once CTWP_DIR_PATH . '/inc/helpers/acf-config.php';
require_once CTWP_DIR_PATH . '/inc/helpers/resize.php';
require_once CTWP_DIR_PATH . '/inc/helpers/components.php';
require_once CTWP_DIR_PATH . '/inc/helpers/nav.php';
function ctwp_get_theme_instance() {
    \CTWP_THEME\Inc\CTWP_THEME::get_instance();
}

ctwp_get_theme_instance();

add_filter('script_loader_tag', 'add_defer_tags_to_scripts');
function add_defer_tags_to_scripts($tag){
    # List scripts to add attributes to
    $scripts_to_defer = array('contact-form-7-js', 'jquery-blockui-js', 'wc-add-to-cart-js', 'js-cookie-js', 'woocommerce-js', 'wc-cart-fragments-js', 'ctwp-defer');
    $scripts_to_async = array('ctwp-vendor-js', 'ctwp-async');

    # add the defer tags to scripts_to_defer array
    foreach($scripts_to_defer as $current_script){
        if(true == strpos($tag, $current_script))
            return str_replace(' src', ' defer="defer" src', $tag);
    }

    # add the async tags to scripts_to_async array
    foreach($scripts_to_async as $current_script){
        if(true == strpos($tag, $current_script))
            return str_replace(' src', ' async="async" src', $tag);
    }

    return $tag;
}
