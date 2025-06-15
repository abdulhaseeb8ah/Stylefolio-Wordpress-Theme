<?php
/**
 * Sample Testimonials Data
 *
 * @package Stylefolio
 * @version 1.0
 * @author abdulhaseeb2002
 * @updated 2025-06-11 15:14:51
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create sample testimonials
 */
function stylefolio_create_sample_testimonials() {
    // Check if we've already created sample testimonials
    if (get_option('stylefolio_sample_testimonials_created')) {
        return;
    }
    
    // Sample testimonials data
    $testimonials = array(
        array(
            'title'           => 'John Anderson',
            'client_name'     => 'John Anderson',
            'client_position' => 'CTO',
            'client_company'  => 'TechVision Inc.',
            'client_quote'    => 'Working with Abdul on our web application was a fantastic experience. Their technical expertise and attention to detail resulted in a product that exceeded our expectations. The development process was smooth, and they were always responsive to our feedback and requirements.',
            'client_rating'   => 5,
            'order'           => 10,
        ),
        array(
            'title'           => 'Sarah Mitchell',
            'client_name'     => 'Sarah Mitchell',
            'client_position' => 'Marketing Director',
            'client_company'  => 'CreativeEdge',
            'client_quote'    => 'Abdul transformed our outdated website into a modern, user-friendly platform that perfectly represents our brand. Their creative approach and technical skills are impressive. What I appreciated most was their ability to explain complex technical concepts in simple terms. Would definitely work with them again!',
            'client_rating'   => 5,
            'order'           => 20,
        ),
        array(
            'title'           => 'Michael Rodriguez',
            'client_name'     => 'Michael Rodriguez',
            'client_position' => 'Founder',
            'client_company'  => 'StartUp Labs',
            'client_quote'    => 'As a startup, we needed a developer who could work within our budget while delivering high-quality results. Abdul didn\'t just meet our expectations—they exceeded them. They provided valuable insights that improved our product beyond what we had envisioned. Their work was crucial to our successful launch.',
            'client_rating'   => 4.5,
            'order'           => 30,
        ),
        array(
            'title'           => 'Emily Chen',
            'client_name'     => 'Emily Chen',
            'client_position' => 'Product Manager',
            'client_company'  => 'InnovateTech',
            'client_quote'    => 'Abdul\'s ability to turn our ideas into a functioning application was remarkable. They have a rare combination of technical prowess and design sensibility. Throughout the project, they remained focused on our business goals and user experience. The result was a product that both looks great and performs exceptionally well.',
            'client_rating'   => 5,
            'order'           => 40,
        ),
        array(
            'title'           => 'David Wilson',
            'client_name'     => 'David Wilson',
            'client_position' => 'E-commerce Manager',
            'client_company'  => 'RetailPlus',
            'client_quote'    => 'We hired Abdul to overhaul our e-commerce platform, and the results have been outstanding. Site speed improved by 40%, and the new checkout process increased our conversion rate significantly. They also implemented robust security measures that give us peace of mind. A true professional who delivers on their promises.',
            'client_rating'   => 5,
            'order'           => 50,
        ),
    );
    
    // Create testimonials
    foreach ($testimonials as $testimonial) {
        $post_id = wp_insert_post(array(
            'post_title'    => $testimonial['title'],
            'post_status'   => 'publish',
            'post_type'     => 'testimonial',
        ));
        
        if ($post_id) {
            // Add ACF fields
            update_field('client_name', $testimonial['client_name'], $post_id);
            update_field('client_position', $testimonial['client_position'], $post_id);
            update_field('client_company', $testimonial['client_company'], $post_id);
            update_field('client_quote', $testimonial['client_quote'], $post_id);
            update_field('client_rating', $testimonial['client_rating'], $post_id);
            update_field('testimonial_order', $testimonial['order'], $post_id);
        }
    }
    
    // Set default section settings if using ACF options
    if (function_exists('update_field') && function_exists('acf_get_setting')) {
        update_field('testimonial_section_title', 'Testimonials', 'option');
        update_field('testimonial_section_subtitle', 'What Clients Say', 'option');
        update_field('testimonial_section_layout', 'slider', 'option');
        update_field('testimonial_section_count', 6, 'option');
    }
    
    // Mark as created
    update_option('stylefolio_sample_testimonials_created', true);
}

/**
 * Add hook for theme activation or manual trigger
 */
function stylefolio_init_testimonial_data() {
    // Only run on explicit request for demo data
    if (isset($_GET['create_sample_testimonials']) && current_user_can('manage_options')) {
        stylefolio_create_sample_testimonials();
        
        // Redirect to remove the query parameter
        wp_redirect(remove_query_arg('create_sample_testimonials'));
        exit;
    }
}
add_action('init', 'stylefolio_init_testimonial_data');

/**
 * Add admin notice for creating sample data
 */
function stylefolio_testimonial_admin_notice() {
    // Only show to admins and only if we haven't created sample data
    if (!current_user_can('manage_options') || get_option('stylefolio_sample_testimonials_created')) {
        return;
    }
    
    // Count existing testimonials
    $testimonials_count = wp_count_posts('testimonial')->publish;
    
    // Only show if no testimonials exist
    if ($testimonials_count > 0) {
        return;
    }
    
    ?>
    <div class="notice notice-info is-dismissible">
        <p><?php _e('No testimonials found. Would you like to create sample testimonials?', 'stylefolio'); ?></p>
        <p>
            <a href="<?php echo esc_url(add_query_arg('create_sample_testimonials', '1')); ?>" class="button button-primary">
                <?php _e('Create Sample Testimonials', 'stylefolio'); ?>
            </a>
            <a href="#" class="button dismiss-notice">
                <?php _e('No Thanks', 'stylefolio'); ?>
            </a>
        </p>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $('.dismiss-notice').on('click', function(e) {
                e.preventDefault();
                $(this).closest('.notice').remove();
                $.post(ajaxurl, {
                    action: 'dismiss_testimonial_sample_notice'
                });
            });
        });
    </script>
    <?php
}
add_action('admin_notices', 'stylefolio_testimonial_admin_notice');

/**
 * Ajax handler to dismiss notice
 */
function stylefolio_dismiss_testimonial_notice() {
    update_option('stylefolio_sample_testimonials_created', true);
    wp_die();
}
add_action('wp_ajax_dismiss_testimonial_sample_notice', 'stylefolio_dismiss_testimonial_notice');