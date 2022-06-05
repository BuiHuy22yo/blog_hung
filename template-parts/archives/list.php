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
?>

<div class="col-3">
    <div class="list-forum">
        <?php if ($forums) { ?>
            <?php
            foreach ($forums as $id => $forum) { ?>
                <div class="item-wrap">
                    <input type="checkbox" id="checkmate-<?php echo $id ?>" name="checkmate">
                    <label for="checkmate-<?php echo $id ?>"> <?php echo $forum ?></label><br>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>
<div class="col-9">
    <div class="archive-post-list">
        <?php if ($topics) { ?>
            <article <?php post_class('post-post '); ?>>
                <?php foreach ($topics as $topic) { ?>
                    <div class="col-inner">
                        <div class="inner-item">
                            <div class="topic-title">
                                <a class="link-title" href="<?php echo get_the_permalink($topic->ID) ?>">
                                    <?php echo get_the_title($topic->ID) ?>
                                </a>
                            </div>
                            <div class="topic-date"><?php echo get_the_date('d/m/Y', $topic->ID)?></div>
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

