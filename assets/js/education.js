/**
 * Stylefolio - Education Section Scripts
 * 
 * @author abdulhaseeb2002
 * @updated 2025-06-12 09:06:44
 */

(function($) {
    'use strict';
    
    // Log initialization
    console.log('Education section initialization started');
    
    // Initialize on document ready
    $(document).ready(function() {
        setTimeout(initializeEducationSection, 100);
    });
    
    /**
     * Main initialization function
     */
    function initializeEducationSection() {
        initTimelineAnimation();
        initCardAnimation();
        initScrollAnimations();
        
        console.log('Education section fully initialized');
    }
    
    /**
     * Initialize timeline animations
     */
    function initTimelineAnimation() {
        const timelineItems = $('.education-timeline .timeline-item');
        
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
        });
        
        // Add animation for timeline markers
        $('.timeline-marker').each(function() {
            const $marker = $(this);
            
            // Add slight rotation on hover
            $marker.hover(
                function() {
                    $(this).css({
                        'transform': 'translateX(-50%) scale(1.1) rotate(10deg)',
                        'transition': 'transform 0.3s ease'
                    });
                },
                function() {
                    $(this).css({
                        'transform': 'translateX(-50%) scale(1) rotate(0deg)',
                        'transition': 'transform 0.3s ease'
                    });
                }
            );
        });
        
        // Trigger scroll event to check initial visibility
        $(window).trigger('scroll');
        
        console.log('Timeline animations initialized');
    }
    
    /**
     * Initialize card animations
     */
    function initCardAnimation() {
        const educationCards = $('.education-cards .education-card');
        
        if (educationCards.length === 0) {
            console.log('Education cards not found');
            return;
        }
        
        // Add staggered reveal animation for cards
        educationCards.each(function(index) {
            const $card = $(this);
            const delay = index * 150;
            
            // Initially hide cards
            $card.css({
                'opacity': 0,
                'transform': 'translateY(20px)'
            });
            
            // Add scroll trigger for each card
            $(window).on('scroll', function() {
                if (isElementInViewport($card) && $card.css('opacity') === '0') {
                    setTimeout(function() {
                        $card.css({
                            'opacity': 1,
                            'transform': 'translateY(0)'
                        });
                        $card.css('transition', 'opacity 0.5s ease, transform 0.5s ease');
                    }, delay);
                }
            });
        });
        
        // Trigger scroll event to check initial visibility
        $(window).trigger('scroll');
        
        console.log('Card animations initialized');
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
    
    /**
     * Make course tags interactive
     */
    $('.course-tag').hover(
        function() {
            $(this).css({
                'background': 'rgba(var(--primary-color-rgb), 0.2)',
                'color': 'var(--primary-color)',
                'transform': 'translateY(-3px)'
            });
        },
        function() {
            $(this).css({
                'background': 'rgba(255, 255, 255, 0.1)',
                'color': 'var(--text-secondary)',
                'transform': 'translateY(0)'
            });
        }
    );
    
})(jQuery);