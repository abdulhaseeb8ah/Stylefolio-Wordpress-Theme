<?php
/**
 * Admin Dashboard Menus
 * 
 * Adds custom admin menu items and admin bar shortcuts
 * for easy access to portfolio content management.
 *
 * @package Stylefolio
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add portfolio management links to admin bar
 */
function portfolio_pro_admin_bar_menu($wp_admin_bar) {
    if (!current_user_can('edit_posts')) {
        return;
    }
    
    // Main node
    $wp_admin_bar->add_node(array(
        'id'    => 'portfolio-sections',
        'title' => 'Portfolio Sections',
        'href'  => admin_url('index.php?page=portfolio-sections'),
    ));
    
    // Skills submenu
    if (post_type_exists('skill')) {
        $wp_admin_bar->add_node(array(
            'id'    => 'edit-skills',
            'title' => 'Manage Skills',
            'href'  => admin_url('edit.php?post_type=skill'),
            'parent' => 'portfolio-sections',
        ));
        
        $wp_admin_bar->add_node(array(
            'id'    => 'add-skill',
            'title' => 'Add New Skill',
            'href'  => admin_url('post-new.php?post_type=skill'),
            'parent' => 'edit-skills',
        ));
        
        $wp_admin_bar->add_node(array(
            'id'    => 'edit-skill-categories',
            'title' => 'Edit Categories',
            'href'  => admin_url('edit.php?post_type=skill_category'),
            'parent' => 'edit-skills',
        ));
        
        $wp_admin_bar->add_node(array(
            'id'    => 'edit-tech-skills',
            'title' => 'Edit Technical Skills',
            'href'  => admin_url('edit.php?post_type=tech_skill'),
            'parent' => 'edit-skills',
        ));
        
        $wp_admin_bar->add_node(array(
            'id'    => 'edit-skills-settings',
            'title' => 'Edit Skills Settings',
            'href'  => admin_url('edit.php?post_type=skills_setting'),
            'parent' => 'edit-skills',
        ));
    }
    
    // Projects submenu
    if (post_type_exists('project')) {
        $wp_admin_bar->add_node(array(
            'id'    => 'edit-projects',
            'title' => 'Manage Projects',
            'href'  => admin_url('edit.php?post_type=project'),
            'parent' => 'portfolio-sections',
        ));
        
        $wp_admin_bar->add_node(array(
            'id'    => 'add-project',
            'title' => 'Add New Project',
            'href'  => admin_url('post-new.php?post_type=project'),
            'parent' => 'edit-projects',
        ));
        
        $wp_admin_bar->add_node(array(
            'id'    => 'edit-project-categories',
            'title' => 'Edit Categories',
            'href'  => admin_url('edit.php?post_type=project_category'),
            'parent' => 'edit-projects',
        ));
        
        $wp_admin_bar->add_node(array(
            'id'    => 'edit-project-settings',
            'title' => 'Edit Projects Settings',
            'href'  => admin_url('edit.php?post_type=portfolio_settings'),
            'parent' => 'edit-projects',
        ));
    }
    
    // Testimonials submenu
    if (post_type_exists('testimonial')) {
        $wp_admin_bar->add_node(array(
            'id'    => 'edit-testimonials',
            'title' => 'Manage Testimonials',
            'href'  => admin_url('edit.php?post_type=testimonial'),
            'parent' => 'portfolio-sections',
        ));
        
        $wp_admin_bar->add_node(array(
            'id'    => 'add-testimonial',
            'title' => 'Add New Testimonial',
            'href'  => admin_url('post-new.php?post_type=testimonial'),
            'parent' => 'edit-testimonials',
        ));
    }
    
    // Experience submenu
    if (post_type_exists('experience')) {
        $wp_admin_bar->add_node(array(
            'id'    => 'edit-experience',
            'title' => 'Manage Experience',
            'href'  => admin_url('edit.php?post_type=experience'),
            'parent' => 'portfolio-sections',
        ));
        
        $wp_admin_bar->add_node(array(
            'id'    => 'add-experience',
            'title' => 'Add New Experience',
            'href'  => admin_url('post-new.php?post_type=experience'),
            'parent' => 'edit-experience',
        ));
    }
    
    // Education submenu
    if (post_type_exists('education')) {
        $wp_admin_bar->add_node(array(
            'id'    => 'edit-education',
            'title' => 'Manage Education',
            'href'  => admin_url('edit.php?post_type=education'),
            'parent' => 'portfolio-sections',
        ));
        
        $wp_admin_bar->add_node(array(
            'id'    => 'add-education',
            'title' => 'Add New Education',
            'href'  => admin_url('post-new.php?post_type=education'),
            'parent' => 'edit-education',
        ));
    }
    
    // Services submenu
    if (post_type_exists('service')) {
        $wp_admin_bar->add_node(array(
            'id'    => 'edit-services',
            'title' => 'Manage Services',
            'href'  => admin_url('edit.php?post_type=service'),
            'parent' => 'portfolio-sections',
        ));
        
        $wp_admin_bar->add_node(array(
            'id'    => 'add-service',
            'title' => 'Add New Service',
            'href'  => admin_url('post-new.php?post_type=service'),
            'parent' => 'edit-services',
        ));
    }
    
    // All sections settings
    $wp_admin_bar->add_node(array(
        'id'    => 'initialize-sections',
        'title' => 'Initialize All Sections',
        'href'  => wp_nonce_url(admin_url('admin.php?action=initialize_portfolio_data'), 'initialize_portfolio_data'),
        'parent' => 'portfolio-sections',
    ));
}
add_action('admin_bar_menu', 'portfolio_pro_admin_bar_menu', 90);

/**
 * Add portfolio sections dashboard page
 */
function portfolio_pro_add_sections_page() {
    add_dashboard_page(
        'Portfolio Sections',
        'Portfolio Sections',
        'edit_posts',
        'portfolio-sections',
        'portfolio_pro_render_sections_page'
    );
}
add_action('admin_menu', 'portfolio_pro_add_sections_page');

/**
 * Render portfolio sections dashboard page
 */
function portfolio_pro_render_sections_page() {
    ?>
    <div class="wrap">
        <h1>Portfolio Pro Sections</h1>
        
        <p>Manage all sections of your portfolio from one place. Each section has its own custom post type for easy management.</p>
        
        <div class="portfolio-sections-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">
            
            <!-- Skills Section -->
            <div class="portfolio-section-card" style="background: #fff; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 20px;">
                <h2 style="margin-top: 0;">Skills & Services</h2>
                <p>Manage your skills, categories, and technical proficiency.</p>
                <div style="margin-top: 15px;">
                    <a href="<?php echo admin_url('edit.php?post_type=skill'); ?>" class="button button-primary">Manage Skills</a>
                    <a href="<?php echo admin_url('post-new.php?post_type=skill'); ?>" class="button">Add New</a>
                </div>
            </div>
            
            <!-- Projects Section -->
            <div class="portfolio-section-card" style="background: #fff; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 20px;">
                <h2 style="margin-top: 0;">Portfolio Projects</h2>
                <p>Showcase your work with beautiful project presentations.</p>
                <div style="margin-top: 15px;">
                    <a href="<?php echo admin_url('edit.php?post_type=project'); ?>" class="button button-primary">Manage Projects</a>
                    <a href="<?php echo admin_url('post-new.php?post_type=project'); ?>" class="button">Add New</a>
                </div>
            </div>
            
            <!-- Testimonials Section -->
            <div class="portfolio-section-card" style="background: #fff; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 20px;">
                <h2 style="margin-top: 0;">Testimonials</h2>
                <p>Share what your clients and colleagues have to say about your work.</p>
                <div style="margin-top: 15px;">
                    <a href="<?php echo admin_url('edit.php?post_type=testimonial'); ?>" class="button button-primary">Manage Testimonials</a>
                    <a href="<?php echo admin_url('post-new.php?post_type=testimonial'); ?>" class="button">Add New</a>
                </div>
            </div>
            
                        <!-- Experience Section -->
            <div class="portfolio-section-card" style="background: #fff; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 20px;">
                <h2 style="margin-top: 0;">Work Experience</h2>
                <p>Showcase your professional background and career achievements.</p>
                <div style="margin-top: 15px;">
                    <a href="<?php echo admin_url('edit.php?post_type=experience'); ?>" class="button button-primary">Manage Experience</a>
                    <a href="<?php echo admin_url('post-new.php?post_type=experience'); ?>" class="button">Add New</a>
                </div>
            </div>
            
            <!-- Education Section -->
            <div class="portfolio-section-card" style="background: #fff; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 20px;">
                <h2 style="margin-top: 0;">Education</h2>
                <p>Display your educational background, degrees, and certifications.</p>
                <div style="margin-top: 15px;">
                    <a href="<?php echo admin_url('edit.php?post_type=education'); ?>" class="button button-primary">Manage Education</a>
                    <a href="<?php echo admin_url('post-new.php?post_type=education'); ?>" class="button">Add New</a>
                </div>
            </div>
            
            <!-- Services Section -->
            <div class="portfolio-section-card" style="background: #fff; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 20px;">
                <h2 style="margin-top: 0;">Services</h2>
                <p>Highlight the services and solutions you offer to clients.</p>
                <div style="margin-top: 15px;">
                    <a href="<?php echo admin_url('edit.php?post_type=service'); ?>" class="button button-primary">Manage Services</a>
                    <a href="<?php echo admin_url('post-new.php?post_type=service'); ?>" class="button">Add New</a>
                </div>
            </div>
            
            <!-- Data Initialization -->
            <div class="portfolio-section-card" style="background: #f7f7f7; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 20px;">
                <h2 style="margin-top: 0;">Initialize Data</h2>
                <p>Populate all sections with default data to get started quickly.</p>
                <div style="margin-top: 15px;">
                    <a href="<?php echo wp_nonce_url(admin_url('admin.php?action=initialize_portfolio_data'), 'initialize_portfolio_data'); ?>" class="button button-primary">Initialize All Sections</a>
                </div>
            </div>
            
        </div>
        
        <div class="portfolio-help-section" style="margin-top: 30px; background: #fff; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 20px;">
            <h2>Getting Started</h2>
            <p>Follow these steps to set up your portfolio sections:</p>
            <ol>
                <li><strong>Initialize Data:</strong> Start by initializing all sections with default data.</li>
                <li><strong>Customize Content:</strong> Edit each section to add your own content and customize settings.</li>
                <li><strong>Arrange Order:</strong> Use the display order field in each item to control how they appear.</li>
                <li><strong>Preview:</strong> Check your portfolio frontend to see how your changes look.</li>
            </ol>
            <p>Need more help? Check the <a href="<?php echo admin_url('admin.php?page=portfolio-documentation'); ?>">documentation</a>.</p>
        </div>
    </div>
    <?php
}

/**
 * Add admin dashboard widget for quick access to portfolio sections
 */
function portfolio_pro_add_dashboard_widget() {
    wp_add_dashboard_widget(
        'portfolio_pro_sections_widget',
        'Portfolio Pro Sections',
        'portfolio_pro_render_dashboard_widget'
    );
}
add_action('wp_dashboard_setup', 'portfolio_pro_add_dashboard_widget');

/**
 * Render portfolio sections dashboard widget
 */
function portfolio_pro_render_dashboard_widget() {
    ?>
    <div class="portfolio-widget-sections">
        <ul style="margin-bottom: 0;">
            <?php if (post_type_exists('skill')): ?>
            <li><a href="<?php echo admin_url('edit.php?post_type=skill'); ?>">Skills & Services</a></li>
            <?php endif; ?>
            
            <?php if (post_type_exists('project')): ?>
            <li><a href="<?php echo admin_url('edit.php?post_type=project'); ?>">Portfolio Projects</a></li>
            <?php endif; ?>
            
            <?php if (post_type_exists('testimonial')): ?>
            <li><a href="<?php echo admin_url('edit.php?post_type=testimonial'); ?>">Testimonials</a></li>
            <?php endif; ?>
            
            <?php if (post_type_exists('experience')): ?>
            <li><a href="<?php echo admin_url('edit.php?post_type=experience'); ?>">Work Experience</a></li>
            <?php endif; ?>
            
            <?php if (post_type_exists('education')): ?>
            <li><a href="<?php echo admin_url('edit.php?post_type=education'); ?>">Education</a></li>
            <?php endif; ?>
            
            <?php if (post_type_exists('service')): ?>
            <li><a href="<?php echo admin_url('edit.php?post_type=service'); ?>">Services</a></li>
            <?php endif; ?>
        </ul>
        <p style="margin-bottom: 0; margin-top: 10px; text-align: right;">
            <a href="<?php echo admin_url('index.php?page=portfolio-sections'); ?>">Manage All Sections</a>
        </p>
    </div>
    <?php
}

/**
 * Add portfolio documentation page
 */
function portfolio_pro_add_documentation_page() {
    add_dashboard_page(
        'Portfolio Documentation',
        'Portfolio Documentation',
        'edit_posts',
        'portfolio-documentation',
        'portfolio_pro_render_documentation_page'
    );
}
add_action('admin_menu', 'portfolio_pro_add_documentation_page');

/**
 * Render portfolio documentation page
 */
function portfolio_pro_render_documentation_page() {
    ?>
    <div class="wrap">
        <h1>Portfolio Pro Documentation</h1>
        
        <div class="portfolio-documentation-tabs" style="margin-top: 20px; display: flex; border-bottom: 1px solid #ccc;">
            <a href="#general" class="nav-tab nav-tab-active">General</a>
            <a href="#skills" class="nav-tab">Skills</a>
            <a href="#projects" class="nav-tab">Projects</a>
            <a href="#testimonials" class="nav-tab">Testimonials</a>
            <a href="#experience" class="nav-tab">Experience</a>
            <a href="#education" class="nav-tab">Education</a>
            <a href="#services" class="nav-tab">Services</a>
        </div>
        
        <div class="portfolio-documentation-content" style="background: #fff; border: 1px solid #ccc; border-top: none; padding: 20px;">
            <div id="general" class="tab-content">
                <h2>General Documentation</h2>
                <p>Portfolio Pro makes it easy to manage all sections of your portfolio using custom post types. Each section is structured with its own post type and associated fields, making it intuitive to update your content.</p>
                
                <h3>Getting Started</h3>
                <ol>
                    <li>Initialize your portfolio with default data to see examples of how each section works.</li>
                    <li>Navigate to each section to customize content according to your needs.</li>
                    <li>Use the display order fields to control the arrangement of items within each section.</li>
                    <li>Preview your portfolio to see your changes in action.</li>
                </ol>
                
                <h3>Global Tips</h3>
                <ul>
                    <li>Each section has its own settings for titles, subtitles, and descriptions.</li>
                    <li>Use the "Display Order" field to control the sequence of items.</li>
                    <li>Icons use Font Awesome classes (e.g., "fas fa-code"). You can browse available icons at <a href="https://fontawesome.com/icons" target="_blank">fontawesome.com</a>.</li>
                    <li>Images should be prepared at appropriate dimensions before uploading for best results.</li>
                </ul>
            </div>
            
            <!-- Additional tab content would go here -->
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            // Simple tab functionality
            $('.portfolio-documentation-tabs a').on('click', function(e) {
                e.preventDefault();
                
                // Hide all tab content
                $('.tab-content').hide();
                
                // Show the selected tab content
                $($(this).attr('href')).show();
                
                // Update active tab
                $('.portfolio-documentation-tabs a').removeClass('nav-tab-active');
                $(this).addClass('nav-tab-active');
            });
            
            // Show the first tab by default
            $('.tab-content').hide();
            $('#general').show();
        });
        </script>
    </div>
    <?php
}

/**
 * Add help tabs to portfolio section edit screens
 */
function portfolio_pro_add_help_tabs() {
    $screen = get_current_screen();
    
    // Skills help tabs
    if ($screen->id === 'skill' || $screen->id === 'edit-skill') {
        $screen->add_help_tab(array(
            'id'      => 'skills_help',
            'title'   => 'Skills Help',
            'content' => '
                <h2>Managing Skills</h2>
                <p>Skills represent your professional capabilities and services that you offer. Each skill belongs to a category and can include:</p>
                <ul>
                    <li><strong>Title:</strong> The name of the skill (e.g., "Front-End Development")</li>
                    <li><strong>Description:</strong> A brief explanation of the skill</li>
                    <li><strong>Icon:</strong> A visual representation using Font Awesome icons</li>
                    <li><strong>Category:</strong> The group this skill belongs to</li>
                    <li><strong>Technologies:</strong> Specific tools or technologies related to this skill</li>
                    <li><strong>Display Order:</strong> Controls the sequence of skills within a category</li>
                </ul>
                <p><a href="' . admin_url('index.php?page=portfolio-documentation#skills') . '">View Full Skills Documentation</a></p>
            ',
        ));
    }
    
    // Similar help tabs would be defined for other post types
}
add_action('admin_head', 'portfolio_pro_add_help_tabs');