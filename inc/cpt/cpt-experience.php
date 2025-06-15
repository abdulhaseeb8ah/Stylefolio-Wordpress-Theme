<?php
/**
 * Register Work Experience Custom Post Type
 *
 * @package Stylefolio
 * @version 1.0
 * @author abdulhaseeb2002
 * @updated 2025-06-11 16:03:15
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the 'experience' custom post type
 */
function stylefolio_register_experience_post_type() {
    $labels = array(
        'name'                  => _x('Work Experience', 'Post Type General Name', 'stylefolio'),
        'singular_name'         => _x('Experience', 'Post Type Singular Name', 'stylefolio'),
        'menu_name'             => __('Work Experience', 'stylefolio'),
        'name_admin_bar'        => __('Experience', 'stylefolio'),
        'archives'              => __('Experience Archives', 'stylefolio'),
        'attributes'            => __('Experience Attributes', 'stylefolio'),
        'parent_item_colon'     => __('Parent Experience:', 'stylefolio'),
        'all_items'             => __('All Experiences', 'stylefolio'),
        'add_new_item'          => __('Add New Experience', 'stylefolio'),
        'add_new'               => __('Add New', 'stylefolio'),
        'new_item'              => __('New Experience', 'stylefolio'),
        'edit_item'             => __('Edit Experience', 'stylefolio'),
        'update_item'           => __('Update Experience', 'stylefolio'),
        'view_item'             => __('View Experience', 'stylefolio'),
        'view_items'            => __('View Experiences', 'stylefolio'),
        'search_items'          => __('Search Experience', 'stylefolio'),
        'not_found'             => __('Not found', 'stylefolio'),
        'not_found_in_trash'    => __('Not found in Trash', 'stylefolio'),
        'featured_image'        => __('Company Logo', 'stylefolio'),
        'set_featured_image'    => __('Set company logo', 'stylefolio'),
        'remove_featured_image' => __('Remove company logo', 'stylefolio'),
        'use_featured_image'    => __('Use as company logo', 'stylefolio'),
        'insert_into_item'      => __('Insert into experience', 'stylefolio'),
        'uploaded_to_this_item' => __('Uploaded to this experience', 'stylefolio'),
        'items_list'            => __('Experiences list', 'stylefolio'),
        'items_list_navigation' => __('Experiences list navigation', 'stylefolio'),
        'filter_items_list'     => __('Filter experiences list', 'stylefolio'),
    );
    
    $args = array(
        'label'                 => __('Experience', 'stylefolio'),
        'description'           => __('Work experience entries', 'stylefolio'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-businessman',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
    );
      register_post_type('experience', $args);
}

// Register the experience post type
add_action('init', 'stylefolio_register_experience_post_type');