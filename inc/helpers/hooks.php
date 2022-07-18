<?php
/**
 * Hooks
 *
 * @package ctwp
 */

if (!function_exists('ctwp_shortcode_login')) {
    function ctwp_shortcode_login($atts)
    {
        $redirect_to = isset($_GET['redirect_to']) && $_GET['redirect_to'] !== '' ? $_GET['redirect_to'] : site_url();
        $username = isset($_GET['username']) && $_GET['username'] !== '' ? $_GET['username'] : '';
        $password = isset($_GET['password']) && $_GET['password'] !== '' ? $_GET['password'] : '';
        ob_start(); ?>
        <div class="Login-gita">
            <div class="title"><?php echo esc_html__('Login account', 'ctwp'); ?></div>
            <form method="post" action="<?php bloginfo('url') ?>/wp-login.php" class="wp_user_form_login">
                <div class="login-form-row login-form-row--wide">
                    <label for="username" class="login-account"><?php echo esc_html__('Username or email', 'ctwp'); ?>
                        <span class="required">*</span></label>
                    <input class="login-input input-text" type="text" name="log" value="" size="20" tabindex="11"
                           placeholder="<?php echo esc_html__('Username or email', 'ctwp') ?>"/>
                    <span class="username_error" style="color:red"><?php echo $username ?></span>
                </div>
                <div class="login-form-row login-form-row--wide">
                    <label for="password" class="login-account"><?php echo esc_html__('Password', 'ctwp'); ?>
                        <span class="required">*</span></label>
                    <input class="login-input input-text" type="password" name="pwd" value="" size="20" id="user_pass"
                           tabindex="12" placeholder="<?php echo esc_html__('Password', 'ctwp') ?>"/>
                    <span class="password_error" style="color:red"><?php echo $password ?></span>
                </div>
                <div class="login_fields">
                    <?php do_action('login_form'); ?>
                    <input type="submit" name="user-submit" value="<?php echo esc_html__('Login', 'ctwp'); ?>"
                           tabindex="14" class="user-submit"/>
                    <input type="hidden" name="redirect_to" value="<?php echo esc_url($redirect_to); ?>"/>
                    <input type="hidden" name="user-cookie" value="1"/>
                </div>
                <div class="has-account">
                    <span><?php echo esc_html__('Do you have an account？', 'ctwp'); ?></span>
                    <a href="<?php echo esc_url(site_url('/register')) ?>"><?php echo esc_html__('register', 'ctwp'); ?></a>
                </div>

            </form>
        </div>
        <?php
        return ob_get_clean();
    }

    add_shortcode('ctwp_shortcode_login', 'ctwp_shortcode_login');
}

if (!function_exists('ctwp_send_welcome_email_to_new_user')) {
    function ctwp_send_welcome_email_to_new_user($user_id)
    {
        $user = get_userdata($user_id);
        $user_email = $user->user_email;
        // for simplicity, lets assume that user has typed their first and last name when they sign up
        $username = get_user_meta($user_id, 'nickname', true);

        // Now we are ready to build our welcome email
        $to = $user_email;
        $subject = "[Gita-Japan] ログインの詳細";
        $body = '
              <p>ユーザー名: ' . $username . ',</p></br>
              <p>システムにログインするには、次のアドレスにアクセスしてください</p>
               <a href="' . site_url('login') . '">' . site_url('login') . '</a>
               
    ';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        if (wp_mail($to, $subject, $body, $headers)) {
            error_log("email has been successfully sent to user whose email is " . $user_email);
        } else {
            error_log("email failed to sent to user whose email is " . $user_email);
        }
    }

    add_action('user_register', 'ctwp_send_welcome_email_to_new_user');
}
/**
 * Hooks ajax
 *
 * @package ctwp
 */

if (!function_exists('ctwp_ajax_get_topic_by_forum')) {
    function ctwp_ajax_get_topic_by_forum()
    {
        try {
            $html = '';
            if (!$_POST) {
                return $html;
            }
            $user_id = ctwpGetCurrentUserId();
            $id = $_POST['id'];
            $page = $_POST['page'];
            if (!$id && !$user_id) {
                return $html;
            }
            $data = ctwpGetAllTopicByForum(array($id), $page,$user_id);
            if (!$data) {
                return $html;
            }
            $topics = !empty($data) && array_key_exists('data', $data) ? $data['data'] : [];
            $html = ctwpGetAllTopicByForum_html($topics);

            $total = array_key_exists('total', $data) ? $data['total'] : '';
            $max_page = array_key_exists('max_page', $data) ? $data['max_page'] : '';
            $current_page = array_key_exists('current_page', $data) ? $data['current_page'] : 1;
            $posts_per_page = array_key_exists('posts_per_page', $data) ? $data['posts_per_page'] : 10;

            $pagination = ctwpGetPagination_html($total, $max_page, $current_page, $posts_per_page);
            echo json_encode(array('data' => $data, 'post' => $html, 'pagination' => $pagination));
            exit();

        } catch (Exception $e) {
            return $html;
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
                        <img class="rounded-circle w-100 " src="<?php echo ctwpGetAvatarUser('avatar', $post_author) ?>"
                             alt="">
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
                                             src="<?php echo ctwpGetAvatarUser('avatar', $post_author) ?>" alt="">
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
