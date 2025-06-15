/**
 * Stylefolio - Work Experience Section Scripts
 * 
 * @author abdulhaseeb2002
 * @updated 2025-06-11 16:03:15
 */

(function($) {
    'use strict';
    
    // Log initialization
    console.log('Experience section initialization started');
    
    // Initialize on document ready
    $(document).ready(function() {
        setTimeout(initializeExperienceSection, 100);
    });
    
    /**
     * Main initialization function
     */
    function initializeExperienceSection() {
        initTimelineAnimation();
        initScrollAnimations();
        
        console.log('Experience section fully initialized');
    }
    
    /**
     * Initialize timeline animations
     */
    function initTimelineAnimation() {
        const timelineItems = $('.timeline-item');
        
        if (timelineItems.length === 0) {
            console.log('Timeline items not found');
            return;
        }
        
        // Add staggered animation for timeline items
        timelineItems.each(function(index) {
            const $item = $(this);
            const delay = index * 200; // Stagger the animations
            
            // Initially hide items
            $item.css({
                'opacity': 0,
                'transform': 'translateY(20px)'
            });
            
            // Add scroll trigger for each item
            $(window).on('scroll', function() {
                if (isElementInViewport($item) && $item.css('opacity') === '0') {
                    setTimeout(function() {
                        $item.css({
                            'opacity': 1,
                            'transform': 'translateY(0)'
                        });
                        $item.css('transition', 'opacity 0.6s ease, transform 0.6s ease');
                    }, delay);
                }
            });
            
            // Trigger scroll event to check initial visibility
            $(window).trigger('scroll');
        });
        
        // Add hover effect for timeline content
        $('.timeline-content').hover(
            function() {
                $(this).find('.tech-tags').css('opacity', '1');
            },
            function() {
                $(this).find('.tech-tags').css('opacity', '0.8');
            }
        );
        
        console.log('Timeline animations initialized');
    }
    
    /**
     * Initialize scroll animations
     */
    function initScrollAnimations() {
        const animatedElements = $('[data-animation]');
        
        if (animatedElements.length === 0) {
            console.log('No animated elements found');
            return;
        }
        
        // Initial check for elements in viewport
        checkAnimations();
        
        // Check elements on scroll
        $(window).on('scroll', function() {
            checkAnimations();
        });
        
        function checkAnimations() {
            animatedElements.each(function() {
                const $element = $(this);
                
                if (isElementInViewport($element) && !$element.hasClass('animated')) {
                    $element.addClass('animated');
                }
            });
        }
        
        console.log('Scroll animations initialized');
    }
    
    /**
     * Check if element is in viewport
     * @param {jQuery} $element - Element to check
     * @returns {boolean} - True if element is in viewport
     */
    function isElementInViewport($element) {
        if (!$element.length) return false;
        
        const windowHeight = $(window).height();
        const windowTop = $(window).scrollTop();
        const windowBottom = windowTop + windowHeight;
        
        const elementTop = $element.offset().top;
        const elementBottom = elementTop + $element.outerHeight();
        
        // Element is in viewport if it's visible at least partially
        return ((elementTop <= windowBottom) && (elementBottom >= windowTop + (windowHeight * 0.2)));
    }
    
})(jQuery);