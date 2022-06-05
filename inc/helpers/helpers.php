<?php
/**
 * Helpers
 *
 * @package ctwp
 */

if (!function_exists('ctwpGetAllForum')) {
    function ctwpGetAllForum($key = [])
    {
        $data = array();
        $args = [
            'post_type' => 'forum',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
        ];
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            while ($query->have_posts()) : $query->the_post();
                if (in_array('id', $key)) {
                    $data[] = get_the_id();
                } else if (in_array('title', $key)) {
                    $data[get_the_id()] = get_the_title();
                    $data[get_the_id()] = get_the_title();
                } else {
                    $data = $query->posts;
                }
            endwhile;
            wp_reset_postdata();
        }
        return $data;
    }
}

if (!function_exists('ctwpGetAllToppicByForum')) {
    function ctwpGetAllToppicByForum($forumId = array(), $current_page = 1)
    {
        $data = array();
        $forumId = !empty($forumId) ? $forumId : ctwpGetAllForum(['id']);
        $current_page = !empty($current_page) ? $current_page : 1;
        $posts_per_page = get_option('posts_per_page') ? get_option('posts_per_page') : -1;
        $args = [
            'post_type' => 'topic',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'paged' => $current_page,
            'post_parent__in' => $forumId,
            'posts_per_page' => $posts_per_page,
        ];
        $query = new WP_Query($args);
        $total = $query->found_posts;
        $max_page = $query->max_num_pages;
        if ($query->have_posts()) {
            $data['data'] = $query->posts;
            $data['total'] = $total;
            $data['max_page'] = $max_page;
            $data['current_page'] = $current_page;
            $data['posts_per_page'] = $posts_per_page;
            wp_reset_postdata();
        }
        return $data;
    }
}
