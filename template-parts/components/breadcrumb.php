<?php
/**
 * Breadcrumb
 *
 * @package ctwp
 */
?>
<div class="breadcrumb">
    <div class="container">
        <div class="inner">
            <?php
            if (!is_home() && !is_front_page()) {
                echo ctwp_breadcrumb();
            }
            ?>
        </div>
    </div>
</div>
