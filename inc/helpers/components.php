<?php
/**
* All Components
*
* @package ctwp
*/

if(!function_exists('ctwp_heading')) {
    function ctwp_heading($tag, $title, $textAlign) { ?>
        <div class="heading">
            <div class="heading-inner">
                <<?= esc_attr( $tag ) ?> class="<?= esc_html('text-') . esc_html($textAlign); ?>">
                    <?= esc_html($title); ?>
                </<?= esc_attr( $tag ) ?>>
            </div>
        </div>
    <?php }
}

if(!function_exists('ctwp_description')) {
    function ctwp_description($description, $textAlign) { ?>
        <div class="description">
            <div class="description-inner">
                <p class="<?= esc_html('text-') . esc_html($textAlign); ?>">
                    <?= esc_html($description); ?>
                </p>
            </div>
        </div>
    <?php }
}

if (!function_exists('ctwp_button')) {
	function ctwp_button($text, $link)
	{ ?>
		<div class='button'>
			<a href="<?php echo $link ?>">
				<div class="inner">
            <span class="text">
                <?php echo $text; ?>
            </span>
					<span class="arrow next"></span>
				</div>
			</a>
		</div>
	<?php }
}
