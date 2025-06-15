<?php
/**
 * Custom Post Types Registration
 * 
 * Registers all custom post types used by the theme:
 * - Portfolio projects
 * - Skills/Services
 * - Experience entries
 * - Education entries
 * - Testimonials
 * - Contact messages
 *
 * @package Stylefolio
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Custom Post Types Manager Class
 */
class Portfolio_Pro_CPT_Manager {
    /**
     * Initialize CPT registration
     */    public function __construct() {
        add_action('init', array($this, 'register_custom_post_types'), 0);
        add_action('admin_init', array($this, 'register_admin_columns'));
    }
    
    /**
     * Register all custom post types
     */
    public function register_custom_post_types() {
        // Load individual CPT files
        $this->load_cpt_files();
    }
      /**
     * Load individual CPT files
     */
    private function load_cpt_files() {        // Array of CPT files to load
        $cpt_files = array(
            'cpt-skills.php',
            'cpt-projects.php',
            'cpt-testimonals.php',  // Fixed filename
            'cpt-experience.php',
            'cpt-education.php',
            'cpt-contact.php',      // Added contact CPT
            'cpt-hero.php',         // Added hero CPT
        );
        
        // Load each file if it exists
        foreach ($cpt_files as $file) {
            $file_path = get_template_directory() . '/inc/cpt/' . $file;
            if (file_exists($file_path)) {
                require_once $file_path;
            }
        }
    }
    
    /**
     * Register admin columns for custom post types
     */
    public function register_admin_columns() {
        // Load admin column customizations
        $column_file = get_template_directory() . '/inc/admin/admin-columns.php';
        if (file_exists($column_file)) {
            require_once $column_file;
        }
    }
}

// Initialize the CPT Manager
new Portfolio_Pro_CPT_Manager();

/**
 * Helper function to register a CPT with standard arguments
 *
 * @param string $post_type Post type key
 * @param string $singular Singular name
 * @param string $plural Plural name
 * @param array $args Additional arguments
 * @return void
 */
function portfolio_pro_register_cpt($post_type, $singular, $plural, $args = array()) {
    $labels = array(
        'name'                  => $plural,
        'singular_name'         => $singular,
        'menu_name'             => $plural,
        'name_admin_bar'        => $singular,
        'archives'              => $singular . ' Archives',
        'attributes'            => $singular . ' Attributes',
        'parent_item_colon'     => 'Parent ' . $singular . ':',
        'all_items'             => 'All ' . $plural,
        'add_new_item'          => 'Add New ' . $singular,
        'add_new'               => 'Add New',
        'new_item'              => 'New ' . $singular,
        'edit_item'             => 'Edit ' . $singular,
        'update_item'           => 'Update ' . $singular,
        'view_item'             => 'View ' . $singular,
        'view_items'            => 'View ' . $plural,
        'search_items'          => 'Search ' . $singular,
        'not_found'             => 'Not found',
        'not_found_in_trash'    => 'Not found in Trash',
    );
    
    $defaults = array(
        'label'                 => $singular,
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail'),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    
    $args = wp_parse_args($args, $defaults);
    
    register_post_type($post_type, $args);
}