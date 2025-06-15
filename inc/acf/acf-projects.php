<?php
/**
 * ACF Fields for Portfolio Projects
 *
 * @package Portfolio_Pro
 * @version 1.0
 * @author abdulhaseeb2002
 * @updated 2025-06-15 15:30:00
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register ACF Fields for Portfolio Projects
 */
function portfolio_pro_register_projects_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }
    
    // Project Category Fields
    acf_add_local_field_group(array(
        'key' => 'group_project_category',
        'title' => 'Project Category Settings',
        'fields' => array(
            array(
                'key' => 'field_category_icon',
                'label' => 'Category Icon',
                'name' => 'category_icon',
                'type' => 'text',
                'instructions' => 'Enter Font Awesome icon class (e.g., fas fa-code)',
                'default_value' => 'fas fa-code',
                'placeholder' => 'fas fa-code',
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
                    'value' => 'project_category',
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
    
    // Individual Project Fields
    acf_add_local_field_group(array(
        'key' => 'group_project',
        'title' => 'Project Details',
        'fields' => array(
            array(
                'key' => 'field_project_category',
                'label' => 'Project Category',
                'name' => 'project_category',
                'type' => 'post_object',
                'instructions' => 'Select the category this project belongs to',
                'required' => 1,
                'post_type' => array(
                    0 => 'project_category',
                ),
                'return_format' => 'id',
                'ui' => 1,
            ),
            array(
                'key' => 'field_project_featured',
                'label' => 'Featured Project',
                'name' => 'project_featured',
                'type' => 'true_false',
                'instructions' => 'Mark this project as featured to highlight it',
                'default_value' => 0,
                'ui' => 1,
            ),
            array(
                'key' => 'field_project_client',
                'label' => 'Client Name',
                'name' => 'project_client',
                'type' => 'text',
                'instructions' => 'Enter the client name (optional)',
            ),
            array(
                'key' => 'field_project_date',
                'label' => 'Project Date',
                'name' => 'project_date',
                'type' => 'date_picker',
                'instructions' => 'When was this project completed?',
                'display_format' => 'F j, Y',
                'return_format' => 'F j, Y',
                'first_day' => 1,
            ),
            array(
                'key' => 'field_project_url',
                'label' => 'Project URL',
                'name' => 'project_url',
                'type' => 'url',
                'instructions' => 'Enter the URL to the live project (optional)',
            ),
            // Project Images - Individual Upload Fields (more reliable than gallery)
            array(
                'key' => 'field_project_image_1',
                'label' => 'Project Image 1',
                'name' => 'project_image_1',
                'type' => 'image',
                'instructions' => 'Upload the first project image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            array(
                'key' => 'field_project_image_2',
                'label' => 'Project Image 2',
                'name' => 'project_image_2',
                'type' => 'image',
                'instructions' => 'Upload the second project image (optional)',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            array(
                'key' => 'field_project_image_3',
                'label' => 'Project Image 3',
                'name' => 'project_image_3',
                'type' => 'image',
                'instructions' => 'Upload the third project image (optional)',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            array(
                'key' => 'field_project_image_4',
                'label' => 'Project Image 4',
                'name' => 'project_image_4',
                'type' => 'image',
                'instructions' => 'Upload the fourth project image (optional)',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            array(
                'key' => 'field_project_image_5',
                'label' => 'Project Image 5',
                'name' => 'project_image_5',
                'type' => 'image',
                'instructions' => 'Upload the fifth project image (optional)',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            array(
                'key' => 'field_project_tech',
                'label' => 'Technologies Used',
                'name' => 'project_tech',
                'type' => 'textarea',
                'instructions' => 'Enter the technologies used in this project (comma-separated)',
                'rows' => 2,
            ),
            array(
                'key' => 'field_project_order',
                'label' => 'Display Order',
                'name' => 'project_order',
                'type' => 'number',
                'instructions' => 'Enter the order in which this project should appear (lower numbers appear first)',
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
                    'value' => 'project',
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
    
    // Portfolio Section Settings
    acf_add_local_field_group(array(
        'key' => 'group_portfolio_settings',
        'title' => 'Portfolio Section Settings',
        'fields' => array(
            array(
                'key' => 'field_portfolio_title',
                'label' => 'Section Title',
                'name' => 'portfolio_title',
                'type' => 'text',
                'instructions' => 'Enter the main title for the portfolio section',
                'default_value' => 'Portfolio',
                'placeholder' => 'Portfolio',
            ),
            array(
                'key' => 'field_portfolio_subtitle',
                'label' => 'Section Subtitle',
                'name' => 'portfolio_subtitle',
                'type' => 'text',
                'instructions' => 'Enter the subtitle for the portfolio section',
                'default_value' => 'My Recent Work',
                'placeholder' => 'My Recent Work',
            ),
            array(
                'key' => 'field_portfolio_description',
                'label' => 'Section Description',
                'name' => 'portfolio_description',
                'type' => 'textarea',
                'instructions' => 'Enter a brief description for the portfolio section',
                'default_value' => 'Explore my latest projects showcasing creative solutions and technical expertise across various domains.',
                'placeholder' => 'Enter a brief description',
                'rows' => 4,
            ),
            array(
                'key' => 'field_portfolio_display_count',
                'label' => 'Number of Projects to Display',
                'name' => 'portfolio_display_count',
                'type' => 'number',
                'instructions' => 'How many projects to show on the homepage (0 for all)',
                'default_value' => 6,
                'min' => 0,
                'max' => 30,
                'step' => 1,
            ),
            array(
                'key' => 'field_portfolio_layout',
                'label' => 'Layout Style',
                'name' => 'portfolio_layout',
                'type' => 'select',
                'instructions' => 'Choose the layout style for the portfolio grid',
                'choices' => array(
                    'grid' => 'Grid Layout',
                    'masonry' => 'Masonry Grid',
                    'carousel' => 'Carousel',
                ),
                'default_value' => 'grid',
                'return_format' => 'value',
                'multiple' => 0,
                'allow_null' => 0,
                'ui' => 1,
            ),
            array(
                'key' => 'field_portfolio_cta_text',
                'label' => 'View All Button Text',
                'name' => 'portfolio_cta_text',
                'type' => 'text',
                'default_value' => 'View All Projects',
                'placeholder' => 'View All Projects',
            ),
            array(
                'key' => 'field_portfolio_cta_url',
                'label' => 'View All Button URL',
                'name' => 'portfolio_cta_url',
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
                    'value' => 'portfolio_settings',
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
add_action('acf/init', 'portfolio_pro_register_projects_acf_fields');

/**
 * Helper function to get project gallery images from individual fields
 */
function portfolio_pro_get_project_gallery($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $gallery = array();
    
    // Check for individual image fields
    for ($i = 1; $i <= 5; $i++) {
        $image = get_field("project_image_$i", $post_id);
        if ($image && is_array($image)) {
            $gallery[] = $image;
        }
    }
    
    return $gallery;
}
