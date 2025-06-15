<?php
/**
 * Education Section Template
 * 
 * Displays educational background in timeline or card format.
 * Add education entries through WordPress Admin > Education.
 * Configure display options in ACF Options > Education Section.
 *
 * @package Stylefolio
 */

// Get section settings
$section_title = get_field('education_section_title', 'option') ?: 'Education';
$section_subtitle = get_field('education_section_subtitle', 'option') ?: 'Academic Background';
$section_description = get_field('education_section_description', 'option') ?: 'My educational journey and academic achievements that shaped my expertise and knowledge foundation.';
$layout_style = get_field('education_section_layout', 'option') ?: 'timeline';
$display_count = get_field('education_section_count', 'option') ?: 0;
$show_achievements = get_field('education_show_achievements', 'option') !== false;
$show_courses = get_field('education_show_courses', 'option') !== false;

// Get education entries
$education_args = array(
    'post_type'      => 'education',
    'posts_per_page' => ($display_count > 0) ? $display_count : -1,
    'post_status'    => 'publish',
    'meta_key'       => 'education_order',
    'orderby'        => array(
        'meta_value_num' => 'ASC',
        'date' => 'DESC'
    ),
);

$education_query = new WP_Query($education_args);
$has_education = $education_query->have_posts();

// Add unique identifier for this section
$section_id = 'education-' . uniqid();
?>

<section id="education" class="education-section">
    <div class="section-background">
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
                <span class="divider-icon"><i class="fas fa-graduation-cap"></i></span>
                <span class="divider-line"></span>
            </div>
        </div>
        
        <?php if ($has_education) : ?>
            <div class="education-container <?php echo esc_attr($layout_style); ?>" data-animation="fade-in-up">
                
                <?php if ($layout_style === 'timeline') : ?>
                    <div class="education-timeline" id="<?php echo esc_attr($section_id); ?>">
                        <div class="timeline-line"></div>
                        
                        <?php 
                        $count = 0;
                        while ($education_query->have_posts()) :
                            $education_query->the_post();
                            $post_id = get_the_ID();
                            
                            // Get fields
                            $degree = get_field('degree', $post_id) ?: get_the_title();
                            $institution = get_field('institution', $post_id) ?: '';
                            $location = get_field('location', $post_id) ?: '';
                            $institution_url = get_field('institution_url', $post_id) ?: '';
                            $education_type = get_field('education_type', $post_id) ?: 'bachelors';
                            $field_of_study = get_field('field_of_study', $post_id) ?: '';
                            $grade = get_field('grade', $post_id) ?: '';
                            $start_date = get_field('start_date', $post_id) ?: '';
                            $end_date = get_field('end_date', $post_id) ?: '';
                            $is_current = get_field('is_current', $post_id) ?: false;
                            $activities = get_field('activities', $post_id) ?: '';
                            $courses = get_field('courses', $post_id) ?: '';
                            
                            // Format the date range
                            $date_range = '';
                            if ($start_date) {
                                $date_range = $start_date;
                                if ($is_current) {
                                    $date_range .= ' - Present';
                                } elseif ($end_date) {
                                    $date_range .= ' - ' . $end_date;
                                }                            }
                            
                            // Get achievements - handle both formats for backward compatibility
                            $achievements = get_field('achievements', $post_id) ?: '';
                            
                            // Convert achievements to array format if needed
                            $achievements_array = array();
                            if (!empty($achievements)) {
                                if (is_array($achievements)) {
                                    // Old repeater format - convert to simple array
                                    foreach ($achievements as $achievement) {
                                        if (is_array($achievement) && isset($achievement['achievement'])) {
                                            $achievements_array[] = $achievement['achievement'];
                                        } elseif (is_string($achievement)) {
                                            $achievements_array[] = $achievement;
                                        }
                                    }
                                } else {
                                    // New textarea format - split by lines
                                    $lines = explode("\n", $achievements);
                                    foreach ($lines as $line) {
                                        $line = trim($line);
                                        if (!empty($line)) {
                                            $achievements_array[] = $line;
                                        }
                                    }
                                }
                            }
                            
                            // Position class (alternating for timeline)
                            $position_class = ($count % 2 === 0) ? 'left' : 'right';
                            $count++;
                            
                            // Get education type icon
                            $education_icon = 'graduation-cap';
                            switch ($education_type) {
                                case 'bachelors':
                                    $education_icon = 'user-graduate';
                                    break;
                                case 'masters':
                                    $education_icon = 'award';
                                    break;
                                case 'doctorate':
                                    $education_icon = 'user-graduate';
                                    break;
                                case 'certification':
                                    $education_icon = 'certificate';
                                    break;
                                case 'diploma':
                                    $education_icon = 'scroll';
                                    break;
                                case 'course':
                                    $education_icon = 'book';
                                    break;
                                case 'highschool':
                                    $education_icon = 'school';
                                    break;
                            }
                        ?>
                            <div class="timeline-item <?php echo esc_attr($position_class); ?>">
                                <div class="timeline-marker">
                                    <?php if ($is_current) : ?>
                                        <span class="current-marker"></span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="timeline-content">
                                    <div class="education-date">
                                        <span><?php echo esc_html($date_range); ?></span>
                                        <span class="education-type">
                                            <?php 
                                            switch ($education_type) {
                                                case 'bachelors': echo 'Bachelor\'s Degree'; break;
                                                case 'masters': echo 'Master\'s Degree'; break;
                                                case 'doctorate': echo 'PhD/Doctorate'; break;
                                                case 'certification': echo 'Certification'; break;
                                                case 'diploma': echo 'Diploma'; break;
                                                case 'course': echo 'Course'; break;
                                                case 'highschool': echo 'High School'; break;
                                                default: echo ucfirst($education_type); break;
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    
                                    <div class="education-details">
                                        <h3 class="degree-title"><?php echo esc_html($degree); ?></h3>
                                        
                                        <div class="institution-info">
                                            <?php if ($institution_url) : ?>
                                                <a href="<?php echo esc_url($institution_url); ?>" class="institution-name" target="_blank" rel="noopener">
                                                    <?php echo esc_html($institution); ?>
                                                </a>
                                            <?php else : ?>
                                                <span class="institution-name"><?php echo esc_html($institution); ?></span>
                                            <?php endif; ?>
                                            
                                            <?php if ($location) : ?>
                                                <span class="institution-location">
                                                    <i class="fas fa-map-marker-alt"></i> <?php echo esc_html($location); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <?php if ($field_of_study || $grade) : ?>
                                            <div class="study-info">
                                                <?php if ($field_of_study) : ?>
                                                    <div class="field-of-study">
                                                        <i class="fas fa-bookmark"></i> <?php echo esc_html($field_of_study); ?>
                                                    </div>
                                                <?php endif; ?>
                                                  <?php if ($grade) : ?>
                                                    <div class="grade">
                                                        <i class="fas fa-star"></i> <?php echo esc_html($grade); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($activities) : ?>
                                            <div class="activities">
                                                <h4><i class="fas fa-users"></i> Activities & Societies</h4>
                                                <p><?php echo esc_html($activities); ?></p>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($show_achievements && !empty($achievements_array)) : ?>
                                            <div class="achievements">
                                                <h4><i class="fas fa-trophy"></i> Achievements & Honors</h4>
                                                <ul>
                                                    <?php foreach ($achievements_array as $achievement) : ?>
                                                        <li><?php echo esc_html($achievement); ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($show_courses && $courses) : ?>
                                            <div class="courses">
                                                <h4><i class="fas fa-book"></i> Relevant Courses</h4>
                                                <div class="course-tags">
                                                    <?php 
                                                    $course_array = explode(',', $courses);
                                                    foreach ($course_array as $course) :
                                                        $course = trim($course);
                                                        if (!empty($course)) :
                                                    ?>
                                                        <span class="course-tag"><?php echo esc_html($course); ?></span>
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
                    <div class="education-cards">
                        <?php 
                        while ($education_query->have_posts()) :
                            $education_query->the_post();
                            $post_id = get_the_ID();
                            
                            // Get fields
                            $degree = get_field('degree', $post_id) ?: get_the_title();
                            $institution = get_field('institution', $post_id) ?: '';
                            $location = get_field('location', $post_id) ?: '';
                            $institution_url = get_field('institution_url', $post_id) ?: '';
                            $education_type = get_field('education_type', $post_id) ?: 'bachelors';
                            $field_of_study = get_field('field_of_study', $post_id) ?: '';
                            $grade = get_field('grade', $post_id) ?: '';
                            $start_date = get_field('start_date', $post_id) ?: '';
                            $end_date = get_field('end_date', $post_id) ?: '';
                            $is_current = get_field('is_current', $post_id) ?: false;
                            $activities = get_field('activities', $post_id) ?: '';
                            $courses = get_field('courses', $post_id) ?: '';
                            
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
                            
                            // Get achievements
                            $achievements = get_field('achievements', $post_id) ?: array();
                            
                            // Get education type icon
                            $education_icon = 'graduation-cap';
                            switch ($education_type) {
                                case 'bachelors':
                                    $education_icon = 'user-graduate';
                                    break;
                                case 'masters':
                                    $education_icon = 'award';
                                    break;
                                case 'doctorate':
                                    $education_icon = 'user-graduate';
                                    break;
                                case 'certification':
                                    $education_icon = 'certificate';
                                    break;
                                case 'diploma':
                                    $education_icon = 'scroll';
                                    break;
                                case 'course':
                                    $education_icon = 'book';
                                    break;
                                case 'highschool':
                                    $education_icon = 'school';
                                    break;
                            }
                        ?>
                            <div class="education-card">
                                
                                
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="institution-logo">
                                        <?php the_post_thumbnail('thumbnail'); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="card-header">
                                    <h3 class="degree-title"><?php echo esc_html($degree); ?></h3>
                                    <div class="institution-info">
                                        <?php if ($institution_url) : ?>
                                            <a href="<?php echo esc_url($institution_url); ?>" class="institution-name" target="_blank" rel="noopener">
                                                <?php echo esc_html($institution); ?>
                                            </a>
                                        <?php else : ?>
                                            <span class="institution-name"><?php echo esc_html($institution); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="card-meta">
                                    <div class="date-range">
                                        <i class="far fa-calendar-alt"></i> <?php echo esc_html($date_range); ?>
                                    </div>
                                    
                                    <?php if ($location) : ?>
                                        <div class="location">
                                            <i class="fas fa-map-marker-alt"></i> <?php echo esc_html($location); ?>
                                        </div>
                                    <?php endif; ?>
                                      <div class="education-type">
                                        <?php 
                                        switch ($education_type) {
                                            case 'bachelors': echo 'Bachelor\'s Degree'; break;
                                            case 'masters': echo 'Master\'s Degree'; break;
                                            case 'doctorate': echo 'PhD/Doctorate'; break;
                                            case 'certification': echo 'Certification'; break;
                                            case 'diploma': echo 'Diploma'; break;
                                            case 'course': echo 'Course'; break;
                                            case 'highschool': echo 'High School'; break;
                                            default: echo ucfirst($education_type); break;
                                        }
                                        ?>
                                    </div>
                                </div>
                                
                                <?php if ($field_of_study || $grade) : ?>
                                    <div class="study-info">
                                        <?php if ($field_of_study) : ?>
                                            <div class="field-of-study">
                                                <strong>Field of Study:</strong> <?php echo esc_html($field_of_study); ?>
                                            </div>
                                        <?php endif; ?>
                                          <?php if ($grade) : ?>
                                            <div class="grade">
                                                <strong>Grade:</strong> <?php echo esc_html($grade); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($activities) : ?>
                                    <div class="activities">
                                        <h4><i class="fas fa-users"></i> Activities & Societies</h4>
                                        <p><?php echo esc_html($activities); ?></p>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($show_achievements && !empty($achievements_array)) : ?>
                                    <div class="achievements">
                                        <h4><i class="fas fa-trophy"></i> Achievements & Honors</h4>
                                        <ul>
                                            <?php foreach ($achievements_array as $achievement) : ?>
                                                <li><?php echo esc_html($achievement); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($show_courses && $courses) : ?>
                                    <div class="courses">
                                        <h4><i class="fas fa-book"></i> Relevant Courses</h4>
                                        <div class="course-tags">
                                            <?php 
                                            $course_array = explode(',', $courses);
                                            foreach ($course_array as $course) :
                                                $course = trim($course);
                                                if (!empty($course)) :
                                            ?>
                                                <span class="course-tag"><?php echo esc_html($course); ?></span>
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
            <div class="education-empty" data-animation="fade-in">
                <div class="empty-message">
                    <i class="fas fa-graduation-cap"></i>
                    <h3>No Education Entries Found</h3>
                    <p>Start adding your educational background to showcase your academic journey.</p>
                    <?php if (current_user_can('edit_posts')) : ?>
                        <a href="<?php echo admin_url('post-new.php?post_type=education'); ?>" class="button button-primary">
                            <i class="fas fa-plus"></i> Add Your First Education Entry
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>