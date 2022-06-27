<?php
if (!function_exists('ctwpGetAddComment_html')) {
    function ctwpGetAddComment_html($id_topic = '', $id_reply = '')
    {
        $html = '';
        if (!$id_topic) {
            return $html;
        }
        $post_author = get_post_field('post_author', $id_topic);
        $is_login = ctwpIsLogin();
        $add_class = $is_login ? 'add-comment' : 'is-logout';


        $html .= '<div class="user-avatar ctwp-mw-40 me-2">';
        $html .= '<img class="rounded-circle w-100 " src="' . get_avatar_url($post_author) . '" alt="">';
        $html .= '</div>';
        $html .= '<div class="content-comment w-100 input-inner d-flex align-items-center">';
        $html .= '<input type="text" id="content" class="input-item w-100 me-2" placeholder="Write a comment...">';
        $html .= '<input type="hidden" id="id_user" value="' . ctwpGetCurrentUserId() . '">';
        $html .= '<input type="hidden" id="id_topic" value="' . $id_topic . '">';
        $html .= '<div class="button ' . $add_class . ' ctwp-mw-40 ctwp-width-40 text-center bg-primary text-white rounded-circle py-2">';
        $html .= '<i class="fa-solid fa-location-arrow rotate-45"></i>';
        $html .= '<input type="hidden" id="id_reply" value="' . $id_reply . '">';
        $html .= '</div>';
        $html .= ' </div>';
        return $html;
    }
}
