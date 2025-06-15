<?php
/**
 * Skills Section Template
 * 
 * Displays skills and services with progress bars or icon-based layouts.
 * Add skills through WordPress Admin > Skills.
 * Configure section settings in Customizer > Skills Section.
 *
 * @package Stylefolio
 */

// Get settings
$settings_args = array(
    'post_type'      => 'skills_setting',
    'posts_per_page' => 1,
    'post_status'    => 'publish',
);

$settings_query = new WP_Query($settings_args);
$settings_id = 0;

if ($settings_query->have_posts()) {
    $settings_query->the_post();
    $settings_id = get_the_ID();
    wp_reset_postdata();
} else {
    // Create a default settings post if none exists
    $settings_id = wp_insert_post(array(
        'post_title'    => 'Skills Section Settings',
        'post_status'   => 'publish',
        'post_type'     => 'skills_setting',
    ));
}

// Default values
$section_title = 'Skills & Services';
$section_subtitle = 'What I can do for you';
$section_description = 'Leveraging cutting-edge technologies to deliver exceptional digital experiences that blend creativity with technical excellence.';
$tech_skills_title = 'Technical Proficiency';
$cta_title = "Let's work together on your next project";
$cta_subtitle = "I'm available for freelance projects and full-time employment";
$cta_btn1_text = 'Get in Touch';
$cta_btn1_url = '#contact';
$cta_btn2_text = 'View My Work';
$cta_btn2_url = '#portfolio';

// Try to get field values if they exist
if (function_exists('get_field') && $settings_id) {
    $section_title = get_field('skills_title', $settings_id) ?: $section_title;
    $section_subtitle = get_field('skills_subtitle', $settings_id) ?: $section_subtitle;
    $section_description = get_field('skills_description', $settings_id) ?: $section_description;
    $tech_skills_title = get_field('tech_skills_title', $settings_id) ?: $tech_skills_title;
    $cta_title = get_field('skills_cta_title', $settings_id) ?: $cta_title;
    $cta_subtitle = get_field('skills_cta_subtitle', $settings_id) ?: $cta_subtitle;
    $cta_btn1_text = get_field('skills_cta_btn1_text', $settings_id) ?: $cta_btn1_text;
    $cta_btn1_url = get_field('skills_cta_btn1_url', $settings_id) ?: $cta_btn1_url;
    $cta_btn2_text = get_field('skills_cta_btn2_text', $settings_id) ?: $cta_btn2_text;
    $cta_btn2_url = get_field('skills_cta_btn2_url', $settings_id) ?: $cta_btn2_url;
}

// Get categories
$categories_args = array(
    'post_type'      => 'skill_category',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_key'       => 'category_order',
    'orderby'        => 'meta_value_num',
    'order'          => 'ASC',
);

$categories_query = new WP_Query($categories_args);
$categories = array();

if ($categories_query->have_posts()) {
    while ($categories_query->have_posts()) {
        $categories_query->the_post();
        $categories[] = array(
            'id'    => get_the_ID(),
            'name'  => get_the_title(),
            'icon'  => get_field('category_icon') ?: 'fas fa-code',
            'slug'  => sanitize_title(get_the_title()),
        );
    }
    wp_reset_postdata();
}

// Get technical skills
$tech_skills_args = array(
    'post_type'      => 'tech_skill',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_key'       => 'skill_order',
    'orderby'        => 'meta_value_num',
    'order'          => 'ASC',
);

$tech_skills_query = new WP_Query($tech_skills_args);
$tech_skills = array();

if ($tech_skills_query->have_posts()) {
    while ($tech_skills_query->have_posts()) {
        $tech_skills_query->the_post();
        $tech_skills[] = array(
            'name'        => get_the_title(),
            'percentage'  => get_field('skill_percentage') ?: 80,
        );
    }
    wp_reset_postdata();
}

// If no data exists at all, display a notice for admin users
$has_data = !empty($categories) || !empty($tech_skills);
?>

<section id="skills" class="skills-section">    <div class="section-background">
        <div class="bg-particles"></div>
        <div class="bg-glow"></div>
    </div>
    
    <div class="container">
        <div class="section-header" data-animation="fade-in">
            <span class="section-subtitle"><?php echo esc_html($section_subtitle); ?></span>
            <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
            <p class="section-description"><?php echo esc_html($section_description); ?></p>
            <div class="section-divider">
                <span class="divider-line"></span>
                <span class="divider-icon"><i class="fas fa-code"></i></span>
                <span class="divider-line"></span>
            </div>
        </div>
        
        <?php if (!$has_data && current_user_can('manage_options')) : ?>
            <div class="admin-notice" style="background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 30px; text-align: center;">
                <p><strong>Notice:</strong> No skills data found. Please add skills and categories or initialize default data.</p>
                <p>
                    <a href="<?php echo admin_url('post-new.php?post_type=skill_category'); ?>" class="button">Add Skill Category</a>
                    <a href="<?php echo admin_url('post-new.php?post_type=skill'); ?>" class="button">Add Skill</a>
                    <a href="<?php echo admin_url('post-new.php?post_type=tech_skill'); ?>" class="button">Add Technical Skill</a>
                </p>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($categories)) : ?>
            <div class="skills-tabs-container">
                <!-- Tabs Navigation -->
                <div class="skills-tabs-nav" data-animation="fade-in">
                    <?php foreach ($categories as $index => $category) : ?>
                        <button class="tab-button <?php echo $index === 0 ? 'active' : ''; ?>" data-tab="<?php echo esc_attr($category['slug']); ?>">
                            <i class="<?php echo esc_attr($category['icon']); ?>"></i>
                            <span><?php echo esc_html($category['name']); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>
                
                <!-- Tabs Content -->
                <div class="skills-tabs-content" data-animation="fade-in-up">
                    <?php foreach ($categories as $index => $category) : 
                        // Get skills for this category
                        $skills_args = array(
                            'post_type'      => 'skill',
                            'posts_per_page' => -1,
                            'post_status'    => 'publish',
                            'meta_key'       => 'skill_order',
                            'orderby'        => 'meta_value_num',
                            'order'          => 'ASC',
                            'meta_query'     => array(
                                array(
                                    'key'     => 'skill_category',
                                    'value'   => $category['id'],
                                    'compare' => '=',
                                ),
                            ),
                        );
                        
                        $skills_query = new WP_Query($skills_args);
                        $has_skills = $skills_query->have_posts();
                    ?>
                        <div class="tab-content <?php echo $index === 0 ? 'active' : ''; ?>" id="tab-<?php echo esc_attr($category['slug']); ?>">
                            <div class="skills-grid">
                                <?php 
                                if ($has_skills) :
                                    while ($skills_query->have_posts()) :
                                        $skills_query->the_post();
                                        $skill_id = get_the_ID();
                                        $skill_name = get_the_title();
                                        $skill_description = get_the_content();
                                        $skill_icon = get_field('skill_icon', $skill_id) ?: 'fas fa-code';
                                        $skill_tech = get_field('skill_tech', $skill_id) ?: '';
                                ?>
                                    <div class="skill-card">
                                        <div class="skill-icon">
                                            <i class="<?php echo esc_attr($skill_icon); ?>"></i>
                                        </div>
                                        <div class="skill-content">
                                            <h3 class="skill-title"><?php echo esc_html($skill_name); ?></h3>
                                            <p class="skill-description"><?php echo esc_html($skill_description); ?></p>
                                            <div class="skill-tech">
                                                <span class="tech-label">
                                                    <?php 
                                                    if ($index === 1) {
                                                        echo 'Tools:';
                                                    } elseif ($index === 2) {
                                                        echo 'Expertise:';
                                                    } else {
                                                        echo 'Technologies:';
                                                    }
                                                    ?>
                                                </span>
                                                <span class="tech-tags"><?php echo esc_html($skill_tech); ?></span>
                                            </div>
                                        </div>
                                        <div class="skill-hover-effect"></div>
                                    </div>
                                <?php 
                                    endwhile;
                                    wp_reset_postdata();
                                else : 
                                ?>
                                    <div class="empty-skills-message">
                                        <p>No skills found for this category.</p>
                                        <?php if (current_user_can('edit_posts')) : ?>
                                            <p><a href="<?php echo admin_url('post-new.php?post_type=skill'); ?>" class="button">Add Skill</a></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Technical Skills Bars -->
        <?php if (!empty($tech_skills)) : ?>
            <div class="technical-skills-container" data-animation="fade-in-up">
                <h3 class="technical-skills-title"><?php echo esc_html($tech_skills_title); ?></h3>
                
                <div class="skills-bars">
                    <?php foreach ($tech_skills as $skill) : 
                        $skill_name = $skill['name'];
                        $skill_percentage = $skill['percentage'];
                        
                        // Ensure percentage is between 0-100
                        $skill_percentage = min(100, max(0, $skill_percentage));
                    ?>
                        <div class="skill-bar-item">
                            <div class="skill-bar-header">
                                <span class="skill-bar-name"><?php echo esc_html($skill_name); ?></span>
                                <span class="skill-bar-percentage"><?php echo esc_html($skill_percentage); ?>%</span>
                            </div>
                            <div class="skill-bar">
                                <div class="skill-bar-fill" data-percentage="<?php echo esc_attr($skill_percentage); ?>" style="width: 0;"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Call to Action -->
        <div class="skills-cta" data-animation="fade-in">
            <div class="cta-content">
                <h3><?php echo esc_html($cta_title); ?></h3>
                <p><?php echo esc_html($cta_subtitle); ?></p>
            </div>
            <div class="cta-buttons">
                <a href="<?php echo esc_url($cta_btn1_url); ?>" class="button button-primary"><?php echo esc_html($cta_btn1_text); ?></a>
                <a href="<?php echo esc_url($cta_btn2_url); ?>" class="button button-secondary"><?php echo esc_html($cta_btn2_text); ?></a>
            </div>
        </div>
    </div>
</section>