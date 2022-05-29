<?php

/**
 * Nav
 *
 * @package ctwp
 */
if (!function_exists('ctwp_menu_nav')) {
	function ctwp_menu_nav($menu_id, $class = '')
	{
		$menu_class = \CTWP_Theme\Inc\Menus::get_instance();
		$header_menu_id = $menu_class->get_menu_id($menu_id);
		$header_menus = wp_get_nav_menu_items($header_menu_id);

		if (!empty($header_menus) && is_array($header_menus)) { ?>
			<nav id="wrapMenuMobile" class="<?php echo $class; ?>">
				<ul class="menu">
					<?php
					foreach ($header_menus as $menu_item) {
						if (!$menu_item->menu_item_parent) {

							$child_menu_items = $menu_class->get_child_menu_items($header_menus, $menu_item->ID);
							$has_children = !empty($child_menu_items) && is_array($child_menu_items);
							$has_sub_menu_class = !empty($has_children) ? 'has-submenu' : '';
							if (is_user_logged_in()) {
								if (isset($menu_item->classes) && !empty($menu_item->classes)) {
									if (in_array('check-login', (array)$menu_item->classes)) {
										$menu_item->title = esc_html('Account', 'theme-ikou');
									}
								}
							}
							$str = implode(" ", $menu_item->classes);
							global $post;
							$thePostID = $post->ID;
							$class_active = '';
							if ($thePostID == $menu_item->object_id) {
								$class_active = 'nav-item-active';
							}

							if (!$has_children) {
								?>
								<li class="nav-item <?php echo $class_active;
								echo isset($str) ? $str : ''; ?>">
									<a class="nav-link" href="<?php echo esc_url($menu_item->url); ?>">
										<?php echo esc_html($menu_item->title); ?>
									</a>
								</li>
								<?php
							} else {
								?>
								<li class="nav-item lv-1 dropdown">
									<a class="nav-link dropdown-toggle" href="<?php echo esc_url($menu_item->url); ?>">
										<?php echo esc_html($menu_item->title); ?>
										<span class="arrow next">next</span>
									</a>
									<ul class="dropdown-menu" style="opacity: 0;visibility: hidden;">
										<?php
										foreach ($child_menu_items as $child_menu_item) {
											$child_menu_items_last = $menu_class->get_child_menu_items($header_menus, $child_menu_item->ID);
											$has_children_last = !empty($child_menu_items_last) && is_array($child_menu_items_last);
											$has_sub_menu_class_last = !empty($has_children_last) ? 'has-submenu' : '';
											if (!$has_children_last) { ?>
												<li class="nav-item">
													<a class="nav-link"
													   href="<?php echo esc_url($child_menu_item->url); ?>">
														<?php echo esc_html($child_menu_item->title); ?>
													</a>
												</li>
											<?php } else { ?>
												<li class="nav-item lv-2 dropdown">
													<a class="nav-link dropdown-toggle"
													   href="<?php echo esc_url($child_menu_item->url); ?>">
														<?php echo esc_html($child_menu_item->title); ?>
														<span class="arrow next">next</span>
													</a>
													<ul class="dropdown-menu" style="opacity: 0;visibility: hidden;">
														<?php
														foreach ($child_menu_items_last as $child_menu_item_last) { ?>
															<li class="nav-item lv-3 dropdown">
																<a class="nav-link"
																   href="<?php echo esc_url($child_menu_item_last->url); ?>">
																	<?php echo esc_html($child_menu_item_last->title); ?>
																</a>
															</li>
															<?php
														}
														?>
													</ul>
												</li>
											<?php }
										}
										?>
									</ul>
								</li>
								<?php
							}
							?>
							<?php
						}
					}
					?>
				</ul>
			</nav>
		<?php }
	}
} ?>
