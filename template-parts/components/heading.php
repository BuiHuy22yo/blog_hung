<?php

/**
 * Components/Heading
 *
 * @package ctwp
 */
    $title       = get_sub_field('title');
    $tag        = get_sub_field('tag');
    $textAlign  = get_sub_field('text_align');

    ctwp_heading($tag, $title, $textAlign);
?>
