<?php

/**
 * Toggle
 *
 * @package ctwp
 */
 ?>

 <?php
	$toggleStyle = get_field('toggle_style','option') ? get_field('toggle_style','option') : '1';
?>
 <div id="wrapToggle" class="wrapToggle wrapToggle_none">
 	<div id="toggle-menu">
 		<div class="nav-icon" id="nav-icon<?php echo esc_attr( $toggleStyle ); ?>">
 			<?php if ($toggleStyle == '1' || $toggleStyle == '4'): ?>
 				<span></span>
	 			<span></span>
	 			<span></span>
 			<?php endif ?>
 			<?php if ($toggleStyle == '2'): ?>
 				<span></span>
	 			<span></span>
	 			<span></span>
	 			<span></span>
	 			<span></span>
	 			<span></span>
 			<?php endif ?>
 			<?php if ($toggleStyle == '3'): ?>
 				<span></span>
	 			<span></span>
	 			<span></span>
	 			<span></span>
 			<?php endif ?>
 		</div>
 	</div>
 </div>
