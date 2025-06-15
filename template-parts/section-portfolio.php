<?php
/**
 * Portfolio Section Template
 * 
 * Displays portfolio projects with filtering and modal views.
 * Add projects through WordPress Admin > Portfolio.
 * Configure section settings in Customizer > Portfolio Section.
 *
 * @package Stylefolio
 */

// Get settings
$settings_args = array(
    'post_type'      => 'portfolio_setting',
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
        'post_title'    => 'Portfolio Section Settings',
        'post_status'   => 'publish',
        'post_type'     => 'portfolio_settings',
    ));
}

// Default values
$section_title = 'Portfolio';
$section_subtitle = 'My Recent Work';
$section_description = 'Explore my latest projects showcasing creative solutions and technical expertise across various domains.';
$display_count = 6;
$layout_style = 'grid';
$cta_text = 'View All Projects';
$cta_url = '#portfolio';

// Try to get field values if they exist
if (function_exists('get_field') && $settings_id) {
    $section_title = get_field('portfolio_title', $settings_id) ?: $section_title;
    $section_subtitle = get_field('portfolio_subtitle', $settings_id) ?: $section_subtitle;
    $section_description = get_field('portfolio_description', $settings_id) ?: $section_description;
    $display_count = get_field('portfolio_display_count', $settings_id) ?: $display_count;
    $layout_style = get_field('portfolio_layout', $settings_id) ?: $layout_style;
    $cta_text = get_field('portfolio_cta_text', $settings_id) ?: $cta_text;
    $cta_url = get_field('portfolio_cta_url', $settings_id) ?: $cta_url;
}

// Get categories
$categories_args = array(
    'post_type'      => 'project_category',
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

// Get projects - Load all projects and let JavaScript handle pagination
$projects_args = array(
    'post_type'      => 'project',
    'posts_per_page' => -1, // Load all projects
    'post_status'    => 'publish',
    'meta_key'       => 'project_order',
    'orderby'        => array(
        'meta_value_num' => 'ASC',
        'date' => 'DESC'
    ),
);

$projects_query = new WP_Query($projects_args);
$has_projects = $projects_query->have_posts();

// Add unique identifier for this section
$section_id = 'portfolio-' . uniqid();
?>

<section id="portfolio" class="portfolio-section">
    <div class="section-background">
        <div class="bg-grid"></div>
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
                <span class="divider-icon"><i class="fas fa-briefcase"></i></span>
                <span class="divider-line"></span>
            </div>
        </div>
        
        <?php if (!empty($categories)) : ?>
            <div class="portfolio-filter" data-animation="fade-in">
                <button class="filter-button active" data-filter="*">All</button>
                <?php foreach ($categories as $category) : ?>
                    <button class="filter-button" data-filter=".category-<?php echo esc_attr($category['slug']); ?>">
                        <?php if ($category['icon']) : ?>
                            <i class="<?php echo esc_attr($category['icon']); ?>"></i>
                        <?php endif; ?>
                        <?php echo esc_html($category['name']); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($has_projects) : ?>
            <div class="portfolio-grid <?php echo esc_attr($layout_style); ?>" data-animation="fade-in-up">
               <!-- Replace the existing portfolio item loop with this -->
<?php 
while ($projects_query->have_posts()) :
    $projects_query->the_post();
    
    $project_id = get_the_ID();
    $project_title = get_the_title();
    $project_excerpt = get_the_excerpt();
    $project_content = get_the_content();
    $project_category_id = get_field('project_category', $project_id);
    $project_client = get_field('project_client', $project_id);
    $project_date = get_field('project_date', $project_id);
    $project_url = get_field('project_url', $project_id);
    $project_tech = get_field('project_tech', $project_id);    // Get project gallery using our helper function
    $project_gallery = portfolio_pro_get_project_gallery($project_id);
    $project_featured = get_field('project_featured', $project_id);
    
    // Get category data
    $category_name = '';
    $category_slug = '';
    
    if ($project_category_id) {
        $category_name = get_the_title($project_category_id);
        $category_slug = sanitize_title($category_name);
    }
    
    // Get featured image or first gallery image
    $thumbnail_id = get_post_thumbnail_id($project_id);
    $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'large');
    
    if (!$thumbnail_url && !empty($project_gallery)) {
        $thumbnail_url = $project_gallery[0]['sizes']['large'] ?? $project_gallery[0]['url'];
    }
    
    // Default image if none exists
    if (!$thumbnail_url) {
        $thumbnail_url = get_template_directory_uri() . '/assets/images/projects/project-1.jpg';
    }
    
    // Class for featured projects
    $featured_class = $project_featured ? 'featured' : '';
    
    // Prepare gallery for popup
    $gallery_json = '';
    if (!empty($project_gallery)) {
        $gallery_items = array();
        foreach ($project_gallery as $image) {
            $gallery_items[] = array(
                'src' => $image['url'],
                'thumb' => $image['sizes']['medium'] ?? $image['sizes']['thumbnail'],
                'caption' => $image['caption'] ?? $image['alt'],
                'alt' => $image['alt']
            );
        }
        $gallery_json = htmlspecialchars(json_encode($gallery_items), ENT_QUOTES, 'UTF-8');
    }
    
    // Create a short excerpt (limited to 120 characters)
    $short_excerpt = wp_trim_words($project_excerpt, 15, '...');
?>    <div class="portfolio-item <?php echo esc_attr($featured_class); ?> category-<?php echo esc_attr($category_slug); ?>" 
         data-project-id="<?php echo esc_attr($project_id); ?>">
        <div class="portfolio-item-inner">
            <div class="portfolio-image">
                <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($project_title); ?>">
                
                <!-- Hover overlay with project details -->
                <div class="portfolio-overlay">
                    <div class="portfolio-overlay-content">
                        <span class="portfolio-category"><?php echo esc_html($category_name); ?></span>
                        <div class="portfolio-links">
                            <a href="#" class="view-details" data-project="<?php echo esc_attr($project_id); ?>">
                                <i class="fas fa-search-plus"></i>
                                Project Details
                            </a>
                            <?php if ($project_url) : ?>
                            <a href="<?php echo esc_url($project_url); ?>" target="_blank" rel="noopener noreferrer">
                                <i class="fas fa-external-link-alt"></i>
                                Live Link
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($project_featured) : ?>
                <span class="featured-badge"><i class="fas fa-star"></i> Featured</span>
            <?php endif; ?>
        </div>
        
        <!-- Hidden Project Details for Popup -->
        <div class="project-details-data" style="display: none;" 
             data-id="<?php echo esc_attr($project_id); ?>"
             data-title="<?php echo esc_attr($project_title); ?>"
             data-excerpt="<?php echo esc_attr($project_excerpt); ?>"
             data-category="<?php echo esc_attr($category_name); ?>"
             data-client="<?php echo esc_attr($project_client); ?>"
             data-date="<?php echo esc_attr($project_date); ?>"
             data-url="<?php echo esc_url($project_url); ?>"
             data-tech="<?php echo esc_attr($project_tech); ?>"
             data-featured-image="<?php echo esc_url($thumbnail_url); ?>"
             data-gallery='<?php echo $gallery_json; ?>'
             data-content="<?php echo esc_attr(wpautop($project_content)); ?>">
        </div>
    </div>
<?php 
endwhile;
wp_reset_postdata();
?>
            </div>
            
            
        <?php else : ?>
            <div class="portfolio-empty" data-animation="fade-in">
                <div class="empty-message">
                    <i class="fas fa-folder-open"></i>
                    <h3>No Projects Found</h3>
                    <p>Start adding your amazing projects to showcase your work.</p>
                    <?php if (current_user_can('edit_posts')) : ?>
                        <a href="<?php echo admin_url('post-new.php?post_type=project'); ?>" class="button button-primary">
                            <i class="fas fa-plus"></i> Add Your First Project
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>    </div>
</section>

<!-- Project Details Popup - Moved outside of section for proper positioning -->
<div id="project-popup" class="project-popup">
    <div class="popup-overlay"></div>
    <div class="popup-container">
        <div class="popup-header">
            <h2 class="popup-title"></h2>
            <button class="popup-close" aria-label="Close popup">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="popup-content">
            <div class="popup-loading">
                <div class="spinner"></div>
                <span>Loading project details...</span>
            </div>
            <div class="popup-body">
                <div class="project-gallery-container">
                    <div class="project-featured-image">
                        <img src="" alt="">
                    </div>
                    <div class="project-gallery"></div>
                </div>
                <div class="project-info">
                    <div class="project-description"></div>
                    <div class="project-meta">
                        <div class="meta-item">
                            <span class="meta-label">Category:</span>
                            <span class="meta-value category"></span>
                        </div>
                        <div class="meta-item client">
                            <span class="meta-label">Client:</span>
                            <span class="meta-value"></span>
                        </div>
                        <div class="meta-item date">
                            <span class="meta-label">Date:</span>
                            <span class="meta-value"></span>
                        </div>
                        <div class="meta-item technologies">
                            <span class="meta-label">Technologies:</span>
                            <span class="meta-value"></span>
                        </div>
                    </div>
                    <div class="project-actions">
                        <a href="#" class="project-url button button-primary" target="_blank" rel="noopener noreferrer">
                            <i class="fas fa-external-link-alt"></i> View Live Project
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>