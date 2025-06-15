<?php
/**
 * Theme Footer Template
 * 
 * Displays the site footer with widgets, social links, and copyright information.
 * You can customize footer content in the WordPress Customizer.
 *
 * @package Stylefolio
 */
?>
    </div><!-- #content -->

    <footer id="colophon" class="site-footer">        <div class="footer-content">
            <!-- About Widget -->
            <div class="footer-widget footer-about">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo">
                    <?php 
                    if (has_custom_logo()) {
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                        echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '">';
                    } else {
                        echo '<h2>' . get_bloginfo('name') . '</h2>';
                    }
                    ?>
                </a>
                <div class="footer-about-text">
                    <?php echo get_theme_mod('footer_about_text', 'Passionate full-stack developer and designer crafting innovative digital solutions with modern technologies and creative excellence.'); ?>
                </div>
            </div>

            <!-- Portfolio Sections -->
            <div class="footer-widget footer-sections">
                <h3 class="footer-widget-title"><?php echo esc_html__('Portfolio Sections', 'stylefolio'); ?></h3>
                <ul>
                    <li><a href="#hero"><?php echo esc_html__('Home', 'stylefolio'); ?></a></li>
                    <li><a href="#skills"><?php echo esc_html__('Skills', 'stylefolio'); ?></a></li>
                    <li><a href="#portfolio"><?php echo esc_html__('Projects', 'stylefolio'); ?></a></li>
                    <li><a href="#experience"><?php echo esc_html__('Experience', 'stylefolio'); ?></a></li>
                    <li><a href="#education"><?php echo esc_html__('Education', 'stylefolio'); ?></a></li>
                </ul>
            </div>

            <!-- Technologies Widget -->
            <div class="footer-widget footer-tech">
                <h3 class="footer-widget-title"><?php echo esc_html__('Technologies', 'stylefolio'); ?></h3>
                <ul>
                    <li><a href="#skills"><?php echo esc_html__('Frontend Development', 'stylefolio'); ?></a></li>
                    <li><a href="#skills"><?php echo esc_html__('Backend Development', 'stylefolio'); ?></a></li>
                    <li><a href="#skills"><?php echo esc_html__('UI/UX Design', 'stylefolio'); ?></a></li>
                    <li><a href="#skills"><?php echo esc_html__('WordPress Development', 'stylefolio'); ?></a></li>
                    <li><a href="#skills"><?php echo esc_html__('Mobile Development', 'stylefolio'); ?></a></li>
                </ul>
            </div>

            <!-- Let's Connect Widget -->
            <div class="footer-widget footer-cta">
                <h3 class="footer-widget-title"><?php echo esc_html__("Let's Work Together", 'stylefolio'); ?></h3>
                <p class="footer-cta-text">
                    <?php echo esc_html__('Have a project in mind? Let\'s discuss how we can bring your ideas to life.', 'stylefolio'); ?>
                </p>
                <div class="footer-buttons">
                    <a href="#contact" class="footer-btn footer-btn-primary">
                        <i class="fas fa-envelope"></i>
                        <?php echo esc_html__('Get In Touch', 'stylefolio'); ?>
                    </a>
                    <a href="#portfolio" class="footer-btn footer-btn-secondary">
                        <i class="fas fa-eye"></i>
                        <?php echo esc_html__('View Portfolio', 'stylefolio'); ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="copyright">
                &copy; <?php echo date('Y'); ?> <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>. 
                <?php echo esc_html__('All Rights Reserved.', 'portfolio-pro'); ?>
                <?php
                if (function_exists('the_privacy_policy_link')) {
                    the_privacy_policy_link('', '');
                }
                ?>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<script>
// DIRECT SOLUTION - No dependencies
(function() {    // Wait for page to fully load
    window.addEventListener('load', function() {
        
        // Find the menu toggle button
        var menuToggle = document.querySelector('.menu-toggle');
        
        if (menuToggle) {
            // Add click event - using direct binding
            menuToggle.onclick = function(e) {
                e.preventDefault();
                  // Debug - add visual feedback
                this.style.border = '2px solid red';
                setTimeout(function() {
                    menuToggle.style.border = '';
                }, 500);
                
                // Find mobile menu
                var mobileMenu = document.querySelector('.mobile-menu');
                
                if (mobileMenu) {                    // Toggle class
                    if (mobileMenu.classList.contains('show-mobile-menu')) {
                        mobileMenu.classList.remove('show-mobile-menu');
                    } else {
                        mobileMenu.classList.add('show-mobile-menu');
                    }
                    
                    // Toggle button state
                    menuToggle.classList.toggle('toggled');
                    
                    // Update aria state
                    var isExpanded = mobileMenu.classList.contains('show-mobile-menu');
                    menuToggle.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');                } else {
                    // Fallback - try inline style
                    var menuContainer = document.querySelector('.primary-menu-container');
                    if (menuContainer) {
                        menuContainer.style.right = menuContainer.style.right === '0px' ? '-100%' : '0px';
                    } else {
                        alert('Menu toggle clicked but menu container not found!');
                    }
                }
                  return false;
            };
              } else {
            // Menu toggle button not found
            // Check all buttons on the page for debugging
            var allButtons = document.querySelectorAll('button');
            allButtons.forEach(function(btn, i) {
                // Check button properties silently
            });
        }
    });
})();
</script>

</body>
</html>