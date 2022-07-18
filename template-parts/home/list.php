<?php
/**
 * Home List
 *
 * @package ctwp
 */
?>
<?php
$user_id = ctwpGetCurrentUserId();
$data = ctwpGetAllTopicByForum(array(),1,$user_id);
$topics = !empty($data) && array_key_exists('data', $data) ? $data['data'] : [];
$total = !empty($data) && array_key_exists('total', $data) ? $data['total'] : '';
$max_page = !empty($data) && array_key_exists('max_page', $data) ? $data['max_page'] : '';
$current_page = !empty($data) && array_key_exists('current_page', $data) ? $data['current_page'] : 0;
$posts_per_page = !empty($data) && array_key_exists('posts_per_page', $data) ? $data['posts_per_page'] : 10;
$forums = ctwpGetAllForum(['title']);
$idForums = ctwpGetForumNew();
$idForums = array_shift($idForums);

?>

    <div class="admin-post">
        <div class="admin-post-inner admin-post-list">
            <?php if ($topics) { ?>
                <article <?php post_class('post-forum-topic border border-color-white'); ?>>
                    <div class="col-inner inner-head border-b border-color-white py-2">
                        <div class="inner-item row ">
                            <div class="col-9 topic-title text-center">Topics</div>
                            <div class="col-3 topic-reply text-center">Last reply</div>
                        </div>
                    </div>
                    <?php foreach ($topics as $topic) { ?>
                        <div class="col-inner inner-body border-b border-color-white py-2">
                            <div class="inner-item row ">
                                <div class="col-9 topic d-flex">
                                    <div class="topic-image ctwp-mw-50 mx-2">
                                        <img class="w-100"
                                             src="<?php echo ctwpGetAvatarUser('avatar', $topic->post_author) ?>"
                                             alt="">
                                    </div>
                                    <div class="topic-info flex-grow-1">
                                        <div class="topic-title">
                                            <a class="link-title" href="<?php echo get_the_permalink($topic->ID) ?>">
                                                <span class="text-title"><?php echo get_the_title($topic->ID) ?></span>
                                            </a>
                                        </div>
                                        <div class="topic-info-inner d-flex">
                                            <div class="topic-author-name me-2">
                                                <span>Author: </span><?php echo get_the_author_meta('display_name', $topic->post_author); ?></span>
                                            </div>
                                            <div class="topic-create-date">
                                                <span>Create at: </span><?php echo get_the_date('d/m/Y', $topic->ID) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cmt">
                                        <i class="fa-regular fa-comment"></i>
                                        <span class="count"><?php echo ctwpGetTotalComment($topic->ID) ?></span>
                                    </div>
                                </div>
                                <div class="col-3 author-reply d-flex">
                                    <?php if(ctwpGetTotalComment($topic->ID) > 0) {
                                        $topicNewComment =  ctwpGetCommentNew($topic->ID);
                                        ?>
                                        <div class="author-image ctwp-mw-40">
                                            <img class="w-100"
                                                 src="<?php echo ctwpGetAvatarUser('avatar', $topicNewComment->post_author) ?>"
                                                 alt="">
                                        </div>
                                        <div class="author-info px-2">
                                            <div class="author-name"><?php echo get_the_author_meta('display_name', $topicNewComment->post_author); ?></div>
                                            <div class="author-date"><?php echo get_the_date('d/m/Y', $topicNewComment->ID)?></div>
                                        </div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </article>
                <?php
            } ?>
        </div>
        <div class="post-pagination admin-post-inner admin-post-pagination">
            <?php echo ctwpGetPagination_html($total, $max_page, $current_page, $posts_per_page) ?>
        </div>
    </div>

