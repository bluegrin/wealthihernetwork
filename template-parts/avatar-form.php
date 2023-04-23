<?php

$user_id = get_current_user_id();
$user_data = get_userdata( $user_id );

if ( isset( $_POST['manage_avatar_submit'] ) ) {
    $basic_user_avatars = new basic_user_avatars;
    $basic_user_avatars->edit_user_profile_update( $user_id );
}

?>
<form id="basic-user-avatar-form" method="post" enctype="multipart/form-data">
    <?php wp_nonce_field( 'basic_user_avatar_nonce', '_basic_user_avatar_nonce', false ); ?>
    <div class="sr-only">
        <input type="checkbox" name="basic-user-avatar-erase" id="basic-user-avatar-erase" value="1">
        <input type="file" name="basic-user-avatar" id="basic-local-avatar">
        <input type="hidden" name="manage_avatar_submit" value="update">
    </div>
    <div class="avatar-container">
        <div class="image">
            <?php echo get_avatar( $user_id ); ?>
        </div>
        <div class="options">
            <label for="basic-user-avatar-erase" class="button-link"><?php _ewh( 'Remove image' ); ?></label>
            <label for="basic-local-avatar" class="button-link"><?php _ewh( 'Upload image' ); ?></label>
        </div>
    </div>
</form>

