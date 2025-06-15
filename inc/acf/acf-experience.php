<?php
/**
 * ACF Fields for Work Experience - Simple Version
 *
 * @package Stylefolio
 * @version 1.0
 * @author abdulhaseeb2002
 * @updated 2025-06-14 14:20:22
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register simplified ACF fields for work experience
 */
function stylefolio_register_experience_acf_fields() {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_experience_fields',
            'title' => 'Experience Details',
            'fields' => array(
                array(
                    'key' => 'field_job_title',
                    'label' => 'Job Title',
                    'name' => 'job_title',
                    'type' => 'text',
                    'instructions' => 'Enter your job title',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_company_name',
                    'label' => 'Company Name',
                    'name' => 'company_name',
                    'type' => 'text',
                    'instructions' => 'Enter the company name',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_company_location',
                    'label' => 'Location',
                    'name' => 'company_location',
                    'type' => 'text',
                    'instructions' => 'Enter the job location (city, country)',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_company_url',
                    'label' => 'Company Website',
                    'name' => 'company_url',
                    'type' => 'url',
                    'instructions' => 'Enter the company website URL',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_job_type',
                    'label' => 'Employment Type',
                    'name' => 'job_type',
                    'type' => 'select',
                    'instructions' => 'Select the employment type',
                    'required' => 0,
                    'choices' => array(
                        'full-time' => 'Full-time',
                        'part-time' => 'Part-time',
                        'contract' => 'Contract',
                        'freelance' => 'Freelance',
                        'internship' => 'Internship',
                        'remote' => 'Remote',
                    ),
                    'default_value' => 'full-time',
                ),
                array(
                    'key' => 'field_start_date',
                    'label' => 'Start Date',
                    'name' => 'start_date',
                    'type' => 'date_picker',
                    'instructions' => 'Select the start date',
                    'required' => 1,
                    'display_format' => 'F Y',
                    'return_format' => 'F Y',
                    'first_day' => 1,
                ),
                array(
                    'key' => 'field_end_date',
                    'label' => 'End Date',
                    'name' => 'end_date',
                    'type' => 'date_picker',
                    'instructions' => 'Select the end date (leave empty if current job)',
                    'required' => 0,
                    'display_format' => 'F Y',
                    'return_format' => 'F Y',
                    'first_day' => 1,
                ),
                array(
                    'key' => 'field_is_current',
                    'label' => 'Current Job',
                    'name' => 'is_current',
                    'type' => 'true_false',
                    'instructions' => 'Is this your current job?',
                    'required' => 0,
                    'default_value' => 0,
                    'ui' => 1,
                ),
                // SIMPLIFIED RESPONSIBILITIES FIELD - Using textarea instead of repeater
                array(
                    'key' => 'field_responsibilities_text',
                    'label' => 'Key Responsibilities',
                    'name' => 'responsibilities_text',
                    'type' => 'textarea',
                    'instructions' => 'Add key responsibilities or achievements (one per line)',
                    'required' => 0,
                    'placeholder' => 'Enter each responsibility on a new line',
                    'rows' => 8,
                ),
                array(
                    'key' => 'field_technologies',
                    'label' => 'Technologies Used',
                    'name' => 'technologies',
                    'type' => 'text',
                    'instructions' => 'Enter technologies used, separated by commas',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_experience_order',
                    'label' => 'Display Order',
                    'name' => 'experience_order',
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
                        'value' => 'experience',
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
            'active' => true,
        ));
        
        // Experience Section Settings
        // (keep the same as before)
    }
}
add_action('acf/init', 'stylefolio_register_experience_acf_fields');

/**
 * Convert textarea values to repeater format
 */
function stylefolio_convert_textarea_to_repeater($post_id) {
    // Check if we're saving an experience post
    if (get_post_type($post_id) !== 'experience') {
        return;
    }
    
    // Get the text area value
    $responsibilities_text = get_field('responsibilities_text', $post_id);
    
    if (!empty($responsibilities_text)) {
        // Split by new lines
        $lines = explode("\n", $responsibilities_text);
        
        // Format for repeater
        $repeater_values = array();
        foreach ($lines as $line) {
            $line = trim($line);
            if (!empty($line)) {
                $repeater_values[] = array(
                    'responsibility' => $line
                );
            }
        }
        
        // Save to a hidden field that the template uses
        update_post_meta($post_id, 'responsibilities', $repeater_values);
    }
}
add_action('acf/save_post', 'stylefolio_convert_textarea_to_repeater', 20);