<?php
/**
 * Admin Helper Functions for Portfolio Pro
 *
 * @package Portfolio_Pro
 * @version 1.0
 * @author abdulhaseeb2002
 * @updated 2025-06-11 07:10:54
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if a post type has default data initialized
 *
 * @param string $post_type Post type to check
 * @return bool Whether the post type has data
 */
function portfolio_pro_post_type_has_data($post_type) {
    $args = array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => 1,
    );
    
    $query = new WP_Query($args);
    return $query->have_posts();
}

/**
 * Get settings post for a section
 *
 * @param string $settings_post_type Settings post type
 * @return int|false Post ID or false if not found
 */
function portfolio_pro_get_section_settings($settings_post_type) {
    $args = array(
        'post_type' => $settings_post_type,
        'post_status' => 'publish',
        'posts_per_page' => 1,
    );
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        $query->the_post();
        $id = get_the_ID();
        wp_reset_postdata();
        return $id;
    }
    
    return false;
}

/**
 * Check if all portfolio sections have been initialized
 *
 * @return bool Whether all sections are initialized
 */
function portfolio_pro_all_sections_initialized() {
    $options = array(
        'portfolio_pro_skills_data_initialized',
        'portfolio_pro_projects_data_initialized',
        'portfolio_pro_testimonials_data_initialized',
        'portfolio_pro_experience_data_initialized',
        'portfolio_pro_education_data_initialized',
        'portfolio_pro_services_data_initialized',
    );
    
    foreach ($options as $option) {
        if (!get_option($option)) {
            return false;
        }
    }
    
    return true;
}

/**
 * Get portfolio section status (initialized/empty)
 *
 * @return array Section status
 */
function portfolio_pro_get_sections_status() {
    $sections = array(
        'skills' => array(
            'name' => 'Skills & Services',
            'post_type' => 'skill',
            'initialized' => get_option('portfolio_pro_skills_data_initialized'),
            'has_data' => portfolio_pro_post_type_has_data('skill'),
            'settings_id' => portfolio_pro_get_section_settings('skills_setting'),
            'admin_url' => admin_url('edit.php?post_type=skill'),
        ),
        'projects' => array(
            'name' => 'Portfolio Projects',
            'post_type' => 'project',
            'initialized' => get_option('portfolio_pro_projects_data_initialized'),
            'has_data' => portfolio_pro_post_type_has_data('project'),
            'settings_id' => portfolio_pro_get_section_settings('portfolio_settings'),
            'admin_url' => admin_url('edit.php?post_type=project'),
        ),
        'testimonials' => array(
            'name' => 'Testimonials',
            'post_type' => 'testimonial',
            'initialized' => get_option('portfolio_pro_testimonials_data_initialized'),
            'has_data' => portfolio_pro_post_type_has_data('testimonial'),
            'settings_id' => portfolio_pro_get_section_settings('testimonial_setting'),
            'admin_url' => admin_url('edit.php?post_type=testimonial'),
        ),
        'experience' => array(
            'name' => 'Work Experience',
            'post_type' => 'experience',
            'initialized' => get_option('portfolio_pro_experience_data_initialized'),
            'has_data' => portfolio_pro_post_type_has_data('experience'),
            'settings_id' => portfolio_pro_get_section_settings('experience_setting'),
            'admin_url' => admin_url('edit.php?post_type=experience'),
        ),
        'education' => array(
            'name' => 'Education',
            'post_type' => 'education',
            'initialized' => get_option('portfolio_pro_education_data_initialized'),
            'has_data' => portfolio_pro_post_type_has_data('education'),
            'settings_id' => portfolio_pro_get_section_settings('education_setting'),
            'admin_url' => admin_url('edit.php?post_type=education'),
        ),
        'services' => array(
            'name' => 'Services',
            'post_type' => 'service',
            'initialized' => get_option('portfolio_pro_services_data_initialized'),
            'has_data' => portfolio_pro_post_type_has_data('service'),
            'settings_id' => portfolio_pro_get_section_settings('service_setting'),
            'admin_url' => admin_url('edit.php?post_type=service'),
        ),
    );
    
    return $sections;
}

/**
 * Add a highlight effect to admin menu items for portfolio sections
 */
function portfolio_pro_highlight_menu_items() {
    // Only run in admin
    if (!is_admin()) {
        return;
    }
    
    // Add custom CSS to highlight portfolio section menu items
    add_action('admin_head', function() {
        ?>
        <style>
            /* Highlight Portfolio section menu items */
            #adminmenu li.menu-top.current a.menu-top,
            #adminmenu li a.wp-has-current-submenu {
                background-color: #0073aa;
                color: #fff;
            }
            
            /* Portfolio sections dashboard widget styling */
            #portfolio_pro_sections_widget .inside {
                padding: 0;
                margin: 0;
            }
            
            #portfolio_pro_sections_widget .portfolio-widget-sections ul {
                padding: 0 12px;
            }
            
            #portfolio_pro_sections_widget .portfolio-widget-sections ul li {
                margin-bottom: 8px;
            }
            
            #portfolio_pro_sections_widget .portfolio-widget-sections p {
                padding: 0 12px 12px;
                border-top: 1px solid #eee;
                margin-top: 12px;
            }
        </style>
        <?php
    });
}
add_action('init', 'portfolio_pro_highlight_menu_items');