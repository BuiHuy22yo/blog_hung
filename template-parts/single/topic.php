<?php

$idTopic = get_the_id();
$post_author = get_post_field('post_author', $idTopic);
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
                <div class="topic-description mt-2"><?php echo get_the_content($idTopic) ?></div>
                <div class="topic-action d-flex mt-1">
                    <div class="button-like me-4"><i class="fa-regular fa-thumbs-up me-2 color-primary-icon"></i>Like</div>
                    <div class="button-share me-4"><i class="fa-solid fa-share-nodes me-2 color-primary-icon"></i>Share</div>
                    <div class="button-comment"><i class="fa-regular fa-comment me-2 color-primary-icon"></i>Comment</div>
                </div>
            </div>
        </div>
        <div class="topic-comment">
            <div class="topic-image ctwp-mw-50 mx-2">
                <!--                <img class="w-100" src="-->
                <?php //echo get_avatar_url($post_author) ?><!--" alt="">-->
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

