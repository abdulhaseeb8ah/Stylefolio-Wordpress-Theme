<?php
/**
 * Experience Section Template
 * 
 * Displays work experience in timeline or card layout.
 * Add experience entries through WordPress Admin > Experience.
 * Configure display options in ACF Options > Experience Section.
 *
 * @package Stylefolio
 */

// Get section settings
$section_title = get_field('experience_section_title', 'option') ?: 'Work Experience';
$section_subtitle = get_field('experience_section_subtitle', 'option') ?: 'My Professional Journey';
$layout_style = get_field('experience_section_layout', 'option') ?: 'timeline';
$display_count = get_field('experience_section_count', 'option') ?: 0;
$show_technologies = get_field('experience_show_technologies', 'option') !== false;

// Get experiences
$experiences_args = array(
    'post_type'      => 'experience',
    'posts_per_page' => ($display_count > 0) ? $display_count : -1,
    'post_status'    => 'publish',
    'meta_key'       => 'experience_order',
    'orderby'        => array(
        'meta_value_num' => 'ASC',
        'date' => 'DESC'
    ),
);

$experiences_query = new WP_Query($experiences_args);
$has_experiences = $experiences_query->have_posts();

// Add unique identifier for this section
$section_id = 'experience-' . uniqid();
?>

<section id="experience" class="experience-section">
    <div class="section-background">
        <div class="bg-grid"></div>
        <div class="bg-particles"></div>
        <div class="bg-glow"></div>
    </div>
    
    <div class="container">
        <div class="section-header" data-animation="fade-in">
            <span class="section-subtitle"><?php echo esc_html($section_subtitle); ?></span>
            <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
            <div class="section-divider">
                <span class="divider-line"></span>
                <span class="divider-icon"><i class="fas fa-briefcase"></i></span>
                <span class="divider-line"></span>
            </div>
        </div>
        
        <?php if ($has_experiences) : ?>
            <div class="experience-container <?php echo esc_attr($layout_style); ?>" data-animation="fade-in-up">
                
                <?php if ($layout_style === 'timeline') : ?>
                    <div class="experience-timeline" id="<?php echo esc_attr($section_id); ?>">
                        <div class="timeline-line"></div>
                        
                        <?php 
                        $count = 0;
                        while ($experiences_query->have_posts()) :
                            $experiences_query->the_post();
                            $post_id = get_the_ID();
                            
                            // Get fields
                            $job_title = get_field('job_title', $post_id) ?: get_the_title();
                            $company_name = get_field('company_name', $post_id) ?: '';
                            $company_location = get_field('company_location', $post_id) ?: '';
                            $company_url = get_field('company_url', $post_id) ?: '';
                            $job_type = get_field('job_type', $post_id) ?: 'full-time';
                            $start_date = get_field('start_date', $post_id) ?: '';
                            $end_date = get_field('end_date', $post_id) ?: '';
                            $is_current = get_field('is_current', $post_id) ?: false;
                            $technologies = get_field('technologies', $post_id) ?: '';
                            
                            // Format the date range
                            $date_range = '';
                            if ($start_date) {
                                $date_range = $start_date;
                                if ($is_current) {
                                    $date_range .= ' - Present';
                                } elseif ($end_date) {
                                    $date_range .= ' - ' . $end_date;
                                }
                            }
                            
                            // Get responsibilities - try both formats
                            $responsibilities = get_field('responsibilities', $post_id);
                            $responsibilities_text = get_field('responsibilities_text', $post_id);
                            
                            // Check for post meta if ACF field is empty (for backward compatibility)
                            if (empty($responsibilities)) {
                                $responsibilities = get_post_meta($post_id, 'responsibilities', true);
                            }
                            
                            // Convert responsibilities_text to array format if needed
                            if (empty($responsibilities) && !empty($responsibilities_text)) {
                                $responsibilities_array = array();
                                $lines = explode("\n", $responsibilities_text);
                                foreach ($lines as $line) {
                                    $line = trim($line);
                                    if (!empty($line)) {
                                        $responsibilities_array[] = array('responsibility' => $line);
                                    }
                                }
                                $responsibilities = $responsibilities_array;
                            }
                            
                            // Position class (alternating for timeline)
                            $position_class = ($count % 2 === 0) ? 'left' : 'right';
                            $count++;
                        ?>
                            <div class="timeline-item <?php echo esc_attr($position_class); ?>">
                                <div class="timeline-marker">
                                    <?php if ($is_current) : ?>
                                        <span class="current-marker"></span>
                                    <?php endif; ?>
                                  
                                </div>
                                
                                <div class="timeline-content">
                                    <div class="experience-date">
                                        <span><?php echo esc_html($date_range); ?></span>
                                        <span class="job-type"><?php echo esc_html(ucfirst($job_type)); ?></span>
                                    </div>
                                    
                                    <div class="experience-details">
                                        <h3 class="job-title"><?php echo esc_html($job_title); ?></h3>
                                        
                                        <div class="company-info">
                                            <?php if ($company_url) : ?>
                                                <a href="<?php echo esc_url($company_url); ?>" class="company-name" target="_blank" rel="noopener">
                                                    <?php echo esc_html($company_name); ?>
                                                </a>
                                            <?php else : ?>
                                                <span class="company-name"><?php echo esc_html($company_name); ?></span>
                                            <?php endif; ?>
                                            
                                            <?php if ($company_location) : ?>
                                                <span class="company-location">
                                                    <i class="fas fa-map-marker-alt"></i> <?php echo esc_html($company_location); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <?php if (!empty($responsibilities)) : ?>
                                            <div class="responsibilities">
                                                <ul>
                                                    <?php 
                                                    if (is_array($responsibilities)) {
                                                        foreach ($responsibilities as $responsibility) {
                                                            // Handle both array formats
                                                            if (is_array($responsibility) && isset($responsibility['responsibility'])) {
                                                                echo '<li>' . esc_html($responsibility['responsibility']) . '</li>';
                                                            } elseif (is_string($responsibility)) {
                                                                echo '<li>' . esc_html($responsibility) . '</li>';
                                                            }
                                                        }
                                                    } elseif (is_string($responsibilities)) {
                                                        // In case it's a string (unlikely but for robustness)
                                                        $lines = explode("\n", $responsibilities);
                                                        foreach ($lines as $line) {
                                                            $line = trim($line);
                                                            if (!empty($line)) {
                                                                echo '<li>' . esc_html($line) . '</li>';
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($show_technologies && $technologies) : ?>
                                            <div class="technologies">
                                                <h4><i class="fas fa-code"></i> Technologies</h4>
                                                <div class="tech-tags">
                                                    <?php 
                                                    $tech_array = explode(',', $technologies);
                                                    foreach ($tech_array as $tech) :
                                                        $tech = trim($tech);
                                                        if (!empty($tech)) :
                                                    ?>
                                                        <span class="tech-tag"><?php echo esc_html($tech); ?></span>
                                                    <?php 
                                                        endif;
                                                    endforeach; 
                                                    ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php 
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                    
                <?php else : ?>
                    <!-- Card Layout -->
                    <div class="experience-cards">
                        <?php 
                        while ($experiences_query->have_posts()) :
                            $experiences_query->the_post();
                            $post_id = get_the_ID();
                            
                            // Get fields
                            $job_title = get_field('job_title', $post_id) ?: get_the_title();
                            $company_name = get_field('company_name', $post_id) ?: '';
                            $company_location = get_field('company_location', $post_id) ?: '';
                            $company_url = get_field('company_url', $post_id) ?: '';
                            $job_type = get_field('job_type', $post_id) ?: 'full-time';
                            $start_date = get_field('start_date', $post_id) ?: '';
                            $end_date = get_field('end_date', $post_id) ?: '';
                            $is_current = get_field('is_current', $post_id) ?: false;
                            $technologies = get_field('technologies', $post_id) ?: '';
                            
                            // Format the date range
                            $date_range = '';
                            if ($start_date) {
                                $date_range = $start_date;
                                if ($is_current) {
                                    $date_range .= ' - Present';
                                } elseif ($end_date) {
                                    $date_range .= ' - ' . $end_date;
                                }
                            }
                            
                            // Get responsibilities - try both formats
                            $responsibilities = get_field('responsibilities', $post_id);
                            $responsibilities_text = get_field('responsibilities_text', $post_id);
                            
                            // Check for post meta if ACF field is empty (for backward compatibility)
                            if (empty($responsibilities)) {
                                $responsibilities = get_post_meta($post_id, 'responsibilities', true);
                            }
                            
                            // Convert responsibilities_text to array format if needed
                            if (empty($responsibilities) && !empty($responsibilities_text)) {
                                $responsibilities_array = array();
                                $lines = explode("\n", $responsibilities_text);
                                foreach ($lines as $line) {
                                    $line = trim($line);
                                    if (!empty($line)) {
                                        $responsibilities_array[] = array('responsibility' => $line);
                                    }
                                }
                                $responsibilities = $responsibilities_array;
                            }
                        ?>
                            <div class="experience-card">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="company-logo">
                                        <?php the_post_thumbnail('thumbnail'); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="card-header">
                                    <h3 class="job-title"><?php echo esc_html($job_title); ?></h3>
                                    <div class="company-info">
                                        <?php if ($company_url) : ?>
                                            <a href="<?php echo esc_url($company_url); ?>" class="company-name" target="_blank" rel="noopener">
                                                <?php echo esc_html($company_name); ?>
                                            </a>
                                        <?php else : ?>
                                            <span class="company-name"><?php echo esc_html($company_name); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="card-meta">
                                    <div class="date-range">
                                        <i class="far fa-calendar-alt"></i> <?php echo esc_html($date_range); ?>
                                    </div>
                                    
                                    <?php if ($company_location) : ?>
                                        <div class="location">
                                            <i class="fas fa-map-marker-alt"></i> <?php echo esc_html($company_location); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="job-type">
                                        <i class="fas fa-briefcase"></i> <?php echo esc_html(ucfirst($job_type)); ?>
                                    </div>
                                </div>
                                
                                <?php if (!empty($responsibilities)) : ?>
                                    <div class="responsibilities">
                                        <h4>Key Responsibilities</h4>
                                        <ul>
                                            <?php 
                                            if (is_array($responsibilities)) {
                                                foreach ($responsibilities as $responsibility) {
                                                    // Handle both array formats
                                                    if (is_array($responsibility) && isset($responsibility['responsibility'])) {
                                                        echo '<li>' . esc_html($responsibility['responsibility']) . '</li>';
                                                    } elseif (is_string($responsibility)) {
                                                        echo '<li>' . esc_html($responsibility) . '</li>';
                                                    }
                                                }
                                            } elseif (is_string($responsibilities)) {
                                                // In case it's a string (unlikely but for robustness)
                                                $lines = explode("\n", $responsibilities);
                                                foreach ($lines as $line) {
                                                    $line = trim($line);
                                                    if (!empty($line)) {
                                                        echo '<li>' . esc_html($line) . '</li>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($show_technologies && $technologies) : ?>
                                    <div class="technologies">
                                        <h4><i class="fas fa-code"></i> Technologies</h4>
                                        <div class="tech-tags">
                                            <?php 
                                            $tech_array = explode(',', $technologies);
                                            foreach ($tech_array as $tech) :
                                                $tech = trim($tech);
                                                if (!empty($tech)) :
                                            ?>
                                                <span class="tech-tag"><?php echo esc_html($tech); ?></span>
                                            <?php 
                                                endif;
                                            endforeach; 
                                            ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php 
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                <?php endif; ?>
            </div>
            
        <?php else : ?>
            <div class="experience-empty" data-animation="fade-in">
                <div class="empty-message">
                    <i class="fas fa-briefcase"></i>
                    <h3>No Work Experience Found</h3>
                    <p>Start adding your work experience to showcase your professional journey.</p>
                    <?php if (current_user_can('edit_posts')) : ?>
                        <a href="<?php echo admin_url('post-new.php?post_type=experience'); ?>" class="button button-primary">
                            <i class="fas fa-plus"></i> Add Your First Experience
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>