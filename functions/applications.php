<?php

$applicants_query_args = array(
    'order' => 'DESC',
    'orderby' => 'user_registered',
    'meta_query' => array(
        array(
            'key' => 'haute_membership_application_status',
            'compare' => 'EXISTS',
        ),
    ),
);

$applicants_query = new WP_User_Query( $applicants_query_args );

/** @var WP_User[] $applicants_results */
$applicants_results = $applicants_query->get_results();

?>
<style>
    table.admin-report-table {
        border: solid 1px #3c434a;
        border-spacing: 0;
        border-collapse: collapse
    }

    table.admin-report-table td, table.admin-report-table th {
        border: solid 1px #3c434a;
        padding: 8px 12px
    }

    table.admin-report-table td.btn, table.admin-report-table td.id, table.admin-report-table th.btn, table.admin-report-table th.id {
        min-width: 45px;
        text-align: center
    }

    table.admin-report-table td > a, table.admin-report-table td > label {
        display: block;
        max-width: 400px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        margin: -8px -12px;
        padding: 8px 12px
    }

    table.admin-report-table tfoot td {
        text-align: right;
        padding: 8px 12px
    }

    table.admin-report-table tfoot td .page-numbers {
        display: inline;
        margin: 0 6px;
        padding: 0
    }
</style>
<h1><?php esc_html_e( 'All Access Pass Applications' ); ?></h1>
<?php if ( ! empty( $applicants_query->get_results() ) ): ?>
<table class="admin-report-table">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email Address</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ( $applicants_results as $user ): ?>
        <tr>
            <td><?php esc_html_e( $user->first_name ); ?></td>
            <td><?php esc_html_e( $user->last_name ); ?></td>
            <td><?php esc_html_e( $user->user_email ); ?></td>
            <td><?php esc_html_e( get_user_meta( $user->ID, 'haute_membership_application_status', true ) ); ?></td>
            <td><a href="<?php echo get_edit_user_link( $user->ID ); ?>"><?php _ewh( 'View' ); ?></a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p><?php _ewh( 'No applicants yet.' ); ?></p>
<?php endif;
