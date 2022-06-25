<?php

$idTopic = get_the_id();
$post_author = get_post_field('post_author', $idTopic);
$is_login = ctwpIsLogin();
$id_forum = ctwpGetForumByTopicId($idTopic);
?>
<div class="col-9">
    <div class="single-detait">

        <div class="topic-detail">
            <div class="topic-info">
                <div class="topic-title">
                    <a class="link-title" href="<?php echo get_the_permalink($idTopic) ?>">
                        <span class="text-title"><?php echo get_the_title($idTopic) ?></span>
                    </a>
                </div>
                <div class="topic-info-inner T16M_56 d-flex ">
                    <div class="topic-author-name me-2">
                        <span>Author: </span><?php echo get_the_author_meta('display_name', $post_author); ?></span>
                    </div>
                    <div class="topic-create-date">
                        <span>Create at: </span><?php echo get_the_date('H:i d/m/Y', $idTopic) ?>
                    </div>
                </div>
                <div class="topic-description py-2"><?php echo get_the_content($idTopic) ?></div>
                <div class="topic-display d-flex py-1">
                    <div class="shows-like me-4 me-auto"><i class="fa-solid fa-thumbs-up me-2 p-1 color-primary-icon rounded-circle bg-primary text-white"></i>5</div>
                    <div class="shows-share me-4">10 Shares</div>
                    <div class="shows-comment">20 Comments</div>
                </div>
                <div class="topic-action d-flex py-1 my-1 justify-content-around border-b border-t border-color-white">
                    <div class="button button-like ctwp-minwidth-180 text-center py-2 me-4"><i class="fa-regular fa-thumbs-up me-2 color-primary-icon"></i>Like</div>
                    <div class="button button-share ctwp-minwidth-180 text-center py-2 me-4"><i class="fa-solid fa-share-nodes me-2 color-primary-icon"></i>Share</div>
                    <div class="button button-comment ctwp-minwidth-180 text-center py-2"><i class="fa-regular fa-comment me-2 color-primary-icon"></i>Comment</div>
                </div>
            </div>
        </div>
        <div class="topic-comment d-flex align-items-center py-2">
            <div class="topic-image ctwp-mw-40 me-2">
                <img class="rounded-circle w-100 " src="<?php echo get_avatar_url($post_author) ?>" alt="">
            </div>
            <div class="content-comment w-100 input-inner d-flex align-items-center">
                <input type="text" id="content" id_user="<?php ?>" class="input-item w-100 me-2" placeholder="Write a comment..." value="1234567890">
                <input type="hidden" id="id_user" value="<?php echo ctwpGetCurrentUserId() ?>">
                <input type="hidden" id="id_topic" value="<?php echo $idTopic ?>">
                <div class="button <?php echo $is_login ? 'add-comment' : 'is-logout'?> ctwp-mw-40 ctwp-width-40 text-center bg-primary text-white rounded-circle py-2">
                    <i class="fa-solid fa-location-arrow rotate-45"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-3">
    <div class="inner ">
        <div class="text-capitalize text-center py-2">recent topic</div>
        <?php ctwpGetRecentTopic_html($idTopic) ?>
    </div>
</div>

