<?php
/**
 * Customizer API implementation
 *
 * @package Portfolio_Pro
 * @version 1.0.0
 * @author abdulhaseeb2002
 * @updated 2025-06-15
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add customizer sections, settings, and controls
 */
function portfolio_pro_customize_register($wp_customize) {
    
    // Add Contact Information Section
    $wp_customize->add_section('contact_information', array(
        'title'       => __('Contact Information', 'portfolio-pro'),
        'description' => __('Configure contact information and form settings', 'portfolio-pro'),
        'priority'    => 30,
    ));
    
    // Contact Email Setting
    $wp_customize->add_setting('contact_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('contact_email', array(
        'label'       => __('Admin Email Address', 'portfolio-pro'),
        'description' => __('This email will receive contact form submissions', 'portfolio-pro'),
        'section'     => 'contact_information',
        'type'        => 'email',
        'priority'    => 10,
    ));
    
    // Contact Phone Setting
    $wp_customize->add_setting('contact_phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('contact_phone', array(
        'label'       => __('Phone Number', 'portfolio-pro'),
        'description' => __('Display phone number on contact section', 'portfolio-pro'),
        'section'     => 'contact_information',
        'type'        => 'text',
        'priority'    => 20,
    ));
    
    // Contact Location Setting
    $wp_customize->add_setting('contact_location', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('contact_location', array(
        'label'       => __('Location/Address', 'portfolio-pro'),
        'description' => __('Display location on contact section', 'portfolio-pro'),
        'section'     => 'contact_information',
        'type'        => 'text',
        'priority'    => 30,
    ));
    
    // Enable Contact Form Setting
    $wp_customize->add_setting('enable_contact_form', array(
        'default'           => true,
        'sanitize_callback' => 'portfolio_pro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('enable_contact_form', array(
        'label'       => __('Enable Contact Form', 'portfolio-pro'),
        'description' => __('Show/hide the contact form on the website', 'portfolio-pro'),
        'section'     => 'contact_information',
        'type'        => 'checkbox',
        'priority'    => 40,
    ));
    
    // Store Contact Submissions Setting
    $wp_customize->add_setting('store_contact_submissions', array(
        'default'           => true,
        'sanitize_callback' => 'portfolio_pro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('store_contact_submissions', array(
        'label'       => __('Store Contact Submissions', 'portfolio-pro'),
        'description' => __('Save contact form submissions in the database as custom posts', 'portfolio-pro'),
        'section'     => 'contact_information',
        'type'        => 'checkbox',
        'priority'    => 50,
    ));
    
    // Email Notifications Setting
    $wp_customize->add_setting('email_notifications', array(
        'default'           => true,
        'sanitize_callback' => 'portfolio_pro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('email_notifications', array(
        'label'       => __('Email Notifications', 'portfolio-pro'),
        'description' => __('Send email notifications when contact form is submitted', 'portfolio-pro'),
        'section'     => 'contact_information',
        'type'        => 'checkbox',
        'priority'    => 60,
    ));
    
}
add_action('customize_register', 'portfolio_pro_customize_register');


/**
 * Sanitize select options
 */
function portfolio_pro_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}