<?php
/**
 * ACF Fields for Education
 *
 * @package Stylefolio
 * @version 1.0
 * @author abdulhaseeb2002
 * @updated 2025-06-12 08:57:05
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register ACF fields for education
 */
function stylefolio_register_education_acf_fields() {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_education_fields',
            'title' => 'Education Details',
            'fields' => array(
                array(
                    'key' => 'field_degree',
                    'label' => 'Degree/Certificate',
                    'name' => 'degree',
                    'type' => 'text',
                    'instructions' => 'Enter your degree or certificate title',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_institution',
                    'label' => 'Institution Name',
                    'name' => 'institution',
                    'type' => 'text',
                    'instructions' => 'Enter the institution name',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_location',
                    'label' => 'Location',
                    'name' => 'location',
                    'type' => 'text',
                    'instructions' => 'Enter the institution location (city, country)',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_institution_url',
                    'label' => 'Institution Website',
                    'name' => 'institution_url',
                    'type' => 'url',
                    'instructions' => 'Enter the institution website URL',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_education_type',
                    'label' => 'Education Type',
                    'name' => 'education_type',
                    'type' => 'select',
                    'instructions' => 'Select the type of education',
                    'required' => 0,
                    'choices' => array(
                        'bachelors' => 'Bachelor\'s Degree',
                        'masters' => 'Master\'s Degree',
                        'doctorate' => 'Doctorate/PhD',
                        'certification' => 'Certification',
                        'diploma' => 'Diploma',
                        'course' => 'Course',
                        'highschool' => 'High School',
                        'other' => 'Other',
                    ),
                    'default_value' => 'bachelors',
                ),
                array(
                    'key' => 'field_field_of_study',
                    'label' => 'Field of Study',
                    'name' => 'field_of_study',
                    'type' => 'text',
                    'instructions' => 'Enter your field of study or major',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_grade',
                    'label' => 'Grade/GPA',
                    'name' => 'grade',
                    'type' => 'text',
                    'instructions' => 'Enter your grade, GPA, or classification (e.g., "3.8/4.0", "First Class Honors")',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_education_start_date',
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
                    'key' => 'field_education_end_date',
                    'label' => 'End Date',
                    'name' => 'end_date',
                    'type' => 'date_picker',
                    'instructions' => 'Select the end date (leave empty if current)',
                    'required' => 0,
                    'display_format' => 'F Y',
                    'return_format' => 'F Y',
                    'first_day' => 1,
                ),
                array(
                    'key' => 'field_is_current_education',
                    'label' => 'Currently Studying',
                    'name' => 'is_current',
                    'type' => 'true_false',
                    'instructions' => 'Are you currently studying here?',
                    'required' => 0,
                    'default_value' => 0,
                    'ui' => 1,
                ),
                array(
                    'key' => 'field_activities',
                    'label' => 'Activities & Societies',
                    'name' => 'activities',
                    'type' => 'textarea',
                    'instructions' => 'List any extracurricular activities, clubs, or societies you participated in',
                    'required' => 0,
                ),                array(
                    'key' => 'field_achievements',
                    'label' => 'Achievements & Honors',
                    'name' => 'achievements',
                    'type' => 'textarea',
                    'instructions' => 'Add any notable achievements or honors (one per line)',
                    'required' => 0,
                    'placeholder' => 'Enter each achievement on a new line',
                    'rows' => 6,
                ),
                array(
                    'key' => 'field_courses',
                    'label' => 'Relevant Courses',
                    'name' => 'courses',
                    'type' => 'textarea',
                    'instructions' => 'List relevant courses separated by commas',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_education_order',
                    'label' => 'Display Order',
                    'name' => 'education_order',
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
                        'value' => 'education',
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
        
        // Education Section Settings
        acf_add_local_field_group(array(
            'key' => 'group_education_section_settings',
            'title' => 'Education Section Settings',
            'fields' => array(
                array(
                    'key' => 'field_education_section_title',
                    'label' => 'Section Title',
                    'name' => 'education_section_title',
                    'type' => 'text',
                    'instructions' => 'Enter the section title',
                    'required' => 0,
                    'default_value' => 'Education',
                ),
                array(
                    'key' => 'field_education_section_subtitle',
                    'label' => 'Section Subtitle',
                    'name' => 'education_section_subtitle',
                    'type' => 'text',
                    'instructions' => 'Enter the section subtitle',
                    'required' => 0,
                    'default_value' => 'Academic Background',
                ),
                array(
                    'key' => 'field_education_section_layout',
                    'label' => 'Layout Style',
                    'name' => 'education_section_layout',
                    'type' => 'select',
                    'instructions' => 'Choose how to display education entries',
                    'required' => 0,
                    'choices' => array(
                        'timeline' => 'Timeline Layout',
                        'cards' => 'Card Layout',
                    ),
                    'default_value' => 'timeline',
                ),
                array(
                    'key' => 'field_education_section_count',
                    'label' => 'Number to Display',
                    'name' => 'education_section_count',
                    'type' => 'number',
                    'instructions' => 'Enter the number of education entries to display (0 for all)',
                    'required' => 0,
                    'default_value' => 0,
                    'min' => 0,
                ),
                array(
                    'key' => 'field_education_show_achievements',
                    'label' => 'Show Achievements',
                    'name' => 'education_show_achievements',
                    'type' => 'true_false',
                    'instructions' => 'Show achievements and honors?',
                    'required' => 0,
                    'default_value' => 1,
                    'ui' => 1,
                ),
                array(
                    'key' => 'field_education_show_courses',
                    'label' => 'Show Courses',
                    'name' => 'education_show_courses',
                    'type' => 'true_false',
                    'instructions' => 'Show relevant courses?',
                    'required' => 0,
                    'default_value' => 1,
                    'ui' => 1,
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
add_action('acf/init', 'stylefolio_register_education_acf_fields');

/**
 * Convert textarea achievements to repeater format for backward compatibility
 */
function stylefolio_convert_achievements_textarea_to_repeater($post_id) {
    // Check if we're saving an education post
    if (get_post_type($post_id) !== 'education') {
        return;
    }
    
    // Get the textarea value
    $achievements_text = get_field('achievements', $post_id);
    
    if (!empty($achievements_text) && is_string($achievements_text)) {
        // Split by new lines
        $lines = explode("\n", $achievements_text);
        
        // Format for repeater (for backward compatibility with existing code)
        $repeater_values = array();
        foreach ($lines as $line) {
            $line = trim($line);
            if (!empty($line)) {
                $repeater_values[] = array(
                    'achievement' => $line
                );
            }
        }
        
        // Save to a hidden field that existing code might use
        update_post_meta($post_id, 'achievements_repeater', $repeater_values);
    }
}
add_action('acf/save_post', 'stylefolio_convert_achievements_textarea_to_repeater', 20);

/**
 * Convert existing repeater achievements to textarea format (run once)
 */
function stylefolio_convert_existing_achievements_to_textarea() {
    // Only run once by checking for a flag
    if (get_option('stylefolio_achievements_converted')) {
        return;
    }
    
    // Get all education posts
    $education_posts = get_posts(array(
        'post_type' => 'education',
        'posts_per_page' => -1,
        'post_status' => 'any'
    ));
    
    foreach ($education_posts as $education) {
        // Get the existing achievements in repeater format
        $achievements = get_field('achievements', $education->ID);
        
        // Convert to text if it's an array
        if (is_array($achievements) && !empty($achievements)) {
            $text_lines = array();
            foreach ($achievements as $item) {
                if (isset($item['achievement'])) {
                    $text_lines[] = $item['achievement'];
                }
            }
            
            if (!empty($text_lines)) {
                $text_value = implode("\n", $text_lines);
                update_field('achievements', $text_value, $education->ID);
            }
        }
    }
    
    // Set flag to avoid running this again
    update_option('stylefolio_achievements_converted', true);
}

// Run the conversion on admin init
add_action('admin_init', 'stylefolio_convert_existing_achievements_to_textarea');