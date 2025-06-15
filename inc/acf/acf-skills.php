<?php
/**
 * ACF Fields for Skills Section
 *
 * @package Portfolio_Pro
 * @version 1.0
 * @author abdulhaseeb2002
 * @updated 2025-06-11 06:58:49
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register ACF Fields for Skills section
 */
function portfolio_pro_register_skills_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }
    
    // Skill Category Fields
    acf_add_local_field_group(array(
        'key' => 'group_skill_category',
        'title' => 'Skill Category Settings',
        'fields' => array(
            array(
                'key' => 'field_category_icon',
                'label' => 'Category Icon',
                'name' => 'category_icon',
                'type' => 'text',
                'instructions' => 'Enter Font Awesome icon class (e.g., fas fa-laptop-code)',
                'default_value' => 'fas fa-laptop-code',
                'placeholder' => 'fas fa-laptop-code',
            ),
            array(
                'key' => 'field_category_order',
                'label' => 'Display Order',
                'name' => 'category_order',
                'type' => 'number',
                'instructions' => 'Enter the order in which this category should appear (lower numbers appear first)',
                'default_value' => 10,
                'min' => 1,
                'max' => 100,
                'step' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'skill_category',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));
    
    // Individual Skill Fields
    acf_add_local_field_group(array(
        'key' => 'group_skill',
        'title' => 'Skill Details',
        'fields' => array(
            array(
                'key' => 'field_skill_category',
                'label' => 'Skill Category',
                'name' => 'skill_category',
                'type' => 'post_object',
                'instructions' => 'Select the category this skill belongs to',
                'required' => 1,
                'post_type' => array(
                    0 => 'skill_category',
                ),
                'return_format' => 'id',
                'ui' => 1,
            ),
            array(
                'key' => 'field_skill_icon',
                'label' => 'Skill Icon',
                'name' => 'skill_icon',
                'type' => 'text',
                'instructions' => 'Enter Font Awesome icon class (e.g., fab fa-html5)',
                'default_value' => 'fas fa-code',
                'placeholder' => 'fas fa-code',
            ),
            array(
                'key' => 'field_skill_tech',
                'label' => 'Technologies/Tools',
                'name' => 'skill_tech',
                'type' => 'text',
                'instructions' => 'Enter comma-separated list of technologies or tools',
                'placeholder' => 'HTML5, CSS3, JavaScript, React',
            ),
            array(
                'key' => 'field_skill_order',
                'label' => 'Display Order',
                'name' => 'skill_order',
                'type' => 'number',
                'instructions' => 'Enter the order in which this skill should appear (lower numbers appear first)',
                'default_value' => 10,
                'min' => 1,
                'max' => 100,
                'step' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'skill',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));
    
    // Technical Skill Fields
    acf_add_local_field_group(array(
        'key' => 'group_tech_skill',
        'title' => 'Technical Skill Details',
        'fields' => array(
            array(
                'key' => 'field_skill_percentage',
                'label' => 'Percentage',
                'name' => 'skill_percentage',
                'type' => 'range',
                'instructions' => 'Select your proficiency level for this skill',
                'required' => 1,
                'min' => 0,
                'max' => 100,
                'step' => 5,
                'default_value' => 80,
            ),
            array(
                'key' => 'field_tech_skill_order',
                'label' => 'Display Order',
                'name' => 'skill_order',
                'type' => 'number',
                'instructions' => 'Enter the order in which this skill should appear (lower numbers appear first)',
                'default_value' => 10,
                'min' => 1,
                'max' => 100,
                'step' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'tech_skill',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));
    
    // Skills Section Settings
    acf_add_local_field_group(array(
        'key' => 'group_skills_settings',
        'title' => 'Skills Section Settings',
        'fields' => array(
            array(
                'key' => 'field_skills_title',
                'label' => 'Section Title',
                'name' => 'skills_title',
                'type' => 'text',
                'instructions' => 'Enter the main title for the skills section',
                'default_value' => 'Skills & Services',
                'placeholder' => 'Skills & Services',
            ),
            array(
                'key' => 'field_skills_subtitle',
                'label' => 'Section Subtitle',
                'name' => 'skills_subtitle',
                'type' => 'text',
                'instructions' => 'Enter the subtitle for the skills section',
                'default_value' => 'What I can do for you',
                'placeholder' => 'What I can do for you',
            ),
            array(
                'key' => 'field_skills_description',
                'label' => 'Section Description',
                'name' => 'skills_description',
                'type' => 'textarea',
                'instructions' => 'Enter a brief description for the skills section',
                'default_value' => 'Leveraging cutting-edge technologies to deliver exceptional digital experiences that blend creativity with technical excellence.',
                'placeholder' => 'Enter a brief description',
                'rows' => 4,
            ),
            array(
                'key' => 'field_tech_skills_title',
                'label' => 'Technical Skills Title',
                'name' => 'tech_skills_title',
                'type' => 'text',
                'instructions' => 'Enter the title for the technical skills section',
                'default_value' => 'Technical Proficiency',
                'placeholder' => 'Technical Proficiency',
            ),
            array(
                'key' => 'field_skills_cta_title',
                'label' => 'CTA Title',
                'name' => 'skills_cta_title',
                'type' => 'text',
                'default_value' => "Let's work together on your next project",
                'placeholder' => "Let's work together on your next project",
            ),
            array(
                'key' => 'field_skills_cta_subtitle',
                'label' => 'CTA Subtitle',
                'name' => 'skills_cta_subtitle',
                'type' => 'text',
                'default_value' => "I'm available for freelance projects and full-time employment",
                'placeholder' => "I'm available for freelance projects",
            ),
            array(
                'key' => 'field_skills_cta_btn1_text',
                'label' => 'Button 1 Text',
                'name' => 'skills_cta_btn1_text',
                'type' => 'text',
                'default_value' => 'Get in Touch',
                'placeholder' => 'Get in Touch',
            ),
            array(
                'key' => 'field_skills_cta_btn1_url',
                'label' => 'Button 1 URL',
                'name' => 'skills_cta_btn1_url',
                'type' => 'text',
                'default_value' => '#contact',
                'placeholder' => '#contact',
            ),
            array(
                'key' => 'field_skills_cta_btn2_text',
                'label' => 'Button 2 Text',
                'name' => 'skills_cta_btn2_text',
                'type' => 'text',
                'default_value' => 'View My Work',
                'placeholder' => 'View My Work',
            ),
            array(
                'key' => 'field_skills_cta_btn2_url',
                'label' => 'Button 2 URL',
                'name' => 'skills_cta_btn2_url',
                'type' => 'text',
                'default_value' => '#portfolio',
                'placeholder' => '#portfolio',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'skills_setting',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));
}
add_action('acf/init', 'portfolio_pro_register_skills_acf_fields');