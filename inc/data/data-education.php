<?php
/**
 * Sample Education Data
 *
 * @package Stylefolio
 * @version 1.0
 * @author abdulhaseeb2002
 * @updated 2025-06-12 08:57:05
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create sample education entries
 */
function stylefolio_create_sample_education() {
    // Check if we've already created sample education data
    if (get_option('stylefolio_sample_education_created')) {
        return;
    }
    
    // Sample education data
    $education = array(
        array(
            'title'          => 'Master of Computer Science',
            'degree'         => 'Master of Computer Science',
            'institution'    => 'Stanford University',
            'location'       => 'Stanford, CA',
            'institution_url' => 'https://www.stanford.edu',
            'education_type' => 'masters',
            'field_of_study' => 'Computer Science',
            'grade'          => '3.9/4.0',
            'start_date'     => '2021-09',
            'end_date'       => '2023-06',
            'is_current'     => 0,
            'activities'     => 'AI Research Group, Hackathon Team Lead, Graduate Student Association',
            'achievements'   => array(
                'Dean\'s List of Academic Excellence, 2022-2023',
                'Outstanding Graduate Student Award',
                'Published research paper on AI algorithms',
                'Won university-wide hackathon with innovative ML solution'
            ),
            'courses'        => 'Advanced Algorithms, Machine Learning, Artificial Intelligence, Natural Language Processing, Computer Vision, Distributed Systems',
            'order'          => 10,
        ),
        array(
            'title'          => 'Bachelor of Science in Computer Engineering',
            'degree'         => 'Bachelor of Science in Computer Engineering',
            'institution'    => 'Massachusetts Institute of Technology (MIT)',
            'location'       => 'Cambridge, MA',
            'institution_url' => 'https://www.mit.edu',
            'education_type' => 'bachelors',
            'field_of_study' => 'Computer Engineering',
            'grade'          => '3.8/4.0',
            'start_date'     => '2017-09',
            'end_date'       => '2021-05',
            'is_current'     => 0,
            'activities'     => 'IEEE Student Branch, Robotics Club, Software Development Society, Chess Club',
            'achievements'   => array(
                'Graduated with Honors',
                'Dean\'s List for 6 consecutive semesters',
                'Best Capstone Project Award',
                'Recipient of Merit Scholarship'
            ),
            'courses'        => 'Data Structures, Computer Architecture, Operating Systems, Digital Signal Processing, Software Engineering, Database Systems, Web Development',
            'order'          => 20,
        ),
        array(
            'title'          => 'AWS Certified Solutions Architect',
            'degree'         => 'AWS Certified Solutions Architect - Professional',
            'institution'    => 'Amazon Web Services',
            'location'       => 'Online',
            'institution_url' => 'https://aws.amazon.com/certification/',
            'education_type' => 'certification',
            'field_of_study' => 'Cloud Computing',
            'grade'          => 'Professional Level',
            'start_date'     => '2023-10',
            'end_date'       => '2023-11',
            'is_current'     => 0,
            'activities'     => '',
            'achievements'   => array(
                'Passed certification exam with score in top 10% of candidates'
            ),
            'courses'        => 'AWS Architecture, Cloud Solutions Design, Security Best Practices, Scalability and Elasticity, Serverless Applications',
            'order'          => 30,
        ),
        array(
            'title'          => 'Fullstack Web Development Bootcamp',
            'degree'         => 'Fullstack Web Development Certificate',
            'institution'    => 'Le Wagon',
            'location'       => 'Paris, France',
            'institution_url' => 'https://www.lewagon.com',
            'education_type' => 'course',
            'field_of_study' => 'Web Development',
            'grade'          => 'Distinction',
            'start_date'     => '2016-01',
            'end_date'       => '2016-04',
            'is_current'     => 0,
            'activities'     => 'Student Community, Hackathon Participant',
            'achievements'   => array(
                'Best Final Project Award',
                'Perfect attendance record'
            ),
            'courses'        => 'HTML, CSS, JavaScript, Ruby on Rails, SQL, Git, UI/UX Design, API Development',
            'order'          => 40,
        ),
    );
    
    // Create education entries
    foreach ($education as $entry) {
        $post_id = wp_insert_post(array(
            'post_title'    => $entry['title'],
            'post_status'   => 'publish',
            'post_type'     => 'education',
        ));
        
        if ($post_id) {
            // Add ACF fields
            update_field('degree', $entry['degree'], $post_id);
            update_field('institution', $entry['institution'], $post_id);
            update_field('location', $entry['location'], $post_id);
            update_field('institution_url', $entry['institution_url'], $post_id);
            update_field('education_type', $entry['education_type'], $post_id);
            update_field('field_of_study', $entry['field_of_study'], $post_id);
            update_field('grade', $entry['grade'], $post_id);
            update_field('start_date', $entry['start_date'], $post_id);
            update_field('end_date', $entry['end_date'], $post_id);
            update_field('is_current', $entry['is_current'], $post_id);
            update_field('activities', $entry['activities'], $post_id);
            update_field('courses', $entry['courses'], $post_id);
            update_field('education_order', $entry['order'], $post_id);
              // Add achievements as textarea field (new format)
            if (!empty($entry['achievements'])) {
                // Convert array to textarea format
                $achievements_text = implode("\n", $entry['achievements']);
                update_field('achievements', $achievements_text, $post_id);
            }
        }
    }
    
    // Set default section settings if using ACF options
    if (function_exists('update_field') && function_exists('acf_get_setting')) {
        update_field('education_section_title', 'Education', 'option');
        update_field('education_section_subtitle', 'Academic Background', 'option');
        update_field('education_section_layout', 'timeline', 'option');
        update_field('education_section_count', 0, 'option');
        update_field('education_show_achievements', 1, 'option');
        update_field('education_show_courses', 1, 'option');
    }
    
    // Mark as created
    update_option('stylefolio_sample_education_created', true);
}

/**
 * Add hook for theme activation or manual trigger
 */
function stylefolio_init_education_data() {
    // Only run on explicit request for demo data
    if (isset($_GET['create_sample_education']) && current_user_can('manage_options')) {
        stylefolio_create_sample_education();
        
        // Redirect to remove the query parameter
        wp_redirect(remove_query_arg('create_sample_education'));
        exit;
    }
}
add_action('init', 'stylefolio_init_education_data');

/**
 * Add admin notice for creating sample data
 */
function stylefolio_education_admin_notice() {
    // Only show to admins and only if we haven't created sample data
    if (!current_user_can('manage_options') || get_option('stylefolio_sample_education_created')) {
        return;
    }
    
    // Count existing education entries
    $education_count = wp_count_posts('education')->publish;
    
    // Only show if no education entries exist
    if ($education_count > 0) {
        return;
    }
    
    ?>
    <div class="notice notice-info is-dismissible">
        <p><?php _e('No education entries found. Would you like to create sample education data?', 'stylefolio'); ?></p>
        <p>
            <a href="<?php echo esc_url(add_query_arg('create_sample_education', '1')); ?>" class="button button-primary">
                <?php _e('Create Sample Education', 'stylefolio'); ?>
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
                    action: 'dismiss_education_sample_notice'
                });
            });
        });
    </script>
    <?php
}
add_action('admin_notices', 'stylefolio_education_admin_notice');

/**
 * Ajax handler to dismiss notice
 */
function stylefolio_dismiss_education_notice() {
    update_option('stylefolio_sample_education_created', true);
    wp_die();
}
add_action('wp_ajax_dismiss_education_sample_notice', 'stylefolio_dismiss_education_notice');