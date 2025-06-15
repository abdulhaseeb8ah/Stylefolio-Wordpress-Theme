<?php
/**
 * Contact Section Template
 * 
 * Displays the contact form and contact information.
 * Configure contact settings in WordPress Customizer > Contact Section.
 * Form submissions are handled automatically and can be viewed in the admin dashboard.
 *
 * @package Stylefolio
 */

// Get contact form settings from customizer
$success_message = get_theme_mod('contact_form_success_message', __('Thank you for your message! I\'ll get back to you soon.', 'stylefolio'));

// Check for form submission status
$form_success = get_transient('stylefolio_contact_success');
$form_errors = get_transient('stylefolio_contact_errors');
$form_data = get_transient('stylefolio_contact_data');

// Clear transients after reading them
if ($form_success) {
    delete_transient('stylefolio_contact_success');
}

if ($form_errors) {
    delete_transient('stylefolio_contact_errors');
}

if ($form_data) {
    delete_transient('stylefolio_contact_data');
}

// Show warning if no notification email is set
$notification_email = get_theme_mod('contact_form_email', '');
$email_notification_enabled = !empty($notification_email);

// Get contact info
$phone = get_theme_mod('contact_phone', '');
$email = get_theme_mod('contact_email', '');
$address = get_theme_mod('contact_address', '');
$social_profiles = function_exists('stylefolio_get_social_profiles') ? stylefolio_get_social_profiles() : array();
?>

<section id="contact" class="contact-section">
    <div class="section-background">
        <div class="bg-grid"></div>
        <div class="bg-particles"></div>
        <div class="bg-glow"></div>
    </div>
    
    <div class="container">        <div class="section-header" data-animation="fade-in">
            <span class="section-subtitle"><?php echo esc_html(get_theme_mod('contact_section_subtitle', __('Get In Touch', 'stylefolio'))); ?></span>
            <h2 class="section-title"><?php echo esc_html(get_theme_mod('contact_section_title', __('Contact Me', 'stylefolio'))); ?></h2>
            <p class="section-description"><?php echo esc_html(get_theme_mod('contact_section_description', __('Let\'s discuss your next project and turn your ideas into reality. I\'m here to help bring your vision to life.', 'stylefolio'))); ?></p>
            <div class="section-divider">
                <span class="divider-line"></span>
                <span class="divider-icon"><i class="fas fa-envelope"></i></span>
                <span class="divider-line"></span>
            </div>
        </div>
        
        <div class="contact-container">
            <div class="contact-info" data-animation="fade-in-right">
                <div class="info-cards">
                    <?php if (!empty($phone)) : ?>
                        <div class="info-card">
                            <div class="icon"><i class="fas fa-phone"></i></div>
                            <div class="details">
                                <h4><?php esc_html_e('Phone', 'stylefolio'); ?></h4>
                                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($email)) : ?>
                        <div class="info-card">
                            <div class="icon"><i class="fas fa-envelope"></i></div>
                            <div class="details">
                                <h4><?php esc_html_e('Email', 'stylefolio'); ?></h4>
                                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($address)) : ?>
                        <div class="info-card">
                            <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="details">
                                <h4><?php esc_html_e('Location', 'stylefolio'); ?></h4>
                                <p><?php echo esc_html($address); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                  <?php if (!empty($social_profiles)) : ?>
                    <div class="contact-social">
                        <h4><?php esc_html_e('Follow Me', 'stylefolio'); ?></h4>
                        <ul class="social-links">
                            <?php foreach ($social_profiles as $platform => $data) : ?>
                                <?php                                if ($platform === 'custom' && is_array($data)) {
                                    $url = $data['url'];
                                    $icon_class = $data['icon'];
                                } else {
                                    $url = $data;
                                    $icon_class = stylefolio_get_social_icon($platform);
                                }
                                ?>
                                <li>
                                    <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="<?php echo esc_attr($platform); ?>">
                                        <i class="<?php echo esc_attr($icon_class); ?>"></i>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
              <div class="contact-form-container" data-animation="fade-in-left">
                <?php if ($form_success) : ?>
                    <div class="form-success">
                        <div class="success-icon"><i class="fas fa-check-circle"></i></div>
                        <h3><?php esc_html_e('Message Sent!', 'stylefolio'); ?></h3>
                        <p><?php echo esc_html($success_message); ?></p>
                    </div>
                <?php else : ?>
                    <div class="contact-form">
                        <h3><?php echo esc_html(get_theme_mod('contact_form_title', __('Get in Touch', 'stylefolio'))); ?></h3>
                        <p class="form-description"><?php echo esc_html(get_theme_mod('contact_form_description', __('Have a question or want to work together? Fill out the form below and I\'ll get back to you as soon as possible.', 'stylefolio'))); ?></p>
                        
                        <?php if (!empty($form_errors) && isset($form_errors['general'])) : ?>
                            <div class="form-error general-error">
                                <p><?php echo esc_html($form_errors['general']); ?></p>
                            </div>
                        <?php endif; ?>                        <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" id="contact-form">
                            <?php wp_nonce_field('stylefolio_contact_form', 'stylefolio_contact_nonce'); ?>
                              <div class="form-row">
                                <div class="form-group <?php echo isset($form_errors['name']) ? 'has-error' : ''; ?>">
                                    <label for="contact_name"><?php esc_html_e('Your Name', 'stylefolio'); ?> <span class="required">*</span></label>
                                    <input type="text" name="contact_name" id="contact_name" placeholder="<?php esc_attr_e('Enter your full name', 'stylefolio'); ?>" value="<?php echo isset($form_data['name']) ? esc_attr($form_data['name']) : ''; ?>" required>
                                    <?php if (isset($form_errors['name'])) : ?>
                                        <div class="error-message"><?php echo esc_html($form_errors['name']); ?></div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="form-group <?php echo isset($form_errors['email']) ? 'has-error' : ''; ?>">
                                    <label for="contact_email"><?php esc_html_e('Your Email', 'stylefolio'); ?> <span class="required">*</span></label>
                                    <input type="email" name="contact_email" id="contact_email" placeholder="<?php esc_attr_e('your.email@example.com', 'stylefolio'); ?>" value="<?php echo isset($form_data['email']) ? esc_attr($form_data['email']) : ''; ?>" required>
                                    <?php if (isset($form_errors['email'])) : ?>
                                        <div class="error-message"><?php echo esc_html($form_errors['email']); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact_phone"><?php esc_html_e('Phone (Optional)', 'stylefolio'); ?></label>
                                <input type="tel" name="contact_phone" id="contact_phone" placeholder="<?php esc_attr_e('+1 (555) 123-4567', 'stylefolio'); ?>" value="<?php echo isset($form_data['phone']) ? esc_attr($form_data['phone']) : ''; ?>">
                            </div>
                            
                            <div class="form-group <?php echo isset($form_errors['subject']) ? 'has-error' : ''; ?>">
                                <label for="contact_subject"><?php esc_html_e('Subject', 'stylefolio'); ?> <span class="required">*</span></label>
                                <input type="text" name="contact_subject" id="contact_subject" placeholder="<?php esc_attr_e('Project inquiry, collaboration, or general question', 'stylefolio'); ?>" value="<?php echo isset($form_data['subject']) ? esc_attr($form_data['subject']) : ''; ?>" required>
                                <?php if (isset($form_errors['subject'])) : ?>
                                    <div class="error-message"><?php echo esc_html($form_errors['subject']); ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="form-group <?php echo isset($form_errors['message']) ? 'has-error' : ''; ?>">
                                <label for="contact_message"><?php esc_html_e('Your Message', 'stylefolio'); ?> <span class="required">*</span></label>
                                <textarea name="contact_message" id="contact_message" rows="5" placeholder="<?php esc_attr_e('Tell me about your project, ideas, or how I can help you. The more details you provide, the better I can understand your needs...', 'stylefolio'); ?>" required><?php echo isset($form_data['message']) ? esc_textarea($form_data['message']) : ''; ?></textarea>
                                <?php if (isset($form_errors['message'])) : ?>
                                    <div class="error-message"><?php echo esc_html($form_errors['message']); ?></div>
                                <?php endif; ?>
                            </div>                            <div class="form-submit">
                                <button type="submit" name="stylefolio_contact_submit" class="submit-button">
                                    <span class="btn-text"><?php esc_html_e('Send Message', 'stylefolio'); ?></span>
                                    <span class="btn-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M22 2L11 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>