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
    function ctwpGetAvatarUser($key ,$author_id = '')
    {
        $url = '';
        if(!$key || !$author_id){
            return $url;
        }
        $avatar_id = get_field($key, 'user_'. $author_id );
        $url = $avatar_id ? wp_get_attachment_url($avatar_id) : "";
        return $url;

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
                                        <div class="topic-author-name">
                                            <span>Author: </span><?php echo get_the_author_meta('display_name', $topic->post_author); ?></span>
                                        </div>
                                        <div class="topic-create-date">
                                            <span>Create at: </span><?php echo get_the_date('d/m/Y', $topic->ID) ?>
                                        </div>
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

    add_action('wp_ajax_ctwp_ajax_get_topic_by_forum', 'ctwp_ajax_get_topic_by_forum');
    add_action('wp_ajax_nopriv_ctwp_ajax_get_topic_by_forum', 'ctwp_ajax_get_topic_by_forum');
}

if (!function_exists('ctwp_ajax_create_comment')) {
    function ctwp_ajax_create_comment()
    {
        try {
            if (!$_POST) {
                return false;
            }
            $id_user = $_POST['id'];
            $content = $_POST['content'];
            $id_topic = $_POST['id_topic'];
            $reply_to = $_POST['id_reply'] ? $_POST['id_reply'] : '';
            if (!$id_user || !$content || !$id_topic) {
                return false;
            }
            $title_reply = get_the_title($id_topic) ? get_the_title($id_topic) : '';
            $ars = [
                'post_type' => 'reply',
                'post_status' => 'publish',
                'post_title' => 'Reply_' . $title_reply,
                'post_content' => $content,
                'post_author' => $id_user,
                'post_parent' => $id_topic,
            ];
            $id = wp_insert_post($ars);
            $id_forum = ctwpGetForumByTopicId($id_topic);
            add_post_meta($id, '_bbp_forum_id', $id_forum);
            add_post_meta($id, '_bbp_topic_id', $id_topic);
            add_post_meta($id, '_bbp_author_ip', $id_user);
            if (!empty($reply_to)) {
                add_post_meta($id, '_bbp_reply_to', $reply_to);
            }

            echo json_encode(1);
            exit;
        } catch (Exception $e) {
            echo json_encode(0);
            exit;
        }
    }

    add_action('wp_ajax_ctwp_ajax_create_comment', 'ctwp_ajax_create_comment');
    add_action('wp_ajax_nopriv_ctwp_ajax_create_comment', 'ctwp_ajax_create_comment');
}

if (!function_exists('ctwp_ajax_Load_comment')) {
    function ctwp_ajax_Load_comment()
    {
        try {
            if (!$_POST) {
                echo '';
                exit;
            }
            $id_topic = $_POST['id_topic'];
            if (!$id_topic) {
                echo '';
                exit;
            }

            $data = ctwpGetComment($id_topic);
            $comments = !empty($data) && array_key_exists('data', $data) ? $data['data'] : [];
            if (!$comments) {
                echo '';
                exit;
            }

            foreach ($comments as $comment) {
                $post_author = get_post_field('post_author', $comment->post_author);
                $id = $comment->ID;
                ?>
                <div id="<?php echo $id ?>" class="inner-item d-flex py-2">
                    <div class="user-avatar ctwp-mw-40 me-2">
                        <img class="rounded-circle w-100 " src="<?php echo ctwpGetAvatarUser('avatar', $post_author)?>" alt="">
                    </div>
                    <div class="item-content-comment w-100">
                        <p class="input-item w-100"><?php echo $comment->post_content ?></p>
                        <div class="topic-action d-flex m-1 ">
                            <div class="button button-like px-2">like</div>
                            <div class="button button-reply px-2">reply</div>
                            <div class="button button-share px-2">share</div>
                            <div class="time-comment px-2">1h</div>
                        </div>
                        <?php
                        if ($replies = $comment->comment_child) {
                            foreach ($replies as $reply) {
                                $post_author = get_post_field('post_author', $reply->post_author);
                                $id = $reply->ID;
                                ?>
                                <div id="<?php echo $id ?>" class="inner-item-replies d-flex py-2">
                                    <div class="user-avatar ctwp-mw-40 me-2">
                                        <img class="rounded-circle w-100 "
                                             src="<?php echo ctwpGetAvatarUser('avatar', $post_author)?>" alt="">
                                    </div>
                                    <div class="item-content-comment w-100">
                                        <p class="input-item w-100"><?php echo $reply->post_content ?></p>
                                        <div class="topic-action d-flex m-1 ">
                                            <div class="button button-like px-2">like</div>
                                            <!--                                            <div class="button button-reply px-2">reply</div>-->
                                            <div class="button button-share px-2">share</div>
                                            <div class="time-comment px-2">1h</div>
                                        </div>
                                        <!--                                        <div class="topic-add-comment d-none align-items-center py-2 ">-->
                                        <!--                                            --><?php //echo ctwpGetAddComment_html($id_topic, $id) ?>
                                        <!--                                        </div>-->
                                    </div>
                                </div>

                            <?php }
                        } ?>
                        <div class="topic-add-comment d-none align-items-center py-2 ">
                            <?php echo ctwpGetAddComment_html($id_topic, $id) ?>
                        </div>
                    </div>
                </div>

            <?php }
            die();

        } catch (Exception $e) {
            echo json_encode(0);
            exit;
        }
    }

    add_action('wp_ajax_ctwp_ajax_Load_comment', 'ctwp_ajax_Load_comment');
    add_action('wp_ajax_nopriv_ctwp_ajax_Load_comment', 'ctwp_ajax_Load_comment');
}



//

if (!function_exists('ctwpGetPagination_html')) {
    function ctwpGetPagination_html($next_page = '')
    {
        $html = '';
//        if (!$current_page) {
//            echo '';
//            exit();
//        }
//        $posts_per_page = !empty($limit) ? $limit : 10;
        $next_page = !empty($next_page) ? $next_page : 1;
        $data = ctwpGetAllTopicByForum();
        if (!$data) {
            echo '';
            exit();
        }
        $posts = array_key_exists('data', $data) ? $data['data'] : [];
        $total = array_key_exists('total', $data) ? $data['total'] : '';
        $max_page = array_key_exists('max_page', $data) ? $data['max_page'] : '';
        $current_page = array_key_exists('current_page', $data) ? $data['current_page'] : 1;
        $posts_per_page = array_key_exists('posts_per_page', $data) ? $data['posts_per_page'] : '';

        if (!$posts || !$total || !$max_page || !$current_page || !$posts_per_page) {
            echo '';
            exit();
        }
        $disable_prev = $current_page == 1 ? 'disable' : '';
        $disable_next = $current_page == $max_page ? 'disable' : '';
        if ($total && $posts_per_page && $total > $posts_per_page) {
            $prev = $current_page - 1 != 0 ? $current_page - 1 : '';
            $next = $current_page + 1 != $max_page ? $current_page + 1 : '';
            $html .= ' <div class="pagination d-flex justify-content-center my-4"><ul class="d-flex align-items-center">';
            $html .= '<li class="page-item prev me-1 '.$disable_prev.'">';
            $html .= '<span><svg class="rotate-180" xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none"><circle cx="14.5" cy="14.5" r="14" transform="rotate(-180 14.5 14.5)" stroke="black"/><path d="M12 22L19.0711 14.9289L12 7.85786" stroke="black" stroke-linecap="round" stroke-linejoin="round"/></svg></span>';
            $html .= '<input type="hidden" id="next_page" value="'.$prev.'"></li>';
            $html .= '</li>';
            $last_page_flag = 0;
            $next_page_flag = 0;
            for ($page = 1; $page <= $max_page; $page++) {

                if ($page != $max_page && $page > $current_page + 2) {
                    $last_page_flag = $page == $max_page - 1 ? 1 : 0;
                    $page_disable = ' page-item-number-disable';
                } else if ($page != 1 && $page < $current_page - 2) {
                    $next_page_flag = $page == 2 ? 1 : 0;
                    $page_disable = ' page-item-number-disable';
                } else {
                    $last_page_flag = 0;
                    $next_page_flag = 0;
                    $page_disable = '';
                }

                $page_active = $current_page == $page ? ' page-item-active' : '';
                if ($next_page_flag === 1) {
                    $html .= '<li class="page-item-dots"><span class="page-numbers dots">…</span></li>';
                }
                if ($last_page_flag === 1) {
                    $html .= '<li class="page-item-dots"><span class="page-numbers dots ">…</span></li>';
                }
                $html .= '<li class="page-item page-item-number p-1 mx-1'.$page_disable.' '.$page_active .'"><span>'.$page .'</span><input type="hidden" id="next_page" value="'.$page .'"></li>';

            }
            $html .= '<li class="page-item next ms-1 '.$disable_next.'">';
            $html .= '<span><svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none"><circle cx="14.5" cy="14.5" r="14" transform="rotate(-180 14.5 14.5)"stroke="black"/><path d="M12 22L19.0711 14.9289L12 7.85786" stroke="black" stroke-linecap="round"stroke-linejoin="round"/></svg></span>';
            $html .= '<input type="hidden" id="next_page" value="'.$next.'"></li>';
            $html .= '</li>';
            $html .= '<input type="hidden" id="current_page" value="'.$current_page.'">';
            $html .= '</ul></div>';
        }

        $html .= '</div>';
        return $html;
    }
}

if (!function_exists('ctwp_ajax_archive_pagination')) {
    function ctwp_ajax_archive_pagination()
    {
        try {
            if (!$_POST) {
                echo '';
                exit;
            }
            $limit = $_POST['limit'];
            $current_page = $_POST['current_page'];
            if (!$current_page || !$limit) {
                echo '';
                exit;
            }
            ctwpGetArchivePagination_html($limit, $current_page);
            die();

        } catch (Exception $e) {
            echo '';
            exit;
        }
    }

    add_action('wp_ajax_ctwp_ajax_archive_pagination', 'ctwp_ajax_archive_pagination');
    add_action('wp_ajax_nopriv_ctwp_ajax_archive_pagination', 'ctwp_ajax_archive_pagination');
}
