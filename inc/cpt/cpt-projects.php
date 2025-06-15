<?php
/**
 * Portfolio Projects Custom Post Types
 *
 * @package Portfolio_Pro
 * @version 1.0
 * @author abdulhaseeb2002
 * @updated 2025-06-11 08:04:03
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Project Category Post Type
 */
function portfolio_pro_register_project_category_cpt() {
    $labels = array(
        'name'                  => _x('Project Categories', 'Post Type General Name', 'portfolio-pro'),
        'singular_name'         => _x('Project Category', 'Post Type Singular Name', 'portfolio-pro'),
        'menu_name'             => __('Project Categories', 'portfolio-pro'),
        'name_admin_bar'        => __('Project Category', 'portfolio-pro'),
        'archives'              => __('Category Archives', 'portfolio-pro'),
        'attributes'            => __('Category Attributes', 'portfolio-pro'),
        'parent_item_colon'     => __('Parent Category:', 'portfolio-pro'),
        'all_items'             => __('All Categories', 'portfolio-pro'),
        'add_new_item'          => __('Add New Category', 'portfolio-pro'),
        'add_new'               => __('Add New', 'portfolio-pro'),
        'new_item'              => __('New Category', 'portfolio-pro'),
        'edit_item'             => __('Edit Category', 'portfolio-pro'),
        'update_item'           => __('Update Category', 'portfolio-pro'),
        'view_item'             => __('View Category', 'portfolio-pro'),
        'view_items'            => __('View Categories', 'portfolio-pro'),
        'search_items'          => __('Search Category', 'portfolio-pro'),
        'not_found'             => __('Not found', 'portfolio-pro'),
        'not_found_in_trash'    => __('Not found in Trash', 'portfolio-pro'),
    );
    
    $args = array(
        'label'                 => __('Project Category', 'portfolio-pro'),
        'description'           => __('Project categories for grouping portfolio items', 'portfolio-pro'),
        'labels'                => $labels,
        'supports'              => array('title', 'thumbnail'),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => 'edit.php?post_type=project',
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-category',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    
    register_post_type('project_category', $args);
}
add_action('init', 'portfolio_pro_register_project_category_cpt', 0);

/**
 * Register Project Post Type
 */
function portfolio_pro_register_project_cpt() {
    $labels = array(
        'name'                  => _x('Projects', 'Post Type General Name', 'portfolio-pro'),
        'singular_name'         => _x('Project', 'Post Type Singular Name', 'portfolio-pro'),
        'menu_name'             => __('Portfolio Projects', 'portfolio-pro'),
        'name_admin_bar'        => __('Project', 'portfolio-pro'),
        'archives'              => __('Project Archives', 'portfolio-pro'),
        'attributes'            => __('Project Attributes', 'portfolio-pro'),
        'parent_item_colon'     => __('Parent Project:', 'portfolio-pro'),
        'all_items'             => __('All Projects', 'portfolio-pro'),
        'add_new_item'          => __('Add New Project', 'portfolio-pro'),
        'add_new'               => __('Add New', 'portfolio-pro'),
        'new_item'              => __('New Project', 'portfolio-pro'),
        'edit_item'             => __('Edit Project', 'portfolio-pro'),
        'update_item'           => __('Update Project', 'portfolio-pro'),
        'view_item'             => __('View Project', 'portfolio-pro'),
        'view_items'            => __('View Projects', 'portfolio-pro'),
        'search_items'          => __('Search Project', 'portfolio-pro'),
        'not_found'             => __('Not found', 'portfolio-pro'),
        'not_found_in_trash'    => __('Not found in Trash', 'portfolio-pro'),
    );
    
    $args = array(
        'label'                 => __('Project', 'portfolio-pro'),
        'description'           => __('Portfolio projects showcasing your work', 'portfolio-pro'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 21,
        'menu_icon'             => 'dashicons-portfolio',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    
    register_post_type('project', $args);
}
add_action('init', 'portfolio_pro_register_project_cpt', 0);
/**
 * Register Portfolio Settings Post Type
 */
function portfolio_pro_register_portfolio_settings_cpt() {
    $labels = array(
        'name'                  => _x('Portfolio Settings', 'Post Type General Name', 'portfolio-pro'),
        'singular_name'         => _x('Portfolio Setting', 'Post Type Singular Name', 'portfolio-pro'),
        'menu_name'             => __('Portfolio Settings', 'portfolio-pro'),
        'name_admin_bar'        => __('Portfolio Setting', 'portfolio-pro'),
        'add_new'               => __('Add New', 'portfolio-pro'),
        'add_new_item'          => __('Add New Setting', 'portfolio-pro'),
        'new_item'              => __('New Setting', 'portfolio-pro'),
        'edit_item'             => __('Edit Setting', 'portfolio-pro'),
        'update_item'           => __('Update Setting', 'portfolio-pro'),
        'view_item'             => __('View Setting', 'portfolio-pro'),
        'search_items'          => __('Search Setting', 'portfolio-pro'),
        'not_found'             => __('Not found', 'portfolio-pro'),
        'not_found_in_trash'    => __('Not found in Trash', 'portfolio-pro'),
    );
    
    $args = array(
        'label'                 => __('Portfolio Setting', 'portfolio-pro'),
        'description'           => __('Settings for portfolio section', 'portfolio-pro'),
        'labels'                => $labels,
        'supports'              => array('title'),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => 'edit.php?post_type=project',
        'menu_position'         => 5,
        'show_in_admin_bar'     => false,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'page',  // Changed from 'post' to 'page' for better permissions
        'show_in_rest'          => true,
        'map_meta_cap'          => true,    // Added for proper capability mapping
    );
    
    register_post_type('portfolio_settings', $args);  // Changed to plural 'portfolio_settings'
}
add_action('init', 'portfolio_pro_register_portfolio_settings_cpt', 0);
