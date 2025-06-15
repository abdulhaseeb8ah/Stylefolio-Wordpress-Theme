<?php
/**
 * Register Education Custom Post Type
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
 * Register the 'education' custom post type
 */
function stylefolio_register_education_post_type() {
    $labels = array(
        'name'                  => _x('Education', 'Post Type General Name', 'stylefolio'),
        'singular_name'         => _x('Education', 'Post Type Singular Name', 'stylefolio'),
        'menu_name'             => __('Education', 'stylefolio'),
        'name_admin_bar'        => __('Education', 'stylefolio'),
        'archives'              => __('Education Archives', 'stylefolio'),
        'attributes'            => __('Education Attributes', 'stylefolio'),
        'parent_item_colon'     => __('Parent Education:', 'stylefolio'),
        'all_items'             => __('All Education', 'stylefolio'),
        'add_new_item'          => __('Add New Education', 'stylefolio'),
        'add_new'               => __('Add New', 'stylefolio'),
        'new_item'              => __('New Education', 'stylefolio'),
        'edit_item'             => __('Edit Education', 'stylefolio'),
        'update_item'           => __('Update Education', 'stylefolio'),
        'view_item'             => __('View Education', 'stylefolio'),
        'view_items'            => __('View Education', 'stylefolio'),
        'search_items'          => __('Search Education', 'stylefolio'),
        'not_found'             => __('Not found', 'stylefolio'),
        'not_found_in_trash'    => __('Not found in Trash', 'stylefolio'),
        'featured_image'        => __('Institution Logo', 'stylefolio'),
        'set_featured_image'    => __('Set institution logo', 'stylefolio'),
        'remove_featured_image' => __('Remove institution logo', 'stylefolio'),
        'use_featured_image'    => __('Use as institution logo', 'stylefolio'),
        'insert_into_item'      => __('Insert into education', 'stylefolio'),
        'uploaded_to_this_item' => __('Uploaded to this education', 'stylefolio'),
        'items_list'            => __('Education list', 'stylefolio'),
        'items_list_navigation' => __('Education list navigation', 'stylefolio'),
        'filter_items_list'     => __('Filter education list', 'stylefolio'),
    );
    
    $args = array(
        'label'                 => __('Education', 'stylefolio'),
        'description'           => __('Educational background and qualifications', 'stylefolio'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 21,
        'menu_icon'             => 'dashicons-welcome-learn-more',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
    );
      register_post_type('education', $args);
}

// Register the education post type
add_action('init', 'stylefolio_register_education_post_type');