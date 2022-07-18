<?php
if (!function_exists('ctwpGetPagination_html')) {
    function ctwpGetPagination_html($total = '' ,$max_page = '' , $current_page = '', $posts_per_page = '')
    {
        $html = '';
        if (!$total || !$max_page || !$current_page || !$posts_per_page) {
           return $html;
        }
        $disable_prev = $current_page == 1 ? 'disable' : '';
        $disable_next = $current_page == $max_page ? 'disable' : '';
        if ($total && $posts_per_page && $total > $posts_per_page) {
            $prev = $current_page - 1 != 0 ? $current_page - 1 : '';
            $next = $current_page + 1 <= $max_page ? $current_page + 1 : '';
            $html .= ' <div class="pagination d-flex justify-content-center my-4"><ul class="d-flex align-items-center">';
            $html .= '<li class="page-item prev me-1 ' . $disable_prev . '">';
            $html .= '<span><svg class="rotate-180" xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none"><circle cx="14.5" cy="14.5" r="14" transform="rotate(-180 14.5 14.5)" stroke="black"/><path d="M12 22L19.0711 14.9289L12 7.85786" stroke="black" stroke-linecap="round" stroke-linejoin="round"/></svg></span>';
            $html .= '<input type="hidden" id="next_page" value="' . $prev . '"></li>';
            $html .= '</li>';
            $last_page_flag = 0;
            $next_page_flag = 0;
            for ($page = 1; $page <= $max_page; $page++) {

                if ($page != $max_page && $page > $current_page + 2) {
                    $last_page_flag = $page == $max_page - 1 ? 1 : 0;
                    $page_disable = ' page-item-number-disable';
                } else if ($page != 1 && $page < $current_page - 2) {
                    $next_page_flag = $page == 2 ? 1 : 0;
                    $page_disable = ' page-item-number-disable';
                } else {
                    $last_page_flag = 0;
                    $next_page_flag = 0;
                    $page_disable = '';
                }

                $page_active = $current_page == $page ? ' page-item-active' : '';
                if ($next_page_flag === 1) {
                    $html .= '<li class="page-item-dots"><span class="page-numbers dots">…</span></li>';
                }
                if ($last_page_flag === 1) {
                    $html .= '<li class="page-item-dots"><span class="page-numbers dots ">…</span></li>';
                }
                $html .= '<li class="page-item page-item-number p-1 mx-1' . $page_disable . ' ' . $page_active . '"><span>' . $page . '</span><input type="hidden" id="next_page" value="' . $page . '"></li>';

            }
            $html .= '<li class="page-item next ms-1 ' . $disable_next . '">';
            $html .= '<span><svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none"><circle cx="14.5" cy="14.5" r="14" transform="rotate(-180 14.5 14.5)"stroke="black"/><path d="M12 22L19.0711 14.9289L12 7.85786" stroke="black" stroke-linecap="round"stroke-linejoin="round"/></svg></span>';
            $html .= '<input type="hidden" id="next_page" value="' . $next . '"></li>';
            $html .= '</li>';
            $html .= '<input type="hidden" id="current_page" value="' . $current_page . '">';
            $html .= '</ul></div>';
        }

        $html .= '';
        return $html;
    }
}
