<?php
/**
 * Contact Submissions Custom Post Type
 *
 * @package Stylefolio
 * @version 1.0
 * @author abdulhaseeb2002
 * @updated 2025-06-15 04:22:31
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Contact Submissions post type
 */
function stylefolio_register_contact_submissions_post_type() {
    $labels = array(
        'name'                  => _x('Contact Submissions', 'Post type general name', 'stylefolio'),
        'singular_name'         => _x('Contact Submission', 'Post type singular name', 'stylefolio'),
        'menu_name'             => _x('Contact Submissions', 'Admin Menu text', 'stylefolio'),
        'name_admin_bar'        => _x('Contact Submission', 'Add New on Toolbar', 'stylefolio'),
        'add_new'               => __('Add New', 'stylefolio'),
        'add_new_item'          => __('Add New Submission', 'stylefolio'),
        'new_item'              => __('New Submission', 'stylefolio'),
        'edit_item'             => __('Edit Submission', 'stylefolio'),
        'view_item'             => __('View Submission', 'stylefolio'),
        'all_items'             => __('All Submissions', 'stylefolio'),
        'search_items'          => __('Search Submissions', 'stylefolio'),
        'parent_item_colon'     => __('Parent Submissions:', 'stylefolio'),
        'not_found'             => __('No submissions found.', 'stylefolio'),
        'not_found_in_trash'    => __('No submissions found in Trash.', 'stylefolio'),
    );    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'capability_type'    => 'post',
        'capabilities'       => array(
            'create_posts' => 'do_not_allow', // Removes support for the "Add New" function
        ),
        'map_meta_cap'       => true, // Set to false, if users are not allowed to edit/delete existing posts
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 30,
        'menu_icon'          => 'dashicons-email-alt',
        'supports'           => array('title'),
    );    $result = register_post_type('contact_submission', $args);
}
add_action('init', 'stylefolio_register_contact_submissions_post_type');

/**
 * Add custom columns to the admin list
 */
function stylefolio_contact_submission_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = __('Subject', 'stylefolio');
    $new_columns['sender'] = __('Sender', 'stylefolio');
    $new_columns['email'] = __('Email', 'stylefolio');
    $new_columns['message'] = __('Message', 'stylefolio');
    $new_columns['status'] = __('Status', 'stylefolio');
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_contact_submission_posts_columns', 'stylefolio_contact_submission_columns');

/**
 * Display data in custom columns
 */
function stylefolio_contact_submission_custom_column($column, $post_id) {
    switch ($column) {
        case 'sender':
            echo esc_html(get_post_meta($post_id, '_contact_name', true));
            break;
        
        case 'email':
            $email = get_post_meta($post_id, '_contact_email', true);
            echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
            break;
            
        case 'message':
            $message = get_post_meta($post_id, '_contact_message', true);
            echo wp_trim_words($message, 10, '...');
            break;
            
        case 'status':
            $emailed = get_post_meta($post_id, '_contact_emailed', true);
            if ($emailed) {
                echo '<span style="color: green;">✓ Emailed</span>';
            } else {
                echo '<span style="color: orange;">✗ Stored Only</span>';
            }
            break;
    }
}
add_action('manage_contact_submission_posts_custom_column', 'stylefolio_contact_submission_custom_column', 10, 2);

/**
 * Add meta box for submission details
 */
function stylefolio_contact_submission_meta_boxes() {
    add_meta_box(
        'contact_submission_details',
        __('Contact Details', 'stylefolio'),
        'stylefolio_contact_submission_meta_box_callback',
        'contact_submission',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'stylefolio_contact_submission_meta_boxes');

/**
 * Meta box callback
 */
function stylefolio_contact_submission_meta_box_callback($post) {
    $name = get_post_meta($post->ID, '_contact_name', true);
    $email = get_post_meta($post->ID, '_contact_email', true);
    $phone = get_post_meta($post->ID, '_contact_phone', true);
    $message = get_post_meta($post->ID, '_contact_message', true);
    $emailed = get_post_meta($post->ID, '_contact_emailed', true);
    $ip = get_post_meta($post->ID, '_contact_ip', true);
    $date = get_the_date('F j, Y g:i a', $post->ID);
    
    ?>
    <style>
        .contact-details {
            padding: 10px;
        }
        .contact-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .contact-details th {
            width: 120px;
            text-align: left;
            padding: 10px;
            vertical-align: top;
            border-bottom: 1px solid #eee;
        }
        .contact-details td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .contact-message {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            white-space: pre-wrap;
        }
        .contact-meta {
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
    </style>
    
    <div class="contact-details">
        <table>
            <tr>
                <th><?php _e('From:', 'stylefolio'); ?></th>
                <td><?php echo esc_html($name); ?></td>
            </tr>
            <tr>
                <th><?php _e('Email:', 'stylefolio'); ?></th>
                <td><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></td>
            </tr>
            <?php if (!empty($phone)) : ?>
            <tr>
                <th><?php _e('Phone:', 'stylefolio'); ?></th>
                <td><?php echo esc_html($phone); ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <th><?php _e('Message:', 'stylefolio'); ?></th>
                <td>
                    <div class="contact-message"><?php echo esc_html($message); ?></div>
                </td>
            </tr>
            <tr>
                <th><?php _e('Status:', 'stylefolio'); ?></th>
                <td>
                    <?php if ($emailed) : ?>
                        <span style="color: green;">✓ Notification email was sent</span>
                    <?php else : ?>
                        <span style="color: orange;">✗ Stored only (no email sent)</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
        
        <div class="contact-meta">
            <p><strong><?php _e('Submission Date:', 'stylefolio'); ?></strong> <?php echo esc_html($date); ?></p>
            <p><strong><?php _e('IP Address:', 'stylefolio'); ?></strong> <?php echo esc_html($ip); ?></p>
        </div>
    </div>
    <?php
}