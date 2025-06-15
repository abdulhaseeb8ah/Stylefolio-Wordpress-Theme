<?php
/**
 * Front Page Template
 * 
 * This is the main homepage template that displays all portfolio sections.
 * The sections are loaded from template-parts/ directory.
 * To customize content, use the WordPress Customizer or ACF Options pages.
 *
 * @package Stylefolio
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <!-- Hero Section -->
        <?php get_template_part( 'template-parts/section', 'hero' ); ?>
        
        <!-- Skills Section -->
        <?php get_template_part( 'template-parts/section', 'skills' ); ?>
        
        <!-- Portfolio Section -->
        <?php get_template_part( 'template-parts/section', 'portfolio' ); ?>
        
        <!-- Testimonials Section -->
        <?php get_template_part( 'template-parts/section', 'testimonials' ); ?>

        <!-- Experience Section -->
        <?php get_template_part( 'template-parts/section', 'experience' ); ?>        <!-- Experience Section -->
        
        <!-- Education Section -->
        <?php get_template_part( 'template-parts/section', 'education' ); ?>
        
        <!-- Contact Section -->
        <?php get_template_part( 'template-parts/section', 'contact' ); ?>
        
    </main>
</div>

<?php
get_footer();