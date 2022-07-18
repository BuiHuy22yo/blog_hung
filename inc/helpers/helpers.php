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
            'posts_per_page' => -1,
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

if (!function_exists('ctwpGetForumNew')) {
    function ctwpGetForumNew()
    {
        $data = array();
        $args = [
            'post_type' => 'forum',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => 1,
        ];
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) : $query->the_post();
                $data[] = get_the_id();
            endwhile;
            wp_reset_postdata();
        }
        return $data;
    }
}

if (!function_exists('ctwpGetAllTopicByForum')) {
    function ctwpGetAllTopicByForum($forumId = array(), $current_page = 1, $user_id = '')
    {
        $data = array();

        $forumId = !empty($forumId) ? $forumId : ctwpGetForumNew();
        $current_page = !empty($current_page) ? $current_page : 1;
        $posts_per_page = get_option('posts_per_page') ? get_option('posts_per_page') : -1;
        $args = [
            'post_type' => 'topic',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'paged' => $current_page,
            'posts_per_page' => $posts_per_page,
        ];
        if($user_id){
            $args['author'] = $user_id;
        }else {
            $args['post_parent__in'] = $forumId;
        }
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

if (!function_exists('ctwpGetRecentTopic')) {
    function ctwpGetRecentTopic($id = '')
    {
        $data = array();
        if (!$id) {
            return $data;
        }
        $id = array($id);
        $args = [
            'post_type' => 'topic',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'post__not_in' => $id,
            'posts_per_page' => 5,
        ];
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            $data['data'] = $query->posts;
            wp_reset_postdata();
        }
        return $data;
    }
}

if (!function_exists('ctwpIsLogin')) {
    function ctwpIsLogin()
    {
        $id_user = get_current_user_id();
        if (!$id_user) {
            return false;
        }
        return true;
    }
}

if (!function_exists('ctwpGetCurrentUserId')) {
    function ctwpGetCurrentUserId()
    {
        $id_user = get_current_user_id();
        return !empty($id_user) ? $id_user : '';
    }
}

if (!function_exists('ctwpGetForumByTopicId')) {
    function ctwpGetForumByTopicId($id_topic = '')
    {

        $id_forum = wp_get_post_parent_id($id_topic);
        if (!$id_topic) {
            return false;
        }
        return $id_forum;
    }
}

if (!function_exists('ctwpGetCommentChild')) {
    function ctwpGetCommentChild($id_topic = '', $id_parent = '')
    {
        $data = array();
        if (!$id_topic && !$id_parent) {
            return $data;
        }
        $args = [
            'post_type' => 'reply',
            'post_status' => 'publish',
            'post_parent' => $id_topic,
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => -1,
            'meta_key' => '_bbp_reply_to',
            'meta_value' => $id_parent,
            'meta_compare' => '=',
        ];
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            $data = $query->posts;
            wp_reset_postdata();
        }
        return $data;
    }
}

if (!function_exists('ctwpGetComment')) {
    function ctwpGetComment($id_topic = '')
    {
        $data = array();
        if (!$id_topic) {
            return $data;
        }
        $args = [
            'post_type' => 'reply',
            'post_status' => 'publish',
            'post_parent' => $id_topic,
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => -1,

        ];
        $query = new WP_Query($args);
        $item = $data['data'];
        if ($query->have_posts()) {
            foreach ($query->posts as $post) {
                if (empty($post->ID)) {
                    $item[] = '';
                }
                $id = $post->ID;
                $id_parent = get_post_meta($id, '_bbp_reply_to', true);

                if (empty($id_parent)) {
                    $post->comment_child = ctwpGetCommentChild($id_topic, $id) ? ctwpGetCommentChild($id_topic, $id) : [];
                    $item[] = $post;
                }
            }
            $data['data'] = $item;
            wp_reset_postdata();
        }
        return $data;
    }
}

if (!function_exists('ctwpGetTotalComment')) {
    function ctwpGetTotalComment($id_topic = '')
    {
        $total_comment = 0;
        if (!$id_topic) {
            return $total_comment;
        }
        $args = [
            'post_type' => 'reply',
            'post_status' => 'publish',
            'post_parent' => $id_topic,
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => -1,

        ];
        $query = new WP_Query($args);
        $total_comment = $query->found_posts;
        return $total_comment;
    }
}

if (!function_exists('ctwpGetAvatarUser')) {
    function ctwpGetAvatarUser($key, $author_id = '')
    {
        $url = '';
        if (!$key || !$author_id) {
            return $url;
        }
        $avatar_id = get_field($key, 'user_' . $author_id);
        $url = $avatar_id ? wp_get_attachment_url($avatar_id) : "";
        return $url;

    }
}

if (!function_exists('ctwpGetCommentNew')) {
    function ctwpGetCommentNew($id_topic = '')
    {

        $data = array();
        if (!$id_topic) {
            return $data;
        }
        $args = [
            'post_type' => 'reply',
            'post_status' => 'publish',
            'post_parent' => $id_topic,
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => 1,

        ];
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            foreach ($query->posts as $post) {
                $data = $post;
            }

            wp_reset_postdata();
        }
        return $data;
    }
}




//


