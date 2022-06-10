<?php
/**
 * Archive List
 *
 * @package ctwp
 */
?>
<?php
$data = ctwpGetAllToppicByForum();
$topics = !empty($data) && array_key_exists('data', $data) ? $data['data'] : [];
$max_page = !empty($data) && array_key_exists('max_page', $data) ? $data['max_page'] : 0;
$current_page = !empty($data) && array_key_exists('current_page', $data) ? $data['current_page'] : 0;
$forums = ctwpGetAllForum(['title']);
$idForums = ctwpGetForumNew();
$idForums = array_shift($idForums);
echo '<pre>';
print_r(get_avatar_url(1));
echo '</pre>';
?>

<div class="col-3" xmlns="http://www.w3.org/1999/html">
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
    <div class="archive-post-list">
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
                                    <img class="w-100" src="http://localhost:8080/blog_hung/wp-content/uploads/2022/06/peter_morales-wallpaper-1024x1024-1.jpg"
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
                                    <img class="w-100" src="http://localhost:8080/blog_hung/wp-content/uploads/2022/06/peter_morales-wallpaper-1024x1024-1.jpg"
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

    <!--//        if (!is_home() && !is_front_page()) { ?>-->
    <!--            <div class="dev_pagination">-->
    <!--                --><?php //if ($max_page > 1) { ?>
    <!--                    <ul class="pagination-nav d-flex justify-content-end">-->
    <!--                        <li class="page-item -->
    <?php //echo $class = $data_page == 1 ? 'disabled' : '' ?><!--">-->
    <!--                            <a class="page-link"-->
    <!--                               href="?paged=-->
    <?php //echo $pre_page = $data_page > 1 ? $data_page - 1 : '' ?><!--">-->
    <!--                                <i class="fa fa-angle-left"></i>-->
    <!--                            </a>-->
    <!--                        </li>-->
    <!--                        --><?php //for ($i = 1; $i <= $max_page; $i++) { ?>
    <!--                            <li class="page-item -->
    <?php //echo $class = $data_page == $i ? 'active' : '' ?><!--"><a-->
    <!--                                    class="page-link" href="?paged=--><?php //echo $i ?><!--">-->
    <?php //echo $i ?><!--</a></li>-->
    <!--                        --><?php //} ?>
    <!--                        <li class="page-item -->
    <?php //echo $class = $data_page == $max_page ? 'disabled' : '' ?><!--">-->
    <!--                            <a class="page-link"-->
    <!--                               href="?paged=-->
    <?php //echo $next_page = $data_page < $max_page ? $data_page + 1 : '' ?><!--"><i-->
    <!--                                    class="fa fa-angle-right"></i>-->
    <!--                            </a>-->
    <!--                        </li>-->
    <!--                    </ul>-->
    <!--                --><?php //} ?>
    <!--            </div>-->
    <!--        --><?php //}
    //    }
    //?>


</div>

