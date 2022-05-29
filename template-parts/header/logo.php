<?php

/**
 * Logo
 *
 * @package ctwp
 */
?>

<?php
	$logoDefault = get_field('logo_default','option') ? get_field('logo_default','option'):'';
	$logoOptional = get_field('logo_optional','option');
	$logoMobile = get_field('logo_mobile','option');
?>

<div class="wrapLogo">
	<div class="wrapLogo-inner">
		<?php if ( is_front_page() ): ?>
			<a href="<?php echo esc_url(site_url()) ?>">
				<h1 class="logo">
					<?php if ($logoDefault): ?>
						<img src="<?php echo esc_url( matthewruddy_image_resize(wp_get_attachment_url($logoDefault), 277, 64, false, false)['url'] ) ?>" alt="<?php echo esc_html(bloginfo('title')) ?>">
					<?php endif ?>
				</h1>
			</a>
		<?php else: ?>
			<a href="<?php echo esc_url(site_url()) ?>">
				<div class="logo">
					<?php if ($logoDefault): ?>
						<img src="<?php echo esc_url( matthewruddy_image_resize(wp_get_attachment_url($logoDefault), 277, 64, false, false)['url'] ) ?>" alt="<?php echo esc_html(bloginfo('title')) ?>">
					<?php endif ?>
				</div>
			</a>
		<?php endif; ?>
	</div>
</div>
