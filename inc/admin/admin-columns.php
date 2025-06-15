<?php
/**
 * Custom Admin Columns for Portfolio Pro CPTs
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
 * Add admin columns for skill posts
 */
function portfolio_pro_skill_admin_columns($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        if ($key == 'title') {
            $new_columns[$key] = $value;
            $new_columns['skill_icon'] = __('Icon', 'portfolio-pro');
            $new_columns['skill_category'] = __('Category', 'portfolio-pro');
        } else {
            $new_columns[$key] = $value;
        }
    }
    return $new_columns;
}
add_filter('manage_skill_posts_columns', 'portfolio_pro_skill_admin_columns');

/**
 * Populate custom columns for skill posts
 */
function portfolio_pro_skill_custom_column($column, $post_id) {
    switch ($column) {
        case 'skill_icon':
            $icon = get_field('skill_icon', $post_id);
            if ($icon) {
                echo '<i class="' . esc_attr($icon) . '" style="font-size: 24px;"></i>';
            } else {
                echo '—';
            }
            break;
        case 'skill_category':
            $category_id = get_field('skill_category', $post_id);
            if ($category_id) {
                echo get_the_title($category_id);
            } else {
                echo '—';
            }
            break;
    }
}
add_action('manage_skill_posts_custom_column', 'portfolio_pro_skill_custom_column', 10, 2);

/**
 * Add admin columns for technical skill posts
 */
function portfolio_pro_tech_skill_admin_columns($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        if ($key == 'title') {
            $new_columns[$key] = $value;
            $new_columns['percentage'] = __('Percentage', 'portfolio-pro');
        } else {
            $new_columns[$key] = $value;
        }
    }
    return $new_columns;
}
add_filter('manage_tech_skill_posts_columns', 'portfolio_pro_tech_skill_admin_columns');

/**
 * Populate custom columns for technical skill posts
 */
function portfolio_pro_tech_skill_custom_column($column, $post_id) {
    switch ($column) {
        case 'percentage':
            $percentage = get_field('skill_percentage', $post_id);
            if ($percentage) {
                echo '<div style="background:#eee;height:20px;width:100%;max-width:200px;border-radius:3px;overflow:hidden;">';
                echo '<div style="background:#0073aa;height:100%;width:' . esc_attr($percentage) . '%;"></div>';
                echo '</div>';
                echo '<span style="display:inline-block;margin-top:5px;">' . esc_html($percentage) . '%</span>';
            } else {
                echo '0%';
            }
            break;
    }
}
add_action('manage_tech_skill_posts_custom_column', 'portfolio_pro_tech_skill_custom_column', 10, 2);

/**
 * Add admin columns for project posts
 */
function portfolio_pro_project_admin_columns($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        if ($key == 'title') {
            $new_columns[$key] = $value;
            $new_columns['project_image'] = __('Image', 'portfolio-pro');
            $new_columns['project_category'] = __('Category', 'portfolio-pro');
        } else if ($key != 'date') {
            $new_columns[$key] = $value;
        }
    }
    
    // Add featured and date at the end
    $new_columns['featured'] = __('Featured', 'portfolio-pro');
    $new_columns['date'] = __('Date', 'portfolio-pro');
    
    return $new_columns;
}
add_filter('manage_project_posts_columns', 'portfolio_pro_project_admin_columns');

/**
 * Populate custom columns for project posts
 */
function portfolio_pro_project_custom_column($column, $post_id) {
    switch ($column) {
        case 'project_image':
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, array(50, 50));
            } else {
                echo '<div style="width:50px;height:50px;background:#eee;display:flex;align-items:center;justify-content:center;"><span style="color:#999;">No Image</span></div>';
            }
            break;
        case 'project_category':
            $category_id = get_field('project_category', $post_id);
            if ($category_id) {
                echo get_the_title($category_id);
            } else {
                echo '—';
            }
            break;
        case 'featured':
            $featured = get_field('project_featured', $post_id);
            if ($featured) {
                echo '<span style="color:#0073aa;"><span class="dashicons dashicons-star-filled"></span></span>';
            } else {
                echo '<span style="color:#ccc;"><span class="dashicons dashicons-star-empty"></span></span>';
            }
            break;
    }
}
add_action('manage_project_posts_custom_column', 'portfolio_pro_project_custom_column', 10, 2);