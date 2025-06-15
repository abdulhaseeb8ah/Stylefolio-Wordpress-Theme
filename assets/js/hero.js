/**
 * Hero Section JavaScript for Portfolio Pro theme
 * Version: 2.2
 * Last Updated: 2025-06-10 07:42:15
 * Author: abdulhaseeb2002
 */

(function($) {
    'use strict';
    
    // Document ready
    $(document).ready(function() {
        console.log('Hero section initialized');
        
        // Set the data-text attribute for hero title (for the glow effect)
        $('.hero-title').attr('data-text', $('.hero-title').text());
        
        // ====================================
        // SOCIAL LINKS HANDLING
        // ====================================
          console.log('Social links handler initialized');
        
        // Force external links to open in new tab - Enhanced version
        $('.hero-social .social-icon').each(function() {
            var $link = $(this);
            var href = $link.attr('href');
            
            console.log('Processing social link:', href);
            
            // Check if link is external (starts with http/https and is not a hash)
            if (href && href !== '#' && (href.indexOf('http://') === 0 || href.indexOf('https://') === 0)) {
                // Ensure it has target="_blank"
                $link.attr('target', '_blank');
                $link.attr('rel', 'noopener noreferrer');
                
                console.log('External link found and configured: ' + href);
            } else if (!href || href === '#' || href === '') {
                console.log('Empty or placeholder link found: ' + href);
            }
        });        // Add click handler to ensure proper link behavior
        $('.hero-social .social-icon').on('click', function(e) {
            var $link = $(this);
            var href = $link.attr('href');
            
            console.log('Social link clicked:', href);
            
            // If it's just a hash, prevent default behavior
            if (href === '#' || !href || href === '') {
                e.preventDefault();
                console.log('Placeholder link clicked, preventing navigation');
                return false;
            }
            
            // For external links, ensure they open in new tab
            if (href.indexOf('http://') === 0 || href.indexOf('https://') === 0) {
                console.log('Opening external link: ' + href);
                
                // If target="_blank" is not set or click handler failed, force open in new window
                if (!$link.attr('target') || $link.attr('target') !== '_blank') {
                    e.preventDefault();
                    console.log('Forcing new window for: ' + href);
                    window.open(href, '_blank', 'noopener,noreferrer');
                    return false;
                }
                
                // Let the default behavior handle it if target="_blank" is already set
                console.log('Using default behavior for: ' + href);
                return true;
            }
            
            // For internal links (not starting with http but not just #)
            console.log('Navigating to internal link: ' + href);
            return true;
        });
        
        // ====================================
        // ANIMATION FUNCTIONS
        // ====================================
        
        // Initialize animations when element is in viewport
        function initInViewportAnimations() {
            $('[data-animation]').each(function() {
                const el = $(this);
                
                if (isElementInViewport(el) && !el.hasClass('animated')) {
                    el.addClass('animated');
                    const animationName = el.data('animation');
                    el.css('animation-name', animationName);
                }
            });
        }
        
        // Check if element is in viewport
        function isElementInViewport(el) {
            const rect = el[0].getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }
        
        // Initialize stats counter
        function initStatsCounter() {
            $('.stat-number').each(function() {
                const $this = $(this);
                const countTo = $this.data('count');
                
                $({ countNum: 0 }).animate(
                    {
                        countNum: countTo
                    },
                    {
                        duration: 2000,
                        easing: 'swing',
                        step: function() {
                            $this.text(Math.floor(this.countNum));
                        },
                        complete: function() {
                            $this.text(this.countNum);
                        }
                    }
                );
            });
        }
        
        // Initialize floating elements
        function initFloatingElements() {
            $('.floating-element').each(function() {
                const el = $(this);
                const speed = el.data('floating-speed') || 5;
                const randomDelay = Math.random() * 2;
                
                el.css({
                    'animation-duration': speed + 's',
                    'animation-delay': randomDelay + 's'
                });
            });
        }
        
        // Run animations on page load
        setTimeout(function() {
            initInViewportAnimations();
            initStatsCounter();
            initFloatingElements();
        }, 500);
        
        // Run animations on scroll
        $(window).on('scroll', function() {
            initInViewportAnimations();
        });
        
        // Smooth scroll for arrow indicator
        $('.scroll-indicator-container').on('click', function() {
            const nextSection = $('#about').length ? $('#about') : $('.hero-section').next('section');
            
            if (nextSection.length) {
                $('html, body').animate({
                    scrollTop: nextSection.offset().top - $('.site-header').outerHeight()
                }, 800, 'easeInOutCubic');
            }
        });
        
        // Parallax effect for hero elements
        $(window).on('mousemove', function(e) {
            const windowWidth = $(window).width();
            const windowHeight = $(window).height();
            
            // Only apply parallax on larger screens
            if (windowWidth > 992) {
                const mouseX = e.clientX;
                const mouseY = e.clientY;
                
                const percentX = mouseX / windowWidth - 0.5;
                const percentY = mouseY / windowHeight - 0.5;
                
                // Apply parallax to geometric shapes
                $('.shape-circle').css({
                    'transform': `translate(${percentX * 20}px, ${percentY * 20}px)`
                });
                
                $('.shape-square').css({
                    'transform': `rotate(45deg) translate(${percentX * -30}px, ${percentY * -30}px)`
                });
                
                $('.shape-triangle').css({
                    'transform': `translate(${percentX * 15}px, ${percentY * 15}px)`
                });
                
                // Subtle movement for hero image
                $('.hero-img').css({
                    'transform': `translate(${percentX * 10}px, ${percentY * 10}px)`
                });
            }
        });
        
        // Add timestamp to console for debugging
        console.log('Hero JS last updated: 2025-06-10 07:42:15 by abdulhaseeb2002');
    });
    
})(jQuery);