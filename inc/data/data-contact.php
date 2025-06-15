<?php
/**
 * Default Contact Section Data
 *
 * @package Stylefolio
 * @version 1.0
 * @author abdulhaseeb2002
 * @updated 2025-06-12 16:37:40
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Set default contact options if they don't exist
 */
function stylefolio_set_default_contact_options() {
    // Check if we've already created default options
    if (get_option('stylefolio_contact_defaults_set')) {
        return;
    }
      // Default contact information for customizer
    $default_customizer_options = array(
        'contact_section_title' => 'Contact Me',
        'contact_section_subtitle' => 'Get In Touch',
        'contact_section_description' => 'Let\'s discuss your next project and turn your ideas into reality. I\'m here to help bring your vision to life.',
        'contact_phone' => '+1 (555) 123-4567',
        'contact_email' => get_option('admin_email') ?: 'hello@yourdomain.com',
        'contact_address' => 'San Francisco, CA, USA',
        'contact_form_email' => get_option('admin_email') ?: 'admin@yourdomain.com',
        'contact_form_success_message' => 'Thank you for your message! I\'ll get back to you soon.',
    );
      // Set customizer theme mods if they don't exist
    foreach ($default_customizer_options as $key => $value) {
        if (get_theme_mod($key) === false) {
            set_theme_mod($key, $value);
        }
    }
    
    // Set default social media links if they don't exist
    $default_social_mods = array(
        'hero_social_linkedin' => 'https://linkedin.com/in/yourprofile',
        'hero_social_github' => 'https://github.com/yourusername',
        'hero_social_twitter' => 'https://twitter.com/yourusername',
        'hero_social_medium' => 'https://medium.com/@yourusername',
        'hero_social_linkedin_enabled' => true,
        'hero_social_github_enabled' => true,
        'hero_social_twitter_enabled' => true,
        'hero_social_medium_enabled' => false,
        'hero_social_custom_enabled' => false,
    );
    
    foreach ($default_social_mods as $key => $value) {
        if (get_theme_mod($key) === false) {
            set_theme_mod($key, $value);
        }
    }
    
    // Default contact information for legacy support
    $default_options = array(
        'contact_section_title' => 'Contact Me',
        'contact_section_subtitle' => 'Get In Touch',
        'contact_section_description' => 'Let\'s discuss your next project and turn your ideas into reality. I\'m here to help bring your vision to life.',
        'contact_email' => get_option('admin_email') ?: 'hello@yourdomain.com',
        'contact_phone' => '+1 (555) 123-4567',
        'contact_location' => 'San Francisco, CA, USA',
        'contact_address' => 'San Francisco, CA, USA',
        'contact_enable_form' => true,
        'contact_store_submissions' => false,
        'contact_success_message' => 'Thank you! Your message has been sent successfully.',
        'contact_error_message' => 'Oops! Something went wrong. Please try again.',
    );
    
    // Default social media links
    $default_social_links = array(
        array(
            'platform' => 'linkedin',
            'url' => 'https://linkedin.com/',
        ),
        array(
            'platform' => 'github',
            'url' => 'https://github.com/',
        ),
        array(
            'platform' => 'twitter',
            'url' => 'https://twitter.com/',
        ),
    );
    
    // Set options in the database
    foreach ($default_options as $key => $value) {
        update_option('stylefolio_' . $key, $value);
    }
    
    // Set social links
    update_option('stylefolio_social_links', $default_social_links);
    
    // Mark as set
    update_option('stylefolio_contact_defaults_set', true);
}

/**
 * Initialize default contact data
 */
function stylefolio_init_contact_data() {
    // Set default options
    stylefolio_set_default_contact_options();
}
add_action('after_setup_theme', 'stylefolio_init_contact_data');

/**
 * Populate ACF fields if they exist
 */
function stylefolio_populate_contact_acf_fields() {
    // Only run if ACF is active and we have options pages
    if (!function_exists('acf_add_options_page') || !function_exists('update_field')) {
        return;
    }
    
    // Check if we've already populated ACF fields
    if (get_option('stylefolio_contact_acf_populated')) {
        return;
    }
      // Get default options
    $options = array(
        'contact_section_title',
        'contact_section_subtitle',
        'contact_section_description',
        'contact_email',
        'contact_phone',
        'contact_location',
        'contact_address',
        'contact_enable_form',
        'contact_store_submissions',
        'contact_success_message',
        'contact_error_message',
    );
    
    // Update ACF fields
    foreach ($options as $option) {
        $value = get_option('stylefolio_' . $option);
        if ($value !== false) {
            update_field($option, $value, 'option');
        }
    }
    
    // Update social links
    $social_links = get_option('stylefolio_social_links');
    if ($social_links) {
        update_field('social_links', $social_links, 'option');
    }
    
    // Mark as populated
    update_option('stylefolio_contact_acf_populated', true);
}
add_action('acf/init', 'stylefolio_populate_contact_acf_fields', 20);