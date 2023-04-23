<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <title><?php echo wp_title( '|', true, 'right' ); bloginfo( 'name' ) ?></title>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class( 'scroll' ); ?>>

<?php wp_body_open(); ?>

<div id="site-header">
<?php get_template_part( 'template-parts/site-header', wealthiher_layout_slug() ); ?>
</div>
