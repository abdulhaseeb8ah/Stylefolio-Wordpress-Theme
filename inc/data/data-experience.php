<?php
/**
 * Sample Work Experience Data
 *
 * @package Stylefolio
 * @version 1.0
 * @author abdulhaseeb2002
 * @updated 2025-06-11 16:03:15
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create sample work experience entries
 */

function stylefolio_create_sample_experience() {
    // Check if we've already created sample experience data
    if (get_option('stylefolio_sample_experience_created')) {
        return;
    }
    
    // Sample experience data
    $experiences = array(
        array(
            'title'            => 'Senior Frontend Developer',
            'job_title'        => 'Senior Frontend Developer',
            'company_name'     => 'TechInnovate Solutions',
            'company_location' => 'San Francisco, CA',
            'company_url'      => 'https://example.com',
            'job_type'         => 'full-time',
            'start_date'       => '2023-01',
            'end_date'         => '',
            'is_current'       => 1,
            'responsibilities' => array(
                'Led a team of 5 frontend developers working on a large-scale SaaS application with React and TypeScript',
                'Implemented modern UI/UX designs and optimized application performance by 40%',
                'Architected and deployed a component library used across multiple products',
                'Collaborated with UX designers and backend developers to create seamless user experiences',
                'Conducted code reviews and mentored junior developers'
            ),
            'technologies'     => 'React, TypeScript, Redux, Next.js, Tailwind CSS, GraphQL',
            'order'            => 10,
        ),
        array(
            'title'            => 'Frontend Developer',
            'job_title'        => 'Frontend Developer',
            'company_name'     => 'WebDynamics Inc.',
            'company_location' => 'Austin, TX',
            'company_url'      => 'https://example.com',
            'job_type'         => 'full-time',
            'start_date'       => '2020-05',
            'end_date'         => '2022-12',
            'is_current'       => 0,
            'responsibilities' => array(
                'Developed responsive web applications with React and Vue.js',
                'Built and maintained RESTful APIs for frontend consumption',
                'Integrated third-party services and payment gateways',
                'Created automated testing suites with Jest and Cypress',
                'Collaborated in an agile development environment'
            ),
            'technologies'     => 'JavaScript, React, Vue.js, REST APIs, Jest, Cypress, CSS3, SCSS',
            'order'            => 20,
        ),
        array(
            'title'            => 'Junior Web Developer',
            'job_title'        => 'Junior Web Developer',
            'company_name'     => 'CreativeTech Studios',
            'company_location' => 'Chicago, IL',
            'company_url'      => 'https://example.com',
            'job_type'         => 'full-time',
            'start_date'       => '2018-09',
            'end_date'         => '2020-04',
            'is_current'       => 0,
            'responsibilities' => array(
                'Developed and maintained websites for various clients',
                'Implemented responsive designs and ensured cross-browser compatibility',
                'Worked with PHP frameworks like Laravel and WordPress',
                'Collaborated with designers to implement UI/UX improvements',
                'Assisted in client meetings and requirement gathering'
            ),
            'technologies'     => 'HTML5, CSS3, JavaScript, jQuery, PHP, Laravel, WordPress',
            'order'            => 30,
        ),
        array(
            'title'            => 'Web Development Intern',
            'job_title'        => 'Web Development Intern',
            'company_name'     => 'Digital Solutions Group',
            'company_location' => 'Remote',
            'company_url'      => 'https://example.com',
            'job_type'         => 'internship',
            'start_date'       => '2018-01',
            'end_date'         => '2018-08',
            'is_current'       => 0,
            'responsibilities' => array(
                'Assisted in developing websites using HTML, CSS, and JavaScript',
                'Learned modern web development workflows and version control',
                'Created and maintained documentation for web projects',
                'Performed QA testing on various web applications',
                'Contributed to team meetings and brainstorming sessions'
            ),
            'technologies'     => 'HTML, CSS, JavaScript, Bootstrap, Git, GitHub',
            'order'            => 40,
        ),
    );
    
    // Create experiences
    foreach ($experiences as $experience) {
        $post_id = wp_insert_post(array(
            'post_title'    => $experience['title'],
            'post_status'   => 'publish',
            'post_type'     => 'experience',
        ));
        
        if ($post_id) {
            // Add ACF fields
            update_field('job_title', $experience['job_title'], $post_id);
            update_field('company_name', $experience['company_name'], $post_id);
            update_field('company_location', $experience['company_location'], $post_id);
            update_field('company_url', $experience['company_url'], $post_id);
            update_field('job_type', $experience['job_type'], $post_id);
            update_field('start_date', $experience['start_date'], $post_id);
            update_field('end_date', $experience['end_date'], $post_id);
            update_field('is_current', $experience['is_current'], $post_id);
            update_field('technologies', $experience['technologies'], $post_id);
            update_field('experience_order', $experience['order'], $post_id);
            
            // Handle responsibilities for both formats
            
            // 1. For text area format
            if (!empty($experience['responsibilities']) && is_array($experience['responsibilities'])) {
                $responsibilities_text = implode("\n", $experience['responsibilities']);
                update_field('responsibilities_text', $responsibilities_text, $post_id);
            }
            
            // 2. For legacy repeater format - save as post meta for template compatibility
            if (!empty($experience['responsibilities']) && is_array($experience['responsibilities'])) {
                $responsibilities_array = array();
                foreach ($experience['responsibilities'] as $responsibility) {
                    $responsibilities_array[] = array(
                        'responsibility' => $responsibility
                    );
                }
                update_post_meta($post_id, 'responsibilities', $responsibilities_array);
            }
        }
    }
    
    // Set default section settings if using ACF options
    if (function_exists('update_field') && function_exists('acf_get_setting')) {
        update_field('experience_section_title', 'Work Experience', 'option');
        update_field('experience_section_subtitle', 'My Professional Journey', 'option');
        update_field('experience_section_layout', 'timeline', 'option');
        update_field('experience_section_count', 0, 'option');
        update_field('experience_show_technologies', 1, 'option');
    }
    
    // Mark as created
    update_option('stylefolio_sample_experience_created', true);
}

/**
 * Add hook for theme activation or manual trigger
 */
function stylefolio_init_experience_data() {
    // Only run on explicit request for demo data
    if (isset($_GET['create_sample_experience']) && current_user_can('manage_options')) {
        stylefolio_create_sample_experience();
        
        // Redirect to remove the query parameter
        wp_redirect(remove_query_arg('create_sample_experience'));
        exit;
    }
}
add_action('init', 'stylefolio_init_experience_data');

/**
 * Add admin notice for creating sample data
 */
function stylefolio_experience_admin_notice() {
    // Only show to admins and only if we haven't created sample data
    if (!current_user_can('manage_options') || get_option('stylefolio_sample_experience_created')) {
        return;
    }
    
    // Count existing experiences
    $experiences_count = wp_count_posts('experience')->publish;
    
    // Only show if no experiences exist
    if ($experiences_count > 0) {
        return;
    }
    
    ?>
    <div class="notice notice-info is-dismissible">
        <p><?php _e('No work experience entries found. Would you like to create sample experiences?', 'stylefolio'); ?></p>
        <p>
            <a href="<?php echo esc_url(add_query_arg('create_sample_experience', '1')); ?>" class="button button-primary">
                <?php _e('Create Sample Experiences', 'stylefolio'); ?>
            </a>
            <a href="#" class="button dismiss-notice">
                <?php _e('No Thanks', 'stylefolio'); ?>
            </a>
        </p>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $('.dismiss-notice').on('click', function(e) {
                e.preventDefault();
                $(this).closest('.notice').remove();
                $.post(ajaxurl, {
                    action: 'dismiss_experience_sample_notice'
                });
            });
        });
    </script>
    <?php
}
add_action('admin_notices', 'stylefolio_experience_admin_notice');

/**
 * Ajax handler to dismiss notice
 */
function stylefolio_dismiss_experience_notice() {
    update_option('stylefolio_sample_experience_created', true);
    wp_die();
}
add_action('wp_ajax_dismiss_experience_sample_notice', 'stylefolio_dismiss_experience_notice');