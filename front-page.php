<?php
get_header();

if( class_exists('ACF') ) :
?>

<?php if( have_rows('builder_componets') ): ?>
    <?php while( have_rows('builder_componets') ): the_row(); ?>
        <?php if( get_row_layout() == 'slider' ): ?>
            <?php get_template_part('template-parts/components/slider'); ?>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>

<?php
	endif;
	get_footer()
 ?>
