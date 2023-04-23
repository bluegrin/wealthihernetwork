<?php
/**
 * Template Name: Champion Partners
 */

?>
<?php get_header(); ?>
<?php get_template_part( 'template-parts/title' ); ?>
<?php get_template_part( 'template-parts/secondary-nav' ); ?>
<main id="main">
	<?php get_template_part( 'template-parts/loop', 'champion' ); ?>
    <?php the_content(); ?>
</main>
<?php get_footer();