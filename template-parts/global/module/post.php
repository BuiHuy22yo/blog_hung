<?php
if (!function_exists('ctwpGetAllTopicByForum_html')) {
    function ctwpGetAllTopicByForum_html($topics = [])
    {
        $html = '';
        if (!$topics) {
            return $html;
        }
        foreach ($topics as $topic) {
            $html .= '<div class="col-inner inner-body border-b border-color-white py-2">';
            $html .= '<div class="inner-item row ">';
            $html .= '<div class="col-9 topic d-flex">';
            $html .= '<div class="topic-image ctwp-mw-50 mx-2">';
            $html .= '<img class="w-100" src="' . ctwpGetAvatarUser('avatar', $topic->post_author) . '" alt="">';
            $html .= '</div>';
            $html .= '<div class="topic-info flex-grow-1">';
            $html .= '<div class="topic-title">';
            $html .= '<a class="link-title" href="' . get_the_permalink($topic->ID) . '">';
            $html .= '<span class="text-title">' . get_the_title($topic->ID) . '</span>';
            $html .= '</a>';
            $html .= '</div>';
            $html .= '<div class="topic-info-inner d-flex">';
            $html .= '<div class="topic-author-name me-2">';
            $html .= '<span>Author: </span>' . get_the_author_meta('display_name', $topic->post_author) . '</span>';
            $html .= '</div>';
            $html .= '<div class="topic-create-date">';
            $html .= '<span>Create at: </span>' . get_the_date('d/m/Y', $topic->ID);
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="cmt">';
            $html .= '<i class="fa-regular fa-comment"></i>';
            $html .= '<span class="count"> ' . ctwpGetTotalComment($topic->ID) . '</span>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="col-3 author-reply d-flex">';
            if(ctwpGetTotalComment($topic->ID) > 0) {
                $topicNewComment = ctwpGetCommentNew($topic->ID);
                $html .= '<div class="author-image ctwp-mw-40">';
                $html .= '<img class="w-100"src="' . ctwpGetAvatarUser('avatar', $topicNewComment->post_author) . '"alt="">';
                $html .= '</div>';
                $html .= '<div class="author-info px-2">';
                $html .= '<div class="author-name">'.get_the_author_meta('display_name', $topicNewComment->post_author).'</div>';
                $html .= '<div class="author-date">'.get_the_date('d/m/Y', $topicNewComment->ID).'</div>';
                $html .= '</div>';
            }
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }
        return $html;
    }
}
