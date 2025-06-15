<?php
/**
 * Skills Section Custom Post Types
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
 * Register Skills Category Post Type
 */
function portfolio_pro_register_skill_category_cpt() {
    portfolio_pro_register_cpt(
        'skill_category',
        'Skill Category',
        'Skill Categories',
        array(
            'supports'              => array('title', 'thumbnail'),
            'menu_icon'             => 'dashicons-category',
            'show_in_menu'          => 'edit.php?post_type=skill',
        )
    );
}
add_action('init', 'portfolio_pro_register_skill_category_cpt', 0);

/**
 * Register Skills Post Type
 */
function portfolio_pro_register_skill_cpt() {
    portfolio_pro_register_cpt(
        'skill',
        'Skill',
        'Skills',
        array(
            'menu_position'         => 20,
            'menu_icon'             => 'dashicons-lightbulb',
        )
    );
}
add_action('init', 'portfolio_pro_register_skill_cpt', 0);

/**
 * Register Technical Skills Post Type
 */
function portfolio_pro_register_tech_skill_cpt() {
    portfolio_pro_register_cpt(
        'tech_skill',
        'Technical Skill',
        'Technical Skills',
        array(
            'supports'              => array('title'),
            'menu_icon'             => 'dashicons-chart-bar',
            'show_in_menu'          => 'edit.php?post_type=skill',
        )
    );
}
add_action('init', 'portfolio_pro_register_tech_skill_cpt', 0);

/**
 * Register Skills Section Settings Post Type
 */
function portfolio_pro_register_skills_settings_cpt() {
    portfolio_pro_register_cpt(
        'skills_setting',
        'Skills Setting',
        'Skills Settings',
        array(
            'supports'              => array('title'),
            'show_in_menu'          => 'edit.php?post_type=skill',
            'show_in_admin_bar'     => false,
        )
    );
}
add_action('init', 'portfolio_pro_register_skills_settings_cpt', 0);