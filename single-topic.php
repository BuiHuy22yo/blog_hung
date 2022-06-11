<?php

if (!defined('ABSPATH')) {
    return;
}

get_header();
get_template_part('template-parts/components/banner');
get_template_part('template-parts/components/breadcrumb');
get_template_part('template-parts/content', 'topic');
get_footer();

?>

