<?php
if (!defined('ABSPATH')) {
    return;
}

/**
 * Generate breadcrumb
 */
if (!function_exists('ctwp_breadcrumb')) {
    function ctwp_breadcrumb()
    {
        $html = '<ul class="ctwp-breadcrumbs d-flex">' . join("", ctwp_get_breadcrumb_items()) . '</ul>';
        return $html;
    }
}

/**
 * Breadcrumb
 * *******************************************************
 */
if (!function_exists('ctwp_get_breadcrumb_items')) {
    function ctwp_get_breadcrumb_items()
    {
        global $wp_query;

        $item = array();
        /* Front page. */
        if (is_front_page()) {
            $item['last'] = esc_html__('Home', 'ctwp');
        }


        /* Link to front page. */
        if (!is_front_page()) {
            $item[] = '<li><a href="' . esc_url(home_url('/')) . '" class="home">' . esc_html__('Home', 'ctwp') . '</a></li>&nbsp/&nbsp</i></i>';
        }

        /* If bbPress is installed and we're on a bbPress page. */
        if (function_exists('is_bbpress') && is_bbpress()) {
            $item = array_merge($item, ctwp_breadcrumb_get_bbpress_items());
        } elseif (is_home()) {
            $home_page = get_post($wp_query->get_queried_object_id());
            $item = array_merge($item, ctwp_breadcrumb_get_parents($home_page->post_parent));
            $item['last'] = get_the_title($home_page->ID);
        } elseif (is_singular()) {
            $post = $wp_query->get_queried_object();
            $post_id = (int)$wp_query->get_queried_object_id();
            $post_type = $post->post_type;

            $post_type_object = get_post_type_object($post_type);
            if ($post_type_object->labels->name == 'Products') $post_type_object->labels->name = esc_html__('Shop', 'ctwp');
            if ('post' === $wp_query->post->post_type) {
                $categories = get_the_category($post_id);
                $item = array_merge($item, ctwp_breadcrumb_get_term_parents($categories[0]->term_id, $categories[0]->taxonomy));
            }

            if ('page' !== $wp_query->post->post_type) {

                /* If there's an archive page, add it. */
                if (function_exists('get_post_type_archive_link') && !empty($post_type_object->has_archive))
                    $item[] = '<li><a href="' . esc_url(get_post_type_archive_link($post_type)) . '" title="' . esc_attr($post_type_object->labels->name) . '">' . $post_type_object->labels->name . '</a></li>&nbsp/&nbsp';

                if (isset($args["singular_{$wp_query->post->post_type}_taxonomy"]) && is_taxonomy_hierarchical($args["singular_{$wp_query->post->post_type}_taxonomy"])) {
                    $terms = wp_get_object_terms($post_id, $args["singular_{$wp_query->post->post_type}_taxonomy"]);
                    $item = array_merge($item, ctwp_breadcrumb_get_term_parents($terms[0], $args["singular_{$wp_query->post->post_type}_taxonomy"]));
                } elseif (isset($args["singular_{$wp_query->post->post_type}_taxonomy"]))
                    $item[] = get_the_term_list($post_id, $args["singular_{$wp_query->post->post_type}_taxonomy"], '', ', ', '');
            }

            if ((is_post_type_hierarchical($wp_query->post->post_type) || 'attachment' === $wp_query->post->post_type) && $parents = ctwp_breadcrumb_get_parents($wp_query->post->post_parent)) {
                $item = array_merge($item, $parents);
            }

            $item['last'] = get_the_title();
        } else if (is_archive()) {
            echo '<pre>';
            echo '</pre>';
            if (is_category() || is_tag() || is_tax()) {

                $term = $wp_query->get_queried_object();

                if ((is_taxonomy_hierarchical($term->taxonomy) && $term->parent) && $parents = ctwp_breadcrumb_get_term_parents($term->parent, $term->taxonomy))
                    $item = array_merge($item, $parents);

                $item['last'] = $term->name;
            } else if (function_exists('is_post_type_archive') && is_post_type_archive()) {
                $post_type_object = get_post_type_object(get_query_var('post_type'));
                if ($post_type_object) {
                    $item['last'] = $post_type_object->labels->name;
                }
            } else if (is_date()) {

                if (is_day())
                    $item['last'] = esc_html__('Archives for ', 'ctwp') . get_the_time('F j, Y');

                elseif (is_month())
                    $item['last'] = esc_html__('Archives for ', 'ctwp') . single_month_title(' ', false);

                elseif (is_year())
                    $item['last'] = esc_html__('Archives for ', 'ctwp') . get_the_time('Y');
            } else if (is_author()) {
                $current_author = $wp_query->get_queried_object();
                $item['last'] = esc_html__('Author: ', 'ctwp') . get_the_author_meta('display_name', $current_author->ID);
            }
        } else if (is_search()) {
            $item['last'] = esc_html__('Search results', 'ctwp');
        } else if (is_404())
            $item['last'] = esc_html__('Page Not Found', 'ctwp');

        if (class_exists('WooCommerce')) {
            if (is_shop()) {
                $item['last'] = esc_html__('Shop', 'ctwp');
            }
        }

        if (isset($item['last'])) {
            $item['last'] = sprintf('<li><span>%s</span></li>', $item['last']);
        }

        return apply_filters('ctwp_framework_filter_breadcrumb_items', $item);
    }
}

if (!function_exists('ctwp_filter_breadcrumb_items')) {
    function ctwp_filter_breadcrumb_items()
    {
        $item = array();
//        $shop_page_id = wc_get_page_id('shop');

//        if (get_option('page_on_front') != $shop_page_id) {
//            $shop_name = $shop_page_id ? get_the_title($shop_page_id) : '';
//            if (!is_shop()) {
//                $item[] = '<li><a href="' . esc_url(get_permalink($shop_page_id)) . '">' . $shop_name . '</a></li>&nbsp/&nbsp';
//            } else {
//                $item['last'] = $shop_name;
//            }
//        }

        if (is_tax('product_cat') || is_tax('product_tag')) {
            $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

        } elseif (is_singular('product')) {
            global $post;
            $terms = wc_get_product_terms($post->ID, 'product_cat', array('orderby' => 'parent', 'order' => 'DESC'));
            if ($terms) {
                $current_term = $terms[0];
            }

        }

        if (!empty($current_term)) {
            if (is_taxonomy_hierarchical($current_term->taxonomy)) {
                $item = array_merge($item, ctwp_breadcrumb_get_term_parents($current_term->parent, $current_term->taxonomy));
            }

            if (is_tax('product_cat') || is_tax('product_tag')) {
                $item['last'] = $current_term->name;
            } else {
                $item[] = '<li><a href="' . esc_url(get_term_link($current_term->term_id, $current_term->taxonomy)) . '">' . $current_term->name . '</a></li>&nbsp/&nbsp';
            }
        }

        if (is_singular('product')) {
            $item['last'] = get_the_title();
        }

        return apply_filters('ctwp_filter_breadcrumb_items', $item);
    }
}

if (!function_exists('ctwp_breadcrumb_get_bbpress_items')) {
    function ctwp_breadcrumb_get_bbpress_items()
    {
        $item = array();
//        $shop_page_id = wc_get_page_id('shop');
//
//        if (get_option('page_on_front') != $shop_page_id) {
//            $shop_name = $shop_page_id ? get_the_title($shop_page_id) : '';
//            if (!is_shop()) {
//                $item[] = '<li><a href="' . esc_url(get_permalink($shop_page_id)) . '">' . $shop_name . '</a></li>&nbsp/&nbsp';
//            } else {
//                $item['last'] = $shop_name;
//            }
//        }

        if (is_tax('product_cat') || is_tax('product_tag')) {
            $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

        } elseif (is_singular('product')) {
            global $post;
            $terms = wc_get_product_terms($post->ID, 'product_cat', array('orderby' => 'parent', 'order' => 'DESC'));
            if ($terms) {
                $current_term = $terms[0];
            }

        }

        if (!empty($current_term)) {
            if (is_taxonomy_hierarchical($current_term->taxonomy)) {
                $item = array_merge($item, ctwp_breadcrumb_get_term_parents($current_term->parent, $current_term->taxonomy));
            }

            if (is_tax('product_cat') || is_tax('product_tag')) {
                $item['last'] = $current_term->name;
            } else {
                $item[] = '<li><a href="' . esc_url(get_term_link($current_term->term_id, $current_term->taxonomy)) . '">' . $current_term->name . '</a></li>&nbsp/&nbsp';
            }
        }

        if (is_singular('product')) {
            $item['last'] = get_the_title();
        }

        return apply_filters('ctwp_filter_breadcrumb_items', $item);
    }
}

if (!function_exists('ctwp_breadcrumb_get_parents')) {
    function ctwp_breadcrumb_get_parents($post_id = '', $separator = '/')
    {
        $parents = array();

        if ($post_id == 0) {
            return $parents;
        }

        while ($post_id) {
            $page = get_post($post_id);
            $parents[] = '<li><a href="' . esc_url(get_permalink($post_id)) . '" title="' . esc_attr(get_the_title($post_id)) . '">' . get_the_title($post_id) . '</a></li>&nbsp/&nbsp';
            $post_id = $page->post_parent;
        }

        if ($parents) {
            $parents = array_reverse($parents);
        }

        return $parents;
    }
}

if (!function_exists('ctwp_breadcrumb_get_term_parents')) {
    function ctwp_breadcrumb_get_term_parents($parent_id = '', $taxonomy = '', $separator = '/')
    {
        $parents = array();

        if (empty($parent_id) || empty($taxonomy)) {
            return $parents;
        }

        while ($parent_id) {
            $parent = get_term($parent_id, $taxonomy);
            $parents[] = '<li><a href="' . esc_url(get_term_link($parent, $taxonomy)) . '" title="' . esc_attr($parent->name) . '">' . $parent->name . '</a></li>&nbsp/&nbsp';
            $parent_id = $parent->parent;
        }

        if ($parents) {
            $parents = array_reverse($parents);
        }

        return $parents;
    }
}
