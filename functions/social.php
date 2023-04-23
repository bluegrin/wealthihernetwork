<?php

const FA_VERSION = '6.2.0';

define( 'FA_ENQUEUE', array(
	'type' => 'style',
	'handle' => 'fontawesome',
	'src' => sprintf( 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/%s/css/all.min.css', FA_VERSION ),
	'ver' => FA_VERSION,
) );

const SOCIAL_PLATFORMS = array(
    'facebook' => 'Facebook',
    'twitter' => 'Twitter',
    'instagram' => 'Instagram',
    'pinterest' => 'Pinterest',
    'linkedin' => 'LinkedIn',
    'youtube' => 'YouTube',
    'tiktok' => 'TikTok',
);

wh_filter( 'wealthiher_wp_enqueue_scripts', 'social' );
wh_filter( 'wealthiher_admin_enqueue_scripts', 'social' );

wh_action( 'admin_init', 'social' );

function wealthiher_filter_wealthiher_wp_enqueue_scripts_social( array $scripts ) {
	$scripts[] = FA_ENQUEUE;
	return $scripts;
}


function wealthiher_filter_wealthiher_admin_enqueue_scripts_social( array $scripts ) {
	$scripts[] = FA_ENQUEUE;
	return $scripts;
}

function wealthiher_action_admin_init_social() {
	
	add_meta_box(
		'social-media-nav',
		__wh( 'Social Media' ),
		'wealthiher_social_media_meta_box_callback',
		'nav-menus',
		'side',
	);
	
}

function wealthiher_social_media_meta_box_callback() {

	global $_nav_menu_placeholder, $nav_menu_selected_id;

	$_nav_menu_placeholder = 0 > $_nav_menu_placeholder ? $_nav_menu_placeholder - 1 : -1;
	
	?>
	<div id="social-media-platforms" class="social-media-platforms">
		<input type="hidden" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-type]" value="social-media">
		<p class="wp-clearfix">
			<label for="social-media-platform" class="howto"><?= __wh( 'Platform' ) ?></label>
			<select name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-title]" id="social-media-platform" class="menu-item-textbox form-required">
				<option selected disabled><?= __wh( 'Choose --' ) ?></option>
				<?php foreach (SOCIAL_PLATFORMS as $value => $label ): ?><option value="<?= $value ?>"><?= $label ?></option><?php endforeach; ?>
			</select>
		</p>
		<p class="wp-clearfix">
			<label for="social-media-url" class="howto"><?= __wh( 'URL' ) ?></label>
			<input type="text" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-url]" id="social-media-url" class="menu-item-textbox form-required" placeholder="https://">
		</p>
		<p class="button-controls">
			<span class="add-to-menu">
				<input type="submit" name="add-social-menu-item" id="submit-social-media-platforms" class="button submit-add-to-menu right" value="<?= __wh( 'Add to Menu' ) ?>">
				<span class="spinner"></span>
			</span>
		</p>
	</div>
	<?php
	
}