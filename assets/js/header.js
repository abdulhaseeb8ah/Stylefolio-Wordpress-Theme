/**
 * Header Navigation Enhancement Script
 * Provides advanced navigation features and smooth scrolling
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        
        // ======================================
        // Navigation Menu Enhancement
        // ======================================
          /**
         * Add section navigation if no menu exists
         */
        function ensureSectionNavigation() {
            const navMenu = $('.nav-menu');
            
            console.log('Nav menu found:', navMenu.length, 'Children:', navMenu.children().length);
            
            // If menu is empty or doesn't exist, add section links
            if (navMenu.length && navMenu.children().length === 0) {
                const sectionLinks = [
                    { title: 'Home', url: '#hero' },
                    { title: 'Skills', url: '#skills' },
                    { title: 'Portfolio', url: '#portfolio' },
                    { title: 'Testimonials', url: '#testimonials' },
                    { title: 'Experience', url: '#experience' },
                    { title: 'Education', url: '#education' },
                    { title: 'Contact', url: '#contact' }
                ];
                
                let menuHTML = '';
                sectionLinks.forEach(function(link) {
                    menuHTML += `<li><a href="${link.url}">${link.title}</a></li>`;
                });
                
                navMenu.html(menuHTML);
                console.log('Section navigation added to menu');
            } else if (navMenu.length && navMenu.children().length > 0) {
                console.log('Menu already exists with items:', navMenu.children().length);
            }
        }
          /**
         * Enhanced smooth scrolling with offset calculation
         */
        function initSmoothScrolling() {
            // Remove any existing handlers to prevent conflicts
            $(document).off('click', 'a[href^="#"]');
            
            $(document).on('click', 'a[href^="#"]:not([href="#"])', function(e) {
                const href = this.getAttribute('href');
                const target = $(href);
                
                console.log('Navigation clicked:', href, 'Target found:', target.length > 0);
                
                if (target.length) {
                    e.preventDefault();
                    
                    // Calculate dynamic header height
                    const headerHeight = $('.site-header').outerHeight() || 80;
                    const offset = headerHeight + 30; // Increased offset for better positioning
                    const targetPosition = target.offset().top - offset;
                    
                    console.log('Scrolling to position:', targetPosition);
                    
                    // Close mobile menu if open
                    $('.mobile-menu').removeClass('show-mobile-menu');
                    $('.menu-toggle').removeClass('toggled').attr('aria-expanded', 'false');
                    $('body').removeClass('menu-open');
                    
                    // Smooth scroll animation
                    $('html, body').stop().animate({
                        scrollTop: targetPosition
                    }, {
                        duration: 1000,
                        easing: 'swing', // Use built-in easing
                        complete: function() {
                            console.log('Scroll complete');
                            // Update URL without jumping
                            if (history.pushState) {
                                history.pushState(null, null, href);
                            }
                            
                            // Trigger custom event
                            $(window).trigger('navigationComplete', [href, target]);
                        }
                    });
                }
            });
        }
          /**
         * Active section highlighting with improved performance
         */
        function initActiveHighlighting() {
            let ticking = false;
            
            function updateActiveSection() {
                const scrollPosition = $(window).scrollTop();
                const headerHeight = $('.site-header').outerHeight() || 80;
                const triggerPoint = scrollPosition + headerHeight + 50;
                
                let activeSection = '';
                
                console.log('Checking sections at scroll position:', scrollPosition);
                
                // Find current section
                $('section[id]').each(function() {
                    const section = $(this);
                    const sectionTop = section.offset().top;
                    const sectionBottom = sectionTop + section.outerHeight();
                    
                    if (triggerPoint >= sectionTop && triggerPoint < sectionBottom) {
                        activeSection = section.attr('id');
                        console.log('Active section:', activeSection);
                        return false; // Break loop
                    }
                });
                
                // Update active menu items
                if (activeSection) {
                    // Remove all active classes
                    $('.nav-menu a').removeClass('current-menu-item active');
                    $('.nav-menu li').removeClass('current-menu-item active');
                    
                    // Add active class to corresponding menu item
                    const activeLink = $('.nav-menu a[href="#' + activeSection + '"]');
                    console.log('Setting active link:', activeLink.length, 'for section:', activeSection);
                    
                    if (activeLink.length) {
                        activeLink.addClass('current-menu-item active');
                        activeLink.closest('li').addClass('current-menu-item active');
                    }
                }
                
                ticking = false;
            }
            
            function requestTick() {
                if (!ticking) {
                    requestAnimationFrame(updateActiveSection);
                    ticking = true;
                }
            }
            
            $(window).on('scroll', requestTick);
            
            // Initial check
            updateActiveSection();
        }        /**
         * Enhanced mobile menu functionality with debugging
         */
        function initMobileMenu() {
            console.log('=== MOBILE MENU INITIALIZATION ===');
            
            // Check if elements exist
            const menuToggle = $('.menu-toggle');
            const mobileMenu = $('.mobile-menu');
            const mainNav = $('.main-navigation');
            
            console.log('Menu toggle elements found:', menuToggle.length);
            console.log('Mobile menu elements found:', mobileMenu.length);
            console.log('Main navigation found:', mainNav.length);
            
            if (menuToggle.length === 0) {
                console.error('❌ Menu toggle button not found!');
                return;
            }
            
            if (mobileMenu.length === 0) {
                console.error('❌ Mobile menu container not found!');
                return;
            }
            
            // Log initial state
            console.log('Initial mobile menu classes:', mobileMenu[0].className);
            console.log('Initial menu toggle classes:', menuToggle[0].className);
            
            // Remove any existing handlers to prevent duplicates
            menuToggle.off('click.mobileMenu');
            $(document).off('click.mobileMenu');
            
            // Add click handler to menu toggle
            menuToggle.on('click.mobileMenu', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                console.log('🍔 HAMBURGER CLICKED!');
                
                const $this = $(this);
                const isCurrentlyOpen = mobileMenu.hasClass('show-mobile-menu');
                
                console.log('Menu currently open:', isCurrentlyOpen);
                console.log('About to toggle menu...');
                
                if (isCurrentlyOpen) {
                    // Close menu
                    mobileMenu.removeClass('show-mobile-menu');
                    $this.removeClass('toggled');
                    $this.attr('aria-expanded', 'false');
                    $('body').removeClass('menu-open');
                    console.log('✅ Menu CLOSED');
                } else {
                    // Open menu
                    mobileMenu.addClass('show-mobile-menu');
                    $this.addClass('toggled');
                    $this.attr('aria-expanded', 'true');
                    $('body').addClass('menu-open');
                    console.log('✅ Menu OPENED');
                }
                
                // Log final state
                console.log('Final mobile menu classes:', mobileMenu[0].className);
                console.log('Final menu toggle classes:', $this[0].className);
                
                // Trigger custom event
                $(window).trigger('mobileMenuToggle', [!isCurrentlyOpen]);
            });
            
            // Close menu when clicking on mobile menu links
            mobileMenu.find('a').on('click.mobileMenu', function() {
                console.log('📱 Mobile menu link clicked, closing menu');
                mobileMenu.removeClass('show-mobile-menu');
                menuToggle.removeClass('toggled').attr('aria-expanded', 'false');
                $('body').removeClass('menu-open');
            });
            
            // Close menu when clicking outside
            $(document).on('click.mobileMenu', function(e) {
                const clickedInsideNav = $(e.target).closest('.main-navigation').length > 0;
                const menuIsOpen = mobileMenu.hasClass('show-mobile-menu');
                
                if (!clickedInsideNav && menuIsOpen) {
                    console.log('👆 Clicked outside navigation, closing menu');
                    mobileMenu.removeClass('show-mobile-menu');
                    menuToggle.removeClass('toggled').attr('aria-expanded', 'false');
                    $('body').removeClass('menu-open');
                }
            });
            
            // Test the elements are working
            console.log('🧪 Testing menu toggle visibility...');
            if ($(window).width() <= 768) {
                console.log('📱 Mobile view - menu toggle should be visible');
                console.log('Menu toggle display:', menuToggle.css('display'));
                console.log('Mobile menu display:', mobileMenu.css('display'));
            } else {
                console.log('💻 Desktop view - menu toggle should be hidden');
            }
            
            console.log('✅ Mobile menu initialized successfully');
        }
        
        // ======================================
        // Simple Mobile Menu Test
        // ======================================
        function testMobileMenuElements() {
            console.log('🔍 TESTING MOBILE MENU ELEMENTS:');
            console.log('jQuery available:', typeof $ !== 'undefined');
            console.log('Document ready:', document.readyState);
            
            setTimeout(function() {
                const menuToggle = document.querySelector('.menu-toggle');
                const mobileMenu = document.querySelector('.mobile-menu');
                const mainNav = document.querySelector('.main-navigation');
                
                console.log('Raw DOM - Menu toggle:', !!menuToggle);
                console.log('Raw DOM - Mobile menu:', !!mobileMenu);
                console.log('Raw DOM - Main nav:', !!mainNav);
                
                if (menuToggle) {
                    console.log('Menu toggle styles:', window.getComputedStyle(menuToggle).display);
                    
                    // Add a direct click test
                    menuToggle.addEventListener('click', function() {
                        console.log('🚨 DIRECT CLICK EVENT FIRED!');
                        if (mobileMenu) {
                            mobileMenu.classList.toggle('show-mobile-menu');
                            console.log('Menu classes after toggle:', mobileMenu.className);
                        }
                    });
                }
                
                if (mobileMenu) {
                    console.log('Mobile menu styles:', window.getComputedStyle(mobileMenu).display);
                }
            }, 100);
        }

        // ======================================
        /**
         * Keyboard navigation support
         */
        function initKeyboardNavigation() {
            $('.nav-menu a').on('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    $(this).trigger('click');
                }
            });
        }
          /**
         * Initialize all header features
         */
        function init() {
            console.log('🚀 INITIALIZING HEADER FEATURES...');
            
            // Run test first
            testMobileMenuElements();
            
            ensureSectionNavigation();
            initSmoothScrolling();
            initActiveHighlighting();
            initMobileMenu();
            initKeyboardNavigation();
            
            // Handle hash on page load
            if (window.location.hash) {
                setTimeout(function() {
                    const target = $(window.location.hash);
                    if (target.length) {
                        const headerHeight = $('.site-header').outerHeight() || 80;
                        const targetPosition = target.offset().top - headerHeight - 20;
                        
                        $('html, body').animate({
                            scrollTop: targetPosition
                        }, 1000);
                    }
                }, 500);
            }
            
            console.log('Header navigation enhanced successfully');
        }
        
        // Initialize when DOM is ready
        init();
        
        // Re-initialize on window resize for responsive handling
        let resizeTimeout;
        $(window).on('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                // Close mobile menu on desktop
                if ($(window).width() > 768) {
                    $('.mobile-menu').removeClass('show-mobile-menu');
                    $('.menu-toggle').removeClass('toggled').attr('aria-expanded', 'false');
                    $('body').removeClass('menu-open');
                }
            }, 250);
        });
        
        // Force mobile menu to work with direct DOM manipulation
        setTimeout(function() {
            console.log('🔧 FORCING MOBILE MENU FUNCTIONALITY...');
            
            // Get elements using vanilla JS as fallback
            const menuToggleBtn = document.querySelector('.menu-toggle');
            const mobileMenuDiv = document.querySelector('.mobile-menu');
            
            if (menuToggleBtn && mobileMenuDiv) {
                console.log('✅ Found elements with vanilla JS');
                
                // Remove any existing event listeners
                const newMenuToggle = menuToggleBtn.cloneNode(true);
                menuToggleBtn.parentNode.replaceChild(newMenuToggle, menuToggleBtn);
                
                // Add new event listener
                newMenuToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    console.log('🍔 VANILLA JS CLICK HANDLER FIRED!');
                    
                    const isOpen = mobileMenuDiv.classList.contains('show-mobile-menu');
                    console.log('Menu is currently open:', isOpen);
                    
                    if (isOpen) {
                        mobileMenuDiv.classList.remove('show-mobile-menu');
                        newMenuToggle.classList.remove('toggled');
                        newMenuToggle.setAttribute('aria-expanded', 'false');
                        console.log('✅ Menu CLOSED via vanilla JS');
                    } else {
                        mobileMenuDiv.classList.add('show-mobile-menu');
                        newMenuToggle.classList.add('toggled');
                        newMenuToggle.setAttribute('aria-expanded', 'true');
                        console.log('✅ Menu OPENED via vanilla JS');
                    }
                    
                    console.log('Final menu classes:', mobileMenuDiv.className);
                });
                
                console.log('✅ Vanilla JS mobile menu handler attached');
            } else {
                console.error('❌ Could not find mobile menu elements with vanilla JS');
                console.log('Menu toggle:', !!menuToggleBtn);
                console.log('Mobile menu:', !!mobileMenuDiv);
            }
        }, 1000);
    });
    
})(jQuery);