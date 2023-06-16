<?php

define( 'WEALTHIHER_REGISTRATION_FIELDS', array(
    'user_first_name' => array(
        'section' => 'names',
        'type' => 'text',
        'label' => 'First Name',
        'question' => 'First name',
        'placeholder' => 'your first name here',
        'required' => true,
    ),
    'user_last_name' => array(
        'section' => 'names',
        'type' => 'text',
        'label' => 'Last Name',
        'question' => 'Last name',
        'placeholder' => 'your last name here',
        'required' => true,
    ),
    'user_email' => array(
        'section' => 'email',
        'type' => 'email',
        'label' => 'Email Address',
        'question' => 'What is your email address?',
        'placeholder' => 'youremail@address.com',
        'required' => true,
    ),
    'mepr_user_password' => array(
        'section' => 'password',
        'type' => 'password',
        'label' => 'Password',
        'question' => 'Set a password',
        'placeholder' => 'set a password',
        'required' => true,
    ),
    'mepr_user_password_confirm' => array(
        'section' => 'password',
        'type' => 'password',
        'label' => 'Password Confirmation',
        'question' => 'Confirm your password',
        'placeholder' => 'confirm your password',
        'required' => true,
    ),
    'mepr_interests' => array(
        'section' => 'interests',
        'type' => 'checkboxes',
        'label' => 'Interests',
        'options' => array(
            'investing' => 'Investing',
            'entrepreneurship' => 'Entrepreneurship',
            'networking' => 'Networking',
            'leadership' => 'Leadership',
            'personal-finance' => 'Personal Finance',
            'self-development' => 'Self-Development',
        ),
        'required' => 1,
    ),
    'mepr_linkedin' => array(
        'section' => 'social',
        'type' => 'url',
        'label' => 'LinkedIn URL',
        'question' => 'LinkedIn URL',
        'placeholder' => 'www.linkedin.com/profile/yourname',
    ),
    'mepr_other_links' => array(
        'section' => 'social',
        'type' => 'text',
        'label' => 'Other Links',
        'question' => 'Other links you’d like to share',
        'placeholder' => 'your website, blog, platform etc.',
    ),
    'mepr_job_level' => array(
        'section' => 'company',
        'type' => 'select',
        'label' => 'Job Title',
        'question' => 'Job Title',
        'placeholder' => 'CTO, Executive Director, Manager etc.',
        'options' => array(
            'owner-founder' => 'Owner/Founder',
            'c-suite' => 'C Suite',
            'director' => 'Director',
            'executive' => 'Executive',
            'senior-contributor' => 'Senior Contributor',
            'senior-management' => 'Senior Management',
            'middle-management' => 'Middle Management',
            'first-level-management' => 'First-Level Management',
            'mid-weight' => 'Mid-Weight',
            'entry-level' => 'Entry-Level',
            'student' => 'Student',
        ),
        'required' => true,
    ),
    'mepr_company' => array(
        'section' => 'company',
        'type' => 'text',
        'label' => 'Company',
        'question' => 'Your Company',
        'placeholder' => 'JP Morgan, HSBC, LVMH, etc.',
        'required' => true,
    ),
    'journey' => array(
        'section' => 'journey',
        'type' => 'radio',
        'label' => 'Plan',
        'question' => 'Plan',
        'options' => array(
            'digital-pass' => 'Get the Digital Pass',
            'haute-membership' => 'Apply to become an All Access Member',
        ),
        'required' => true,
    ),
    'mepr_product_id' => array(
        'section' => 'membership',
        'journey' => 'digital-pass',
        'type' => 'radio',
        'label' => 'Membership',
        'question' => 'Membership',
        'options' => wealthiher_digital_pass_options(),
        'required' => true,
    ),
    'haute_question_1' => array(
        'section' => 'question1',
        'journey' => 'haute-membership',
        'type' => 'textarea',
        'label' => 'Answer',
        'question' => 'Tell us who you are and why you believe you will add value to the WealthiHer network',
        'placeholder' => 'Begin typing here...',
        'required' => true,
    ),
    'mepr_salary' => array(
        'section' => 'salary',
        'journey' => 'haute-membership',
        'type' => 'select',
        'label' => 'Salary',
        'question' => 'Your Salary',
        'placeholder' => 'Choose --',
        'options' => array(
            'less-50k' => 'Less than ￡50k',
            '50k-100k' => '￡50k - ￡100k',
            '101k-150k' => '￡101k - ￡150k',
            '151k-250k' => '￡151k - ￡250k',
            'greater-251k' => '￡251k +',
            'private' => __wh( 'Prefer Not To Say' ),
        ),
        'required' => true,
    ),
    'mepr_referral' => array(
        'section' => 'referral',
        'journey' => 'haute-membership',
        'type' => 'text',
        'label' => 'Referrer',
        'question' => 'Were you recommended by another member? If so, please tell us who.',
        'placeholder' => 'Begin typing here...',
        'required' => true,
    ),
    'haute_question_2' => array(
        'section' => 'question2',
        'journey' => 'haute-membership',
        'type' => 'textarea',
        'label' => 'Answer',
        'question' => 'Why is the economic advancement of women important to you?',
        'placeholder' => 'Begin typing here...',
        'required' => true,
    ),
) );

define( 'WEALTHIHER_HAUTE_MEMBERSHIP_PRODUCT_ID', 703 );

add_action( 'wp_ajax_validate_registration', 'wealthiher_action_ajax_validate_registration_memberpress' );
add_action( 'wp_ajax_nopriv_validate_registration', 'wealthiher_action_ajax_validate_registration_memberpress' );

wh_filter( 'register_url' );

wh_action( 'admin_menu', 'register' );
wh_action( 'edit_user_profile', 'register' );

/*
 * Filters
 */

function wealthiher_filter_register_url( $register ) {

    return site_url( '/welcome' );
}

function wealthiher_filter_wp_mail_content_type_register() {
    return 'text/html';
}

/*
 * Actions
 */

function wealthiher_action_ajax_validate_registration_memberpress() {

    $success = true;
    $messages = array();
    $redirect = false;

    $section = $_POST['section'] ?? null;
    $submit = $_POST['submit'] ?? null;

    if ( is_null( $section ) ) {
        $success = false;
        $messages[] = 'There was a problem processing your information. Please try again later or contact support.';
    }

    $processing = array();
    $missing = array();

    foreach ( WEALTHIHER_REGISTRATION_FIELDS as $name => $config ) {

        if ( $section != $config['section'] ?? null ) {

            if ( is_null( $submit ) ) {
                continue;
            }

            if ( isset( $config['journey'] ) && $submit != $config['journey'] ) {
                continue;
            }

        }

        $required = $config['required'] ?? false;
        $label = $config['label'] ?? $name;
        $value = $_POST[ $name ] ?? null;

        if ( $required && empty( $value ) ) {
            if ( 'checkboxes' == $config['type'] ) {
                $success = false;
                $messages[] = sprintf( _n( 'At least %s interest is required.', 'At least %s interests are required.', $config['required'], 'wealthiher' ), number_format_i18n( $config['required'] ) );
            } else {
                $missing[] = $label;
            }
        }

        if ( ! is_null( $submit ) ) {
            $processing[$name] = $config;
        }

    }

    if ( count( $missing ) ) {
        $success = false;
        $messages[] = sprintf( '%s %s', implode( ', ', $missing ), _n( 'is required.', 'are required.', count( $missing ), 'wealthiher' ) );
    }

    if ( empty( $missing ) ) {
        switch ( $section ) {

            case 'email':

                $email = $_POST['user_email'] ?? null;

                if ( ! is_email( $email ) ) {
                    $success = false;
                    $messages[] = 'Email Address is invalid, please check again.';
                    break;
                }

                if ( get_user_by_email( $email ) instanceof WP_User ) {
                    $success = false;
                    $messages[] = sprintf( 'Email Address is already taken. Login <a href="%s" class="click-tap">here</a> or reset your password <a href="%s" class="click-tap">here</a>.', esc_url( wp_login_url() ), esc_url( wp_lostpassword_url() ) );
                    break;
                }

                break;

            case 'password':

                $password = $_POST['mepr_user_password'] ?? null;
                $confirm = $_POST['mepr_user_password_confirm'] ?? null;

                if ( $confirm != $password ) {
                    $success = false;
                    $messages[] = 'Password and confirmation do not match.';
                    break;
                }

                break;

            default:
                break;

        }
    }

    if ( ! empty( $processing ) ) {

        $wp_user = new WP_User;

        $wp_user->user_login = $_POST['user_email'];
        $wp_user->user_email = $_POST['user_email'];
        $wp_user->first_name = $_POST['user_first_name'];
        $wp_user->last_name = $_POST['user_last_name'];
        $wp_user->user_pass = $_POST['mepr_user_password'];

        $result = wp_insert_user( $wp_user );

        if ( $result instanceof WP_Error ) {

            $success = false;

            $messages[] = __wh( 'There was a problem saving your data. Please try again or contact support.' );

            foreach ( $result->errors as $code => $error ) {
                $messages[] = sprintf( '[%s] %s', $code, implode( ', ', $error ) );
            }

        } else {


            $user_id = $result;

            $skip_list = array(
                'user_first_name',
                'user_last_name',
                'user_email',
                'mepr_user_password',
                'mepr_user_password_confirm',
                'journey',
                'mepr_product_id'
            );

            foreach ( $processing as $name => $config ) {
                if ( ! in_array( $name, $skip_list ) ) {
                    update_user_meta( $user_id, $name, $_POST[ $name ] );
                }
            }

            switch ( $submit ) {

                case 'digital-pass':

                    wp_set_auth_cookie( $user_id );

                    $messages[] = 'Redirecting you to the payment form. Please wait...';
                    $messages[] = sprintf( 'If you are not redirected, please <a href="%s">click here</a>.', get_permalink( $_POST['mepr_product_id'] ) );
                    $redirect = get_permalink( $_POST['mepr_product_id'] );

                    break;

                case 'haute-membership':

                    update_user_meta( $user_id, 'haute_membership_application_status', 'pending' );
                    update_user_meta( $user_id, 'haute_membership_application_hash', md5( uniqid() ) );

                    $messages[] = 'Redirecting you. Please wait...';
                    $messages[] = sprintf( 'If you are not redirected, please <a href="%s">click here</a>.', get_home_url() . '/application-submitted' );
                    $redirect = get_home_url() . '/application-submitted';

                    $email_body = __wh( '<h1>All Access Pass Application Received</h1>' );

                    foreach ( $processing as $name => $config ) {

                        if ( in_array( $name, array( 'mepr_user_password', 'mepr_user_password_confirm', 'journey' ) ) ) {
                            continue;
                        }

                        $label = in_array( $name, array( 'haute_question_1', 'haute_question_2' ) ) ? $config['question'] : $config['label'];

                        $value = $_POST[ $name ] ?? 'N/A';

                        $email_body .= sprintf( '<p><b>%s</b><br>%s</p>', $label, $value );

                    }

                    $email_body .= sprintf( '<p><a href="%s">%s</a></p>', get_edit_user_link( $user_id ), __wh( 'View Application' ) );

                    add_action(  'wp_mail_content_type', 'wealthiher_filter_wp_mail_content_type_register' );
                    wp_mail( array( 'hello@whngroup.co', $_POST['user_email'] ), __wh( 'All Access Pass Application' ), $email_body );
                    remove_action( 'wp_mail_content_type', 'wealthiher_filter_wp_mail_content_type_register' );

                    break;

                default:
                    break;

            }

        }

    }

    $data = array(
        'message' => empty( $messages ) ? ( $success ? null : __wh( 'There was a problem processing your form. Please try again later or contact support.' ) ) : implode( ' ', $messages ),
        'redirect' => $redirect,
    );

    if ( $success ) {
        wp_send_json_success( $data );
    } else {
        wp_send_json_error( $data );
    }

    wp_die();
}

function wealthiher_action_admin_menu_register() {

    add_menu_page(
        __wh( 'All Access Pass Applications' ),
        __wh( 'Applications' ),
        'manage_options',
        'wealthiher_applications',
        'wealthiher_callback_add_menu_page_applications',
    );
}

/**
 * @param WP_User $profile_user
 *
 * @return void
 */
function wealthiher_action_edit_user_profile_register( WP_User $profile_user ) {

    if ( isset( $_GET['update_application_status'] ) ) {
        update_user_meta( $profile_user->ID, 'haute_membership_application_status', $_GET['update_application_status'] );

        if ( 'approved' == $_GET['update_application_status'] ) {

            $email_body = sprintf( '<p>Dear %1$s</p><p>Congratulations! Your membership application has been approved! <a href="%2$s">Click here</a> to complete your membership or follow the link below.</p><p>%2$s</p><p>Regards</p><p>The WealthiHer Network Team</p>', $profile_user->first_name, wealthiher_application_complete_link( $profile_user ) );

            add_action(  'wp_mail_content_type', 'wealthiher_filter_wp_mail_content_type_register' );
            wp_mail( $profile_user->user_email, __wh( 'All Access Pass Application' ), $email_body );
            remove_action( 'wp_mail_content_type', 'wealthiher_filter_wp_mail_content_type_register' );

        }

    }

    $application_status = get_user_meta( $profile_user->ID, 'haute_membership_application_status', true );

    if ( ! empty( $application_status ) ) {

        $status_labels = array(
            'pending' => __wh( 'Pending' ),
            'approved' => __wh( 'Approved' ),
            'declined' => __wh( 'Declined' ),
        );

        $status_label = $status_labels[ $application_status ] ?? $status_labels['pending'];
?>
<h2><?php _ewh( 'All Access Pass Application' ); ?></h2>
<p><b><?php _ewh( 'Status:' ); ?></b><br><?php echo $status_label; ?></p>
<p><b><?php _ewh( WEALTHIHER_REGISTRATION_FIELDS['haute_question_1']['question'] ); ?></b><br><?php esc_html_e( get_user_meta( $profile_user->ID, 'haute_question_1', true ) ); ?></p>
<p><b><?php _ewh( WEALTHIHER_REGISTRATION_FIELDS['haute_question_2']['question'] ); ?></b><br><?php esc_html_e( get_user_meta( $profile_user->ID, 'haute_question_2', true ) ); ?></p>
<p><b><?php _ewh( 'Actions:' ); ?></b><br>
    <?php if ( in_array( $application_status, array( 'pending', 'approved' ) ) ): ?>
    <a href="<?php echo add_query_arg( array( 'update_application_status' => 'declined' ), get_edit_user_link( $profile_user->ID ) ); ?>" class="whn-button-decline" style="font-weight: bold; color: #d63638;"><?php _ewh( 'Decline' ); ?></a>
    <?php endif; if ( in_array( $application_status, array( 'pending', 'declined' ) ) ): ?>
    <a href="<?php echo add_query_arg( array( 'update_application_status' => 'approved' ), get_edit_user_link( $profile_user->ID ) ); ?>" class="whn-button-approve" style="font-weight: bold; color: #00a32a;"><?php _ewh( 'Approve' ); ?></a>
    <?php endif; ?>
</p>
<p><b><?php _ewh( 'Complete Link' ); ?></b><br><a href="<?php echo wealthiher_application_complete_link( $profile_user ); ?>"><?php echo wealthiher_application_complete_link( $profile_user ); ?></a></p>
<?php

    }
}

/*
 * Callbacks
 */

function wealthiher_callback_add_menu_page_applications() {

    require_once 'applications.php';
}

/*
 * Functions
 */

function wealthiher_digital_pass_options() {

    $digital_pass_options = array();

    $membership_query_args = array(
        'post_type' => array( 'memberpressproduct' ),
        'post_status' => array( 'publish' ),
        'meta_query' => array(
            array(
                'key' => 'wh_onboarding_group',
                'value' => 'digital_pass',
            ),
        ),
    );

    foreach ( get_posts( $membership_query_args ) as $post ) {
        if ( $post instanceof WP_Post ) {
            $digital_pass_options[ $post->ID ] = get_post_meta( $post->ID, 'wh_onboarding_name', true );
        }
    }

    return $digital_pass_options;
}

/**
 * @param WP_User $wp_user
 *
 * @return string
 */
function wealthiher_application_complete_link( WP_User $wp_user ) {

    return add_query_arg( 'app_id', get_user_meta( $wp_user->ID, 'haute_membership_application_hash', true ), get_the_permalink( WEALTHIHER_HAUTE_MEMBERSHIP_PRODUCT_ID ) );
}
