<?php
/**
 * Archive List
 *
 * @package ctwp
 */
?>
<?php
$data = ctwpGetAllTopicByForum();
$topics = !empty($data) && array_key_exists('data', $data) ? $data['data'] : [];
$total = !empty($data) && array_key_exists('total', $data) ? $data['total'] : '';
$max_page = !empty($data) && array_key_exists('max_page', $data) ? $data['max_page'] : '';
$current_page = !empty($data) && array_key_exists('current_page', $data) ? $data['current_page'] : 0;
$posts_per_page = !empty($data) && array_key_exists('posts_per_page', $data) ? $data['posts_per_page'] : 10;
$forums = ctwpGetAllForum(['title']);
$idForums = ctwpGetForumNew();
$idForums = array_shift($idForums);

?>

<div class="col-3" >
    <div class="list-forum pt-2">
        <?php if ($forums) { ?>
            <?php
            foreach ($forums as $id => $forum) {?>
                <div class="item-wrap pt-2">
                    <input type="checkbox" id="checkmate-<?php echo $id ?>" name="checkmate" value="<?php echo $id?>" <?php  echo $idForums == $id ? 'checked' : ''; ?> >
                    <label for="checkmate-<?php echo $id ?>"> <?php echo $forum ?></label><br>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>
<div class="col-9">
    <div class="archive-post">
        <div class="archive-post-inner archive-post-pagination">
            <?php echo ctwpGetPagination_html($total, $max_page, $current_page, $posts_per_page) ?>
        </div>
        <div class="archive-post-inner archive-post-list">
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
                                    <div class="author-image ctwp-mw-40">
                                        <img class="w-100"
                                             src="<?php echo ctwpGetAvatarUser('avatar', $topic->post_author) ?>"
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
                </article>
                <?php
            } ?>
        </div>
        <div class="archive-post-inner archive-post-pagination">
            <?php echo ctwpGetPagination_html($total, $max_page, $current_page, $posts_per_page) ?>
        </div>
    </div>
</div>

