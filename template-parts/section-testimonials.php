<?php
/**
 * Testimonials Section Template
 * 
 * Displays client testimonials in slider or grid layout.
 * Add testimonials through WordPress Admin > Testimonials.
 * Configure display options in ACF Options > Testimonials Section.
 *
 * @package Stylefolio
 */

// Get section settings
$section_title = get_field('testimonial_section_title', 'option') ?: 'Testimonials';
$section_subtitle = get_field('testimonial_section_subtitle', 'option') ?: 'What Clients Say';
$layout_style = get_field('testimonial_section_layout', 'option') ?: 'slider';
$display_count = get_field('testimonial_section_count', 'option') ?: 6;

// Get testimonials
$testimonials_args = array(
    'post_type'      => 'testimonial',
    'posts_per_page' => ($display_count > 0) ? $display_count : -1,
    'post_status'    => 'publish',
    'meta_key'       => 'testimonial_order',
    'orderby'        => array(
        'meta_value_num' => 'ASC',
        'date' => 'DESC'
    ),
);

$testimonials_query = new WP_Query($testimonials_args);
$has_testimonials = $testimonials_query->have_posts();

// Add unique identifier for this section
$section_id = 'testimonials-' . uniqid();
?>

<section id="testimonials" class="testimonials-section">
    <div class="section-background">        <div class="bg-particles"></div>
        <div class="bg-glow"></div>
    </div>
      <div class="container">        
        <div class="section-header" data-animation="fade-in">
            <span class="section-subtitle"><?php echo esc_html($section_subtitle); ?></span>
            <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
            <p class="section-description">Discover what our valued clients have to say about their experience working with us and the exceptional results we've delivered together.</p>
            <div class="section-divider">
                <span class="divider-line"></span>
                <span class="divider-icon"><i class="fas fa-quote-right"></i></span>
                <span class="divider-line"></span>
            </div>
        </div>
        
        <?php if ($has_testimonials) : ?>
            <div class="testimonials-container <?php echo esc_attr($layout_style); ?>" data-animation="fade-in-up">
                
                <?php if ($layout_style === 'slider') : ?>
                    <div class="testimonials-slider" id="<?php echo esc_attr($section_id); ?>">
                        <?php 
                        while ($testimonials_query->have_posts()) :
                            $testimonials_query->the_post();
                            
                            $testimonial_id = get_the_ID();
                            $client_name = get_field('client_name', $testimonial_id) ?: get_the_title();
                            $client_position = get_field('client_position', $testimonial_id) ?: '';
                            $client_company = get_field('client_company', $testimonial_id) ?: '';
                            $client_quote = get_field('client_quote', $testimonial_id) ?: get_the_content();
                            $client_rating = get_field('client_rating', $testimonial_id) ?: 5;
                            
                            // Generate star rating
                            $star_rating = '';
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $client_rating) {
                                    $star_rating .= '<i class="fas fa-star"></i>';
                                } else if ($i - 0.5 <= $client_rating) {
                                    $star_rating .= '<i class="fas fa-star-half-alt"></i>';
                                } else {
                                    $star_rating .= '<i class="far fa-star"></i>';
                                }
                            }
                        ?>
                            <div class="testimonial-item">
                                <div class="testimonial-content">
                                    <div class="quote-icon">
                                        <i class="fas fa-quote-left"></i>
                                    </div>
                                    <div class="client-quote">
                                        <?php echo wpautop(esc_html($client_quote)); ?>
                                    </div>
                                    <div class="client-rating">
                                        <?php echo $star_rating; ?>
                                    </div>
                                </div>
                                <div class="testimonial-meta">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="client-image">
                                            <?php the_post_thumbnail('thumbnail'); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="client-info">
                                        <h4 class="client-name"><?php echo esc_html($client_name); ?></h4>
                                        <?php if ($client_position && $client_company) : ?>
                                            <p class="client-position"><?php echo esc_html($client_position); ?>, <?php echo esc_html($client_company); ?></p>
                                        <?php elseif ($client_position) : ?>
                                            <p class="client-position"><?php echo esc_html($client_position); ?></p>
                                        <?php elseif ($client_company) : ?>
                                            <p class="client-position"><?php echo esc_html($client_company); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php 
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                    
                    <div class="testimonials-controls">
                        <button class="testimonial-prev" aria-label="Previous testimonial">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="testimonials-dots"></div>
                        <button class="testimonial-next" aria-label="Next testimonial">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                      <?php else : ?>
                    <!-- Cards Layout -->
                    <div class="testimonials-cards">
                        <?php 
                        while ($testimonials_query->have_posts()) :
                            $testimonials_query->the_post();
                            
                            $testimonial_id = get_the_ID();
                            $client_name = get_field('client_name', $testimonial_id) ?: get_the_title();
                            $client_position = get_field('client_position', $testimonial_id) ?: '';
                            $client_company = get_field('client_company', $testimonial_id) ?: '';
                            $client_quote = get_field('client_quote', $testimonial_id) ?: get_the_content();
                            $client_rating = get_field('client_rating', $testimonial_id) ?: 5;
                            
                            // Generate star rating
                            $star_rating = '';
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $client_rating) {
                                    $star_rating .= '<i class="fas fa-star"></i>';
                                } else if ($i - 0.5 <= $client_rating) {
                                    $star_rating .= '<i class="fas fa-star-half-alt"></i>';
                                } else {
                                    $star_rating .= '<i class="far fa-star"></i>';
                                }
                            }
                        ?>
                            <div class="testimonial-card">
                                <div class="testimonial-content">
                                    <div class="quote-icon">
                                        <i class="fas fa-quote-left"></i>
                                    </div>
                                    <div class="client-quote">
                                        <?php echo wpautop(esc_html($client_quote)); ?>
                                    </div>
                                    <div class="client-rating">
                                        <?php echo $star_rating; ?>
                                    </div>
                                </div>
                                <div class="testimonial-meta">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="client-image">
                                            <?php the_post_thumbnail('thumbnail'); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="client-info">
                                        <h4 class="client-name"><?php echo esc_html($client_name); ?></h4>
                                        <?php if ($client_position && $client_company) : ?>
                                            <p class="client-position"><?php echo esc_html($client_position); ?>, <?php echo esc_html($client_company); ?></p>
                                        <?php elseif ($client_position) : ?>
                                            <p class="client-position"><?php echo esc_html($client_position); ?></p>
                                        <?php elseif ($client_company) : ?>
                                            <p class="client-position"><?php echo esc_html($client_company); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="testimonial-hover-effect"></div>
                            </div>
                        <?php 
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                <?php endif; ?>
            </div>
            
        <?php else : ?>
            <div class="testimonials-empty" data-animation="fade-in">
                <div class="empty-message">
                    <i class="fas fa-comment-dots"></i>
                    <h3>No Testimonials Found</h3>
                    <p>Start adding testimonials from your clients to showcase your reputation.</p>
                    <?php if (current_user_can('edit_posts')) : ?>
                        <a href="<?php echo admin_url('post-new.php?post_type=testimonial'); ?>" class="button button-primary">
                            <i class="fas fa-plus"></i> Add Your First Testimonial
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>