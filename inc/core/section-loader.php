<?php
/**
 * Section Template Loader
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
 * Class for loading section templates
 */
class Portfolio_Pro_Section_Loader {
    /**
     * Get the appropriate template for a section
     *
     * @param string $section Section name
     * @return string Template path
     */
    public static function get_template($section) {
        $method = "get_{$section}_template";
        
        if (method_exists(__CLASS__, $method)) {
            return self::$method();
        }
        
        // Default template
        return "section-{$section}";
    }
    
    /**
     * Get skills section template
     *
     * @return string Template path
     */
    public static function get_skills_template() {
        // First check if CPT approach is available
        if (post_type_exists('skill') && post_type_exists('skill_category')) {
            return 'section-skills-cpt';
        }
        
        // Then check if ACF options approach is available
        if (function_exists('get_field')) {
            return 'section-skills-acf';
        }
        
        // Otherwise, fall back to the Customizer version
        return 'section-skills';
    }
    
    /**
     * Get projects section template
     *
     * @return string Template path
     */
    public static function get_projects_template() {
        // First check if CPT approach is available
        if (post_type_exists('project') && post_type_exists('project_category')) {
            return 'section-projects-cpt';
        }
        
        // Otherwise, fall back to the default version
        return 'section-projects';
    }
    
    /**
     * Get testimonials section template
     *
     * @return string Template path
     */
    public static function get_testimonials_template() {
        // First check if CPT approach is available
        if (post_type_exists('testimonial')) {
            return 'section-testimonials-cpt';
        }
        
        // Otherwise, fall back to the default version
        return 'section-testimonials';
    }
    
    /**
     * Get experience section template
     *
     * @return string Template path
     */
    public static function get_experience_template() {
        // First check if CPT approach is available
        if (post_type_exists('experience')) {
            return 'section-experience-cpt';
        }
        
        // Otherwise, fall back to the default version
        return 'section-experience';
    }
    
    /**
     * Get education section template
     *
     * @return string Template path
     */
    public static function get_education_template() {
        // First check if CPT approach is available
        if (post_type_exists('education')) {
            return 'section-education-cpt';
        }
        
        // Otherwise, fall back to the default version
        return 'section-education';
    }
    
    /**
     * Get services section template
     *
     * @return string Template path
     */
    public static function get_services_template() {
        // First check if CPT approach is available
        if (post_type_exists('service')) {
            return 'section-services-cpt';
        }
        
        // Otherwise, fall back to the default version
        return 'section-services';
    }
}