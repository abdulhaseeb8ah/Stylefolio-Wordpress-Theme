<?php
/**
 * Default Data Loader
 * 
 * Automatically populates the theme with sample content when first activated.
 * This includes demo portfolio projects, skills, experience, and testimonials.
 * 
 * Users can choose to keep or replace this content with their own.
 *
 * @package Stylefolio
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Data Manager for theme setup and demo content
 */
class Portfolio_Pro_Data_Manager {
    /**
     * Initialize data management hooks
     */    public function __construct() {
        add_action('after_switch_theme', array($this, 'initialize_data_on_activation'));
        add_action('admin_init', array($this, 'handle_manual_initialization'));
        add_action('admin_notices', array($this, 'data_initialization_notice'));
    }
    
    /**
     * Initialize data on theme activation
     */
    public function initialize_data_on_activation() {
        // Only run if ACF is active
        if (!function_exists('update_field')) {
            return;
        }
        
        $this->load_data_files();
    }
    
    /**
     * Load all data initialization files
     */
    private function load_data_files() {
        // Array of data files to load
        $data_files = array(
            'data-skills.php',
            'data-projects.php',
            'data-testimonials.php',
            'data-experience.php',
            'data-education.php',
            'data-services.php',
        );
        
        // Load each file if it exists
        foreach ($data_files as $file) {
            $file_path = get_template_directory() . '/inc/data/' . $file;
            if (file_exists($file_path)) {
                require_once $file_path;
                
                // Call the initialization function if it exists
                $function_name = 'portfolio_pro_initialize_' . str_replace('-', '_', str_replace('.php', '', $file));
                if (function_exists($function_name)) {
                    call_user_func($function_name);
                }
            }
        }
    }
    
    /**
     * Handle manual initialization of data
     */
    public function handle_manual_initialization() {
        if (isset($_GET['action']) && $_GET['action'] === 'initialize_portfolio_data') {
            // Verify nonce
            check_admin_referer('initialize_portfolio_data');
            
            // Only allow admins
            if (!current_user_can('manage_options')) {
                wp_die('You do not have permission to perform this action.');
            }
            
            // Load and run all data files
            $this->load_data_files();
            
            // Reset the initialization flags to force repopulation
            $this->reset_initialization_flags();
            
            // Redirect back
            wp_redirect(admin_url('index.php?data_initialized=1'));
            exit;
        }
        
        // Show success message after initialization
        if (isset($_GET['data_initialized']) && $_GET['data_initialized'] === '1' && current_user_can('manage_options')) {
            add_action('admin_notices', function() {
                ?>
                <div class="notice notice-success is-dismissible">
                    <p><strong>Success!</strong> All portfolio sections have been initialized with default data.</p>
                </div>
                <?php
            });
        }
    }
    
    /**
     * Reset initialization flags to force repopulation
     */
    private function reset_initialization_flags() {
        $options = array(
            'portfolio_pro_skills_data_initialized',
            'portfolio_pro_projects_data_initialized',
            'portfolio_pro_testimonials_data_initialized',
            'portfolio_pro_experience_data_initialized',
            'portfolio_pro_education_data_initialized',
            'portfolio_pro_services_data_initialized',
        );
        
        foreach ($options as $option) {
            delete_option($option);
        }
    }
    
    /**
     * Show admin notice for data initialization
     */
    public function data_initialization_notice() {
        // Only show to admins
        if (!current_user_can('manage_options')) {
            return;
        }
        
        // Check if any data needs initialization
        $needs_initialization = false;
        
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
                $needs_initialization = true;
                break;
            }
        }
        
        if (!$needs_initialization) {
            return;
        }
        
        // Only show if ACF is active
        if (!function_exists('update_field')) {
            return;
        }
        
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><strong>Portfolio Pro:</strong> Some sections need to be initialized with default data.</p>
            <p>
                <a href="<?php echo wp_nonce_url(admin_url('admin.php?action=initialize_portfolio_data'), 'initialize_portfolio_data'); ?>" class="button button-primary">Initialize All Sections</a>
            </p>
        </div>
        <?php
    }
}

// Initialize the Data Manager
new Portfolio_Pro_Data_Manager();