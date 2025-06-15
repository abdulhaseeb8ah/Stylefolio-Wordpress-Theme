<?php
/**
 * Portfolio Projects Default Data
 *
 * @package Portfolio_Pro
 * @version 1.0
 * @author abdulhaseeb2002
 * @updated 2025-06-11 08:52:32
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Initialize default projects data
 */
function portfolio_pro_initialize_data_projects() {
    // Check if data has already been populated
    if (get_option('portfolio_pro_projects_data_initialized')) {
        return;
    }
    
    // Create Portfolio Settings
    $settings_id = wp_insert_post(array(
        'post_title'    => 'Portfolio Section Settings',
        'post_status'   => 'publish',
        'post_type'     => 'portfolio_settings',
    ));
    
    if (!is_wp_error($settings_id)) {
        update_field('portfolio_title', 'Portfolio', $settings_id);
        update_field('portfolio_subtitle', 'My Recent Work', $settings_id);
        update_field('portfolio_description', 'Explore my latest projects showcasing creative solutions and technical expertise across various domains.', $settings_id);
        update_field('portfolio_display_count', 6, $settings_id);
        update_field('portfolio_layout', 'grid', $settings_id);
        update_field('portfolio_cta_text', 'View All Projects', $settings_id);
        update_field('portfolio_cta_url', '#portfolio', $settings_id);
    }
    
    // Create Categories
    $categories = array(
        array(
            'title' => 'Web Development',
            'icon' => 'fas fa-globe',
            'order' => 10,
        ),
        array(
            'title' => 'Mobile Apps',
            'icon' => 'fas fa-mobile-alt',
            'order' => 20,
        ),
        array(
            'title' => 'UI/UX Design',
            'icon' => 'fas fa-palette',
            'order' => 30,
        ),
        array(
            'title' => 'Brand Identity',
            'icon' => 'fas fa-fingerprint',
            'order' => 40,
        ),
    );
    
    $category_ids = array();
    
    foreach ($categories as $category) {
        $category_id = wp_insert_post(array(
            'post_title'    => $category['title'],
            'post_status'   => 'publish',
            'post_type'     => 'project_category',
        ));
        
        if (!is_wp_error($category_id)) {
            update_field('category_icon', $category['icon'], $category_id);
            update_field('category_order', $category['order'], $category_id);
            $category_ids[$category['title']] = $category_id;
        }
    }
    
    // Create Projects
    $projects = array(
        array(
            'title' => 'E-Commerce Platform',
            'excerpt' => 'A full-featured e-commerce platform built with modern web technologies.',
            'content' => 'This e-commerce platform was developed for a retail client looking to expand their online presence. The project involved creating a custom shopping experience with seamless checkout flow, inventory management, and integration with multiple payment gateways.

The frontend was built using React for a smooth user experience, while the backend uses Node.js with Express and MongoDB for efficient data handling. The platform includes features such as product filtering, user accounts, wishlist functionality, and order tracking.

One of the main challenges was implementing a real-time inventory system that syncs with the client\'s physical stores. This was achieved using WebSockets to ensure immediate updates across all platforms.',
            'category' => 'Web Development',
            'client' => 'RetailGrowth Inc.',
            'date' => '2025-03-15',
            'url' => 'https://example.com/ecommerce',
            'tech' => 'React, Node.js, Express, MongoDB, Stripe API, AWS',
            'featured' => true,
            'order' => 10,
            'image' => 'project-1.jpg',
        ),
        array(
            'title' => 'Fitness Tracking App',
            'excerpt' => 'Mobile application for tracking workouts, nutrition, and fitness progress.',
            'content' => 'This fitness tracking mobile application helps users monitor their health and fitness journey. The app allows users to track workouts, nutrition intake, and overall progress towards their fitness goals.

The app features customizable workout plans, integration with wearable devices, nutrition logging with barcode scanning, and progress visualization through interactive charts. Users can also join challenges and connect with friends for motivation.

The app was built using React Native for cross-platform compatibility, with a Firebase backend for real-time data synchronization. Special attention was given to offline functionality, ensuring users can log workouts even without an internet connection.',
            'category' => 'Mobile Apps',
            'client' => 'FitLife Health',
            'date' => '2024-11-22',
            'url' => 'https://example.com/fitapp',
            'tech' => 'React Native, Firebase, Redux, Wearable APIs, Google Fit, Apple HealthKit',
            'featured' => false,
            'order' => 20,
            'image' => 'project-2.jpg',
        ),
        array(
            'title' => 'Financial Dashboard',
            'excerpt' => 'Interactive dashboard for visualizing complex financial data and analytics.',
            'content' => 'This financial dashboard was designed for a fintech company to help their clients visualize and analyze complex financial data. The dashboard provides real-time insights into investment performance, market trends, and portfolio allocation.

The project required handling large datasets and creating interactive visualizations that are both informative and intuitive. Features include customizable widgets, real-time data updates, export capabilities, and multi-device support.

The frontend was built using Vue.js with D3.js for advanced data visualization. The backend uses Python with FastAPI for efficient data processing and API endpoints. The system integrates with various financial data providers through secure API connections.',
            'category' => 'Web Development',
            'client' => 'FinVision Partners',
            'date' => '2024-09-05',
            'url' => 'https://example.com/findash',
            'tech' => 'Vue.js, D3.js, Python, FastAPI, PostgreSQL, Docker',
            'featured' => true,
            'order' => 15,
            'image' => 'project-3.jpg',
        ),
        array(
            'title' => 'Travel Companion App',
            'excerpt' => 'Mobile app for travelers with itinerary planning, local recommendations, and offline maps.',
            'content' => 'The Travel Companion App was developed to enhance the travel experience by providing comprehensive tools for trip planning and exploration. The app helps users discover local attractions, create detailed itineraries, and navigate unfamiliar destinations with ease.

Key features include offline maps, local recommendations based on user preferences, itinerary planning with time optimization, travel expense tracking, and photo journaling with location tagging. The app also provides real-time information about weather, transportation schedules, and attraction waiting times.

Built with Flutter for a smooth cross-platform experience, the app utilizes location services, offline data storage, and integrates with various travel APIs for comprehensive coverage across global destinations.',
            'category' => 'Mobile Apps',
            'client' => 'GlobalTrek Adventures',
            'date' => '2024-07-18',
            'url' => 'https://example.com/travelapp',
            'tech' => 'Flutter, Dart, Firebase, Google Maps API, TripAdvisor API, Offline Storage',
            'featured' => false,
            'order' => 25,
            'image' => 'project-4.jpg',
        ),
        array(
            'title' => 'Creative Agency Website Redesign',
            'excerpt' => 'Complete redesign of a creative agency\'s web presence with focus on portfolio showcase.',
            'content' => 'This project involved reimagining the online presence for a leading creative agency. The redesign focused on creating an immersive showcase for their portfolio while communicating their brand values and creative process.

The design approach centered on bold typography, strategic use of negative space, and seamless transitions between sections. Interactive elements were thoughtfully implemented to engage visitors without overwhelming them, creating memorable micro-interactions throughout the experience.

The project began with comprehensive user research and competitive analysis, followed by wireframing, prototyping, and user testing before final implementation. Special attention was given to performance optimization and accessibility compliance.',
            'category' => 'UI/UX Design',
            'client' => 'Prism Creative Studio',
            'date' => '2025-01-30',
            'url' => 'https://example.com/prismcreative',
            'tech' => 'Figma, Adobe Creative Suite, HTML5, CSS3, JavaScript, GSAP',
            'featured' => false,
            'order' => 30,
            'image' => 'project-5.jpg',
        ),
        array(
            'title' => 'Sustainable Food Delivery Branding',
            'excerpt' => 'Complete brand identity for an eco-conscious food delivery service.',
            'content' => 'This branding project was for a startup food delivery service focused on sustainability and eco-friendly practices. The project encompassed creating a complete brand identity that would resonate with environmentally conscious consumers while conveying freshness and quality.

The brand development process included market research, competitor analysis, brand strategy development, and the creation of visual identity elements. The final deliverables included logo design, color palette, typography system, packaging design, website design, mobile app UI, vehicle wraps, and comprehensive brand guidelines.

The visual identity uses organic shapes, a nature-inspired color palette, and sustainable materials for all physical touchpoints. The brand voice was developed to be friendly, educational, and inspiring, encouraging sustainable choices without being preachy.',
            'category' => 'Brand Identity',
            'client' => 'GreenBite Delivery',
            'date' => '2024-10-10',
            'url' => 'https://example.com/greenbite',
            'tech' => 'Adobe Illustrator, Photoshop, InDesign, Sustainable Materials Research, Packaging Prototyping',
            'featured' => true,
            'order' => 12,
            'image' => 'project-6.jpg',
        ),
        array(
            'title' => 'Healthcare Patient Portal',
            'excerpt' => 'User-centered patient portal for a healthcare provider with telemedicine features.',
            'content' => 'This healthcare patient portal was designed to improve patient engagement and streamline healthcare delivery. The portal provides patients with secure access to their medical records, appointment scheduling, prescription refills, and telemedicine consultations.

The UX design process focused on creating an intuitive interface accessible to users of all ages and technical abilities. Extensive user research and testing with diverse patient groups informed the design decisions, ensuring the portal meets the needs of all users, including those with accessibility requirements.

The final design emphasizes clarity, ease of navigation, and thoughtful information architecture. Special consideration was given to mobile responsiveness, as many patients access healthcare information on smartphones. The telemedicine feature includes a custom-designed video interface optimized for clinical consultations.',
            'category' => 'UI/UX Design',
            'client' => 'MediCare Health Network',
            'date' => '2024-12-05',
            'url' => 'https://example.com/medicareportal',
            'tech' => 'Figma, Sketch, InVision, User Testing, Accessibility Standards, HIPAA Compliance',
            'featured' => false,
            'order' => 35,
            'image' => 'project-7.jpg',
        ),
        array(
            'title' => 'Boutique Hotel Brand Identity',
            'excerpt' => 'Sophisticated brand identity for a luxury boutique hotel chain.',
            'content' => 'This comprehensive brand identity project was for a new boutique hotel chain entering the luxury travel market. The client sought to establish a distinctive brand that would communicate sophistication, exceptional service, and unique experiences while remaining approachable and inviting.

The branding package included a primary logo and variations, custom typography, color system, pattern design, photography style guide, stationery, key cards, in-room materials, digital touchpoints, signage system, and staff uniform design. Each element was crafted to reflect the hotel\'s unique positioning at the intersection of luxury and authenticity.

The design language draws inspiration from local architecture and cultural elements of each hotel location, creating a cohesive yet locally-relevant brand experience. Materials and finishes were selected to convey quality while incorporating sustainable practices aligned with the brand\'s values.',
            'category' => 'Brand Identity',
            'client' => 'Elysian Hotels & Resorts',
            'date' => '2025-02-20',
            'url' => 'https://example.com/elysianhotels',
            'tech' => 'Adobe Creative Suite, 3D Rendering, Material Sampling, Environmental Graphics',
            'featured' => false,
            'order' => 40,
            'image' => 'project-8.jpg',
        ),
    );
    
    foreach ($projects as $project) {
        $project_id = wp_insert_post(array(
            'post_title'    => $project['title'],
            'post_excerpt'  => $project['excerpt'],
            'post_content'  => $project['content'],
            'post_status'   => 'publish',
            'post_type'     => 'project',
        ));
        
        if (!is_wp_error($project_id)) {
            // Set project category
            if (isset($category_ids[$project['category']])) {
                update_field('project_category', $category_ids[$project['category']], $project_id);
            }
            
            // Set other project fields
            update_field('project_featured', $project['featured'], $project_id);
            update_field('project_client', $project['client'], $project_id);
            update_field('project_date', $project['date'], $project_id);
            update_field('project_url', $project['url'], $project_id);
            update_field('project_tech', $project['tech'], $project_id);
            update_field('project_order', $project['order'], $project_id);
            
            // Import and set project image
            if (isset($project['image'])) {
                // Add debugging
                error_log('Processing image for project: ' . $project['title']);
                
                // First, try to find if image is already in media library
                $image_path = get_template_directory() . '/assets/images/projects/' . $project['image'];
                error_log('Looking for image at: ' . $image_path);
                
                // Check if file exists
                if (file_exists($image_path)) {
                    error_log('Image file found at: ' . $image_path);
                    
                    // Get WordPress upload directory
                    $upload_dir = wp_upload_dir();
                    
                    // Prepare filename - unique to avoid duplicates
                    $filename = wp_unique_filename($upload_dir['path'], $project['image']);
                    
                    // Move the file to the uploads directory
                    $new_file = $upload_dir['path'] . '/' . $filename;
                    error_log('Attempting to copy image to: ' . $new_file);
                    
                    // Copy the file to the uploads directory
                    if (copy($image_path, $new_file)) {
                        error_log('Successfully copied image to uploads directory');
                        
                        // Prepare file type
                        $file_type = wp_check_filetype($filename, null);
                        
                        // Prepare attachment data
                        $attachment = array(
                            'post_mime_type' => $file_type['type'],
                            'post_title'     => sanitize_file_name($filename),
                            'post_content'   => '',
                            'post_status'    => 'inherit'
                        );
                        
                        // Insert the attachment
                        $attach_id = wp_insert_attachment($attachment, $new_file, $project_id);
                        
                        if (is_wp_error($attach_id)) {
                            error_log('Error creating attachment: ' . $attach_id->get_error_message());
                        } else {
                            error_log('Attachment created with ID: ' . $attach_id);
                            
                            // Include required files for media handling
                            require_once(ABSPATH . 'wp-admin/includes/image.php');
                            require_once(ABSPATH . 'wp-admin/includes/file.php');
                            require_once(ABSPATH . 'wp-admin/includes/media.php');
                            
                            // Generate metadata for the attachment
                            $attach_data = wp_generate_attachment_metadata($attach_id, $new_file);
                            
                            if (is_wp_error($attach_data)) {
                                error_log('Error generating attachment metadata: ' . $attach_data->get_error_message());
                            } else {
                                wp_update_attachment_metadata($attach_id, $attach_data);
                                
                                // Set as featured image
                                set_post_thumbnail($project_id, $attach_id);
                                error_log('Featured image set for project: ' . $project['title']);
                                
                                // Create a gallery with the same image for demonstration
                                if (function_exists('update_field')) {
                                    update_field('project_gallery', array($attach_id), $project_id);
                                    error_log('Gallery created for project: ' . $project['title']);
                                }
                            }
                        }
                    } else {
                        error_log('Failed to copy image file. Check permissions.');
                        
                        // Try a different method - direct URL attachment
                        $file_array = array();
                        $file_array['name'] = basename($image_path);
                        $file_array['tmp_name'] = $image_path;
                        
                        // If error storing temporarily, return the error
                        if (is_wp_error($file_array['tmp_name'])) {
                            error_log('Error storing temp file: ' . $file_array['tmp_name']->get_error_message());
                        } else {
                            // Do the validation and storage stuff
                            $attach_id = media_handle_sideload($file_array, $project_id);
                            
                            // If error storing permanently, unlink and return the error
                            if (is_wp_error($attach_id)) {
                                error_log('Error in media_handle_sideload: ' . $attach_id->get_error_message());
                            } else {
                                set_post_thumbnail($project_id, $attach_id);
                                error_log('Featured image set using sideload for project: ' . $project['title']);
                                
                                if (function_exists('update_field')) {
                                    update_field('project_gallery', array($attach_id), $project_id);
                                }
                            }
                        }
                    }
                } else {
                    error_log('Image file not found at: ' . $image_path);
                    
                    // Try alternative method - directly load from theme URL
                    $image_url = get_template_directory_uri() . '/assets/images/projects/' . $project['image'];
                    error_log('Trying to load from URL: ' . $image_url);
                    
                    // Download and attach the image
                    $tmp = download_url($image_url);
                    
                    if (is_wp_error($tmp)) {
                        error_log('Error downloading image: ' . $tmp->get_error_message());
                    } else {
                        $file_array = array();
                        $file_array['name'] = $project['image'];
                        $file_array['tmp_name'] = $tmp;
                        
                        // Do the validation and storage stuff
                        $attach_id = media_handle_sideload($file_array, $project_id);
                        
                        // If error storing permanently, unlink and return the error
                        if (is_wp_error($attach_id)) {
                            @unlink($tmp);
                            error_log('Error in media_handle_sideload URL method: ' . $attach_id->get_error_message());
                        } else {
                            error_log('Successfully attached image from URL');
                            set_post_thumbnail($project_id, $attach_id);
                            
                            if (function_exists('update_field')) {
                                update_field('project_gallery', array($attach_id), $project_id);
                            }
                        }
                    }
                }
            }
        }
    }
    
    // Mark as initialized
    update_option('portfolio_pro_projects_data_initialized', true);
    
    // Log completion for debugging
    error_log('Portfolio Pro: Project data initialization completed');
}