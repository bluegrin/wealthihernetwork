<?php
/**
 * Template Name: Registration Form
 */

$register_sections = array(
    'names' => array(
        'heading' => 'First things First.',
        'description' => 'What would you like us to call you?',
    ),
    'email' => array(
        'heading' => 'Wonderful to meet you %1$s!',
        'description' => 'What is your email address?',
        'heading_merges' => array( 'user_first_name' ),
        'field_labels' => false,
    ),
    'password' => array(
        'heading' => 'Last thing, before the fun stuff',
        'description' => 'Set a password',
        'field_labels' => false,
    ),
    'interests' => array(
        'heading' => 'Thanks %1$s. We\'d like to keep getting to know you!',
        'description' => 'What is your main motivation for wanting to join the WealthiHer network? (tick all the relevant options)',
        'heading_merges' => array( 'user_first_name' ),
        'field_labels' => false,
    ),
    'social' => array(
        'heading' => 'Share your socials.',
    ),
    'company' => array(
        'heading' => 'Where do you come from?',
    ),
    'journey' => array(
        'heading' => 'Great to know!',
        'description' => 'Which option are you interested in?',
    ),
);

$digital_pass_sections = array(
    'membership' => array(
        'heading' => 'Just a few more steps',
        'description' => 'Choose your payment option',
        'field_labels' => false,
        'submit_slide' => true,
    ),
);

$haute_membership_sections = array(
    'question1' => array(
        'heading' => 'Just a few more steps!',
        'field_labels' => true,
    ),
    'salary' => array(
        'heading' => 'Your Personal Income',
        'field_labels' => true,
    ),
    'referral' => array(
        'heading' => 'It’s about who you know.',
        'field_labels' => true,
    ),
    'question2' => array(
        'heading' => 'Just a few more steps',
        'field_labels' => true,
    ),
    'membership-haute' => array(
        'heading' => 'And lastly...',
        'description' => 'Choose your payment option',
        'field_labels' => false,
        'submit_slide' => true,
    ),
);

?>
<?php get_header(); ?>
<input type="hidden" id="stored_data" value='<?= json_encode( array() ); ?>'>
<h1 class="sr-only"><?php _ewh( 'Register' ); ?></h1>
<div class="splide" id="registration">
    <div class="splide__track">
        <ul class="splide__list">
            <?php foreach ( $register_sections as $section_name => $section_config ): get_template_part( 'template-parts/registration-slide', null, array( 'name' => $section_name, 'config' => $section_config ) ); endforeach; ?>
        </ul>
    </div>
    <div class="splide__arrows navigation">
        <button type="button" id="registration-prev" class="button button-primary">Back</button>
        <button type="button" id="registration-next" class="button button-primary">Next<span class="fas fa-spinner fa-spin busy hidden"></span></button>
    </div>
</div>
<template id="registration-digital-pass">
    <?php foreach ( $digital_pass_sections as $section_name => $section_config ): get_template_part( 'template-parts/registration-slide', null, array( 'name' => $section_name, 'config' => $section_config, 'journey' => 'digital-pass' ) ); endforeach; ?>
</template>
<template id="registration-haute-membership">
    <?php foreach ( $haute_membership_sections as $section_name => $section_config ): get_template_part( 'template-parts/registration-slide', null, array( 'name' => $section_name, 'config' => $section_config, 'journey' => 'haute-membership' ) ); endforeach; ?>
</template>
<?php get_footer();
