<?php
/**
 * ACF Fields for Contact Section
 *
 * @package Stylefolio
 * @version 1.0
 * @author abdulhaseeb2002
 * @updated 2025-06-12 16:33:05
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register ACF fields for contact section
 */
function stylefolio_register_contact_acf_fields() {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_contact_section_settings',
            'title' => 'Contact Section Settings',
            'fields' => array(
                array(
                    'key' => 'field_contact_section_title',
                    'label' => 'Section Title',
                    'name' => 'contact_section_title',
                    'type' => 'text',
                    'instructions' => 'Enter the section title',
                    'required' => 0,
                    'default_value' => 'Get In Touch',
                ),
                array(
                    'key' => 'field_contact_section_subtitle',
                    'label' => 'Section Subtitle',
                    'name' => 'contact_section_subtitle',
                    'type' => 'text',
                    'instructions' => 'Enter the section subtitle',
                    'required' => 0,
                    'default_value' => 'Let\'s Start a Conversation',
                ),
                array(
                    'key' => 'field_contact_section_description',
                    'label' => 'Section Description',
                    'name' => 'contact_section_description',
                    'type' => 'textarea',
                    'instructions' => 'Enter a short description for the section',
                    'required' => 0,
                    'default_value' => 'Have a project in mind or just want to say hello? Feel free to reach out!',
                ),
                array(
                    'key' => 'field_contact_info_tab',
                    'label' => 'Contact Information',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'placement' => 'top',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_contact_email',
                    'label' => 'Email Address',
                    'name' => 'contact_email',
                    'type' => 'email',
                    'instructions' => 'Enter your contact email address',
                    'required' => 0,
                    'default_value' => 'hello@yourdomain.com',
                ),
                array(
                    'key' => 'field_contact_phone',
                    'label' => 'Phone Number',
                    'name' => 'contact_phone',
                    'type' => 'text',
                    'instructions' => 'Enter your contact phone number',
                    'required' => 0,
                    'default_value' => '+1 (555) 123-4567',
                ),
                array(
                    'key' => 'field_contact_location',
                    'label' => 'Location',
                    'name' => 'contact_location',
                    'type' => 'text',
                    'instructions' => 'Enter your location (city, country)',
                    'required' => 0,
                    'default_value' => 'San Francisco, CA',
                ),
                array(
                    'key' => 'field_social_links',
                    'label' => 'Social Media Links',
                    'name' => 'social_links',
                    'type' => 'repeater',
                    'instructions' => 'Add your social media links',
                    'required' => 0,
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'table',
                    'button_label' => 'Add Social Media',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_social_platform',
                            'label' => 'Platform',
                            'name' => 'platform',
                            'type' => 'select',
                            'instructions' => '',
                            'required' => 1,
                            'choices' => array(
                                'facebook' => 'Facebook',
                                'twitter' => 'Twitter',
                                'instagram' => 'Instagram',
                                'linkedin' => 'LinkedIn',
                                'github' => 'GitHub',
                                'dribbble' => 'Dribbble',
                                'behance' => 'Behance',
                                'youtube' => 'YouTube',
                                'pinterest' => 'Pinterest',
                                'medium' => 'Medium',
                                'dev' => 'Dev.to',
                                'other' => 'Other',
                            ),
                            'default_value' => 'linkedin',
                        ),
                        array(
                            'key' => 'field_social_url',
                            'label' => 'URL',
                            'name' => 'url',
                            'type' => 'url',
                            'instructions' => '',
                            'required' => 1,
                        ),
                    ),
                ),
                array(
                    'key' => 'field_contact_form_tab',
                    'label' => 'Contact Form',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'placement' => 'top',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_contact_enable_form',
                    'label' => 'Enable Contact Form',
                    'name' => 'contact_enable_form',
                    'type' => 'true_false',
                    'instructions' => 'Enable or disable the contact form',
                    'required' => 0,
                    'default_value' => 1,
                    'ui' => 1,
                ),
                array(
                    'key' => 'field_contact_recipient_email',
                    'label' => 'Recipient Email',
                    'name' => 'contact_recipient_email',
                    'type' => 'email',
                    'instructions' => 'Enter the email address where form submissions should be sent (defaults to admin email if left blank)',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_contact_enable_form',
                                'operator' => '==',
                                'value' => 1,
                            ),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_contact_store_submissions',
                    'label' => 'Store Form Submissions',
                    'name' => 'contact_store_submissions',
                    'type' => 'true_false',
                    'instructions' => 'Store form submissions in the database',
                    'required' => 0,
                    'default_value' => 0,
                    'ui' => 1,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_contact_enable_form',
                                'operator' => '==',
                                'value' => 1,
                            ),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_contact_success_message',
                    'label' => 'Success Message',
                    'name' => 'contact_success_message',
                    'type' => 'text',
                    'instructions' => 'Message to display when form is submitted successfully',
                    'required' => 0,
                    'default_value' => 'Thank you! Your message has been sent successfully.',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_contact_enable_form',
                                'operator' => '==',
                                'value' => 1,
                            ),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_contact_error_message',
                    'label' => 'Error Message',
                    'name' => 'contact_error_message',
                    'type' => 'text',
                    'instructions' => 'Message to display when form submission fails',
                    'required' => 0,
                    'default_value' => 'Oops! Something went wrong. Please try again.',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_contact_enable_form',
                                'operator' => '==',
                                'value' => 1,
                            ),
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'theme-general-settings',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
        ));
    }
}
add_action('acf/init', 'stylefolio_register_contact_acf_fields');