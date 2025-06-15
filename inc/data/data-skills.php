<?php
/**
 * Skills Section Default Data
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
 * Initialize default skills data
 */
function portfolio_pro_initialize_data_skills() {
    // Check if data has already been populated
    if (get_option('portfolio_pro_skills_data_initialized')) {
        return;
    }
    
    // Create Skills Settings
    $settings_id = wp_insert_post(array(
        'post_title'    => 'Skills Section Settings',
        'post_status'   => 'publish',
        'post_type'     => 'skills_setting',
    ));
    
    if (!is_wp_error($settings_id)) {
        update_field('skills_title', 'Skills & Services', $settings_id);
        update_field('skills_subtitle', 'What I can do for you', $settings_id);
        update_field('skills_description', 'Leveraging cutting-edge technologies to deliver exceptional digital experiences that blend creativity with technical excellence.', $settings_id);
        update_field('tech_skills_title', 'Technical Proficiency', $settings_id);
        update_field('skills_cta_title', "Let's work together on your next project", $settings_id);
        update_field('skills_cta_subtitle', "I'm available for freelance projects and full-time employment", $settings_id);
        update_field('skills_cta_btn1_text', 'Get in Touch', $settings_id);
        update_field('skills_cta_btn1_url', '#contact', $settings_id);
        update_field('skills_cta_btn2_text', 'View My Work', $settings_id);
        update_field('skills_cta_btn2_url', '#portfolio', $settings_id);
    }
    
    // Create Categories
    $categories = array(
        array(
            'title' => 'Development',
            'icon' => 'fas fa-laptop-code',
            'order' => 10,
        ),
        array(
            'title' => 'Design',
            'icon' => 'fas fa-pencil-ruler',
            'order' => 20,
        ),
        array(
            'title' => 'Other Skills',
            'icon' => 'fas fa-tools',
            'order' => 30,
        ),
    );
    
    $category_ids = array();
    
    foreach ($categories as $category) {
        $category_id = wp_insert_post(array(
            'post_title'    => $category['title'],
            'post_status'   => 'publish',
            'post_type'     => 'skill_category',
        ));
        
        if (!is_wp_error($category_id)) {
            update_field('category_icon', $category['icon'], $category_id);
            update_field('category_order', $category['order'], $category_id);
            $category_ids[$category['title']] = $category_id;
        }
    }
    
    // Create Development Skills
    $dev_skills = array(
        array(
            'title' => 'Front-End Development',
            'icon' => 'fab fa-html5',
            'description' => 'Creating responsive and interactive user interfaces using modern frameworks and technologies.',
            'tech' => 'HTML5, CSS3, JavaScript, React, Vue, Angular',
            'order' => 10,
        ),
        array(
            'title' => 'Back-End Development',
            'icon' => 'fas fa-server',
            'description' => 'Building robust server-side applications and APIs that power your digital products.',
            'tech' => 'PHP, Node.js, Python, Ruby, Laravel, Express',
            'order' => 20,
        ),
        array(
            'title' => 'WordPress Development',
            'icon' => 'fab fa-wordpress',
            'description' => 'Custom WordPress themes and plugins that are tailored to your specific needs.',
            'tech' => 'WordPress, PHP, MySQL, WooCommerce, ACF',
            'order' => 30,
        ),
        array(
            'title' => 'Mobile App Development',
            'icon' => 'fas fa-mobile-alt',
            'description' => 'Native and cross-platform mobile applications for iOS and Android devices.',
            'tech' => 'React Native, Flutter, Swift, Kotlin',
            'order' => 40,
        ),
    );
    
    foreach ($dev_skills as $skill) {
        $skill_id = wp_insert_post(array(
            'post_title'    => $skill['title'],
            'post_content'  => $skill['description'],
            'post_status'   => 'publish',
            'post_type'     => 'skill',
        ));
        
        if (!is_wp_error($skill_id)) {
            update_field('skill_category', $category_ids['Development'], $skill_id);
            update_field('skill_icon', $skill['icon'], $skill_id);
            update_field('skill_tech', $skill['tech'], $skill_id);
            update_field('skill_order', $skill['order'], $skill_id);
        }
    }
    
    // Create Design Skills
    $design_skills = array(
        array(
            'title' => 'UI/UX Design',
            'icon' => 'fas fa-palette',
            'description' => 'Creating user-centered designs with intuitive interfaces and exceptional user experiences.',
            'tech' => 'Figma, Adobe XD, Sketch, InVision, Principle',
            'order' => 10,
        ),
        array(
            'title' => 'Web Design',
            'icon' => 'fas fa-desktop',
            'description' => 'Visually stunning websites that communicate your brand message effectively.',
            'tech' => 'Adobe Photoshop, Illustrator, CSS, SASS, Bootstrap',
            'order' => 20,
        ),
        array(
            'title' => 'Brand Identity',
            'icon' => 'fas fa-fingerprint',
            'description' => 'Developing cohesive brand identities that resonate with your target audience.',
            'tech' => 'Logo Design, Style Guides, Typography, Color Theory',
            'order' => 30,
        ),
        array(
            'title' => 'Motion Graphics',
            'icon' => 'fas fa-film',
            'description' => 'Engaging animations and motion graphics that bring your content to life.',
            'tech' => 'After Effects, Lottie, CSS Animations, GSAP',
            'order' => 40,
        ),
    );
    
    foreach ($design_skills as $skill) {
        $skill_id = wp_insert_post(array(
            'post_title'    => $skill['title'],
            'post_content'  => $skill['description'],
            'post_status'   => 'publish',
            'post_type'     => 'skill',
        ));
        
        if (!is_wp_error($skill_id)) {
            update_field('skill_category', $category_ids['Design'], $skill_id);
            update_field('skill_icon', $skill['icon'], $skill_id);
            update_field('skill_tech', $skill['tech'], $skill_id);
            update_field('skill_order', $skill['order'], $skill_id);
        }
    }
    
    // Create Other Skills
    $other_skills = array(
        array(
            'title' => 'Project Management',
            'icon' => 'fas fa-tasks',
            'description' => 'Efficiently planning, executing, and closing projects while ensuring all objectives are met.',
            'tech' => 'Agile, Scrum, Kanban, JIRA, Trello, Asana',
            'order' => 10,
        ),
        array(
            'title' => 'Digital Marketing',
            'icon' => 'fas fa-bullhorn',
            'description' => 'Strategies to increase visibility and engagement across digital channels.',
            'tech' => 'SEO, Content Marketing, Social Media, Email Campaigns',
            'order' => 20,
        ),
        array(
            'title' => 'DevOps',
            'icon' => 'fas fa-sync-alt',
            'description' => 'Streamlining development and operations for continuous integration and delivery.',
            'tech' => 'Docker, AWS, CI/CD, Jenkins, GitHub Actions',
            'order' => 30,
        ),
        array(
            'title' => 'Analytics',
            'icon' => 'fas fa-chart-line',
            'description' => 'Data-driven insights to optimize performance and user experience.',
            'tech' => 'Google Analytics, Hotjar, Data Visualization, A/B Testing',
            'order' => 40,
        ),
    );
    
    foreach ($other_skills as $skill) {
        $skill_id = wp_insert_post(array(
            'post_title'    => $skill['title'],
            'post_content'  => $skill['description'],
            'post_status'   => 'publish',
            'post_type'     => 'skill',
        ));
        
        if (!is_wp_error($skill_id)) {
            update_field('skill_category', $category_ids['Other Skills'], $skill_id);
            update_field('skill_icon', $skill['icon'], $skill_id);
            update_field('skill_tech', $skill['tech'], $skill_id);
            update_field('skill_order', $skill['order'], $skill_id);
        }
    }
    
    // Create Technical Skills
    $tech_skills = array(
        array(
            'title' => 'HTML/CSS',
            'percentage' => 95,
            'order' => 10,
        ),
        array(
            'title' => 'JavaScript',
            'percentage' => 90,
            'order' => 20,
        ),
        array(
            'title' => 'PHP',
            'percentage' => 85,
            'order' => 30,
        ),
        array(
            'title' => 'WordPress',
            'percentage' => 95,
            'order' => 40,
        ),
        array(
            'title' => 'React',
            'percentage' => 80,
            'order' => 50,
        ),
        array(
            'title' => 'UI/UX Design',
            'percentage' => 85,
            'order' => 60,
        ),
    );
    
    foreach ($tech_skills as $skill) {
        $skill_id = wp_insert_post(array(
            'post_title'    => $skill['title'],
            'post_status'   => 'publish',
            'post_type'     => 'tech_skill',
        ));
        
        if (!is_wp_error($skill_id)) {
            update_field('skill_percentage', $skill['percentage'], $skill_id);
            update_field('skill_order', $skill['order'], $skill_id);
        }
    }
    
    // Mark as initialized
    update_option('portfolio_pro_skills_data_initialized', true);
}