<?php
/**
 * ACF Fields for Testimonials
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
 * Register ACF fields for testimonials
 */
function stylefolio_register_testimonial_acf_fields() {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_testimonial_fields',
            'title' => 'Testimonial Details',
            'fields' => array(
                array(
                    'key' => 'field_client_name',
                    'label' => 'Client Name',
                    'name' => 'client_name',
                    'type' => 'text',
                    'instructions' => 'Enter the client\'s name',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_client_position',
                    'label' => 'Client Position',
                    'name' => 'client_position',
                    'type' => 'text',
                    'instructions' => 'Enter the client\'s position',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_client_company',
                    'label' => 'Client Company',
                    'name' => 'client_company',
                    'type' => 'text',
                    'instructions' => 'Enter the client\'s company',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_client_quote',
                    'label' => 'Client Quote',
                    'name' => 'client_quote',
                    'type' => 'textarea',
                    'instructions' => 'Enter the testimonial text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_client_rating',
                    'label' => 'Client Rating',
                    'name' => 'client_rating',
                    'type' => 'number',
                    'instructions' => 'Enter a rating from 1-5',
                    'required' => 0,
                    'min' => 1,
                    'max' => 5,
                    'step' => 0.5,
                    'default_value' => 5,
                ),
                array(
                    'key' => 'field_testimonial_order',
                    'label' => 'Display Order',
                    'name' => 'testimonial_order',
                    'type' => 'number',
                    'instructions' => 'Enter a number to control the display order (lower numbers appear first)',
                    'required' => 0,
                    'default_value' => 10,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'testimonial',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'permalink',
                1 => 'excerpt',
                2 => 'discussion',
                3 => 'comments',
                4 => 'slug',
                5 => 'author',
                6 => 'format',
                7 => 'categories',
                8 => 'tags',
                9 => 'send-trackbacks',
            ),
        ));
        
        // Section settings
        acf_add_local_field_group(array(
            'key' => 'group_testimonial_section_settings',
            'title' => 'Testimonials Section Settings',
            'fields' => array(
                array(
                    'key' => 'field_testimonial_section_title',
                    'label' => 'Section Title',
                    'name' => 'testimonial_section_title',
                    'type' => 'text',
                    'instructions' => 'Enter the section title',
                    'required' => 0,
                    'default_value' => 'Testimonials',
                ),
                array(
                    'key' => 'field_testimonial_section_subtitle',
                    'label' => 'Section Subtitle',
                    'name' => 'testimonial_section_subtitle',
                    'type' => 'text',
                    'instructions' => 'Enter the section subtitle',
                    'required' => 0,
                    'default_value' => 'What Clients Say',
                ),
                array(
                    'key' => 'field_testimonial_section_layout',
                    'label' => 'Layout Style',
                    'name' => 'testimonial_section_layout',
                    'type' => 'select',
                    'instructions' => 'Choose how to display testimonials',
                    'required' => 0,
                    'choices' => array(
                        'slider' => 'Slider/Carousel',
                        'grid' => 'Grid Layout',
                    ),
                    'default_value' => 'slider',
                ),
                array(
                    'key' => 'field_testimonial_section_count',
                    'label' => 'Number to Display',
                    'name' => 'testimonial_section_count',
                    'type' => 'number',
                    'instructions' => 'Enter the number of testimonials to display (0 for all)',
                    'required' => 0,
                    'default_value' => 6,
                    'min' => 0,
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
add_action('acf/init', 'stylefolio_register_testimonial_acf_fields');