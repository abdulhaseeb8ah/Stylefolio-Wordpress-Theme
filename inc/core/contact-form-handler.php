<?php
/**
 * Contact Form Handler
 * 
 * Processes contact form submissions, validates data, sends emails,
 * and stores messages in the database for admin review.
 *
 * @package Stylefolio
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle contact form submission and validation
 */
function stylefolio_process_contact_form() {
    // Check if form was submitted
    if (!isset($_POST['stylefolio_contact_submit'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['stylefolio_contact_nonce'], 'stylefolio_contact_form')) {
        return;
    }
    
    // Get form data
    $name = isset($_POST['contact_name']) ? sanitize_text_field($_POST['contact_name']) : '';
    $email = isset($_POST['contact_email']) ? sanitize_email($_POST['contact_email']) : '';
    $phone = isset($_POST['contact_phone']) ? sanitize_text_field($_POST['contact_phone']) : '';
    $subject = isset($_POST['contact_subject']) ? sanitize_text_field($_POST['contact_subject']) : '';
    $message = isset($_POST['contact_message']) ? sanitize_textarea_field($_POST['contact_message']) : '';
    
    // Validate required fields
    $errors = array();
    
    if (empty($name)) {
        $errors['name'] = __('Please enter your name.', 'stylefolio');
    }
    
    if (empty($email)) {
        $errors['email'] = __('Please enter your email address.', 'stylefolio');
    } elseif (!is_email($email)) {
        $errors['email'] = __('Please enter a valid email address.', 'stylefolio');
    }
    
    if (empty($subject)) {
        $errors['subject'] = __('Please enter a subject.', 'stylefolio');
    }
    
    if (empty($message)) {
        $errors['message'] = __('Please enter your message.', 'stylefolio');
    }
    
    // If there are errors, store them in a transient and redirect back to the form
    if (!empty($errors)) {
        set_transient('stylefolio_contact_errors', $errors, 60 * 5);
        set_transient('stylefolio_contact_data', array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message,
        ), 60 * 5);
        
        // Redirect back to the form
        wp_safe_redirect(add_query_arg('contact_error', '1', wp_get_referer()));
        exit;
    }
    
    // Get the notification email from theme options
    $notification_email = get_theme_mod('contact_form_email', get_option('admin_email'));
    $should_send_email = !empty($notification_email);    // Create a new contact submission post
    $post_id = wp_insert_post(array(
        'post_title'    => wp_strip_all_tags($subject),
        'post_status'   => 'publish',
        'post_type'     => 'contact_submission',
    ));
    
    if ($post_id) {
        // Store contact details as post meta
        update_post_meta($post_id, '_contact_name', $name);
        update_post_meta($post_id, '_contact_email', $email);
        update_post_meta($post_id, '_contact_phone', $phone);
        update_post_meta($post_id, '_contact_subject', $subject);
        update_post_meta($post_id, '_contact_message', $message);
        update_post_meta($post_id, '_contact_ip', stylefolio_get_client_ip());
        update_post_meta($post_id, '_contact_emailed', false); // Default to not emailed
        
        // Only send email if notification email is configured
        if ($should_send_email) {
            $email_sent = stylefolio_send_contact_notification($post_id, $notification_email, $name, $email, $subject, $message, $phone);
            
            // Update emailed status
            if ($email_sent) {
                update_post_meta($post_id, '_contact_emailed', true);
            }
        }
        
        // Set success message
        set_transient('stylefolio_contact_success', true, 60 * 5);
        
        // Redirect to thank you page if specified in options, otherwise back to the form
        $thank_you_page = get_theme_mod('contact_form_thank_you_page', '');
        
        if (!empty($thank_you_page)) {
            wp_safe_redirect(get_permalink($thank_you_page));
        } else {
            wp_safe_redirect(add_query_arg('contact_success', '1', wp_get_referer()));
        }
        
        exit;
    } else {
        // Something went wrong with saving the submission
        set_transient('stylefolio_contact_errors', array(
            'general' => __('There was a problem submitting your message. Please try again.', 'stylefolio')
        ), 60 * 5);
        
        wp_safe_redirect(add_query_arg('contact_error', '1', wp_get_referer()));
        exit;
    }
}
add_action('template_redirect', 'stylefolio_process_contact_form');

/**
 * Send contact form notification email
 */
function stylefolio_send_contact_notification($post_id, $to, $name, $email, $subject, $message, $phone = '') {
    $site_name = get_bloginfo('name');
    $site_url = get_bloginfo('url');
    
    // Build email content
    $email_subject = sprintf('[%s] New Contact: %s', $site_name, $subject);
    
    $email_body = sprintf(__("You have received a new contact form submission on %s.\n\n", 'stylefolio'), $site_name);
    $email_body .= sprintf(__("From: %s\n", 'stylefolio'), $name);
    $email_body .= sprintf(__("Email: %s\n", 'stylefolio'), $email);
    
    if (!empty($phone)) {
        $email_body .= sprintf(__("Phone: %s\n", 'stylefolio'), $phone);
    }
    
    $email_body .= sprintf(__("Subject: %s\n\n", 'stylefolio'), $subject);
    $email_body .= __("Message:\n", 'stylefolio');
    $email_body .= $message;
    $email_body .= "\n\n";
    $email_body .= sprintf(__("View this submission in your dashboard: %s\n", 'stylefolio'), admin_url('post.php?post=' . $post_id . '&action=edit'));
    
    // Build email headers
    $headers = array();
    $headers[] = 'Content-Type: text/plain; charset=UTF-8';
    $headers[] = 'From: ' . $name . ' <' . $email . '>';
    $headers[] = 'Reply-To: ' . $email;
    
    // Send the email
    $mail_sent = wp_mail($to, $email_subject, $email_body, $headers);
    
    return $mail_sent;
}

/**
 * Get client IP address
 */
function stylefolio_get_client_ip() {
    $ip_keys = array(
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    );
    
    foreach ($ip_keys as $key) {
        if (isset($_SERVER[$key]) && filter_var($_SERVER[$key], FILTER_VALIDATE_IP)) {
            return $_SERVER[$key];
        }
    }
    
    return '127.0.0.1'; // Default if nothing found
}

/**
 * Debug function to test if contact_submission post type works
 * (Remove this after debugging)
 */
function stylefolio_test_contact_post_type() {
    if (defined('WP_DEBUG') && WP_DEBUG && isset($_GET['test_contact_post'])) {
        $test_post = wp_insert_post(array(
            'post_title' => 'Debug Test Submission - ' . date('Y-m-d H:i:s'),
            'post_type' => 'contact_submission',
            'post_status' => 'publish'
        ));
        
        if ($test_post && !is_wp_error($test_post)) {
            error_log('Debug test: Contact submission post created successfully with ID: ' . $test_post);
            wp_die('Test post created with ID: ' . $test_post . '. Check admin for Contact Submissions.');
        } else {
            error_log('Debug test: Failed to create contact submission post: ' . print_r($test_post, true));
            wp_die('Failed to create test post: ' . print_r($test_post, true));
        }
    }
}
add_action('init', 'stylefolio_test_contact_post_type', 999);

/**
 * Alternative form processing hook (for debugging)
 */
function stylefolio_debug_all_posts() {
    if (defined('WP_DEBUG') && WP_DEBUG && $_SERVER['REQUEST_METHOD'] === 'POST') {
        error_log('=== DEBUG: POST request detected ===');
        error_log('REQUEST_URI: ' . $_SERVER['REQUEST_URI']);
        error_log('POST data in init hook: ' . print_r($_POST, true));
        error_log('=== END DEBUG ===');
    }
}
add_action('init', 'stylefolio_debug_all_posts', 1);