/**
 * Main JavaScript file for Portfolio Pro theme
 * Author: Abdul Haseeb
 * Version: 2.2
 * Last Updated: 2025-06-09 12:48:03
 */
(function($) {
    'use strict';

    // Document ready
    $(document).ready(function() {
        console.log('Portfolio Pro theme initialized at ' + new Date().toISOString());
        
        // Display admin user info and datetime
        function displayAdminInfo() {
            if ($('body').hasClass('logged-in')) {
                // Add user ID display
                $('body').append('<div class="admin-user-id">User: <span>abdulhaseeb2002</span></div>');
                
                // Add current datetime display
                const currentDatetime = '2025-06-09 12:48:03';
                $('body').append('<div class="current-datetime">' + currentDatetime + ' UTC</div>');
            }
        }
        
        // Create scroll indicator
        function createScrollIndicator() {
            const header = $('.site-header');
            $('<div class="scroll-indicator"></div>').appendTo(header);
            
            // Update scroll indicator width based on scroll position
            $(window).on('scroll', function() {
                const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrolled = (winScroll / height) * 100;
                $('.scroll-indicator').css('width', scrolled + '%');
            });
        }        // Create back to top button
        function createBackToTop() {
            // Add back to top button
            $('body').append('<a class="back-to-top" aria-label="Back to top" title="Back to top"><i class="fas fa-arrow-up"></i></a>');
            
            // Throttle scroll event for better performance
            let scrollTimer = null;
            
            // Show/hide back to top button based on scroll position
            $(window).on('scroll', function() {
                if (scrollTimer !== null) {
                    clearTimeout(scrollTimer);
                }
                
                scrollTimer = setTimeout(function() {
                    if ($(window).scrollTop() > 300) {
                        $('.back-to-top').addClass('show');
                    } else {
                        $('.back-to-top').removeClass('show');
                    }
                }, 10);
            });
            
            // Smooth scroll to top when clicking the button
            $('.back-to-top').on('click', function(e) {
                e.preventDefault();
                
                // Use native smooth scroll for better performance
                if ('scrollBehavior' in document.documentElement.style) {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                } else {
                    // Fallback for older browsers
                    $('html, body').animate({scrollTop: 0}, 800, 'swing');
                }
            });
        }
        
        // Create footer particles
        function createFooterParticles() {
            // Check if footer exists
            if ($('.site-footer').length) {
                // Create particles container
                const particlesContainer = $('<div class="footer-particles"></div>');
                
                // Add particles
                for (let i = 0; i < 4; i++) {
                    particlesContainer.append('<div class="footer-particle"></div>');
                }
                
                // Add to footer
                $('.site-footer').prepend(particlesContainer);
            }
        }
        
        // Call functions to create elements
        createScrollIndicator();
        displayAdminInfo();
        createBackToTop();
        createFooterParticles();
        
        // ======================================
        // Sticky header functionality
        // ======================================
        function handleStickyHeader() {
            if ($(window).scrollTop() > 50) {
                $('.site-header').addClass('scrolled');
            } else {
                $('.site-header').removeClass('scrolled');
            }
        }
        
        // Run on page load
        handleStickyHeader();
        
        // Run on scroll
        $(window).on('scroll', function() {
            handleStickyHeader();
        });

        // ======================================
        // Mobile menu dropdown toggle
        // ======================================
        $('.menu-toggle').on('click', function(e) {
            e.preventDefault();
            
            // Toggle mobile menu visibility
            $('.mobile-menu').toggleClass('show-mobile-menu');
            
            // Toggle the active state of the button
            $(this).toggleClass('toggled');
            
            // Update aria-expanded attribute for accessibility
            var isExpanded = $('.mobile-menu').hasClass('show-mobile-menu');
            $(this).attr('aria-expanded', isExpanded);
            
            // Log for debugging
            console.log('Mobile menu toggled, visible: ' + isExpanded);
            
            // Prevent scrolling when menu is open
            if (isExpanded) {
                $('body').addClass('menu-open');
            } else {
                $('body').removeClass('menu-open');
            }
        });
        
        // ======================================        // ======================================
        // Close mobile menu when clicking a link
        // ======================================
        $('.mobile-menu a, .nav-menu a').on('click', function() {
            $('.mobile-menu').removeClass('show-mobile-menu');
            $('.menu-toggle').removeClass('toggled');
            $('.menu-toggle').attr('aria-expanded', 'false');
            $('body').removeClass('menu-open');
        });        // ======================================
        // Note: Smooth scroll is now handled by header.js
        // ======================================        // ======================================
        // Note: Active menu highlighting is now handled by header.js
        // ======================================
        
        // ======================================
        // Add dropdown arrows to mobile menu items
        // ======================================
        function addMobileMenuArrows() {
            if (!$('.nav-menu > li > a .dropdown-arrow').length) {
                $('.nav-menu > li > a').append('<span class="dropdown-arrow"><i class="fas fa-chevron-right"></i></span>');
                console.log('Dropdown arrows added to menu items');
            }
        }
        
        // ======================================
        // Newsletter form submission
        // ======================================
        $('.newsletter-form').on('submit', function(e) {
            e.preventDefault();
            
            const email = $(this).find('.newsletter-input').val();
            if (email) {
                // Show success message (would normally submit to server)
                $(this).html('<p style="color: var(--secondary-color);">Thank you for subscribing!</p>');
                console.log('Newsletter signup:', email);
            }
        });
        
        // Call the function to add arrows
        addMobileMenuArrows();
          // ======================================
        // Handle window resize events
        // ======================================
        let resizeTimeoutMain;
        
        function handleResponsiveUpdates() {
            clearTimeout(resizeTimeoutMain);
            resizeTimeoutMain = setTimeout(function() {
                // Force repaint for smoother transitions
                $('body').removeClass('resizing');
                
                // Check if mobile menu should be closed on desktop
                if ($(window).width() > 768) {
                    $('.mobile-menu').removeClass('show-mobile-menu');
                    $('.menu-toggle').removeClass('toggled').attr('aria-expanded', 'false');
                    $('body').removeClass('menu-open');
                }
                
                // Trigger custom resize event for other scripts
                $(window).trigger('responsiveResize');
            }, 250);
        }
        
        $(window).on('resize', function() {
            // Add resizing class for smoother transitions
            $('body').addClass('resizing');
            
            // Close mobile menu when window is resized to desktop size
            if ($(window).width() > 768 && $('.mobile-menu').hasClass('show-mobile-menu')) {
                $('.mobile-menu').removeClass('show-mobile-menu');
                $('.menu-toggle').removeClass('toggled');
                $('.menu-toggle').attr('aria-expanded', 'false');
                $('body').removeClass('menu-open');
            }
            
            // Handle responsive updates
            handleResponsiveUpdates();
        });
        
        $(window).on('orientationchange', function() {
            $('body').addClass('resizing');
            handleResponsiveUpdates();
        });
        
        // ======================================
        // Handle escape key to close mobile menu
        // ======================================
        $(document).on('keyup', function(e) {
            if (e.key === "Escape" && $('.mobile-menu').hasClass('show-mobile-menu')) {
                $('.mobile-menu').removeClass('show-mobile-menu');
                $('.menu-toggle').removeClass('toggled');
                $('.menu-toggle').attr('aria-expanded', 'false');
                $('body').removeClass('menu-open');
            }
        });
        
        // ======================================
        // Initialize jQuery easing if available
        // ======================================
        if (typeof $.easing === 'undefined') {
            // Define a simple easing function if jQuery easing isn't available
            $.extend($.easing, {
                easeInOutCubic: function (x, t, b, c, d) {
                    if ((t/=d/2) < 1) return c/2*t*t*t + b;
                    return c/2*((t-=2)*t*t + 2) + b;
                }
            });
        }
          // ======================================
        // Scroll Progress Indicator - DISABLED
        // ======================================
        function initScrollProgress() {
            // DISABLED: This function was creating the unwanted top progress line
            // User requested to keep only the bottom scroll indicator
            /*
            // Create scroll progress bar if it doesn't exist
            if (!$('.scroll-progress').length) {
                $('body').prepend('<div class="scroll-progress"></div>');
            }
            
            $(window).on('scroll', function() {
                const scrolled = $(window).scrollTop();
                const documentHeight = $(document).height() - $(window).height();
                const progress = (scrolled / documentHeight) * 100;
                
                $('.scroll-progress').css('width', progress + '%');
            });
            */
        }
          // ======================================
        // Initialize navigation features
        // ======================================
        function initNavigationFeatures() {
            // Initialize scroll progress - DISABLED (was creating unwanted top progress line)
            // initScrollProgress();
            
            // Add smooth scroll class to body for enhanced animations
            $('body').addClass('smooth-scroll-enabled');
            
            // Handle hash links on page load
            if (window.location.hash) {
                setTimeout(function() {
                    const target = $(window.location.hash);
                    if (target.length) {
                        const headerHeight = $('.site-header').outerHeight() + 20;
                        const targetOffset = target.offset().top - headerHeight;
                        
                        $('html, body').animate({
                            scrollTop: targetOffset
                        }, 1000, 'easeInOutCubic');
                    }
                }, 100);
            }
            
            // Add hover effects for menu items
            $('.nav-menu a').hover(
                function() {
                    $(this).addClass('menu-hover');
                },
                function() {
                    $(this).removeClass('menu-hover');
                }
            );
        }
        
        // Initialize all navigation features
        initNavigationFeatures();

    });

})(jQuery);