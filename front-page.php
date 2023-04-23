<?php get_header(); ?>
<div class="backdrop"></div>
<div class="hero">
    <p class="hero-heading">A bridge to close the<br>gender wealth gap</p>
    <a href="/membership" class="button button-cta">Learn More</a>
</div>
<?php get_template_part( 'template-parts/title' ); ?>
<?php get_template_part( 'template-parts/secondary-nav' ); ?>
<main id="main">
    <?php the_content(); ?>
</main>
<?php get_footer();