<?php
/**
 * Register Hero Section Custom Post Type
 *
 * @package Stylefolio
 * @version 1.0
 * @author abdulhaseeb2002
 * @updated 2025-06-14 12:00:00
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the 'hero_content' custom post type
 */
function stylefolio_register_hero_post_type() {
    $labels = array(
        'name'                  => _x('Hero Content', 'Post Type General Name', 'stylefolio'),
        'singular_name'         => _x('Hero Content', 'Post Type Singular Name', 'stylefolio'),
        'menu_name'             => __('Hero Section', 'stylefolio'),
        'name_admin_bar'        => __('Hero Content', 'stylefolio'),
        'archives'              => __('Hero Archives', 'stylefolio'),
        'attributes'            => __('Hero Attributes', 'stylefolio'),
        'parent_item_colon'     => __('Parent Hero:', 'stylefolio'),
        'all_items'             => __('All Hero Content', 'stylefolio'),
        'add_new_item'          => __('Add New Hero Content', 'stylefolio'),
        'add_new'               => __('Add New', 'stylefolio'),
        'new_item'              => __('New Hero Content', 'stylefolio'),
        'edit_item'             => __('Edit Hero Content', 'stylefolio'),
        'update_item'           => __('Update Hero Content', 'stylefolio'),
        'view_item'             => __('View Hero Content', 'stylefolio'),
        'view_items'            => __('View Hero Content', 'stylefolio'),
        'search_items'          => __('Search Hero Content', 'stylefolio'),
        'not_found'             => __('Not found', 'stylefolio'),
        'not_found_in_trash'    => __('Not found in Trash', 'stylefolio'),
        'featured_image'        => __('Hero Background Image', 'stylefolio'),
        'set_featured_image'    => __('Set hero background image', 'stylefolio'),
        'remove_featured_image' => __('Remove hero background image', 'stylefolio'),
        'use_featured_image'    => __('Use as hero background image', 'stylefolio'),
        'insert_into_item'      => __('Insert into hero content', 'stylefolio'),
        'uploaded_to_this_item' => __('Uploaded to this hero content', 'stylefolio'),
        'items_list'            => __('Hero content list', 'stylefolio'),
        'items_list_navigation' => __('Hero content list navigation', 'stylefolio'),
        'filter_items_list'     => __('Filter hero content list', 'stylefolio'),
    );
    
    $args = array(
        'label'                 => __('Hero Content', 'stylefolio'),
        'description'           => __('Hero section content and settings', 'stylefolio'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail'),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 25,
        'menu_icon'             => 'dashicons-format-image',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
    );
    
    register_post_type('hero_content', $args);
}

// Register the hero post type
add_action('init', 'stylefolio_register_hero_post_type');
