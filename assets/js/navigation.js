/**
 * Portfolio Navigation Script
 * Advanced navigation features for portfolio sections
 */

(function($) {
    'use strict';

    // Navigation state management
    const NavigationState = {
        currentSection: '',
        isScrolling: false,
        isMobileMenuOpen: false,
        sections: []
    };

    $(document).ready(function() {
        
        /**
         * Initialize navigation system
         */
        function initNavigation() {
            // Cache sections for performance
            NavigationState.sections = $('section[id]').map(function() {
                return {
                    id: this.id,
                    element: $(this),
                    top: 0,
                    bottom: 0
                };
            }).get();
            
            updateSectionPositions();
            setupIntersectionObserver();
            setupScrollIndicator();
            
            console.log('Portfolio navigation initialized with', NavigationState.sections.length, 'sections');
        }
        
        /**
         * Update section positions (call on resize)
         */
        function updateSectionPositions() {
            NavigationState.sections.forEach(function(section) {
                const rect = section.element[0].getBoundingClientRect();
                const scrollTop = $(window).scrollTop();
                section.top = rect.top + scrollTop;
                section.bottom = section.top + section.element.outerHeight();
            });
        }
        
        /**
         * Modern Intersection Observer for better performance
         */
        function setupIntersectionObserver() {
            if (!window.IntersectionObserver) {
                // Fallback for older browsers
                setupScrollBasedNavigation();
                return;
            }
            
            const options = {
                root: null,
                rootMargin: '-20% 0px -60% 0px',
                threshold: 0
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        updateActiveMenuItem(entry.target.id);
                    }
                });
            }, options);
            
            // Observe all sections
            NavigationState.sections.forEach(function(section) {
                observer.observe(section.element[0]);
            });
        }
        
        /**
         * Fallback scroll-based navigation
         */
        function setupScrollBasedNavigation() {
            let ticking = false;
            
            $(window).on('scroll', function() {
                if (!ticking) {
                    requestAnimationFrame(function() {
                        const scrollTop = $(window).scrollTop();
                        const headerHeight = $('.site-header').outerHeight() || 80;
                        const triggerPoint = scrollTop + headerHeight + 50;
                        
                        NavigationState.sections.forEach(function(section) {
                            if (triggerPoint >= section.top && triggerPoint < section.bottom) {
                                updateActiveMenuItem(section.id);
                            }
                        });
                        
                        ticking = false;
                    });
                    ticking = true;
                }
            });
        }
        
        /**
         * Update active menu item
         */
        function updateActiveMenuItem(sectionId) {
            if (NavigationState.currentSection === sectionId) return;
            
            NavigationState.currentSection = sectionId;
            
            // Remove active classes
            $('.nav-menu a, .nav-menu li').removeClass('current-menu-item active');
            
            // Add active class to current section link
            const activeLink = $('.nav-menu a[href="#' + sectionId + '"]');
            activeLink.addClass('current-menu-item active');
            activeLink.closest('li').addClass('current-menu-item active');
            
            // Trigger custom event
            $(window).trigger('sectionChanged', [sectionId]);
        }
          /**
         * Scroll progress indicator - DISABLED
         */
        function setupScrollIndicator() {
            // DISABLED: This function was creating the unwanted top progress line
            // User requested to keep only the bottom scroll indicator
            /*
            // Create progress bar if it doesn't exist
            if (!$('.scroll-progress').length) {
                $('<div class="scroll-progress"></div>').prependTo('body');
            }
            
            $(window).on('scroll', function() {
                const scrolled = $(window).scrollTop();
                const documentHeight = $(document).height() - $(window).height();
                const progress = Math.min((scrolled / documentHeight) * 100, 100);
                
                $('.scroll-progress').css('width', progress + '%');
            });
            */
        }
        
        /**
         * Enhanced smooth scrolling with easing
         */
        function smoothScrollTo(targetId, duration = 1200) {
            const target = $('#' + targetId);
            if (!target.length) return;
            
            NavigationState.isScrolling = true;
            
            const headerHeight = $('.site-header').outerHeight() || 80;
            const targetPosition = target.offset().top - headerHeight - 20;
            
            $('html, body').animate({
                scrollTop: targetPosition
            }, {
                duration: duration,
                easing: 'easeInOutCubic',
                complete: function() {
                    NavigationState.isScrolling = false;
                    
                    // Update URL
                    if (history.pushState) {
                        history.pushState(null, null, '#' + targetId);
                    }
                    
                    // Focus target for accessibility
                    target.attr('tabindex', '-1').focus();
                    
                    $(window).trigger('scrollComplete', [targetId]);
                }
            });
        }
        
        /**
         * Navigation utilities
         */
        const NavigationUtils = {
            
            // Get next section
            getNextSection: function() {
                const currentIndex = NavigationState.sections.findIndex(s => s.id === NavigationState.currentSection);
                return currentIndex < NavigationState.sections.length - 1 ? 
                       NavigationState.sections[currentIndex + 1] : null;
            },
            
            // Get previous section
            getPreviousSection: function() {
                const currentIndex = NavigationState.sections.findIndex(s => s.id === NavigationState.currentSection);
                return currentIndex > 0 ? NavigationState.sections[currentIndex - 1] : null;
            },
            
            // Navigate to next section
            goToNext: function() {
                const next = this.getNextSection();
                if (next) smoothScrollTo(next.id);
            },
            
            // Navigate to previous section
            goToPrevious: function() {
                const prev = this.getPreviousSection();
                if (prev) smoothScrollTo(prev.id);
            }
        };
        
        /**
         * Keyboard navigation
         */
        function setupKeyboardNavigation() {
            $(document).on('keydown', function(e) {
                // Only handle if no input is focused
                if ($('input:focus, textarea:focus, select:focus').length) return;
                
                switch(e.key) {
                    case 'ArrowDown':
                    case 'PageDown':
                        e.preventDefault();
                        NavigationUtils.goToNext();
                        break;
                    case 'ArrowUp':
                    case 'PageUp':
                        e.preventDefault();
                        NavigationUtils.goToPrevious();
                        break;
                    case 'Home':
                        e.preventDefault();
                        smoothScrollTo('hero');
                        break;
                    case 'End':
                        e.preventDefault();
                        smoothScrollTo('contact');
                        break;
                }
            });
        }
        
        /**
         * Handle window resize
         */
        function handleResize() {
            let resizeTimeout;
            $(window).on('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    updateSectionPositions();
                }, 250);
            });
        }
        
        /**
         * Public API
         */
        window.PortfolioNavigation = {
            scrollTo: smoothScrollTo,
            utils: NavigationUtils,
            state: NavigationState,
            updatePositions: updateSectionPositions
        };
        
        // Initialize everything
        initNavigation();
        setupKeyboardNavigation();
        handleResize();
        
        // Handle initial hash
        if (window.location.hash) {
            setTimeout(function() {
                const targetId = window.location.hash.substring(1);
                smoothScrollTo(targetId, 800);
            }, 100);
        }
        
    });
    
})(jQuery);