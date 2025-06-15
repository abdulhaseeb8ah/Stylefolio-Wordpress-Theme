/**
 * Skills Section JavaScript with cache-busting and improved initialization
 * Version: 1.1
 * Last Updated: 2025-06-10 09:48:52
 * Author: abdulhaseeb2002
 */

(function($) {
    'use strict';
    
    // Document ready with additional DOM loaded check
    $(function() {
        console.log('Skills section initialization started');
        
        // Wait a short moment to ensure DOM is fully rendered
        setTimeout(function() {
            initializeSkillsSection();
        }, 100);
    });
    
    function initializeSkillsSection() {
        console.log('Skills section fully initialized');
        
        // Tabs functionality with improved error handling
        function initTabs() {
            if ($('.tab-button').length === 0) {
                console.warn('Tab buttons not found - DOM might not be ready');
                return false;
            }
            
            $('.tab-button').on('click', function() {
                // Get the tab to show
                const tabId = $(this).data('tab');
                
                if (!tabId) {
                    console.warn('Tab ID not found:', this);
                    return;
                }
                
                // Remove active class from all tabs and content
                $('.tab-button').removeClass('active');
                $('.tab-content').removeClass('active');
                
                // Add active class to current tab and content
                $(this).addClass('active');
                $('#tab-' + tabId).addClass('active');
                
                // Re-trigger animation for newly visible content
                $('#tab-' + tabId + ' [data-animation]').each(function() {
                    $(this).removeClass('animated').addClass('animated');
                });
                
                console.log('Tab switched to:', tabId);
            });
            
            return true;
        }
        
        // Skill bars animation with improved visibility detection
        function initSkillBars() {
            const skillBars = $('.skill-bar-fill');
            
            if (skillBars.length === 0) {
                console.warn('Skill bars not found');
                return false;
            }
            
            function animateSkillBars() {
                skillBars.each(function() {
                    const $this = $(this);
                    const percentage = $this.data('percentage');
                    
                    if (!percentage && percentage !== 0) {
                        console.warn('Percentage attribute missing for skill bar');
                        return;
                    }
                    
                    if (isElementInViewport($this) && !$this.hasClass('animated')) {
                        $this.addClass('animated');
                        $this.css('width', percentage + '%');
                        console.log('Animated skill bar to:', percentage + '%');
                    }
                });
            }
            
            // Initial check
            animateSkillBars();
            
            // Check on scroll
            $(window).on('scroll', function() {
                animateSkillBars();
            });
            
            return true;
        }
        
        // Scroll animations with better error handling
        function initScrollAnimations() {
            const animatedElements = $('[data-animation]');
            
            if (animatedElements.length === 0) {
                console.warn('No elements with data-animation found');
                return false;
            }
            
            function checkAnimations() {
                animatedElements.each(function() {
                    const $this = $(this);
                    
                    if (isElementInViewport($this) && !$this.hasClass('animated')) {
                        $this.addClass('animated');
                        console.log('Element animated:', $this);
                    }
                });
            }
            
            // Initial check
            checkAnimations();
            
            // Check on scroll
            $(window).on('scroll', function() {
                checkAnimations();
            });
            
            return true;
        }
        
        // Improved viewport detection
        function isElementInViewport(el) {
            if (!el || !el.length) {
                console.warn('Invalid element passed to isElementInViewport');
                return false;
            }
            
            if (typeof jQuery === "function" && el instanceof jQuery) {
                el = el[0];
            }
            
            const rect = el.getBoundingClientRect();
            
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.9 &&
                rect.bottom >= 0 &&
                rect.left <= (window.innerWidth || document.documentElement.clientWidth) &&
                rect.right >= 0
            );
        }
        
        // Skill cards hover effects with error handling
        function initSkillCardEffects() {
            if ($('.skill-card').length === 0) {
                console.warn('Skill cards not found');
                return false;
            }
            
            $('.skill-card').hover(
                function() {
                    $(this).find('.skill-icon i').addClass('animated rubberBand');
                },
                function() {
                    $(this).find('.skill-icon i').removeClass('animated rubberBand');
                }
            );
            
            return true;
        }
        
        // Adding keyframe animations dynamically
        function addKeyframeAnimations() {
            if ($('#skillsKeyframes').length === 0) {
                const keyframes = `
                    @keyframes rubberBand {
                        from {
                            transform: scale3d(1, 1, 1);
                        }
                        30% {
                            transform: scale3d(1.25, 0.75, 1);
                        }
                        40% {
                            transform: scale3d(0.75, 1.25, 1);
                        }
                        50% {
                            transform: scale3d(1.15, 0.85, 1);
                        }
                        65% {
                            transform: scale3d(0.95, 1.05, 1);
                        }
                        75% {
                            transform: scale3d(1.05, 0.95, 1);
                        }
                        to {
                            transform: scale3d(1, 1, 1);
                        }
                    }
                    
                    .animated.rubberBand {
                        animation: rubberBand 1s;
                    }
                `;
                
                $('head').append(`<style id="skillsKeyframes">${keyframes}</style>`);
            }
        }
        
        // Force initial tab display
        function forceTabDisplay() {
            // Make sure the first tab is active
            if ($('.tab-content.active').length === 0) {
                $('.tab-button:first').addClass('active');
                $('.tab-content:first').addClass('active');
                console.log('Forced initial tab display');
            }
        }
        
        // Add unique version to bust cache on skills content
        $('[data-tab]').each(function() {
            // Add version query param to force fresh content
            $(this).attr('data-version', '1.1');
        });
        
        // Initialize all functionality
        const tabsInitialized = initTabs();
        const skillBarsInitialized = initSkillBars();
        const scrollAnimationsInitialized = initScrollAnimations();
        const skillCardsInitialized = initSkillCardEffects();
        addKeyframeAnimations();
        forceTabDisplay();
        
        // Log initialization status
        console.log('Skills section initialization status:', {
            tabs: tabsInitialized,
            skillBars: skillBarsInitialized,
            scrollAnimations: scrollAnimationsInitialized,
            skillCards: skillCardsInitialized
        });
        
        // Handle resize events
        $(window).on('resize', function() {
            initSkillBars();
            initScrollAnimations();
        });
        
        // Add timestamp to console for debugging
        console.log('Skills JS last updated: 2025-06-10 09:48:52 by abdulhaseeb2002');
    }
    
})(jQuery);