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
    function ctwpGetAllTopicByForum($forumId = array(), $current_page = 1)
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

if (!function_exists('ctwp_ajax_get_topic_by_forum')) {
    function ctwp_ajax_get_topic_by_forum()
    {
        if ($_POST) {
            $id = $_POST['id'];
            $page = $_POST['page'];
            if ($id && $page) {
                $data = ctwpGetAllTopicByForum(array($id), $page);
            }
        }
        if ($data) {
            $topics = !empty($data) && array_key_exists('data', $data) ? $data['data'] : [];
            if ($topics) { ?>
                <?php foreach ($topics as $topic) { ?>
                    <div class="col-inner inner-body border-b border-color-white py-2">
                        <div class="inner-item row ">
                            <div class="col-9 topic d-flex">
                                <div class="topic-image ctwp-mw-50 mx-2">
                                    <img class="w-100"
                                         src="http://localhost:8080/blog_hung/wp-content/uploads/2022/06/peter_morales-wallpaper-1024x1024-1.jpg"
                                         alt="">
                                </div>
                                <div class="topic-info flex-grow-1">
                                    <div class="topic-title">
                                        <a class="link-title" href="<?php echo get_the_permalink($topic->ID) ?>">
                                            <span class="text-title"><?php echo get_the_title($topic->ID) ?></span>
                                        </a>
                                    </div>
                                    <div class="topic-info-inner d-flex">
                                        <div class="topic-author-name"><span>Author: </span><?php echo get_the_author_meta('display_name', $topic->post_author);?></span></div>
                                        <div class="topic-create-date"><span>Create at: </span><?php echo get_the_date('d/m/Y', $topic->ID) ?></div>
                                    </div>
                                </div>
                                <div class="cmt">
                                    <i class="fa-solid fa-comments"></i>
                                    <span class="count">5</span>
                                </div>
                            </div>
                            <div class="col-3 author-reply d-flex">
                                <div class="author-image ctwp-mw-40">
                                    <img class="w-100"
                                         src="http://localhost:8080/blog_hung/wp-content/uploads/2022/06/peter_morales-wallpaper-1024x1024-1.jpg"
                                         alt="">
                                </div>
                                <div class="author-info px-2">
                                    <div class="author-name">mcnb02</div>
                                    <div class="author-date">01/01/2020</div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php }
            die();
        }
    }
}
add_action('wp_ajax_ctwp_ajax_get_topic_by_forum', 'ctwp_ajax_get_topic_by_forum');
add_action('wp_ajax_nopriv_ctwp_ajax_get_topic_by_forum', 'ctwp_ajax_get_topic_by_forum');
