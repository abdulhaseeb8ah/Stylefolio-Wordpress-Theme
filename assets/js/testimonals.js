/**
 * Stylefolio - Testimonials Section Scripts
 * Enhanced to match Skills Section interactions
 * 
 * @author abdulhaseeb2002
 * @updated 2025-01-28 15:30:00
 */

(function($) {
    'use strict';
    
    // Log initialization
    console.log('Testimonials section initialization started');
    
    // Initialize on document ready
    $(document).ready(function() {
        setTimeout(initializeTestimonialsSection, 100);
    });
    
    /**
     * Main initialization function
     */
    function initializeTestimonialsSection() {
        initSlider();
        initCardInteractions();
        initScrollAnimations();
        
        console.log('Testimonials section fully initialized');
    }
    
    /**
     * Initialize testimonials slider
     */
    function initSlider() {
        const sliderContainer = $('.testimonials-slider');
        
        if (sliderContainer.length === 0) {
            console.log('Testimonials slider not found');
            return;
        }
        
        // Initialize Slick Slider
        sliderContainer.slick({
            dots: false,
            arrows: false,
            infinite: true,
            speed: 800,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 5000,
            pauseOnHover: true,
            adaptiveHeight: false,
            cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1.000)',
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });
        
        // Create dots
        const totalSlides = sliderContainer.slick('getSlick').slideCount;
        const dotsContainer = $('.testimonials-dots');
        
        for (let i = 0; i < totalSlides; i++) {
            const dot = $('<span class="dot"></span>');
            if (i === 0) {
                dot.addClass('active');
            }
            
            dot.on('click', function() {
                sliderContainer.slick('slickGoTo', i);
            });
            
            dotsContainer.append(dot);
        }
        
        // Update dots on slide change
        sliderContainer.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
            dotsContainer.find('.dot').removeClass('active');
            dotsContainer.find('.dot').eq(nextSlide).addClass('active');
        });
        
        // Add click events for prev/next buttons
        $('.testimonial-prev').on('click', function() {
            sliderContainer.slick('slickPrev');
        });
        
        $('.testimonial-next').on('click', function() {
            sliderContainer.slick('slickNext');
        });
        
        console.log('Testimonials slider initialized');
    }
      /**
     * Initialize card interactions - Match skills cards behavior
     */
    function initCardInteractions() {
        if ($('.testimonial-card').length === 0) {
            console.log('Testimonial cards not found');
            return;
        }
        
        // Add hover effects for testimonial cards
        $('.testimonial-card').hover(
            function() {
                $(this).find('.quote-icon i').addClass('animated rubberBand');
                $(this).find('.client-rating i').addClass('star-glow');
            },
            function() {
                $(this).find('.quote-icon i').removeClass('animated rubberBand');
                $(this).find('.client-rating i').removeClass('star-glow');
            }
        );
        
        // Add click interaction for cards
        $('.testimonial-card').on('click', function() {
            $(this).addClass('card-clicked');
            setTimeout(() => {
                $(this).removeClass('card-clicked');
            }, 300);
        });
        
        console.log('Testimonial card interactions initialized');
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
        
        function isElementInViewport($element) {
            const windowHeight = $(window).height();
            const windowTop = $(window).scrollTop();
            const windowBottom = windowTop + windowHeight;
            
            const elementTop = $element.offset().top;
            const elementBottom = elementTop + $element.outerHeight();
            
            // Element is in viewport if it's visible at least partially
            return ((elementTop <= windowBottom) && (elementBottom >= windowTop + (windowHeight * 0.2)));
        }
        
        console.log('Scroll animations initialized');
    }
    
})(jQuery);