<?php
/**
 * Hero Section Template
 * 
 * Displays the main hero section with introduction text and call-to-action buttons.
 * Content can be customized in WordPress Customizer > Hero Section.
 *
 * @package Stylefolio
 */

// Default content values - customize these in the WordPress Customizer
$defaults = [
    'greeting' => 'Hi, I\'m',
    'name' => 'Mark Fedrish',
    'profession' => 'Full Stack Developer',
    'description' => 'Crafting innovative digital experiences with clean code and pixel-perfect design. Specialized in creating modern web applications that blend form and function.',
    'cta_primary_text' => 'Hire Me',
    'cta_primary_url' => '#contact',
    'cta_secondary_text' => 'View Projects',
    'cta_secondary_url' => '#portfolio',
    'cta_tertiary_text' => 'Download Resume',
];

// Get customized content from WordPress Customizer (or use defaults)
$greeting = get_theme_mod('hero_greeting', $defaults['greeting']);
$name = get_theme_mod('hero_name', $defaults['name']);
$profession = get_theme_mod('hero_profession', $defaults['profession']);
$description = get_theme_mod('hero_description', $defaults['description']);
$cta_primary_text = get_theme_mod('hero_cta_primary_text', $defaults['cta_primary_text']);
$cta_primary_url = get_theme_mod('hero_cta_primary_url', $defaults['cta_primary_url']);
$cta_secondary_text = get_theme_mod('hero_cta_secondary_text', $defaults['cta_secondary_text']);
$cta_secondary_url = get_theme_mod('hero_cta_secondary_url', $defaults['cta_secondary_url']);
$cta_tertiary_text = get_theme_mod('hero_cta_tertiary_text', $defaults['cta_tertiary_text']);
$cta_tertiary_url = stylefolio_get_resume_download_url();

// Get hero image
$hero_image_id = get_theme_mod('hero_image');
$hero_image_url = $hero_image_id ? wp_get_attachment_image_url($hero_image_id, 'full') : get_template_directory_uri() . '/assets/images/haseeb.png';
$hero_image_alt = $name . ' - ' . $profession;
?>

<section id="hero" class="hero-section">
    <div class="hero-container">
        <div class="hero-content">
            <div class="hero-intro" data-animation="fade-in">
                <span class="hero-greeting"><?php echo esc_html($greeting); ?></span>
                <h1 class="hero-title"><?php echo esc_html($name); ?></h1>
                <h2 class="hero-subtitle"><?php echo esc_html($profession); ?></h2>
                
                <div class="hero-description">
                    <p><?php echo esc_html($description); ?></p>
                </div>
                  <div class="hero-cta">
                    <a href="<?php echo esc_url($cta_primary_url); ?>" class="btn btn-primary"><?php echo esc_html($cta_primary_text); ?> <i class="fas fa-paper-plane"></i></a>
                    <a href="<?php echo esc_url($cta_secondary_url); ?>" class="btn btn-secondary"><?php echo esc_html($cta_secondary_text); ?> <i class="fas fa-eye"></i></a>                    <?php 
                    // Check if resume is available and valid
                    $resume_file_id = get_theme_mod('hero_resume_file');
                    $is_resume_valid = false;
                    
                    if ($resume_file_id) {
                        $file_path = get_attached_file($resume_file_id);
                        if ($file_path && file_exists($file_path)) {
                            $file_info = pathinfo($file_path);
                            $extension = strtolower($file_info['extension']);
                            $allowed_extensions = array('pdf', 'doc', 'docx');
                            $is_resume_valid = in_array($extension, $allowed_extensions);
                        }
                    }
                    
                    $download_attr = $is_resume_valid ? '' : 'download';
                    $button_class = $cta_tertiary_url === '#' ? 'btn btn-outlined disabled' : 'btn btn-outlined';
                    $button_title = $cta_tertiary_url === '#' ? 'Resume not uploaded yet' : 'Download Resume';
                    ?>
                    <a href="<?php echo esc_url($cta_tertiary_url); ?>" 
                       class="<?php echo esc_attr($button_class); ?>" 
                       <?php echo $download_attr; ?>
                       <?php if ($cta_tertiary_url === '#') echo 'onclick="return false;"'; ?>
                       title="<?php echo esc_attr($button_title); ?>"
                       <?php if ($is_resume_valid) echo 'target="_blank"'; ?>>
                       <?php echo esc_html($cta_tertiary_text); ?> <i class="fas fa-download"></i>
                    </a>
                </div>
                
                <div class="hero-social">                    <?php
                    // LinkedIn
                    if (get_theme_mod('hero_social_linkedin_enabled', true)) :
                        $linkedin_url = get_theme_mod('hero_social_linkedin', '#');
                        // Ensure URL is not empty - fallback to # if it is
                        $linkedin_url = !empty($linkedin_url) ? $linkedin_url : '#';
                        
                        // Check if it's an external link (starts with http/https)
                        $is_external_linkedin = ($linkedin_url !== '#' && (strpos($linkedin_url, 'http://') === 0 || strpos($linkedin_url, 'https://') === 0));
                        
                        // Only show if enabled and URL is not just placeholder
                        if ($linkedin_url !== '#') :
                    ?>
                        <a href="<?php echo esc_url($linkedin_url); ?>" 
                        class="social-icon" 
                        aria-label="LinkedIn" 
                        <?php echo $is_external_linkedin ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    <?php endif; ?>
                    <?php endif; ?>
                      <?php
                    // GitHub
                    if (get_theme_mod('hero_social_github_enabled', true)) :
                        $github_url = get_theme_mod('hero_social_github', '#');
                        // Ensure URL is not empty - fallback to # if it is
                        $github_url = !empty($github_url) ? $github_url : '#';
                        
                        // Check if it's an external link (starts with http/https)
                        $is_external_github = ($github_url !== '#' && (strpos($github_url, 'http://') === 0 || strpos($github_url, 'https://') === 0));
                        
                        // Only show if enabled and URL is not just placeholder
                        if ($github_url !== '#') :
                    ?>
                        <a href="<?php echo esc_url($github_url); ?>" 
                        class="social-icon" 
                        aria-label="GitHub" 
                        <?php echo $is_external_github ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                            <i class="fab fa-github"></i>
                        </a>
                    <?php endif; ?>
                    <?php endif; ?>
                      <?php
                    // Twitter
                    if (get_theme_mod('hero_social_twitter_enabled', true)) :
                        $twitter_url = get_theme_mod('hero_social_twitter', '#');
                        // Ensure URL is not empty - fallback to # if it is
                        $twitter_url = !empty($twitter_url) ? $twitter_url : '#';
                        
                        // Check if it's an external link (starts with http/https)
                        $is_external_twitter = ($twitter_url !== '#' && (strpos($twitter_url, 'http://') === 0 || strpos($twitter_url, 'https://') === 0));
                        
                        // Only show if enabled and URL is not just placeholder
                        if ($twitter_url !== '#') :
                    ?>
                        <a href="<?php echo esc_url($twitter_url); ?>" 
                        class="social-icon" 
                        aria-label="Twitter" 
                        <?php echo $is_external_twitter ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                            <i class="fab fa-twitter"></i>
                        </a>
                    <?php endif; ?>
                    <?php endif; ?>
                      <?php
                    // Medium
                    if (get_theme_mod('hero_social_medium_enabled', true)) :
                        $medium_url = get_theme_mod('hero_social_medium', '#');
                        // Ensure URL is not empty - fallback to # if it is
                        $medium_url = !empty($medium_url) ? $medium_url : '#';
                        
                        // Check if it's an external link (starts with http/https)
                        $is_external_medium = ($medium_url !== '#' && (strpos($medium_url, 'http://') === 0 || strpos($medium_url, 'https://') === 0));
                        
                        // Only show if enabled and URL is not just placeholder
                        if ($medium_url !== '#') :
                    ?>
                        <a href="<?php echo esc_url($medium_url); ?>" 
                        class="social-icon" 
                        aria-label="Medium" 
                        <?php echo $is_external_medium ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                            <i class="fab fa-medium-m"></i>
                        </a>
                    <?php endif; ?>
                    <?php endif; ?>
                      <?php
                    // Custom social icon
                    if (get_theme_mod('hero_social_custom_enabled', false)) :
                        $custom_url = get_theme_mod('hero_social_custom', '');
                        // For custom icon, if URL is empty, don't show the icon at all
                        if (!empty($custom_url)) :
                            $custom_icon = get_theme_mod('hero_social_custom_icon', 'fab fa-instagram');
                            
                            // Check if it's an external link (starts with http/https)
                            $is_external_custom = (strpos($custom_url, 'http://') === 0 || strpos($custom_url, 'https://') === 0);
                    ?>
                        <a href="<?php echo esc_url($custom_url); ?>" 
                        class="social-icon" 
                        aria-label="Social Media" 
                        <?php echo $is_external_custom ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                            <i class="<?php echo esc_attr($custom_icon); ?>"></i>
                        </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="hero-image" data-animation="slide-in-right">
                <!-- Hero image container -->
                <div class="hero-image-container">
                    <img src="<?php echo esc_url($hero_image_url); ?>" alt="<?php echo esc_attr($hero_image_alt); ?>" class="hero-img">
                    
                    <!-- Floating Elements -->
                    <div class="floating-element element-1" data-floating-speed="5">
                        <i class="fab fa-react"></i>
                    </div>
                    <div class="floating-element element-2" data-floating-speed="7">
                        <i class="fab fa-node-js"></i>
                    </div>
                    <div class="floating-element element-3" data-floating-speed="9">
                        <i class="fab fa-wordpress"></i>
                    </div>
                    <div class="floating-element element-4" data-floating-speed="6">
                        <i class="fab fa-php"></i>
                    </div>
                </div>
            </div>
        </div>
        
    </div>    <!-- Animated Background Elements -->
    <div class="hero-bg-elements">
        <div class="bg-grid"></div>
        <div class="bg-particles"></div>
        <div class="bg-glow"></div>
    </div>
    
    <!-- Timestamp Comment (for development) -->
    <!-- Last updated: 2025-06-10 07:29:45 by abdulhaseeb2002 -->
</section>