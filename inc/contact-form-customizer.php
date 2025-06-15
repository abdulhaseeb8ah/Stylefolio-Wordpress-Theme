<?php
/**
 * Contact Form Customizer Settings
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
 * Add Contact Form settings to the Customizer
 */
function stylefolio_contact_form_customizer_settings($wp_customize) {
    // Add Contact Form section
    $wp_customize->add_section('stylefolio_contact_form_section', array(
        'title'       => __('Contact Form Settings', 'stylefolio'),
        'description' => __('Configure settings for your contact form.', 'stylefolio'),
        'priority'    => 120,
    ));
    
    // Add Contact Information section
    $wp_customize->add_section('stylefolio_contact_info_section', array(
        'title'       => __('Contact Information', 'stylefolio'),
        'description' => __('Configure your contact information displayed on the contact section.', 'stylefolio'),
        'priority'    => 121,
    ));
    
    // Contact Section Title
    $wp_customize->add_setting('contact_section_title', array(
        'default'           => __('Contact Me', 'stylefolio'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('contact_section_title', array(
        'label'       => __('Section Title', 'stylefolio'),
        'description' => __('Enter the main title for the contact section.', 'stylefolio'),
        'section'     => 'stylefolio_contact_info_section',
        'type'        => 'text',
    ));
    
    // Contact Section Subtitle
    $wp_customize->add_setting('contact_section_subtitle', array(
        'default'           => __('Get In Touch', 'stylefolio'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('contact_section_subtitle', array(
        'label'       => __('Section Subtitle', 'stylefolio'),
        'description' => __('Enter the subtitle for the contact section.', 'stylefolio'),
        'section'     => 'stylefolio_contact_info_section',
        'type'        => 'text',
    ));
    
    // Contact Section Description
    $wp_customize->add_setting('contact_section_description', array(
        'default'           => __('Let\'s discuss your next project and turn your ideas into reality. I\'m here to help bring your vision to life.', 'stylefolio'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('contact_section_description', array(
        'label'       => __('Section Description', 'stylefolio'),
        'description' => __('Enter a description for the contact section.', 'stylefolio'),
        'section'     => 'stylefolio_contact_info_section',
        'type'        => 'textarea',
    ));
    
    // Contact Phone
    $wp_customize->add_setting('contact_phone', array(
        'default'           => '+1 (555) 123-4567',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('contact_phone', array(
        'label'       => __('Phone Number', 'stylefolio'),
        'description' => __('Enter your contact phone number.', 'stylefolio'),
        'section'     => 'stylefolio_contact_info_section',
        'type'        => 'tel',
    ));
    
    // Contact Email
    $wp_customize->add_setting('contact_email', array(
        'default'           => get_option('admin_email'),
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('contact_email', array(
        'label'       => __('Email Address', 'stylefolio'),
        'description' => __('Enter your contact email address (displayed on website).', 'stylefolio'),
        'section'     => 'stylefolio_contact_info_section',
        'type'        => 'email',
    ));
    
    // Contact Address
    $wp_customize->add_setting('contact_address', array(
        'default'           => 'San Francisco, CA, USA',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('contact_address', array(
        'label'       => __('Address/Location', 'stylefolio'),
        'description' => __('Enter your location or address.', 'stylefolio'),
        'section'     => 'stylefolio_contact_info_section',
        'type'        => 'textarea',
    ));
    
    // Contact Form Email Setting
    $wp_customize->add_setting('contact_form_email', array(
        'default'           => get_option('admin_email'),
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('contact_form_email', array(
        'label'       => __('Notification Email', 'stylefolio'),
        'description' => __('Email address to receive contact form submissions. Leave empty to disable email notifications and only store submissions in the dashboard.', 'stylefolio'),
        'section'     => 'stylefolio_contact_form_section',
        'type'        => 'email',
    ));
    
    // Thank You Page Setting
    $wp_customize->add_setting('contact_form_thank_you_page', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('contact_form_thank_you_page', array(
        'label'       => __('Thank You Page', 'stylefolio'),
        'description' => __('Select a page to redirect users to after successful form submission. Leave blank to stay on the same page.', 'stylefolio'),
        'section'     => 'stylefolio_contact_form_section',
        'type'        => 'dropdown-pages',
        'allow_addition' => true,
    ));
    
    // Success Message
    $wp_customize->add_setting('contact_form_success_message', array(
        'default'           => __('Thank you for your message! I\'ll get back to you soon.', 'stylefolio'),
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('contact_form_success_message', array(
        'label'       => __('Success Message', 'stylefolio'),
        'description' => __('Message to display after successful form submission (if not redirecting to a thank you page).', 'stylefolio'),
        'section'     => 'stylefolio_contact_form_section',
        'type'        => 'textarea',
    ));
}
add_action('customize_register', 'stylefolio_contact_form_customizer_settings');