<?php
/**
 * Advanced Custom Fields (ACF) Configuration
 * 
 * This file registers all custom fields used throughout the theme.
 * Fields are organized by sections (Hero, Portfolio, Skills, etc.).
 * 
 * Note: ACF plugin must be installed for these fields to work.
 * Fields can also be managed through the ACF admin interface.
 *
 * @package Stylefolio
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register all ACF field groups for the theme
 */
function portfolio_pro_register_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }
      // Load field groups
    add_action('acf/include_fields', function() {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }
        
        // Skills Section Field Group
        acf_add_local_field_group(array(
            'key' => 'group_skills_section',
            'title' => 'Skills & Services Section',
            'fields' => array(
                // Section Header Fields
                array(
                    'key' => 'field_skills_section_title',
                    'label' => 'Section Title',
                    'name' => 'skills_section_title',
                    'type' => 'text',
                    'default_value' => 'Skills & Services',
                    'placeholder' => 'Enter section title',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key' => 'field_skills_section_subtitle',
                    'label' => 'Section Subtitle',
                    'name' => 'skills_section_subtitle',
                    'type' => 'text',
                    'default_value' => 'What I can do for you',
                    'placeholder' => 'Enter section subtitle',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key' => 'field_skills_section_description',
                    'label' => 'Section Description',
                    'name' => 'skills_section_description',
                    'type' => 'textarea',
                    'default_value' => 'Leveraging cutting-edge technologies to deliver exceptional digital experiences that blend creativity with technical excellence.',
                    'placeholder' => 'Enter section description',
                    'rows' => 3,
                ),
                
                // Categories/Tabs Repeater
                array(
                    'key' => 'field_skills_categories',
                    'label' => 'Skill Categories',
                    'name' => 'skills_categories',
                    'type' => 'repeater',
                    'instructions' => 'Add categories/tabs for your skills.',
                    'min' => 1,
                    'max' => 5,
                    'layout' => 'block',
                    'button_label' => 'Add Category',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_category_name',
                            'label' => 'Category Name',
                            'name' => 'name',
                            'type' => 'text',
                            'required' => 1,
                            'wrapper' => array(
                                'width' => '50',
                            ),
                        ),
                        array(
                            'key' => 'field_category_icon',
                            'label' => 'Category Icon',
                            'name' => 'icon',
                            'type' => 'text',
                            'instructions' => 'Enter Font Awesome icon class (e.g., fas fa-laptop-code)',
                            'default_value' => 'fas fa-laptop-code',
                            'wrapper' => array(
                                'width' => '50',
                            ),
                        ),
                        
                        // Skills Repeater (nested)
                        array(
                            'key' => 'field_category_skills',
                            'label' => 'Skills',
                            'name' => 'skills',
                            'type' => 'repeater',
                            'instructions' => 'Add skills for this category.',
                            'min' => 1,
                            'max' => 8,
                            'layout' => 'row',
                            'button_label' => 'Add Skill',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_skill_name',
                                    'label' => 'Skill Name',
                                    'name' => 'name',
                                    'type' => 'text',
                                    'required' => 1,
                                    'wrapper' => array(
                                        'width' => '50',
                                    ),
                                ),
                                array(
                                    'key' => 'field_skill_icon',
                                    'label' => 'Skill Icon',
                                    'name' => 'icon',
                                    'type' => 'text',
                                    'instructions' => 'Enter Font Awesome icon class',
                                    'default_value' => 'fas fa-code',
                                    'wrapper' => array(
                                        'width' => '50',
                                    ),
                                ),
                                array(
                                    'key' => 'field_skill_description',
                                    'label' => 'Description',
                                    'name' => 'description',
                                    'type' => 'textarea',
                                    'rows' => 3,
                                ),
                                array(
                                    'key' => 'field_skill_tech',
                                    'label' => 'Technologies/Tools',
                                    'name' => 'tech',
                                    'type' => 'text',
                                    'instructions' => 'Enter comma-separated list of technologies',
                                ),
                            ),
                        ),
                    ),
                ),
                
                // Technical Skills Bars
                array(
                    'key' => 'field_technical_skills_title',
                    'label' => 'Technical Skills Title',
                    'name' => 'technical_skills_title',
                    'type' => 'text',
                    'default_value' => 'Technical Proficiency',
                ),
                array(
                    'key' => 'field_technical_skills',
                    'label' => 'Technical Skills',
                    'name' => 'technical_skills',
                    'type' => 'repeater',
                    'instructions' => 'Add technical skills with percentage bars.',
                    'min' => 0,
                    'max' => 10,
                    'layout' => 'table',
                    'button_label' => 'Add Skill Bar',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_skill_bar_name',
                            'label' => 'Skill Name',
                            'name' => 'name',
                            'type' => 'text',
                            'required' => 1,
                        ),
                        array(
                            'key' => 'field_skill_bar_percentage',
                            'label' => 'Percentage',
                            'name' => 'percentage',
                            'type' => 'range',
                            'default_value' => 80,
                            'min' => 0,
                            'max' => 100,
                            'step' => 5,
                            'required' => 1,
                        ),
                    ),
                ),
                
                // CTA Section
                array(
                    'key' => 'field_skills_cta_title',
                    'label' => 'CTA Title',
                    'name' => 'skills_cta_title',
                    'type' => 'text',
                    'default_value' => "Let's work together on your next project",
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key' => 'field_skills_cta_subtitle',
                    'label' => 'CTA Subtitle',
                    'name' => 'skills_cta_subtitle',
                    'type' => 'text',
                    'default_value' => "I'm available for freelance projects and full-time employment",
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key' => 'field_skills_cta_btn1_text',
                    'label' => 'Button 1 Text',
                    'name' => 'skills_cta_btn1_text',
                    'type' => 'text',
                    'default_value' => 'Get in Touch',
                    'wrapper' => array(
                        'width' => '25',
                    ),
                ),
                array(
                    'key' => 'field_skills_cta_btn1_url',
                    'label' => 'Button 1 URL',
                    'name' => 'skills_cta_btn1_url',
                    'type' => 'text',
                    'default_value' => '#contact',
                    'wrapper' => array(
                        'width' => '25',
                    ),
                ),
                array(
                    'key' => 'field_skills_cta_btn2_text',
                    'label' => 'Button 2 Text',
                    'name' => 'skills_cta_btn2_text',
                    'type' => 'text',
                    'default_value' => 'View My Work',
                    'wrapper' => array(
                        'width' => '25',
                    ),
                ),
                array(
                    'key' => 'field_skills_cta_btn2_url',
                    'label' => 'Button 2 URL',
                    'name' => 'skills_cta_btn2_url',
                    'type' => 'text',
                    'default_value' => '#portfolio',
                    'wrapper' => array(
                        'width' => '25',
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'theme-general-settings',
                    ),
                ),
            ),
            'menu_order' => 10,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => true,
        ));
        
        error_log('ACF field group registered for Portfolio Pro theme');
    }, 20); // Higher priority to ensure it runs after ACF is initialized
}
add_action('acf/init', 'portfolio_pro_register_acf_fields');

/**
 * Add Theme Options Page for ACF fields
 */
function portfolio_pro_acf_options_page() {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title' => 'Theme Settings',
            'menu_title' => 'Theme Settings',
            'menu_slug' => 'theme-general-settings',
            'capability' => 'edit_theme_options',
            'redirect' => false,
            'icon_url' => 'dashicons-admin-customizer',
            'position' => 59,
        ));
    }
}
add_action('acf/init', 'portfolio_pro_acf_options_page');

/**
 * Populate default ACF data on theme activation
 */
function portfolio_pro_populate_default_acf_data() {
    // Only run once
    if (get_option('portfolio_pro_acf_defaults_set')) {
        return;
    }
    
    // Check if ACF is active
    if (!function_exists('update_field')) {
        return;
    }
    
    // Default categories
    $default_categories = array(
        array(
            'name' => 'Development',
            'icon' => 'fas fa-laptop-code',
            'skills' => array(
                array(
                    'name' => 'Front-End Development',
                    'icon' => 'fab fa-html5',
                    'description' => 'Creating responsive and interactive user interfaces using modern frameworks and technologies.',
                    'tech' => 'HTML5, CSS3, JavaScript, React, Vue, Angular',
                ),
                array(
                    'name' => 'Back-End Development',
                    'icon' => 'fas fa-server',
                    'description' => 'Building robust server-side applications and APIs that power your digital products.',
                    'tech' => 'PHP, Node.js, Python, Ruby, Laravel, Express',
                ),
                array(
                    'name' => 'WordPress Development',
                    'icon' => 'fab fa-wordpress',
                    'description' => 'Custom WordPress themes and plugins that are tailored to your specific needs.',
                    'tech' => 'WordPress, PHP, MySQL, WooCommerce, ACF',
                ),
                array(
                    'name' => 'Mobile App Development',
                    'icon' => 'fas fa-mobile-alt',
                    'description' => 'Native and cross-platform mobile applications for iOS and Android devices.',
                    'tech' => 'React Native, Flutter, Swift, Kotlin',
                ),
            ),
        ),
        array(
            'name' => 'Design',
            'icon' => 'fas fa-pencil-ruler',
            'skills' => array(
                array(
                    'name' => 'UI/UX Design',
                    'icon' => 'fas fa-palette',
                    'description' => 'Creating user-centered designs with intuitive interfaces and exceptional user experiences.',
                    'tech' => 'Figma, Adobe XD, Sketch, InVision, Principle',
                ),
                array(
                    'name' => 'Web Design',
                    'icon' => 'fas fa-desktop',
                    'description' => 'Visually stunning websites that communicate your brand message effectively.',
                    'tech' => 'Adobe Photoshop, Illustrator, CSS, SASS, Bootstrap',
                ),
                array(
                    'name' => 'Brand Identity',
                    'icon' => 'fas fa-fingerprint',
                    'description' => 'Developing cohesive brand identities that resonate with your target audience.',
                    'tech' => 'Logo Design, Style Guides, Typography, Color Theory',
                ),
                array(
                    'name' => 'Motion Graphics',
                    'icon' => 'fas fa-film',
                    'description' => 'Engaging animations and motion graphics that bring your content to life.',
                    'tech' => 'After Effects, Lottie, CSS Animations, GSAP',
                ),
            ),
        ),
        array(
            'name' => 'Other Skills',
            'icon' => 'fas fa-tools',
            'skills' => array(
                array(
                    'name' => 'Project Management',
                    'icon' => 'fas fa-tasks',
                    'description' => 'Efficiently planning, executing, and closing projects while ensuring all objectives are met.',
                    'tech' => 'Agile, Scrum, Kanban, JIRA, Trello, Asana',
                ),
                array(
                    'name' => 'Digital Marketing',
                    'icon' => 'fas fa-bullhorn',
                    'description' => 'Strategies to increase visibility and engagement across digital channels.',
                    'tech' => 'SEO, Content Marketing, Social Media, Email Campaigns',
                ),
                array(
                    'name' => 'DevOps',
                    'icon' => 'fas fa-sync-alt',
                    'description' => 'Streamlining development and operations for continuous integration and delivery.',
                    'tech' => 'Docker, AWS, CI/CD, Jenkins, GitHub Actions',
                ),
                array(
                    'name' => 'Analytics',
                    'icon' => 'fas fa-chart-line',
                    'description' => 'Data-driven insights to optimize performance and user experience.',
                    'tech' => 'Google Analytics, Hotjar, Data Visualization, A/B Testing',
                ),
            ),
        ),
    );
    
    // Default technical skills
    $default_tech_skills = array(
        array(
            'name' => 'HTML/CSS',
            'percentage' => 95,
        ),
        array(
            'name' => 'JavaScript',
            'percentage' => 90,
        ),
        array(
            'name' => 'PHP',
            'percentage' => 85,
        ),
        array(
            'name' => 'WordPress',
            'percentage' => 95,
        ),
        array(
            'name' => 'React',
            'percentage' => 80,
        ),
        array(
            'name' => 'UI/UX Design',
            'percentage' => 85,
        ),
    );
    
    // Update ACF fields with default data
    update_field('skills_section_title', 'Skills & Services', 'option');
    update_field('skills_section_subtitle', 'What I can do for you', 'option');
    update_field('skills_section_description', 'Leveraging cutting-edge technologies to deliver exceptional digital experiences that blend creativity with technical excellence.', 'option');
    update_field('skills_categories', $default_categories, 'option');
    update_field('technical_skills_title', 'Technical Proficiency', 'option');
    update_field('technical_skills', $default_tech_skills, 'option');
    update_field('skills_cta_title', "Let's work together on your next project", 'option');
    update_field('skills_cta_subtitle', "I'm available for freelance projects and full-time employment", 'option');
    update_field('skills_cta_btn1_text', 'Get in Touch', 'option');
    update_field('skills_cta_btn1_url', '#contact', 'option');
    update_field('skills_cta_btn2_text', 'View My Work', 'option');
    update_field('skills_cta_btn2_url', '#portfolio', 'option');
    
    // Mark as done
    update_option('portfolio_pro_acf_defaults_set', true);
}
add_action('after_switch_theme', 'portfolio_pro_populate_default_acf_data');