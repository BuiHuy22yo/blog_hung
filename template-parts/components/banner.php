<?php
/**
 * Banner
 *
 * @package ctwp
 */
?>
<div class="banner">
    <div class="container">
        <div class="inner">
            <?php
//            if (is_home() || is_front_page()) {
                $banner_image_id = get_field('banner_images', 'option') ? get_field('banner_images', 'option') : '1';
                $banner_image_url = $banner_image_id ? wp_get_attachment_url($banner_image_id) : "#";
                echo ctwp_banner($banner_image_url);
//            }
//            ?>
        </div>
    </div>
</div>
