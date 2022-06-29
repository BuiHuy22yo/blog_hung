<?php
if (!function_exists('ctwpGetRecentTopic_html')) {
    function ctwpGetRecentTopic_html($id)
    {
        $data = ctwpGetRecentTopic($id);
        $topics = !empty($data) && array_key_exists('data', $data) ? $data['data'] : [];
        foreach ($topics as $topic) {
            ?>
            <div class="d-flex py-2">
                <div class="author-image ctwp-mw-40 mx-2">
                    <img class="w-100" src="<?php echo ctwpGetAvatarUser('avatar', $topic->post_author)?>" alt="">
                </div>
                <div class="topic-info flex-grow-1">
                    <div class="topic-title">
                        <a class="link-title" href="<?php echo get_the_permalink($topic->ID) ?>">
                            <span class="text-title"><?php echo get_the_title($topic->ID) ?></span>
                        </a>
                    </div>
                    <div class="topic-info-inner T16M_56 d-flex justify-content-end">
                        <div class="topic-author-name me-2"><?php echo get_the_author_meta('display_name', $topic->post_author); ?>
                            <span>posted</span></div>
                        <div class="topic-create-date"><?php echo get_the_date('d/m/Y', $topic->ID) ?></div>
                    </div>
                </div>
            </div>
        <?php }
    }
}
