<?php
/**
 * Stylefolio Theme Functions
 * 
 * This file contains all theme functionality including plugin dependencies,
 * theme setup, script enqueuing, customizer options, and helper functions.
 * 
 * For customization:
 * - Modify theme constants in the top section
 * - Add custom functions at the bottom of this file
 * - Use child themes for major modifications
 *
 * @package Stylefolio
 * @version 1.0.0
 * @author Your Name
 */

// Theme version constant - update when making changes to CSS/JS files
define('PORTFOLIO_PRO_VERSION', '1.0.0');

/**
 * Plugin Dependencies
 * 
 * This theme requires Advanced Custom Fields (ACF) to function properly.
 * The following code ensures ACF is installed and activated.
 */
require_once get_template_directory() . '/inc/tgmpa/class-tgm-plugin-activation.php';


/**
 * Register required plugins for the theme
 * 
 * This function ensures that Advanced Custom Fields is installed.
 * Users will see an admin notice if ACF is not active.
 */
function portfolio_pro_register_required_plugins() {
    $plugins = array(
        array(
            'name'      => 'Advanced Custom Fields',
            'slug'      => 'advanced-custom-fields',
            'required'  => true,
        ),
        array(
            'name'      => 'Elementor',
            'slug'      => 'elementor',
            'required'  => false,
        ),
        array(
            'name'      => 'Elementor Pro',
            'slug'      => 'elementor-pro',
            'required'  => false,
            'external_url' => 'https://elementor.com/pro/',
        ),
    );
    
    // Configuration for plugin installer
    $config = array(
        'id'           => 'portfolio-pro',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'parent_slug'  => 'themes.php',
        'capability'   => 'edit_theme_options',
        'has_notices'  => true,
        'dismissable'  => false,
        'dismiss_msg'  => '',
        'is_automatic' => true,
        'message'      => '',
    );

    tgmpa($plugins, $config);
}
add_action('tgmpa_register', 'portfolio_pro_register_required_plugins');

/**
 * Theme Setup & Core Functionality
 * 
 * Sets up theme defaults and registers WordPress features support.
 * This includes post thumbnails, navigation menus, custom logo, etc.
 */

/**
 * Configure theme features and WordPress support
 */
function portfolio_pro_setup() {
    // RSS feed links
    add_theme_support('automatic-feed-links');
    
    // WordPress document title management
    add_theme_support('title-tag');
    
    // Post thumbnail support
    add_theme_support('post-thumbnails');
    
    // Navigation menu locations
    register_nav_menus(
        array(
            'primary' => esc_html__('Primary Menu', 'portfolio-pro'),
            'footer' => esc_html__('Footer Menu', 'portfolio-pro'),
        )
    );
    
    // Widget selective refresh
    add_theme_support('customize-selective-refresh-widgets');
      // Custom logo support
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );
    
    // Elementor support
    add_theme_support('elementor');
    
    // Elementor Editor
    add_theme_support('elementor-editor');
    
    // Wide Alignment
    add_theme_support('align-wide');
    
    // Editor styles
    add_theme_support('editor-styles');
    
    // Responsive embeds
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'portfolio_pro_setup');

/**
 * Scripts & Styles Enqueuing
 * 
 * Loads all CSS and JavaScript files for the theme.
 * Files are loaded in the correct order with proper dependencies.
 */

/**
 * Enqueue theme styles and scripts
 */
function portfolio_pro_scripts() {
    wp_enqueue_script('jquery');
    
    // Version for cache busting
    $version = get_option('portfolio_pro_skills_version', PORTFOLIO_PRO_VERSION);
    
    // Main stylesheet
    wp_enqueue_style(
        'portfolio-pro-style', 
        get_stylesheet_uri(), 
        array(), 
        PORTFOLIO_PRO_VERSION
    );
    
    // Main CSS
    wp_enqueue_style(
        'portfolio-pro-main', 
        get_template_directory_uri() . '/assets/css/main.css', 
        array(), 
        PORTFOLIO_PRO_VERSION
    );
    
    // Component CSS files
    wp_enqueue_style(
        'portfolio-pro-header', 
        get_template_directory_uri() . '/assets/css/header.css', 
        array('portfolio-pro-main'), 
        PORTFOLIO_PRO_VERSION
    );
      wp_enqueue_script(
        'stylefolio-header',
        get_template_directory_uri() . '/assets/js/header.js',
        array('jquery'),
        '1.0.0',
        true
    );
    
    wp_enqueue_script(
        'stylefolio-navigation',
        get_template_directory_uri() . '/assets/js/navigation.js',
        array('jquery', 'stylefolio-header'),
        '1.0.0',
        true
    );

    wp_enqueue_style(
        'portfolio-pro-hero', 
        get_template_directory_uri() . '/assets/css/hero.css', 
        array('portfolio-pro-main'), 
        '2.1'
    );
    
    wp_enqueue_style(
        'portfolio-pro-skills', 
        get_template_directory_uri() . '/assets/css/skills.css', 
        array('portfolio-pro-main'), 
        $version // Use dynamic version for cache busting
    );
    
    wp_enqueue_style(
        'portfolio-pro-footer', 
        get_template_directory_uri() . '/assets/css/footer.css', 
        array('portfolio-pro-main'), 
        PORTFOLIO_PRO_VERSION
    );
    
    // Enqueue Responsive CSS (should be after all other styles)
    wp_enqueue_style(
        'portfolio-pro-responsive', 
        get_template_directory_uri() . '/assets/css/responsive.css', 
        array('portfolio-pro-main'), 
        PORTFOLIO_PRO_VERSION
    );
    
    // Enqueue Font Awesome
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',
        array(),
        '6.0.0'
    );
    
    // Enqueue JS Files - all in footer
    wp_enqueue_script(
        'portfolio-pro-main', 
        get_template_directory_uri() . '/assets/js/main.js', 
        array('jquery'), 
        PORTFOLIO_PRO_VERSION, 
        true
    );
    
    wp_enqueue_script(
        'portfolio-pro-hero', 
        get_template_directory_uri() . '/assets/js/hero.js', 
        array('jquery'), 
        '2.1', 
        true
    );
    
    wp_enqueue_script(
        'portfolio-pro-skills', 
        get_template_directory_uri() . '/assets/js/skills.js', 
        array('jquery'), 
        $version, // Use dynamic version for cache busting
        true
    );
    
    // Enable comment threading if needed
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'portfolio_pro_scripts');

/**
 * Add inline script for mobile menu toggle functionality
 */
function portfolio_pro_inline_script() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Direct menu toggle
        var menuToggle = document.querySelector('.menu-toggle');
        var mobileMenu = document.querySelector('.mobile-menu');
        
        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                mobileMenu.classList.toggle('show-mobile-menu');
                menuToggle.classList.toggle('toggled');
                  // Update aria-expanded
                var isExpanded = mobileMenu.classList.contains('show-mobile-menu');
                menuToggle.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
            });
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'portfolio_pro_inline_script', 100);

/**
 * Widget Areas Registration
 * 
 * Registers footer widget areas for theme customization.
 */

/**
 * Register footer widget areas
 */
function portfolio_pro_widgets_init() {
    // Footer About Widget Area
    register_sidebar(
        array(
            'name'          => esc_html__('Footer About', 'portfolio-pro'),
            'id'            => 'footer-about',
            'description'   => esc_html__('Add widgets for the footer about section.', 'portfolio-pro'),
            'before_widget' => '<div class="footer-widget footer-about">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>',
        )
    );
    
    // Footer Links Widget Area
    register_sidebar(
        array(
            'name'          => esc_html__('Footer Links', 'portfolio-pro'),
            'id'            => 'footer-links',
            'description'   => esc_html__('Add widgets for the footer links section.', 'portfolio-pro'),
            'before_widget' => '<div class="footer-widget footer-links">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>',
        )
    );
    
    // Footer Navigation Widget Area
    register_sidebar(
        array(
            'name'          => esc_html__('Footer Navigation', 'portfolio-pro'),
            'id'            => 'footer-nav',
            'description'   => esc_html__('Add widgets for the footer navigation section.', 'portfolio-pro'),
            'before_widget' => '<div class="footer-widget footer-nav">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>',
        )
    );
    
    // Footer Contact Widget Area
    register_sidebar(
        array(
            'name'          => esc_html__('Footer Contact', 'portfolio-pro'),
            'id'            => 'footer-contact',
            'description'   => esc_html__('Add widgets for the footer contact section.', 'portfolio-pro'),
            'before_widget' => '<div class="footer-widget footer-contact">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>',
        )
    );
}
add_action('widgets_init', 'portfolio_pro_widgets_init');

/**
 * WordPress Customizer Settings
 * 
 * Adds customizer panels for easy theme configuration including:
 * - Hero section content
 * - Social media links  
 * - Contact information
 * - Resume upload
 */

/**
 * Configure hero section in WordPress Customizer
 */
function stylefolio_hero_customizer($wp_customize) {
    // Add Hero Section
    $wp_customize->add_section('stylefolio_hero_section', array(
        'title' => __('Hero Section', 'portfolio-pro'),
        'priority' => 30,
        'description' => __('Customize the hero section of your portfolio.', 'portfolio-pro'),
    ));
    
    // Hero Greeting
    $wp_customize->add_setting('hero_greeting', array(
        'default' => 'Hi, I\'m',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_greeting', array(
        'label' => __('Greeting Text', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'text',
    ));
    
    // Hero Name
    $wp_customize->add_setting('hero_name', array(
        'default' => 'Abdul Haseeb',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_name', array(
        'label' => __('Your Name', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'text',
    ));
    
    // Hero Profession
    $wp_customize->add_setting('hero_profession', array(
        'default' => 'Full Stack Developer',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_profession', array(
        'label' => __('Your Profession', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'text',
    ));
    
    // Hero Description
    $wp_customize->add_setting('hero_description', array(
        'default' => 'Crafting innovative digital experiences with clean code and pixel-perfect design.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('hero_description', array(
        'label' => __('Description', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'textarea',
    ));
    
    // Hero Image
    $wp_customize->add_setting('hero_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hero_image', array(
        'label' => __('Hero Image', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'mime_type' => 'image',
    )));
    
    // Primary CTA Button
    $wp_customize->add_setting('hero_cta_primary_text', array(
        'default' => 'Hire Me',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_cta_primary_text', array(
        'label' => __('Primary Button Text', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('hero_cta_primary_url', array(
        'default' => '#contact',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hero_cta_primary_url', array(
        'label' => __('Primary Button URL', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'url',
    ));
    
    // Secondary CTA Button
    $wp_customize->add_setting('hero_cta_secondary_text', array(
        'default' => 'View Projects',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_cta_secondary_text', array(
        'label' => __('Secondary Button Text', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('hero_cta_secondary_url', array(
        'default' => '#portfolio',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hero_cta_secondary_url', array(
        'label' => __('Secondary Button URL', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'url',
    ));
    
    // Tertiary CTA Button
    $wp_customize->add_setting('hero_cta_tertiary_text', array(
        'default' => 'Download Resume',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_cta_tertiary_text', array(
        'label' => __('Download Button Text', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'text',
    ));    // Resume Upload
    $wp_customize->add_setting('hero_resume_file', array(
        'default' => '',
        'sanitize_callback' => 'stylefolio_sanitize_resume_file',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hero_resume_file', array(
        'label' => __('Upload Resume (PDF, DOC, DOCX)', 'portfolio-pro'),
        'description' => __('Upload your resume file. Only PDF, DOC, and DOCX formats are allowed.', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'mime_type' => 'application',
    )));
}
add_action('customize_register', 'stylefolio_hero_customizer');

/**
 * Social Media Links Customizer Settings
 */
function stylefolio_social_links_customizer($wp_customize) {
    // Add Social Links Section to existing Hero Section
    $wp_customize->add_setting('hero_social_heading', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'hero_social_heading', array(
        'label' => __('Social Media Links', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'settings' => 'hero_social_heading',
        'type' => 'hidden',
        'priority' => 90,
    )));
    
    // LinkedIn
    $wp_customize->add_setting('hero_social_linkedin', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('hero_social_linkedin', array(
        'label' => __('LinkedIn URL', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'url',
        'priority' => 91,
    ));
    
    $wp_customize->add_setting('hero_social_linkedin_enabled', array(
        'default' => true,
        'sanitize_callback' => 'stylefolio_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('hero_social_linkedin_enabled', array(
        'label' => __('Show LinkedIn', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'checkbox',
        'priority' => 92,
    ));
    
    // GitHub
    $wp_customize->add_setting('hero_social_github', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('hero_social_github', array(
        'label' => __('GitHub URL', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'url',
        'priority' => 93,
    ));
    
    $wp_customize->add_setting('hero_social_github_enabled', array(
        'default' => true,
        'sanitize_callback' => 'stylefolio_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('hero_social_github_enabled', array(
        'label' => __('Show GitHub', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'checkbox',
        'priority' => 94,
    ));
    
    // Twitter
    $wp_customize->add_setting('hero_social_twitter', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('hero_social_twitter', array(
        'label' => __('Twitter URL', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'url',
        'priority' => 95,
    ));
    
    $wp_customize->add_setting('hero_social_twitter_enabled', array(
        'default' => true,
        'sanitize_callback' => 'stylefolio_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('hero_social_twitter_enabled', array(
        'label' => __('Show Twitter', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'checkbox',
        'priority' => 96,
    ));
    
    // Medium
    $wp_customize->add_setting('hero_social_medium', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('hero_social_medium', array(
        'label' => __('Medium URL', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'url',
        'priority' => 97,
    ));
    
    $wp_customize->add_setting('hero_social_medium_enabled', array(
        'default' => true,
        'sanitize_callback' => 'stylefolio_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('hero_social_medium_enabled', array(
        'label' => __('Show Medium', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'checkbox',
        'priority' => 98,
    ));
    
    // Custom Social Link
    $wp_customize->add_setting('hero_social_custom', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('hero_social_custom', array(
        'label' => __('Custom Social URL', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'url',
        'priority' => 99,
    ));
    
    $wp_customize->add_setting('hero_social_custom_icon', array(
        'default' => 'fab fa-instagram',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_social_custom_icon', array(
        'label' => __('Custom Icon Class (Font Awesome)', 'portfolio-pro'),
        'description' => __('Example: fab fa-instagram', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'text',
        'priority' => 100,
    ));
    
    $wp_customize->add_setting('hero_social_custom_enabled', array(
        'default' => false,
        'sanitize_callback' => 'stylefolio_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('hero_social_custom_enabled', array(
        'label' => __('Show Custom Social Icon', 'portfolio-pro'),
        'section' => 'stylefolio_hero_section',
        'type' => 'checkbox',
        'priority' => 101,
    ));
}
add_action('customize_register', 'stylefolio_social_links_customizer');

/**
 * Helper Functions
 * 
 * Utility functions for sanitization, validation, and common theme operations.
 */

/**
 * Sanitize checkbox input for customizer
 */
function stylefolio_sanitize_checkbox($input) {
    return (isset($input) && true == $input) ? true : false;
}


/**
 * Validate resume file uploads (PDF, DOC, DOCX only)
 */
function stylefolio_sanitize_resume_file($input) {
    if (empty($input)) {
        return '';
    }
    
    $attachment_id = absint($input);
    if (!$attachment_id) {
        return '';
    }
    
    // Get file info
    $file_path = get_attached_file($attachment_id);
    if (!$file_path) {
        return '';
    }
    
    $file_info = pathinfo($file_path);
    $extension = strtolower($file_info['extension']);
    
    // Allowed extensions
    $allowed_extensions = array('pdf', 'doc', 'docx');
    
    if (!in_array($extension, $allowed_extensions)) {
        // Add customizer error message
        add_settings_error(
            'hero_resume_file',
            'invalid_file_type',
            __('Invalid file type. Please upload only PDF, DOC, or DOCX files.', 'portfolio-pro')
        );
        return '';
    }
    
    // Validate MIME type as additional security
    $mime_type = get_post_mime_type($attachment_id);
    $allowed_mime_types = array(
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    );
    
    if (!in_array($mime_type, $allowed_mime_types)) {
        add_settings_error(
            'hero_resume_file',
            'invalid_mime_type',
            __('Invalid file format. Please upload a valid PDF, DOC, or DOCX file.', 'portfolio-pro')
        );
        return '';
    }
    
    return $attachment_id;
}

/**
 * Resume Download Handler
 * Handles secure resume downloads with proper headers and validation
 */
function stylefolio_handle_resume_download() {
    // Check if this is a resume download request
    if (!isset($_GET['resume_download']) || $_GET['resume_download'] !== '1') {
        return;
    }
    
    // Add nonce verification for security
    if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'download_resume')) {
        wp_die(__('Security check failed.', 'portfolio-pro'), __('Download Error', 'portfolio-pro'), array('response' => 403));
    }
    
    // Get the resume file ID from customizer
    $resume_file_id = get_theme_mod('hero_resume_file');
    
    if (!$resume_file_id) {
        wp_die(__('Resume file not found. Please contact the site administrator.', 'portfolio-pro'), __('File Not Found', 'portfolio-pro'), array('response' => 404));
    }
    
    // Validate attachment exists and is accessible
    $attachment = get_post($resume_file_id);
    if (!$attachment || $attachment->post_type !== 'attachment') {
        wp_die(__('Invalid resume file. Please contact the site administrator.', 'portfolio-pro'), __('Invalid File', 'portfolio-pro'), array('response' => 404));
    }
    
    // Get file path
    $file_path = get_attached_file($resume_file_id);
    
    if (!$file_path || !file_exists($file_path)) {
        wp_die(__('Resume file not found on server. Please contact the site administrator.', 'portfolio-pro'), __('File Not Found', 'portfolio-pro'), array('response' => 404));
    }
    
    // Get file info
    $file_info = pathinfo($file_path);
    $extension = strtolower($file_info['extension']);
    
    // Double-check file type for security
    $allowed_extensions = array('pdf', 'doc', 'docx');
    if (!in_array($extension, $allowed_extensions)) {
        wp_die(__('Invalid file type.', 'portfolio-pro'), __('Invalid File', 'portfolio-pro'), array('response' => 403));
    }
    
    // Get original filename or create a clean one
    $original_title = get_the_title($resume_file_id);
    $clean_filename = $original_title ? sanitize_file_name($original_title) . '.' . $extension : 'resume.' . $extension;
    
    // Set proper mime type based on extension
    $mime_types = array(
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    );
    
    $mime_type = $mime_types[$extension];
    
    // Get file size
    $file_size = filesize($file_path);
    
    // Clean any output buffer
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    // Set headers for secure download
    header('Content-Type: ' . $mime_type);
    header('Content-Disposition: attachment; filename="' . $clean_filename . '"');
    header('Content-Length: ' . $file_size);
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    header('X-Robots-Tag: noindex, nofollow');
    
    // Prevent any further output
    header('Connection: close');
    
    // Output file in chunks for better memory management
    $chunk_size = 8192;
    $handle = fopen($file_path, 'rb');
    
    if ($handle === false) {
        wp_die(__('Cannot read resume file.', 'portfolio-pro'), __('Read Error', 'portfolio-pro'), array('response' => 500));
    }
    
    while (!feof($handle)) {
        $chunk = fread($handle, $chunk_size);
        echo $chunk;
        flush();
    }
    
    fclose($handle);
    exit;
}
add_action('init', 'stylefolio_handle_resume_download');

/**
 * Get Resume Download URL
 * Returns the proper download URL for the resume with security nonce
 */
function stylefolio_get_resume_download_url() {
    // Check if a resume file is uploaded
    $resume_file_id = get_theme_mod('hero_resume_file');
    
    if ($resume_file_id) {
        // Validate file still exists and is valid
        $file_path = get_attached_file($resume_file_id);
        if ($file_path && file_exists($file_path)) {
            // Return secure download URL with nonce
            return add_query_arg(array(
                'resume_download' => '1',
                '_wpnonce' => wp_create_nonce('download_resume')
            ), home_url('/'));
        }
    }
    
    // Return # if no resume uploaded
    return '#';
}

/**
 * Add admin notice for resume upload feature
 */
function stylefolio_resume_admin_notice() {
    $screen = get_current_screen();
    
    // Only show on customizer page
    if ($screen && $screen->id === 'customize') {
        return;
    }
    
    // Check if user can manage options and resume is not uploaded yet
    if (current_user_can('manage_options') && !get_theme_mod('hero_resume_file')) {
        echo '<div class="notice notice-info is-dismissible">';
        echo '<p><strong>Stylefolio Resume Feature:</strong> ';
        echo 'You can now upload your resume in <a href="' . admin_url('customize.php?autofocus[section]=stylefolio_hero_section') . '">Appearance → Customize → Hero Section</a>. ';
        echo 'Users will be able to download it directly from your website!</p>';
        echo '</div>';
    }
}
add_action('admin_notices', 'stylefolio_resume_admin_notice');

/**
 * Add JavaScript to restrict file uploads in customizer for resume
 */
function stylefolio_customizer_scripts() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Override media uploader for resume upload
        if (typeof wp !== 'undefined' && wp.customize) {
            wp.customize.control('hero_resume_file', function(control) {
                control.container.on('click', '.upload-button, .thumbnail-image img', function(e) {
                    e.preventDefault();
                    
                    var uploader = wp.media({
                        title: 'Select Resume File',
                        button: {
                            text: 'Select Resume'
                        },
                        library: {
                            type: ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']
                        },
                        multiple: false
                    });
                    
                    uploader.on('select', function() {
                        var attachment = uploader.state().get('selection').first().toJSON();
                        
                        // Double-check file type
                        var allowedTypes = [
                            'application/pdf',
                            'application/msword', 
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                        ];
                        
                        if (allowedTypes.indexOf(attachment.mime) === -1) {
                            alert('Please select only PDF, DOC, or DOCX files.');
                            return;
                        }
                        
                        control.setting.set(attachment.id);
                    });
                    
                    uploader.open();
                    return false;
                });
            });
        }
    });
    </script>
    <?php
}
add_action('customize_controls_print_footer_scripts', 'stylefolio_customizer_scripts');

/**
 * Filter upload mimes to ensure only allowed resume formats
 */
function stylefolio_filter_resume_mimes($mimes) {
    // Only filter when in customizer context for resume upload
    if (is_admin() && isset($_REQUEST['action']) && $_REQUEST['action'] === 'query-attachments') {
        // Allow only resume file types
        $resume_mimes = array(
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        );
        
        // Check if this is for resume upload (basic check)
        if (isset($_REQUEST['query']) && is_array($_REQUEST['query']) && 
            isset($_REQUEST['query']['type']) && 
            $_REQUEST['query']['type'] === 'application') {
            return $resume_mimes;
        }
    }
    
    return $mimes;
}
add_filter('upload_mimes', 'stylefolio_filter_resume_mimes');

/**
 * Validate resume file upload on server side
 */
function stylefolio_validate_resume_upload($file) {
    // Only validate if this is a potential resume file
    if (!isset($file['type']) || strpos($file['type'], 'application/') !== 0) {
        return $file;
    }
    
    $allowed_types = array(
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    );
    
    $allowed_extensions = array('pdf', 'doc', 'docx');
    
    // Check MIME type
    if (!in_array($file['type'], $allowed_types)) {
        // Check if this might be intended as a resume based on filename
        $filename = strtolower($file['name']);
        if (strpos($filename, 'resume') !== false || 
            strpos($filename, 'cv') !== false ||
            in_array(pathinfo($filename, PATHINFO_EXTENSION), $allowed_extensions)) {
            
            $file['error'] = 'Invalid resume file type. Please upload only PDF, DOC, or DOCX files.';
        }
    }
    
    // Additional extension check
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (in_array($file['type'], $allowed_types) && !in_array($file_extension, $allowed_extensions)) {
        $file['error'] = 'File extension does not match the file type. Please upload a valid resume file.';
    }
    
    return $file;
}
add_filter('wp_handle_upload_prefilter', 'stylefolio_validate_resume_upload');

/**
 * Add helpful error messages for resume uploads
 */
function stylefolio_resume_upload_error_messages() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Add error handling for resume uploads in customizer
        if (typeof wp !== 'undefined' && wp.customize) {
            $(document).on('click', '[data-customize-setting-link="hero_resume_file"] .upload-button', function() {
                setTimeout(function() {
                    $('.media-modal').on('click', '.media-button-select', function() {
                        var selected = wp.media.frame.state().get('selection').first();
                        if (selected) {
                            var mime = selected.get('mime');
                            var filename = selected.get('filename');
                            var allowedMimes = [
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                            ];
                            
                            if (allowedMimes.indexOf(mime) === -1) {
                                alert('Error: Please select only PDF, DOC, or DOCX files for your resume.\n\nSelected file: ' + filename + '\nFile type: ' + mime);
                                return false;
                            }
                        }
                    });
                }, 100);
            });
        }
    });
    </script>
    <?php
}
add_action('customize_controls_print_footer_scripts', 'stylefolio_resume_upload_error_messages');

/**
 * Custom Post Types & ACF Integration
 * 
 * Loads all custom post types, ACF fields, and admin functionality.
 */

/**
 * Load theme framework files
 */
function portfolio_pro_load_cpt_framework() {
    // Theme framework directories
    $directories = array(
        '/inc/core/',
        '/inc/cpt/',
        '/inc/acf/',
        '/inc/data/',
        '/inc/admin/',
    );
    
    // Load all PHP files in each directory
    foreach ($directories as $directory) {
        $dir_path = get_template_directory() . $directory;
        
        if (is_dir($dir_path)) {
            $files = glob($dir_path . '*.php');
            
            if ($files) {
                foreach ($files as $file) {
                    if (file_exists($file)) {
                        require_once $file;
                    }
                }
            }
        }
    }
}
add_action('after_setup_theme', 'portfolio_pro_load_cpt_framework');

/**
 * Include ACF Fields and Options
 */
function portfolio_pro_include_acf_files() {
    $acf_file = get_template_directory() . '/inc/acf-fields.php';
    if (file_exists($acf_file)) {
        require_once $acf_file;
    }
}
add_action('after_setup_theme', 'portfolio_pro_include_acf_files');

/**
 * Set section template path based on CPT availability
 */
function portfolio_pro_get_skills_template() {
    // First check if CPT approach is available and has data
    if (post_type_exists('skill') && post_type_exists('skill_category')) {
        return 'section-skills-cpt';
    }
    
    // Then check if ACF options approach is available
    if (function_exists('get_field')) {
        return 'section-skills-acf';
    }
    
    // Otherwise, fall back to the default version
    return 'section-skills';
}

/**
 * Add a cache-busting parameter to ensure skills changes are shown immediately
 */
function portfolio_pro_bust_skills_cache() {
    // Only add this script on the front page
    if (!is_front_page() && !is_home()) {
        return;
    }
    ?>
    <script>
        // Add a timestamp to force browser to get fresh data
        const skillsUpdateTime = '<?php echo date("YmdHis"); ?>';
        
        // Add event listener to refresh page when admin bar edit links are clicked
        document.addEventListener('DOMContentLoaded', function() {
            const adminBarLinks = document.querySelectorAll('#wpadminbar a[href*="post_type=skill"], #wpadminbar a[href*="post_type=skill_category"], #wpadminbar a[href*="post_type=tech_skill"]');
            adminBarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Set a session storage flag that will trigger a refresh when returning to the page
                    sessionStorage.setItem('portfolioSkillsEdited', 'true');
                });
            });
            
            // Check if we're returning from editing skills
            if (sessionStorage.getItem('portfolioSkillsEdited') === 'true') {
                // Clear the flag
                sessionStorage.removeItem('portfolioSkillsEdited');
                // Force a hard refresh to show the latest data
                if (window.location.href.indexOf('?') >= 0) {
                    window.location.href = window.location.href + '&refresh=' + Math.random();
                } else {
                    window.location.href = window.location.href + '?refresh=' + Math.random();
                }
            }
        });
    </script>
    <?php
}
add_action('wp_footer', 'portfolio_pro_bust_skills_cache');

/**
 * Clear cache when skills CPT items are saved
 */
function portfolio_pro_clear_skills_cache($post_id, $post) {
    // Skip autosaves and revisions
    if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
        return;
    }
    
    // Only run for our custom post types
    $post_types = array('skill', 'skill_category', 'tech_skill', 'skills_setting');
    
    if (!in_array($post->post_type, $post_types)) {
        return;
    }
    
    // Clear any transients or caches
    delete_transient('portfolio_pro_skills_data');
    
    // Bump a version number for cache busting
    $version = get_option('portfolio_pro_skills_version', 1);
    update_option('portfolio_pro_skills_version', $version + 1);
}
add_action('save_post', 'portfolio_pro_clear_skills_cache', 10, 2);

/**
 * Function to get the correct template path for any section
 */
function portfolio_pro_get_section_template($section) {
    // Special handling for skills section
    if ($section === 'skills') {
        return portfolio_pro_get_skills_template();
    }
    
    // Default template
    return "section-{$section}";
}

/**
 * Debug Skills Section Loading
 */
function portfolio_pro_debug_skills_section() {
    // Only show when logged in
    if (!current_user_can('edit_posts')) {
        return;
    }
    
    // Check if sections are missing
    if (isset($_GET['debug_sections'])) {
        echo '<div style="position:fixed; top:32px; right:0; z-index:99999; background:#23282d; color:#fff; padding:15px; max-width:400px; max-height:80vh; overflow:auto; font-family:monospace; font-size:12px;">';
        echo '<h3>Skills Section Debug</h3>';
        
        // Check template paths
        echo '<h4>Template Paths:</h4>';
        $template_paths = array(
            'section-skills-cpt.php' => file_exists(get_template_directory() . '/template-parts/section-skills-cpt.php'),
            'section-skills-acf.php' => file_exists(get_template_directory() . '/template-parts/section-skills-acf.php'),
            'section-skills.php' => file_exists(get_template_directory() . '/template-parts/section-skills.php')
        );
        
        echo '<ul>';
        foreach ($template_paths as $path => $exists) {
            echo '<li>' . $path . ': ' . ($exists ? '<span style="color:green">Found</span>' : '<span style="color:red">Missing</span>') . '</li>';
        }
        echo '</ul>';
        
        // Check template selection
        echo '<h4>Template Selection:</h4>';
        echo '<p>Selected template: ' . portfolio_pro_get_skills_template() . '</p>';
        
        // Check post types
        echo '<h4>Custom Post Types:</h4>';
        echo '<ul>';
        echo '<li>skill post type exists: ' . (post_type_exists('skill') ? 'Yes' : 'No') . '</li>';
        echo '<li>skill_category post type exists: ' . (post_type_exists('skill_category') ? 'Yes' : 'No') . '</li>';
        echo '<li>tech_skill post type exists: ' . (post_type_exists('tech_skill') ? 'Yes' : 'No') . '</li>';
        echo '<li>skills_setting post type exists: ' . (post_type_exists('skills_setting') ? 'Yes' : 'No') . '</li>';
        echo '</ul>';
        
        // Check data
        echo '<h4>Data Check:</h4>';
        
        // Check skills data
        $skills_args = array(
            'post_type' => 'skill',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        );
        
        $skills_query = new WP_Query($skills_args);
        echo '<p>Skills count: ' . $skills_query->found_posts . '</p>';
        
        // Check category data
        $cat_args = array(
            'post_type' => 'skill_category',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        );
        
        $cat_query = new WP_Query($cat_args);
        echo '<p>Categories count: ' . $cat_query->found_posts . '</p>';
        
        // Check settings data
        $settings_args = array(
            'post_type' => 'skills_setting',
            'posts_per_page' => 1,
            'post_status' => 'publish',
        );
        
        $settings_query = new WP_Query($settings_args);
        echo '<p>Settings posts: ' . $settings_query->found_posts . '</p>';
        
        // Check ACF
        echo '<h4>ACF Status:</h4>';
        echo '<p>ACF functions exist: ' . (function_exists('get_field') ? 'Yes' : 'No') . '</p>';
        
        if (function_exists('get_field') && $settings_query->have_posts()) {
            $settings_query->the_post();
            $settings_id = get_the_ID();
            wp_reset_postdata();
            
            echo '<p>Settings title field: ' . (get_field('skills_title', $settings_id) ? get_field('skills_title', $settings_id) : 'Not found') . '</p>';
        }
        
        echo '<p><a href="#" onclick="this.parentNode.parentNode.style.display=\'none\'; return false;" style="color:yellow;">Close</a></p>';
        echo '</div>';
    }
}
add_action('wp_footer', 'portfolio_pro_debug_skills_section');

/**
 * Enqueue portfolio scripts and styles
 */
function portfolio_pro_portfolio_scripts() {
    // Enqueue Isotope for filtering and layouts
    wp_enqueue_script(
        'isotope',
        'https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js',
        array('jquery'),
        '3.0.6',
        true
    );
    
    // Enqueue imagesLoaded for proper Isotope initialization
    wp_enqueue_script(
        'imagesloaded',
        'https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js',
        array('jquery'),
        '5.0.0',
        true
    );
    
    // Enqueue portfolio CSS
    wp_enqueue_style(
        'portfolio-pro-portfolio',
        get_template_directory_uri() . '/assets/css/portfolio.css',
        array('portfolio-pro-main'),
        get_option('portfolio_pro_projects_version', PORTFOLIO_PRO_VERSION)
    );
    
    // Enqueue portfolio JS
    wp_enqueue_script(
        'portfolio-pro-portfolio',
        get_template_directory_uri() . '/assets/js/portfolio.js',
        array('jquery', 'isotope', 'imagesloaded'),
        get_option('portfolio_pro_projects_version', PORTFOLIO_PRO_VERSION),
        true
    );
}
add_action('wp_enqueue_scripts', 'portfolio_pro_portfolio_scripts');

/**
 * Add CSS to handle popup body scrolling
 */
function portfolio_pro_popup_scroll_fix() {
    ?>
    <style>
        body.popup-open {
            overflow: hidden;
        }
    </style>
    <?php
}
add_action('wp_head', 'portfolio_pro_popup_scroll_fix');

/**
 * Clear cache when project CPT items are saved
 */
function portfolio_pro_clear_projects_cache($post_id, $post) {
    // Skip autosaves and revisions
    if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
        return;
    }
    
    // Only run for our custom post types
    $post_types = array('project', 'project_category', 'portfolio_settings');
    
    if (!in_array($post->post_type, $post_types)) {
        return;
    }
    
    // Bump a version number for cache busting
    $version = get_option('portfolio_pro_projects_version', 1);
    update_option('portfolio_pro_projects_version', $version + 1);
}
add_action('save_post', 'portfolio_pro_clear_projects_cache', 10, 2);


/**
 * Enqueue testimonials scripts
 */
function stylefolio_enqueue_testimonials_assets() {
    // Enqueue Slick Slider library if not already included
    if (!wp_script_is('slick-slider', 'enqueued')) {
        wp_enqueue_style(
            'slick-slider',
            'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css',
            array(),
            '1.8.1'
        );
        
        wp_enqueue_script(
            'slick-slider',
            'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
            array('jquery'),
            '1.8.1',
            true
        );
    }
    
    // Enqueue testimonials styles and scripts
    wp_enqueue_style(
        'stylefolio-testimonials',
        get_template_directory_uri() . '/assets/css/testimonals.css',
        array(),
        '1.0.0'
    );
    
    wp_enqueue_script(
        'stylefolio-testimonials',
        get_template_directory_uri() . '/assets/js/testimonals.js',
        array('jquery', 'slick-slider'),
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'stylefolio_enqueue_testimonials_assets');

// Reset portfolio data initialization
function portfolio_pro_reset_initialization() {
    if (isset($_GET['reset_portfolio']) && current_user_can('manage_options')) {
        delete_option('portfolio_pro_projects_data_initialized');
        echo '<div class="notice notice-success"><p>Portfolio data initialization flag has been reset.</p></div>';
    }
}
add_action('admin_notices', 'portfolio_pro_reset_initialization');


/**
 * Enqueue experience scripts and styles
 */
function stylefolio_enqueue_experience_assets() {
    // Enqueue styles
    wp_enqueue_style(
        'stylefolio-experience',
        get_template_directory_uri() . '/assets/css/experience.css',
        array(),
        '1.0.0'
    );
    
    // Enqueue scripts
    wp_enqueue_script(
        'stylefolio-experience',
        get_template_directory_uri() . '/assets/js/experience.js',
        array('jquery'),
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'stylefolio_enqueue_experience_assets');

/**
 * Enqueue education scripts and styles
 */
function stylefolio_enqueue_education_assets() {
    // Enqueue styles
    wp_enqueue_style(
        'stylefolio-education',
        get_template_directory_uri() . '/assets/css/education.css',
        array(),
        '1.0.0'
    );
    
    // Enqueue scripts
    wp_enqueue_script(
        'stylefolio-education',
        get_template_directory_uri() . '/assets/js/education.js',
        array('jquery'),
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'stylefolio_enqueue_education_assets');

/**
 * Include contact form files directly
 */
// Include the contact submissions post type
require_once get_template_directory() . '/inc/cpt/cpt-contact.php';

// Include the contact form handler  
require_once get_template_directory() . '/inc/core/contact-form-handler.php';

// Include the contact form customizer settings
require_once get_template_directory() . '/inc/contact-form-customizer.php';

/**
 * Enqueue contact form styles and scripts
 */
function stylefolio_enqueue_contact_assets() {
    // Enqueue the contact form CSS
    wp_enqueue_style(
        'stylefolio-contact',
        get_template_directory_uri() . '/assets/css/contact.css',
        array(),
        '1.0.0'
    );
    
    // Enqueue the contact form JavaScript
    wp_enqueue_script(
        'stylefolio-contact',
        get_template_directory_uri() . '/assets/js/contact.js',
        array('jquery'),
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'stylefolio_enqueue_contact_assets');

/**
 * Add admin notification for contact form email settings
 */
function stylefolio_contact_form_admin_notice() {
    // Only show to admins
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Check if notification email is set
    $notification_email = get_theme_mod('contact_form_email', '');
    
    if (empty($notification_email) && !get_transient('stylefolio_contact_email_notice_dismissed')) {
        ?>
        <div class="notice notice-warning is-dismissible stylefolio-contact-notice">
            <p><?php _e('<strong>Stylefolio Theme:</strong> Contact form email notifications are not configured. Submissions will be stored in the database but no email notifications will be sent. <a href="' . esc_url(admin_url('customize.php?autofocus[section]=stylefolio_contact_form_section')) . '">Configure now</a>', 'stylefolio'); ?></p>
        </div>
        <script>
            jQuery(document).ready(function($) {
                $(document).on('click', '.stylefolio-contact-notice .notice-dismiss', function() {
                    $.ajax({
                        url: ajaxurl,
                        data: {
                            action: 'stylefolio_dismiss_contact_notice'
                        }
                    });
                });
            });
        </script>
        <?php
    }
}
add_action('admin_notices', 'stylefolio_contact_form_admin_notice');

/**
 * Ajax handler to dismiss the admin notice
 */
function stylefolio_dismiss_contact_notice() {
    // Set transient for 30 days
    set_transient('stylefolio_contact_email_notice_dismissed', true, 30 * DAY_IN_SECONDS);
    wp_die();
}
add_action('wp_ajax_stylefolio_dismiss_contact_notice', 'stylefolio_dismiss_contact_notice');
/**
 * Navigation Enhancements
 * 
 * Custom navigation menu functions and fallback menus.
 */

/**
 * Default navigation menu when no menu is assigned
 */
function portfolio_pro_fallback_menu() {
    echo '<ul id="primary-menu" class="nav-menu">';
    echo '<li><a href="#hero">Home</a></li>';
    echo '<li><a href="#skills">Skills</a></li>';
    echo '<li><a href="#portfolio">Portfolio</a></li>';
    echo '<li><a href="#testimonials">Testimonials</a></li>';
    echo '<li><a href="#experience">Experience</a></li>';
    echo '<li><a href="#education">Education</a></li>';
    echo '<li><a href="#contact">Contact</a></li>';
    echo '</ul>';
}

/**
 * Automatically create primary navigation menu on theme activation
 */
function portfolio_pro_create_navigation_menu() {
    // Check if primary menu location exists and has no menu assigned
    $locations = get_theme_mod('nav_menu_locations');
    
    if (!isset($locations['primary']) || !$locations['primary']) {
        // Create a new menu
        $menu_name = 'Portfolio Navigation';
        $menu_id = wp_create_nav_menu($menu_name);
        
        if (!is_wp_error($menu_id)) {
            // Add menu items for each section
            $menu_items = array(
                array('title' => 'Home', 'url' => '#hero'),
                array('title' => 'About', 'url' => '#about'),
                array('title' => 'Skills', 'url' => '#skills'),
                array('title' => 'Portfolio', 'url' => '#portfolio'),
                array('title' => 'Resume', 'url' => '#resume'),
                array('title' => 'Testimonials', 'url' => '#testimonials'),
                array('title' => 'Experience', 'url' => '#experience'),
                array('title' => 'Education', 'url' => '#education'),
                array('title' => 'Blog', 'url' => '#blog'),
                array('title' => 'Contact', 'url' => '#contact'),
            );
            
            foreach ($menu_items as $index => $item) {
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' => $item['title'],
                    'menu-item-url' => home_url('/') . $item['url'],
                    'menu-item-status' => 'publish',
                    'menu-item-position' => $index + 1,
                ));
            }
            
            // Assign menu to primary location
            $locations['primary'] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
        }
    }
}

/**
 * Initialize navigation menu on theme activation
 */
function portfolio_pro_after_switch_theme() {
    portfolio_pro_create_navigation_menu();
}
add_action('after_switch_theme', 'portfolio_pro_after_switch_theme');

/**
 * Check and create menu if needed
 */
function portfolio_pro_check_navigation_menu() {
    if (is_admin()) {
        return;
    }
    
    $locations = get_theme_mod('nav_menu_locations');
    if (!isset($locations['primary']) || !$locations['primary']) {
        portfolio_pro_create_navigation_menu();
    }
}
add_action('wp_loaded', 'portfolio_pro_check_navigation_menu');

/**
 * Theme Debug & Development Functions
 * 
 * Temporary functions for troubleshooting. Remove these in production.
 */

/**
 * Backup CPT registration (for debugging only)
 */
function stylefolio_force_register_all_cpts() {
    // Hero Content CPT
    if (!post_type_exists('hero_content')) {
        register_post_type('hero_content', array(
            'labels' => array(
                'name' => 'Hero Content',
                'singular_name' => 'Hero Content',
                'menu_name' => 'Hero Section',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Hero Content',
                'edit_item' => 'Edit Hero Content',
                'new_item' => 'New Hero Content',
                'view_item' => 'View Hero Content',
                'search_items' => 'Search Hero Content',
                'not_found' => 'No hero content found',
                'not_found_in_trash' => 'No hero content found in Trash'
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 25,
            'menu_icon' => 'dashicons-format-image',
            'supports' => array('title', 'editor', 'thumbnail'),
            'capability_type' => 'page',
            'show_in_rest' => true,
        ));
    }
    
    // Experience CPT
    if (!post_type_exists('experience')) {
        register_post_type('experience', array(
            'labels' => array(
                'name' => 'Work Experience',
                'singular_name' => 'Experience',
                'menu_name' => 'Work Experience',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Experience',
                'edit_item' => 'Edit Experience',
                'new_item' => 'New Experience',
                'view_item' => 'View Experience',
                'search_items' => 'Search Experience',
                'not_found' => 'No experience found',
                'not_found_in_trash' => 'No experience found in Trash'
            ),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 20,
            'menu_icon' => 'dashicons-businessman',
            'supports' => array('title', 'editor', 'thumbnail'),
            'capability_type' => 'page',
            'show_in_rest' => true,
        ));
    }
    
    // Education CPT
    if (!post_type_exists('education')) {
        register_post_type('education', array(
            'labels' => array(
                'name' => 'Education',
                'singular_name' => 'Education',
                'menu_name' => 'Education',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Education',
                'edit_item' => 'Edit Education',
                'new_item' => 'New Education',
                'view_item' => 'View Education',
                'search_items' => 'Search Education',
                'not_found' => 'No education found',
                'not_found_in_trash' => 'No education found in Trash'
            ),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 21,
            'menu_icon' => 'dashicons-welcome-learn-more',
            'supports' => array('title', 'editor', 'thumbnail'),
            'capability_type' => 'page',
            'show_in_rest' => true,
        ));
    }
    
    // Contact Submissions CPT
    if (!post_type_exists('contact_submission')) {
        register_post_type('contact_submission', array(
            'labels' => array(
                'name' => 'Contact Submissions',
                'singular_name' => 'Contact Submission',
                'menu_name' => 'Contact Submissions',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Submission',
                'edit_item' => 'Edit Submission',
                'new_item' => 'New Submission',
                'view_item' => 'View Submission',
                'search_items' => 'Search Submissions',
                'not_found' => 'No submissions found',
                'not_found_in_trash' => 'No submissions found in Trash'
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 30,
            'menu_icon' => 'dashicons-email-alt',
            'supports' => array('title', 'editor'),
            'capability_type' => 'post',
            'show_in_rest' => true,
        ));
    }
}

// Hook with high priority to ensure it runs early
add_action('init', 'stylefolio_force_register_all_cpts', 5);

/**
 * Add admin notice to show CPT status
 */
function stylefolio_cpt_admin_notice() {
    $screen = get_current_screen();
    if ($screen && $screen->id === 'dashboard') {
        $cpts = array('hero_content', 'experience', 'education', 'contact_submission');
        $registered = array();
        $missing = array();
        
        foreach ($cpts as $cpt) {
            if (post_type_exists($cpt)) {
                $registered[] = $cpt;
            } else {
                $missing[] = $cpt;
            }
        }
        
        if (!empty($registered)) {
            echo '<div class="notice notice-success"><p><strong>Custom Post Types Registered:</strong> ' . implode(', ', $registered) . '</p></div>';
        }
        
        if (!empty($missing)) {
            echo '<div class="notice notice-error"><p><strong>Missing Custom Post Types:</strong> ' . implode(', ', $missing) . '. Check your theme files.</p></div>';
        }
    }
}
add_action('admin_notices', 'stylefolio_cpt_admin_notice');

/**
 * Convert between textarea and repeater formats for responsibilities
 */
function stylefolio_responsibilities_format_converter() {
    // Convert from textarea to repeater array when saving a post
    add_action('acf/save_post', function($post_id) {
        // Only run for experience post type
        if (get_post_type($post_id) !== 'experience') {
            return;
        }
        
        // Get the textarea value
        $responsibilities_text = get_field('responsibilities_text', $post_id);
        
        if (!empty($responsibilities_text)) {
            // Convert to array format for template compatibility
            $lines = explode("\n", $responsibilities_text);
            $formatted = array();
            
            foreach ($lines as $line) {
                $line = trim($line);
                if (!empty($line)) {
                    $formatted[] = array(
                        'responsibility' => $line
                    );
                }
            }
            
            // Save as post meta for the template to use
            update_post_meta($post_id, 'responsibilities', $formatted);
        }
    }, 20);
    
    // Convert existing repeater data to textarea format
    add_action('admin_init', function() {
        // Only run once by checking for a flag
        if (get_option('stylefolio_responsibilities_converted')) {
            return;
        }
        
        // Get all experience posts
        $experiences = get_posts(array(
            'post_type' => 'experience',
            'posts_per_page' => -1,
            'post_status' => 'any'
        ));
        
        foreach ($experiences as $experience) {
            // Get the existing responsibilities in repeater format
            $responsibilities = get_post_meta($experience->ID, 'responsibilities', true);
            
            // Convert to text if it's an array
            if (is_array($responsibilities) && !empty($responsibilities)) {
                $text_lines = array();
                
                foreach ($responsibilities as $item) {
                    if (isset($item['responsibility'])) {
                        $text_lines[] = $item['responsibility'];
                    }
                }
                
                if (!empty($text_lines)) {
                    $text_value = implode("\n", $text_lines);
                    update_field('responsibilities_text', $text_value, $experience->ID);
                }
            }
        }
        
        // Set flag to avoid running this again
        update_option('stylefolio_responsibilities_converted', true);
    });
}
stylefolio_responsibilities_format_converter();

/**
 * Fix for ACF gallery fields in project
 */
function portfolio_pro_fix_project_gallery() {
    // Only in admin
    if (!is_admin()) {
        return;
    }
    
    // Only on project edit screen
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'project') {
        return;
    }
    
    // Enqueue the JS fix
    wp_enqueue_script(
        'acf-gallery-fix',
        get_template_directory_uri() . '/assets/js/acf-gallery-fix.js',
        array('jquery', 'acf-input'),
        '1.0.0',
        true
    );
    
    // Also add custom admin CSS to fix gallery display
    wp_add_inline_style('acf-input', '
        .acf-field-gallery .acf-gallery-toolbar {
            display: block !important;
            padding: 10px;
            background: #f9f9f9;
            border-top: 1px solid #ddd;
        }
        .acf-field-gallery .acf-gallery-attachments {
            display: flex;
            flex-wrap: wrap;
            padding: 10px;
            min-height: 100px;
            background: #f5f5f5;
            border-radius: 3px;
        }
        .acf-field-gallery .acf-gallery-attachment {
            width: 80px;
            height: 80px;
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
            background: #fff;
            overflow: hidden;
        }
        .acf-field-gallery .acf-gallery-attachment img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    ');
}
add_action('admin_enqueue_scripts', 'portfolio_pro_fix_project_gallery');

/**
 * Get social media profiles for contact section
 */
function stylefolio_get_social_profiles() {
    $social_profiles = array();
    
    // LinkedIn
    if (get_theme_mod('hero_social_linkedin_enabled', true) && get_theme_mod('hero_social_linkedin', '#') !== '#') {
        $social_profiles['linkedin'] = get_theme_mod('hero_social_linkedin', '#');
    }
    
    // GitHub
    if (get_theme_mod('hero_social_github_enabled', true) && get_theme_mod('hero_social_github', '#') !== '#') {
        $social_profiles['github'] = get_theme_mod('hero_social_github', '#');
    }
    
    // Twitter
    if (get_theme_mod('hero_social_twitter_enabled', true) && get_theme_mod('hero_social_twitter', '#') !== '#') {
        $social_profiles['twitter'] = get_theme_mod('hero_social_twitter', '#');
    }
    
    // Medium
    if (get_theme_mod('hero_social_medium_enabled', true) && get_theme_mod('hero_social_medium', '#') !== '#') {
        $social_profiles['medium'] = get_theme_mod('hero_social_medium', '#');
    }
    
    // Custom Social
    if (get_theme_mod('hero_social_custom_enabled', false) && get_theme_mod('hero_social_custom', '') !== '') {
        $social_profiles['custom'] = array(
            'url' => get_theme_mod('hero_social_custom', ''),
            'icon' => get_theme_mod('hero_social_custom_icon', 'fab fa-instagram')
        );
    }
    
    return $social_profiles;
}

/**
 * Get social media icon class for a platform
 */
function stylefolio_get_social_icon($platform) {
    $icons = array(
        'linkedin' => 'fab fa-linkedin-in',
        'github'   => 'fab fa-github',
        'twitter'  => 'fab fa-twitter',
        'medium'   => 'fab fa-medium-m',
        'facebook' => 'fab fa-facebook-f',
        'instagram' => 'fab fa-instagram',
        'youtube'  => 'fab fa-youtube',
        'dribbble' => 'fab fa-dribbble',
        'behance'  => 'fab fa-behance',
        'custom'   => get_theme_mod('hero_social_custom_icon', 'fab fa-instagram')
    );
    
    return isset($icons[$platform]) ? $icons[$platform] : 'fas fa-link';
}

/**
 * Fix Gravatar Tracking Prevention Issues
 * 
 * Disable external Gravatar requests to prevent tracking prevention warnings
 * and use local default avatars instead.
 */

/**
 * Disable Gravatar and use local default avatar
 */
function portfolio_pro_disable_gravatar($avatar, $id_or_email, $size, $default, $alt) {
    // Use a local default avatar
    $default_avatar_url = get_theme_file_uri('/assets/images/default-avatar.svg');
    
    // If SVG doesn't exist, create a simple data URI avatar
    if (!file_exists(get_theme_file_path('/assets/images/default-avatar.svg'))) {
        $default_avatar_url = 'data:image/svg+xml;base64,' . base64_encode('
            <svg width="' . $size . '" height="' . $size . '" xmlns="http://www.w3.org/2000/svg">
                <rect width="100%" height="100%" fill="#e1e5e9"/>
                <circle cx="' . ($size / 2) . '" cy="' . ($size * 0.4) . '" r="' . ($size * 0.15) . '" fill="#6c757d"/>
                <path d="M' . ($size * 0.3) . ' ' . ($size * 0.7) . ' Q' . ($size / 2) . ' ' . ($size * 0.6) . ' ' . ($size * 0.7) . ' ' . ($size * 0.7) . ' L' . ($size * 0.7) . ' ' . $size . ' L' . ($size * 0.3) . ' ' . $size . ' Z" fill="#6c757d"/>
            </svg>
        ');
    }
    
    return '<img alt="' . esc_attr($alt) . '" src="' . esc_url($default_avatar_url) . '" 
             class="avatar avatar-' . $size . ' photo" height="' . $size . '" width="' . $size . '" 
             loading="lazy" decoding="async" />';
}
add_filter('get_avatar', 'portfolio_pro_disable_gravatar', 10, 5);

/**
 * Remove Gravatar from WordPress entirely
 */
function portfolio_pro_remove_gravatar_options($avatar_defaults) {
    // Remove all Gravatar options and keep only local options
    $avatar_defaults = array(
        'blank' => 'Blank',
        'mystery' => 'Mystery Person'
    );
    return $avatar_defaults;
}
add_filter('avatar_defaults', 'portfolio_pro_remove_gravatar_options');

/**
 * Force local avatars only
 */
function portfolio_pro_force_local_avatars() {
    // Disable Gravatar entirely
    add_filter('pre_option_show_avatars', '__return_zero');
}
add_action('init', 'portfolio_pro_force_local_avatars');

/**
 * Elementor Support & Integration
 * 
 * Adds comprehensive Elementor support including theme locations,
 * header/footer builder integration, and styling compatibility.
 */

/**
 * Register Elementor theme locations
 */
function portfolio_pro_elementor_theme_locations() {
    if (function_exists('elementor_theme_do_location')) {
        // Register theme locations for Elementor Pro
        add_theme_support('elementor-theme-locations', array(
            'header',
            'footer',
            'single',
            'archive',
        ));
    }
}
add_action('after_setup_theme', 'portfolio_pro_elementor_theme_locations');

/**
 * Elementor Pro Header/Footer Builder Support
 */
function portfolio_pro_elementor_header_footer_support() {
    // Add support for Elementor Pro Header & Footer Builder
    add_theme_support('elementor-header-footer');
}
add_action('after_setup_theme', 'portfolio_pro_elementor_header_footer_support');

/**
 * Add Elementor custom CSS support
 */
function portfolio_pro_elementor_custom_css() {
    if (class_exists('\Elementor\Plugin')) {
        // Ensure Elementor's CSS is loaded properly
        add_action('wp_head', function() {
            if (class_exists('\Elementor\Core\Files\CSS\Post')) {
                $css_file = new \Elementor\Core\Files\CSS\Post(get_the_ID());
                $css_file->enqueue();
            }
        });
    }
}
add_action('wp_enqueue_scripts', 'portfolio_pro_elementor_custom_css');

/**
 * Elementor compatibility styles
 */
function portfolio_pro_elementor_styles() {
    if (class_exists('\Elementor\Plugin')) {
        wp_add_inline_style('portfolio-pro-style', '
            /* Elementor Compatibility Styles */
            .elementor-page .site-main {
                width: 100%;
                max-width: none;
                margin: 0;
                padding: 0;
            }
            
            .elementor-page .container {
                max-width: none;
                padding: 0;
            }
            
            .elementor-section-wrap {
                overflow: hidden;
            }
            
            /* Ensure theme header/footer work with Elementor */
            .elementor-location-header,
            .elementor-location-footer {
                width: 100%;
            }
            
            /* Fix Elementor editor styles */
            .elementor-editor-active .site-header,
            .elementor-editor-active .site-footer {
                position: relative !important;
            }
        ');
    }
}
add_action('wp_enqueue_scripts', 'portfolio_pro_elementor_styles');

/**
 * Elementor Pro theme builder conditions
 */
function portfolio_pro_elementor_theme_builder_conditions() {
    if (class_exists('\ElementorPro\Modules\ThemeBuilder\Module')) {
        // Add custom conditions for theme builder
        add_filter('elementor/theme/conditions/get_locations', function($locations) {
            $locations['portfolio'] = [
                'label' => __('Portfolio', 'portfolio-pro'),
                'public' => true,
                'object_type' => 'post_type',
            ];
            return $locations;
        });
    }
}
add_action('init', 'portfolio_pro_elementor_theme_builder_conditions');

/**
 * Override theme templates with Elementor
 */
function portfolio_pro_elementor_override_templates($template) {
    if (class_exists('\Elementor\Plugin')) {
        // Check if Elementor Pro theme builder is active
        if (function_exists('elementor_theme_do_location')) {
            // Let Elementor handle the template if it has a custom one
            $elementor_template = \ElementorPro\Modules\ThemeBuilder\Module::instance()->get_locations_manager()->do_location('single');
            if ($elementor_template) {
                return get_template_directory() . '/elementor-template.php';
            }
        }
    }
    return $template;
}
add_filter('template_include', 'portfolio_pro_elementor_override_templates');

/**
 * Add Elementor widgets category for theme
 */
function portfolio_pro_elementor_widget_categories($elements_manager) {
    if (class_exists('\Elementor\Plugin')) {
        $elements_manager->add_category(
            'portfolio-pro-widgets',
            [
                'title' => __('Portfolio Pro Widgets', 'portfolio-pro'),
                'icon' => 'fa fa-briefcase',
            ]
        );
    }
}
add_action('elementor/elements/categories_registered', 'portfolio_pro_elementor_widget_categories');

/**
 * Ensure theme works with Elementor Canvas template
 */
function portfolio_pro_elementor_canvas_support() {
    if (class_exists('\Elementor\Plugin')) {
        // Add body class for Elementor canvas
        add_filter('body_class', function($classes) {
            if (\Elementor\Plugin::$instance->preview->is_preview_mode()) {
                $classes[] = 'elementor-preview';
            }
            return $classes;
        });
    }
}
add_action('init', 'portfolio_pro_elementor_canvas_support');

/**
 * Register Elementor Pro locations if available
 */
function portfolio_pro_register_elementor_locations() {
    if (function_exists('elementor_theme_do_location')) {
        // Register locations for Elementor Pro Theme Builder
        elementor_theme_do_location('header');
        elementor_theme_do_location('footer');
    }
}

/**
 * Elementor editor improvements
 */
function portfolio_pro_elementor_editor_enhancements() {
    if (class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->editor->is_edit_mode()) {
        // Add editor-specific styles
        wp_add_inline_style('portfolio-pro-style', '
            /* Elementor Editor Enhancements */
            .elementor-editor-active body {
                overflow-x: auto !important;
            }
            
            .elementor-editor-active .site-header {
                position: static !important;
            }
            
            .elementor-editor-active .sticky-header {
                position: static !important;
            }
        ');
    }
}
add_action('wp_enqueue_scripts', 'portfolio_pro_elementor_editor_enhancements');

/**
 * Load custom Elementor widgets
 */
function stylefolio_load_elementor_widgets() {
    if (class_exists('\Elementor\Plugin')) {
        require_once get_template_directory() . '/inc/elementor-widgets.php';
    }
}
add_action('elementor/widgets/widgets_registered', 'stylefolio_load_elementor_widgets', 10);

/**
 * Enable Elementor editing for all post types
 */
function portfolio_pro_enable_elementor_editing() {
    // Add Elementor support to post types
    add_post_type_support('page', 'elementor');
    add_post_type_support('post', 'elementor');
    add_post_type_support('portfolio', 'elementor');
    
    // Add custom post types if they exist
    $custom_post_types = get_post_types(['_builtin' => false], 'names');
    foreach ($custom_post_types as $post_type) {
        add_post_type_support($post_type, 'elementor');
    }
}
add_action('init', 'portfolio_pro_enable_elementor_editing', 20);

/**
 * Force Elementor to recognize theme compatibility
 */
function portfolio_pro_force_elementor_compatibility() {
    if (class_exists('\Elementor\Plugin')) {
        // Force Elementor to recognize theme as compatible
        update_option('elementor_disable_color_schemes', 'yes');
        update_option('elementor_disable_typography_schemes', 'yes');
        update_option('elementor_load_fa4_shim', 'yes');
        
        // Enable Elementor for the theme
        if (!get_option('elementor_theme_builder_v2')) {
            update_option('elementor_theme_builder_v2', 'yes');
        }
    }
}
add_action('after_switch_theme', 'portfolio_pro_force_elementor_compatibility');
add_action('admin_init', 'portfolio_pro_force_elementor_compatibility');

/**
 * Add Elementor edit link to post/page edit screens
 */
function portfolio_pro_add_elementor_edit_button() {
    if (!class_exists('\Elementor\Plugin')) {
        return;
    }
    
    global $post;
    if (!$post) {
        return;
    }
    
    // Check if current post type supports Elementor
    if (!post_type_supports($post->post_type, 'elementor')) {
        return;
    }
      if (!\Elementor\User::is_current_user_can_edit($post->ID)) {
        return;
    }
    
    // Get proper Elementor edit URL
    try {
        $document = \Elementor\Plugin::$instance->documents->get($post->ID);
        $edit_url = $document ? $document->get_edit_url() : admin_url('post.php?post=' . $post->ID . '&action=elementor');
    } catch (Exception $e) {
        $edit_url = admin_url('post.php?post=' . $post->ID . '&action=elementor');
    }
    ?>
    <script>
    jQuery(document).ready(function($) {
        // Add Elementor edit button to post edit screen
        if ($('.page-title-action').length) {
            $('.page-title-action').after(
                '<a href="<?php echo esc_url($edit_url); ?>" class="page-title-action elementor-edit-btn" style="background: #9b0a46; border-color: #9b0a46;">' +
                '<?php echo esc_js(__('Edit with Elementor', 'portfolio-pro')); ?>' +
                '</a>'
            );
        }
        
        // Add to post row actions in list view
        $('body.edit-php .row-actions').each(function() {
            var $row = $(this).closest('tr');
            var postId = $row.attr('id');
            if (postId) {
                var id = postId.replace('post-', '');
                var editUrl = '<?php echo admin_url('post.php?post='); ?>' + id + '&action=elementor';
                $(this).append(' | <span class="elementor"><a href="' + editUrl + '"><?php echo esc_js(__('Elementor', 'portfolio-pro')); ?></a></span>');
            }
        });
    });
    </script>
    <style>
    .elementor-edit-btn {
        background: #9b0a46 !important;
        border-color: #9b0a46 !important;
        color: white !important;
    }
    .elementor-edit-btn:hover {
        background: #7a0837 !important;
        border-color: #7a0837 !important;
    }
    </style>
    <?php
}
add_action('admin_footer-post.php', 'portfolio_pro_add_elementor_edit_button');
add_action('admin_footer-post-new.php', 'portfolio_pro_add_elementor_edit_button');
add_action('admin_footer-edit.php', 'portfolio_pro_add_elementor_edit_button');

/**
 * Handle Elementor edit action
 */
function portfolio_pro_handle_elementor_edit_action() {
    if (!class_exists('\Elementor\Plugin')) {
        return;
    }
    
    if (isset($_GET['action']) && $_GET['action'] === 'elementor' && isset($_GET['post'])) {
        $post_id = intval($_GET['post']);
        
        // Validate post exists
        $post = get_post($post_id);
        if (!$post) {
            wp_die(__('Post not found.', 'portfolio-pro'));
        }
        
        // Check permissions
        if (!current_user_can('edit_post', $post_id)) {
            wp_die(__('You do not have permission to edit this post with Elementor.', 'portfolio-pro'));
        }
        
        // Check if post type supports Elementor
        if (!post_type_supports($post->post_type, 'elementor')) {
            wp_die(__('This post type does not support Elementor editing.', 'portfolio-pro'));
        }
        
        // Get proper Elementor edit URL
        $elementor_edit_url = add_query_arg([
            'elementor' => '',
            'post' => $post_id,
        ], admin_url(''));
        
        // Alternative method to get edit URL
        if (method_exists('\Elementor\Plugin', 'instance')) {
            try {
                $document = \Elementor\Plugin::$instance->documents->get($post_id);
                if ($document) {
                    $elementor_edit_url = $document->get_edit_url();
                }
            } catch (Exception $e) {
                // Fallback to manual URL construction
                $elementor_edit_url = add_query_arg([
                    'elementor' => '',
                    'post' => $post_id,
                ], home_url('/'));
            }
        }
        
        wp_redirect($elementor_edit_url);
        exit;
    }
}
add_action('admin_init', 'portfolio_pro_handle_elementor_edit_action');

/**
 * Force refresh Elementor capabilities
 */
function portfolio_pro_refresh_elementor_capabilities() {
    if (class_exists('\Elementor\Plugin')) {
        // Clear any cached capabilities
        wp_cache_delete('elementor_user_capabilities');
        
        // Force Elementor to re-check user permissions
        if (current_user_can('edit_posts')) {
            add_filter('elementor/user/is_current_user_can_edit', '__return_true');
        }
    }
}
add_action('admin_init', 'portfolio_pro_refresh_elementor_capabilities');

/**
 * Initialize Elementor database and settings for theme
 */
function portfolio_pro_init_elementor_settings() {
    if (!class_exists('\Elementor\Plugin')) {
        return;
    }
    
    // Set theme compatibility options
    $elementor_options = [
        'elementor_container_width' => '1200',
        'elementor_cpt_support' => ['page', 'post'],
        'elementor_css_print_method' => 'external',
        'elementor_default_generic_fonts' => 'Sans-serif',
        'elementor_disable_color_schemes' => 'yes',
        'elementor_disable_typography_schemes' => 'yes',
        'elementor_editor_break_lines' => '1',
        'elementor_exclude_user_roles' => [],
        'elementor_global_image_lightbox' => 'yes',
        'elementor_load_fa4_shim' => 'yes',
        'elementor_space_between_widgets' => '20',
        'elementor_stretched_section_container' => '.site, .site-main',
        'elementor_page_title_selector' => 'h1.entry-title',
        'elementor_viewport_lg' => '1025',
        'elementor_viewport_md' => '768',
    ];
    
    foreach ($elementor_options as $option_name => $option_value) {
        if (get_option($option_name) === false) {
            update_option($option_name, $option_value);
        }
    }
    
    // Flush rewrite rules to ensure proper URL handling
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'portfolio_pro_init_elementor_settings');

/**
 * Add theme-specific Elementor kit settings
 */
function portfolio_pro_setup_elementor_kit() {
    if (!class_exists('\Elementor\Plugin')) {
        return;
    }
    
    // Wait for Elementor to be fully loaded
    add_action('elementor/loaded', function() {
        // Create default kit if it doesn't exist
        $kit_id = \Elementor\Plugin::$instance->kits_manager->get_active_id();
        
        if (!$kit_id) {
            $kit_id = \Elementor\Plugin::$instance->kits_manager->create_default();
        }
        
        // Set theme colors in kit
        $kit_settings = [
            'system_colors' => [
                [
                    '_id' => 'primary',
                    'title' => __('Primary Color', 'portfolio-pro'),
                    'color' => '#007cba',
                ],
                [
                    '_id' => 'secondary',
                    'title' => __('Secondary Color', 'portfolio-pro'),
                    'color' => '#666666',
                ],
                [
                    '_id' => 'text',
                    'title' => __('Text Color', 'portfolio-pro'),
                    'color' => '#333333',
                ],
                [
                    '_id' => 'accent',
                    'title' => __('Accent Color', 'portfolio-pro'),
                    'color' => '#ff6b6b',
                ],
            ],
            'system_typography' => [
                [
                    '_id' => 'primary',
                    'title' => __('Primary Font', 'portfolio-pro'),
                    'typography_typography' => 'custom',
                    'typography_font_family' => 'Roboto',
                    'typography_font_weight' => '400',
                ],
                [
                    '_id' => 'secondary',
                    'title' => __('Secondary Font', 'portfolio-pro'),
                    'typography_typography' => 'custom',
                    'typography_font_family' => 'Open Sans',
                    'typography_font_weight' => '600',
                ],
            ],
        ];
        
        // Update kit settings
        if ($kit_id) {
            $kit = \Elementor\Plugin::$instance->documents->get($kit_id);
            if ($kit) {
                $kit->update_settings($kit_settings);
            }
        }
    });
}
add_action('init', 'portfolio_pro_setup_elementor_kit');

/**
 * Debug function to check Elementor status
 */
function portfolio_pro_debug_elementor_status() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    if (isset($_GET['debug_elementor']) && $_GET['debug_elementor'] === '1') {
        echo '<div style="background: #fff; padding: 20px; margin: 20px; border: 1px solid #ccc;">';
        echo '<h3>Elementor Debug Information</h3>';
        echo '<p><strong>Elementor Active:</strong> ' . (class_exists('\Elementor\Plugin') ? 'Yes' : 'No') . '</p>';
        
        if (class_exists('\Elementor\Plugin')) {
            echo '<p><strong>Elementor Version:</strong> ' . ELEMENTOR_VERSION . '</p>';
            echo '<p><strong>Post Types with Elementor Support:</strong></p>';
            echo '<ul>';
            
            $post_types = get_post_types(['public' => true], 'objects');
            foreach ($post_types as $post_type) {
                $supports = post_type_supports($post_type->name, 'elementor') ? 'Yes' : 'No';
                echo '<li>' . $post_type->label . ' (' . $post_type->name . '): ' . $supports . '</li>';
            }
            echo '</ul>';
            
            $current_user = wp_get_current_user();
            echo '<p><strong>Current User Can Edit:</strong> ' . (\Elementor\User::is_current_user_can_edit() ? 'Yes' : 'No') . '</p>';
            echo '<p><strong>User Roles:</strong> ' . implode(', ', $current_user->roles) . '</p>';
        }
        echo '</div>';
    }
}
add_action('wp_footer', 'portfolio_pro_debug_elementor_status');
add_action('admin_footer', 'portfolio_pro_debug_elementor_status');

/**
 * Fix Elementor integration issues
 */
function portfolio_pro_fix_elementor_integration() {
    if (!class_exists('\Elementor\Plugin')) {
        return;
    }
    
    // Ensure Elementor can handle our post types
    add_filter('elementor/utils/get_public_post_types', function($post_types) {
        // Make sure pages and posts are included
        if (!in_array('page', $post_types)) {
            $post_types['page'] = 'page';
        }
        if (!in_array('post', $post_types)) {
            $post_types['post'] = 'post';
        }
        return $post_types;
    });
    
    // Fix Elementor editor URL generation
    add_filter('elementor/document/urls/edit', function($url, $document) {
        if ($document) {
            $post_id = $document->get_main_id();
            return add_query_arg([
                'elementor' => '',
                'post' => $post_id,
            ], admin_url(''));
        }
        return $url;
    }, 10, 2);
    
    // Ensure proper permissions
    add_filter('elementor/user/is_current_user_can_edit', function($can_edit, $post_id) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        
        if (!$post_id) {
            return $can_edit;
        }
        
        // Check if user can edit the post
        return current_user_can('edit_post', $post_id);
    }, 10, 2);
}
add_action('elementor/loaded', 'portfolio_pro_fix_elementor_integration');

/**
 * Force Elementor to recognize theme after plugin activation
 */
function portfolio_pro_elementor_after_activation() {
    if (class_exists('\Elementor\Plugin')) {
        // Clear Elementor cache
        if (method_exists('\Elementor\Plugin', 'instance') && isset(\Elementor\Plugin::$instance->files_manager)) {
            \Elementor\Plugin::$instance->files_manager->clear_cache();
        }
        
        // Update theme support options
        update_option('elementor_cpt_support', ['page', 'post']);
        update_option('elementor_disable_color_schemes', 'yes');
        update_option('elementor_disable_typography_schemes', 'yes');
        update_option('elementor_container_width', '1200');
        
        // Flush rewrite rules
        flush_rewrite_rules();
    }
}
add_action('activated_plugin', 'portfolio_pro_elementor_after_activation');

/**
 * Add custom CSS for Elementor admin interface
 */
function portfolio_pro_elementor_admin_css() {
    if (!class_exists('\Elementor\Plugin')) {
        return;
    }
    ?>
    <style>
    /* Elementor admin bar button styling */
    #wp-admin-bar-elementor-edit .ab-item {
        color: #fff !important;
        background: #9b0a46 !important;
    }
    #wp-admin-bar-elementor-edit:hover .ab-item {
        background: #7a0837 !important;
    }
    
    /* Elementor edit button in post list */
    .elementor a {
        color: #9b0a46 !important;
        font-weight: bold;
    }
    .elementor a:hover {
        color: #7a0837 !important;
    }
    </style>
    <?php
}
add_action('admin_head', 'portfolio_pro_elementor_admin_css');
add_action('wp_head', 'portfolio_pro_elementor_admin_css');

/**
 * Emergency Elementor fix - Add this temporarily to test
 */
function portfolio_pro_emergency_elementor_fix() {
    if (!class_exists('\Elementor\Plugin')) {
        return;
    }
    
    // Add a simple test button to admin bar for any logged-in user
    add_action('admin_bar_menu', function($wp_admin_bar) {
        if (is_singular() && current_user_can('edit_posts')) {
            $post_id = get_the_ID();
            if ($post_id) {
                // Create a direct link to Elementor editor
                $elementor_url = home_url('/?elementor&post=' . $post_id);
                
                $wp_admin_bar->add_node([
                    'id' => 'test-elementor-edit',
                    'title' => 'Test Elementor Edit',
                    'href' => $elementor_url,
                    'meta' => [
                        'target' => '_blank',
                        'class' => 'test-elementor-button',
                    ],
                ]);
            }
        }
    }, 999);
    
    // Also add to any page/post edit screen
    add_action('admin_footer', function() {
        global $post;
        if ($post && current_user_can('edit_post', $post->ID)) {
            $elementor_url = home_url('/?elementor&post=' . $post->ID);
            echo '<script>
            jQuery(document).ready(function($) {
                if ($(".page-title-action").length) {
                    $(".page-title-action").after(
                        "<a href=\"' . esc_url($elementor_url) . '\" class=\"page-title-action\" style=\"background: #e74c3c; border-color: #e74c3c; margin-left: 5px;\" target=\"_blank\">Test Elementor Direct</a>"
                    );
                }
            });
            </script>';
        }
    });
}
add_action('init', 'portfolio_pro_emergency_elementor_fix');

