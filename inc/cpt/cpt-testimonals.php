<?php
/**
 * Register Testimonial Custom Post Type
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
 * Register the 'testimonial' custom post type
 */
function stylefolio_register_testimonial_post_type() {
    $labels = array(
        'name'                  => _x('Testimonials', 'Post Type General Name', 'stylefolio'),
        'singular_name'         => _x('Testimonial', 'Post Type Singular Name', 'stylefolio'),
        'menu_name'             => __('Testimonials', 'stylefolio'),
        'name_admin_bar'        => __('Testimonial', 'stylefolio'),
        'archives'              => __('Testimonial Archives', 'stylefolio'),
        'attributes'            => __('Testimonial Attributes', 'stylefolio'),
        'parent_item_colon'     => __('Parent Testimonial:', 'stylefolio'),
        'all_items'             => __('All Testimonials', 'stylefolio'),
        'add_new_item'          => __('Add New Testimonial', 'stylefolio'),
        'add_new'               => __('Add New', 'stylefolio'),
        'new_item'              => __('New Testimonial', 'stylefolio'),
        'edit_item'             => __('Edit Testimonial', 'stylefolio'),
        'update_item'           => __('Update Testimonial', 'stylefolio'),
        'view_item'             => __('View Testimonial', 'stylefolio'),
        'view_items'            => __('View Testimonials', 'stylefolio'),
        'search_items'          => __('Search Testimonial', 'stylefolio'),
        'not_found'             => __('Not found', 'stylefolio'),
        'not_found_in_trash'    => __('Not found in Trash', 'stylefolio'),
        'featured_image'        => __('Client Photo', 'stylefolio'),
        'set_featured_image'    => __('Set client photo', 'stylefolio'),
        'remove_featured_image' => __('Remove client photo', 'stylefolio'),
        'use_featured_image'    => __('Use as client photo', 'stylefolio'),
        'insert_into_item'      => __('Insert into testimonial', 'stylefolio'),
        'uploaded_to_this_item' => __('Uploaded to this testimonial', 'stylefolio'),
        'items_list'            => __('Testimonials list', 'stylefolio'),
        'items_list_navigation' => __('Testimonials list navigation', 'stylefolio'),
        'filter_items_list'     => __('Filter testimonials list', 'stylefolio'),
    );
    
    $args = array(
        'label'                 => __('Testimonial', 'stylefolio'),
        'description'           => __('Testimonials from clients', 'stylefolio'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-testimonial',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
    );
    
    register_post_type('testimonial', $args);
}

// Add to register-cpt.php
add_action('init', 'stylefolio_register_testimonial_post_type');