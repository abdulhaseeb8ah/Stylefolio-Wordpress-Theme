<?php
/**
 * ACF Fields Loader for Custom Post Types
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
 * Class for managing ACF fields for all sections
 */
class Portfolio_Pro_ACF_Manager {
    /**
     * Initialize the class
     */
    public function __construct() {
        // Hook to ACF init to register fields
        add_action('acf/init', array($this, 'load_acf_fields'), 10);
    }
    
    /**
     * Load all ACF field files
     */
    public function load_acf_fields() {
        // Check if ACF is active
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }
        
        // Array of ACF files to load
        $acf_files = array(
            'acf-skills.php',
            'acf-projects.php',
            'acf-testimonials.php',
            'acf-experience.php',
            'acf-education.php',
            'acf-services.php',
        );
        
        // Load each file if it exists
        foreach ($acf_files as $file) {
            $file_path = get_template_directory() . '/inc/acf/' . $file;
            if (file_exists($file_path)) {
                require_once $file_path;
            }
        }
    }
}

// Initialize the ACF Manager
new Portfolio_Pro_ACF_Manager();