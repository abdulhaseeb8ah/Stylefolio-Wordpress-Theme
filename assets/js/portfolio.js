/**
 * Portfolio Pro - Portfolio Section Scripts
 * 
 * @author abdulhaseeb2002
 * @updated 2025-06-12 10:45:00
 */

(function($) {
    'use strict';
    
    // Log initialization
    console.log('Portfolio section initialization started');
      // Global variables
    let totalProjects = 0;
    let loadedProjects = 6; // Start with 6 projects
    let projectsPerPage = 6;
    let isLoading = false;
    let cachedProjectData = {};
    let currentFilter = '*'; // Track current filter
    let allProjectsData = []; // Store all project data for filtering
    
    // Initialize on document ready
    $(document).ready(function() {
        // Wait for DOM to be fully loaded
        setTimeout(function() {
            initializePortfolioSection();
        }, 100);
    });    /**
     * Main initialization function
     */
    function initializePortfolioSection() {
        // Move popup to body to avoid stacking context issues
        const popup = $('#project-popup');
        if (popup.length > 0 && popup.parent()[0] !== document.body) {
            popup.detach().appendTo('body');
            console.log('Popup moved to body for proper positioning');
        }
        
        // Initialize functionality
        initFilterButtons();
        initIsotope();
        initPopup();
        initLoadMore();
        initScrollAnimations();
        preloadProjectData();
          // Count total projects
        totalProjects = $('.portfolio-item').length;
        
        // Initially hide projects beyond the first 6
        hideProjectsBeyondLimit(projectsPerPage);
        
        // Store all project data for filtering
        storeAllProjectsData();
          // Enhanced resize handler for better responsive behavior
        let resizeTimeout;
        const $grid = $('.portfolio-grid');
        
        function handleResize() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                // Force isotope to recalculate layout
                if ($grid.data('isotope')) {
                    $grid.isotope('reloadItems').isotope('layout');
                }
                
                // Force CSS grid recalculation
                $grid.css('grid-template-columns', '');
                setTimeout(function() {
                    $grid.css('grid-template-columns', '');
                }, 50);
            }, 250);
        }
        
        $(window).on('resize orientationchange', handleResize);
        
        // Log completion
        console.log('Portfolio section fully initialized');
    }
      /**
     * Initialize filter buttons - Fixed for category filtering
     */
    function initFilterButtons() {
        const filterButtons = $('.portfolio-filter .filter-button');
        
        if (filterButtons.length === 0) {
            console.log('Filter buttons not found');
            return;
        }
        
        // Debug: Log all portfolio items and their categories
        const portfolioItems = $('.portfolio-item');
        console.log('=== Portfolio Filter Debug ===');
        console.log(`Found ${portfolioItems.length} portfolio items:`);
        portfolioItems.each(function(index) {
            const classes = $(this).attr('class');
            console.log(`  Item ${index + 1}: ${classes}`);
        });
        
        console.log(`Found ${filterButtons.length} filter buttons:`);
        filterButtons.each(function(index) {
            const filter = $(this).data('filter');
            const text = $(this).text().trim();
            console.log(`  Button ${index + 1}: "${text}" -> filter: "${filter}"`);
        });
        console.log('===============================');
          filterButtons.on('click', function() {
            const $this = $(this);
            // Get filter value - this should match the category class on items
            const filterValue = $this.data('filter');
            
            console.log('Filter clicked:', filterValue); // Debug log
            
            // Update current filter
            currentFilter = filterValue;
            
            // Update active class
            filterButtons.removeClass('active');
            $this.addClass('active');
            
            // Reset load more state
            loadedProjects = projectsPerPage;
            
            // Filter items
            if (window.portfolioIsotope) {
                window.portfolioIsotope.arrange({
                    filter: filterValue
                });
                
                // After filtering, apply load more logic
                setTimeout(function() {
                    applyLoadMoreToFilteredItems(filterValue);
                    updateLoadMoreVisibility();
                }, 200);
                
                // Debug: Log filtering results
                setTimeout(function() {
                    const visibleItems = $('.portfolio-item.filtered-in:visible').length;
                    const hiddenItems = $('.portfolio-item.filtered-out').length;
                    const totalItems = $('.portfolio-item').length;
                    console.log(`After filtering with "${filterValue}": ${visibleItems} visible, ${hiddenItems} hidden, ${totalItems} total`);
                }, 200);
            } else {
                console.warn('Filter system not initialized yet');
            }
        });
        
        console.log('Filter buttons initialized');
    }/**
     * Initialize filtering system without Isotope conflicts
     */
    function initIsotope() {
        const portfolioGrid = $('.portfolio-grid');
        
        if (portfolioGrid.length === 0) {
            console.log('Portfolio grid not found');
            return;
        }
        
        // Initialize with a simple visibility-based filter system
        // This avoids conflicts with CSS Grid
        portfolioGrid.imagesLoaded(function() {
            console.log('Images loaded, initializing filtering system');
              // Create a simple filter system that works with CSS Grid
            window.portfolioIsotope = {
                arrange: function(options) {
                    const filter = options.filter;
                    const items = portfolioGrid.find('.portfolio-item');
                    
                    // Add filtering class to trigger CSS transitions
                    portfolioGrid.addClass('filtering');
                    
                    if (filter === '*') {
                        // Show all items
                        items.removeClass('filtered-out').addClass('filtered-in');
                    } else {
                        // Hide items that don't match filter
                        items.each(function() {
                            const $item = $(this);
                            if ($item.hasClass(filter.substring(1))) { // Remove the dot from filter
                                $item.removeClass('filtered-out').addClass('filtered-in');
                            } else {
                                $item.removeClass('filtered-in').addClass('filtered-out');
                            }
                        });
                    }
                    
                    // Force grid recalculation and layout reflow
                    setTimeout(function() {
                        // Force browser to recalculate grid layout
                        portfolioGrid[0].offsetHeight; // Trigger reflow
                        
                        // Remove filtering class after animation
                        setTimeout(function() {
                            portfolioGrid.removeClass('filtering');
                        }, 100);
                        
                        portfolioGrid.trigger('arrange.isotope');
                    }, 50);
                },
                
                getFilteredItemElements: function() {
                    return portfolioGrid.find('.portfolio-item.filtered-in').toArray();
                }
            };
            
            // Log the items for debugging
            console.log('Portfolio items:', portfolioGrid.find('.portfolio-item').length);
              // Initialize all items as visible
            setTimeout(function() {
                portfolioGrid.find('.portfolio-item').addClass('filtered-in');
                
                // Apply initial load more logic
                applyLoadMoreToFilteredItems('*');
                
                // Make sure "All" filter is active on load
                $('.portfolio-filter .filter-button[data-filter="*"]').addClass('active');
                
                // Update visibility of load more button based on initial filter
                updateLoadMoreVisibility();
            }, 100);
            
            console.log('Custom filtering system initialized');
        });
    }
      /**
     * Initialize project popup functionality with enhanced positioning
     */
    function initPopup() {
        const popup = $('#project-popup');
        const viewButtons = $('.view-details');
        
        if (popup.length === 0 || viewButtons.length === 0) {
            console.log('Popup elements not found');
            return;
        }
        
        // Ensure popup is appended to body for proper positioning
        if (popup.parent()[0] !== document.body) {
            popup.detach().appendTo('body');
        }
        
        // Add hover event to preload data
        viewButtons.on('mouseenter', function() {
            const projectId = $(this).data('project');
            preloadProjectData(projectId);
        });
        
        // Open popup when clicking view button
        viewButtons.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const projectId = $(this).data('project');
            openProjectPopup(projectId);
        });
        
        // Close popup when clicking close button or overlay
        popup.find('.popup-close').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeProjectPopup();
        });
        
        popup.find('.popup-overlay').on('click', function(e) {
            if (e.target === this) {
                closeProjectPopup();
            }
        });
        
        // Prevent popup container clicks from closing popup
        popup.find('.popup-container').on('click', function(e) {
            e.stopPropagation();
        });
        
        // Close popup with ESC key
        $(document).on('keydown.popup', function(e) {
            if (e.key === 'Escape' && popup.hasClass('active')) {
                closeProjectPopup();
            }
        });
        
        console.log('Enhanced popup functionality initialized');
    }
      /**
     * Initialize load more functionality
     */
    function initLoadMore() {
        // Remove the portfolio CTA if it exists
        $('.portfolio-cta').remove();
        
        // Create the enhanced load more button
        const loadMoreHtml = `
            <div class="load-more-container">
                <button class="load-more-button">
                    <span>Load More Projects</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        `;
        
        // Append after portfolio grid
        $('.portfolio-grid').after(loadMoreHtml);
        
        // Get the button
        const loadMoreButton = $('.load-more-button');
        
        // Add click event
        loadMoreButton.on('click', function() {
            loadMoreProjects();
        });
        
        // Initial check if we need the button
        updateLoadMoreVisibility();
        
        console.log('Enhanced load more functionality initialized');
    }/**
     * Update the visibility of the load more button - Fixed for filtered items
     */
    function updateLoadMoreVisibility() {
        const loadMoreButton = $('.load-more-button');
        
        if (!window.portfolioIsotope) {
            console.warn('Filter system not initialized yet in updateLoadMoreVisibility');
            return;
        }
        
        // Get all projects that match current filter
        const filteredProjects = getVisibleProjectsWithFilter(currentFilter);
        const totalFilteredProjects = filteredProjects.length;
        const visibleProjects = $('.portfolio-item:visible:not(.load-more-hidden)').length;
        
        console.log(`Load more check: ${visibleProjects} visible, ${totalFilteredProjects} total filtered projects`);
        
        // Show load more button if there are more projects to load
        if (visibleProjects < totalFilteredProjects) {
            loadMoreButton.parent().fadeIn(300);
        } else {
            loadMoreButton.parent().fadeOut(300);
        }
    }
      /**
     * Load more projects
     */
    function loadMoreProjects() {
        if (isLoading) return;
        
        const loadMoreButton = $('.load-more-button');
        
        // Set loading state
        isLoading = true;
        loadMoreButton.addClass('loading');
        
        console.log('Loading more projects with filter:', currentFilter);
        
        // Get projects that match current filter
        const filteredProjects = getVisibleProjectsWithFilter(currentFilter);
        const currentlyVisible = $('.portfolio-item:visible:not(.load-more-hidden)').length;
        const nextBatch = filteredProjects.slice(currentlyVisible, currentlyVisible + projectsPerPage);
        
        // Show loading for a short time for better UX
        setTimeout(function() {
            // Show the next batch of projects
            nextBatch.forEach(function(project) {
                project.element.show().removeClass('load-more-hidden');
            });
            
            // Update loaded count
            loadedProjects = currentlyVisible + nextBatch.length;
            
            // Remove loading state
            isLoading = false;
            loadMoreButton.removeClass('loading');
            
            // Update load more button visibility
            updateLoadMoreVisibility();
            
            console.log(`Loaded ${nextBatch.length} more projects. Total visible: ${loadedProjects}`);
            updateDebugInfo();
            
        }, 800); // Small delay for better UX
    }
    
    /**
     * Preload project data for faster popup loading
     */
    function preloadProjectData(projectId) {
        // If no specific project, preload all visible projects
        if (!projectId) {
            $('.portfolio-item:visible').each(function() {
                const id = $(this).data('project-id');
                if (id && !cachedProjectData[id]) {
                    const dataElement = $(`.project-details-data[data-id="${id}"]`);
                    if (dataElement.length > 0) {
                        cacheProjectData(id, dataElement);
                    }
                }
            });
            return;
        }
        
        // If we already have this project cached, skip
        if (cachedProjectData[projectId]) {
            return;
        }
        
        // Find the data element
        const dataElement = $(`.project-details-data[data-id="${projectId}"]`);
        
        if (dataElement.length > 0) {
            cacheProjectData(projectId, dataElement);
        }
    }
    
    /**
     * Cache project data for faster popup loading
     */
    function cacheProjectData(projectId, dataElement) {
        // Extract and cache the data
        cachedProjectData[projectId] = {
            title: dataElement.data('title'),
            excerpt: dataElement.data('excerpt'),
            content: dataElement.data('content'),
            category: dataElement.data('category'),
            client: dataElement.data('client'),
            date: dataElement.data('date'),
            url: dataElement.data('url'),
            tech: dataElement.data('tech'),
            featuredImage: dataElement.data('featured-image'),
            gallery: dataElement.data('gallery')
        };
        
        // Preload featured image
        if (cachedProjectData[projectId].featuredImage) {
            const img = new Image();
            img.src = cachedProjectData[projectId].featuredImage;
        }
    }
      /**
     * Open project popup with enhanced positioning and scroll management
     */
    function openProjectPopup(projectId) {
        const popup = $('#project-popup');
        const $body = $('body');
        
        // Store current scroll position
        const scrollTop = $(window).scrollTop();
        $body.data('scroll-position', scrollTop);
          // Ensure popup is properly positioned
        popup.css({
            'position': 'fixed',
            'top': '0',
            'left': '0',
            'width': '100vw',
            'height': '100vh',
            'z-index': '2147483647'
        });
        
        console.log('Popup positioning set:', {
            position: popup.css('position'),
            zIndex: popup.css('z-index'),
            top: popup.css('top'),
            left: popup.css('left')
        });
        
        // Show popup and loading state
        popup.addClass('active').show();
        popup.find('.popup-loading').show();
        popup.find('.popup-body').hide();
        
        // Enhanced body scroll lock
        $body.addClass('popup-open').css({
            'position': 'fixed',
            'top': -scrollTop + 'px',
            'width': '100%',
            'overflow': 'hidden'
        });
        
        // Force focus to popup for accessibility
        popup.attr('tabindex', '-1').focus();
        
        // Get project data - either from cache or directly
        let projectData;
        
        if (cachedProjectData[projectId]) {
            projectData = cachedProjectData[projectId];
            populatePopup(projectData);
        } else {
            const dataElement = $(`.project-details-data[data-id="${projectId}"]`);
            
            if (dataElement.length === 0) {
                console.error('Project data not found for ID:', projectId);
                closeProjectPopup();
                return;
            }
            
            projectData = {
                title: dataElement.data('title'),
                excerpt: dataElement.data('excerpt'),
                content: dataElement.data('content'),
                category: dataElement.data('category'),
                client: dataElement.data('client'),
                date: dataElement.data('date'),
                url: dataElement.data('url'),
                tech: dataElement.data('tech'),
                featuredImage: dataElement.data('featured-image'),
                gallery: dataElement.data('gallery')
            };
            
            cachedProjectData[projectId] = projectData;
            populatePopup(projectData);
        }
        
        console.log('Project popup opened for ID:', projectId);
    }
    
    /**
     * Populate the popup with project data
     */
    function populatePopup(projectData) {
        const popup = $('#project-popup');
        
        // Populate popup with data
        popup.find('.popup-title').text(projectData.title);
        popup.find('.project-featured-image img').attr('src', projectData.featuredImage);
        popup.find('.project-description').html(projectData.content || projectData.excerpt);
        popup.find('.meta-value.category').text(projectData.category || 'N/A');
        
        // Client info (optional)
        if (projectData.client) {
            popup.find('.meta-item.client').show();
            popup.find('.meta-item.client .meta-value').text(projectData.client);
        } else {
            popup.find('.meta-item.client').hide();
        }
        
        // Date info (optional)
        if (projectData.date) {
            popup.find('.meta-item.date').show();
            popup.find('.meta-item.date .meta-value').text(projectData.date);
        } else {
            popup.find('.meta-item.date').hide();
        }
        
        // Technologies info (optional)
        if (projectData.tech) {
            popup.find('.meta-item.technologies').show();
            popup.find('.meta-item.technologies .meta-value').text(projectData.tech);
        } else {
            popup.find('.meta-item.technologies').hide();
        }
        
        // Project URL (optional)
        if (projectData.url) {
            popup.find('.project-url').show().attr('href', projectData.url);
        } else {
            popup.find('.project-url').hide();
        }        // Gallery (optional)
        const galleryContainer = popup.find('.project-gallery');
        galleryContainer.empty();
        
        if (projectData.gallery && projectData.gallery.length > 0) {
            try {
                const galleryItems = typeof projectData.gallery === 'string' 
                    ? JSON.parse(projectData.gallery) 
                    : projectData.gallery;
                
                // Create a complete gallery array that includes the featured image
                let completeGallery = [];
                
                // Add featured image as the first item if it's not already in the gallery
                const featuredImageSrc = projectData.featured_image;
                const featuredInGallery = galleryItems.find(item => 
                    item.src === featuredImageSrc || item.thumb === featuredImageSrc
                );
                
                if (!featuredInGallery && featuredImageSrc) {
                    completeGallery.push({
                        src: featuredImageSrc,
                        thumb: featuredImageSrc,
                        caption: 'Featured Image',
                        alt: projectData.title + ' - Featured Image'
                    });
                }
                
                // Add all gallery items
                completeGallery = completeGallery.concat(galleryItems);
                
                // Show gallery if there are any images (even just the featured image)
                if (completeGallery.length > 0) {
                    completeGallery.forEach(function(item, index) {
                        const isActive = (index === 0) ? 'active' : '';
                        const thumbnail = $(`
                            <div class="gallery-thumbnail ${isActive}" data-index="${index}">
                                <img src="${item.thumb}" alt="${item.caption || item.alt || ''}">
                                ${item.caption ? `<span class="thumbnail-caption">${item.caption}</span>` : ''}
                            </div>
                        `);
                          thumbnail.on('click', function() {
                            // Update featured image
                            const featuredImg = popup.find('.project-featured-image img');
                            featuredImg.attr('src', item.src);
                            
                            // Update active state
                            galleryContainer.find('.gallery-thumbnail').removeClass('active');
                            $(this).addClass('active');
                            
                            // Add subtle animation
                            featuredImg.css('opacity', '0.7');
                            setTimeout(() => {
                                featuredImg.css('opacity', '1');
                            }, 150);
                            
                            console.log('Gallery image selected:', item.caption || 'Image ' + (index + 1));
                        });
                        
                        // Add right-click or double-click for lightbox
                        thumbnail.on('dblclick', function() {
                            openImageLightbox(item.src, completeGallery);
                        });
                        
                        galleryContainer.append(thumbnail);
                    });
                    
                    galleryContainer.show();
                    console.log('Gallery displayed with', completeGallery.length, 'images');
                } else {
                    galleryContainer.hide();
                    console.log('No gallery images to display');
                }
            } catch (error) {
                console.error('Error parsing gallery data:', error);
                galleryContainer.hide();
            }
        } else {
            // Even if no gallery data, show the featured image as a single thumbnail
            const featuredImageSrc = projectData.featured_image;
            if (featuredImageSrc) {
                const thumbnail = $(`
                    <div class="gallery-thumbnail active" data-index="0">
                        <img src="${featuredImageSrc}" alt="${projectData.title} - Featured Image">
                        <span class="thumbnail-caption">Featured Image</span>
                    </div>
                `);
                
                thumbnail.on('click', function() {
                    // Restore featured image
                    const featuredImg = popup.find('.project-featured-image img');
                    featuredImg.attr('src', featuredImageSrc);
                    
                    // Add subtle animation
                    featuredImg.css('opacity', '0.7');
                    setTimeout(() => {
                        featuredImg.css('opacity', '1');
                    }, 150);
                    
                    console.log('Featured image restored');
                });
                
                galleryContainer.append(thumbnail).show();
                console.log('Showing featured image only in gallery');
            } else {
                galleryContainer.hide();
                console.log('No images available for gallery');
            }        }
        
        // Make featured image clickable for fullscreen view
        popup.find('.project-featured-image img').off('click').on('click', function() {
            const currentSrc = $(this).attr('src');
            // Get the complete gallery including featured image
            const completeGallery = [];
            
            // Add featured image if not already in gallery
            if (projectData.featured_image) {
                completeGallery.push({
                    src: projectData.featured_image,
                    caption: projectData.title + ' - Featured Image'
                });
            }
            
            // Add gallery items if they exist
            if (projectData.gallery) {
                try {
                    const galleryItems = typeof projectData.gallery === 'string' 
                        ? JSON.parse(projectData.gallery) 
                        : projectData.gallery;
                    completeGallery.push(...galleryItems);
                } catch (error) {
                    console.error('Error parsing gallery for lightbox:', error);
                }
            }
            
            openImageLightbox(currentSrc, completeGallery);
        });
        
        // Show content with minimal delay for smooth transition
        setTimeout(function() {
            popup.find('.popup-loading').fadeOut(200, function() {
                popup.find('.popup-body').fadeIn(200);
            });
        }, 300); // Reduced delay for faster loading
    }
    
    /**
     * Close project popup with proper scroll restoration
     */
    function closeProjectPopup() {
        const popup = $('#project-popup');
        const $body = $('body');
        
        // Hide popup
        popup.removeClass('active');
        
        // Restore body scroll and position
        const scrollTop = $body.data('scroll-position') || 0;
        $body.removeClass('popup-open').css({
            'position': '',
            'top': '',
            'width': '',
            'overflow': ''
        });
        
        // Restore scroll position
        $(window).scrollTop(scrollTop);
        
        // Remove focus from popup
        popup.removeAttr('tabindex');
        
        // Reset popup state after transition
        setTimeout(function() {
            popup.hide();
            popup.find('.popup-body').hide();
            popup.find('.popup-loading').show();
        }, 300);
        
        console.log('Project popup closed');    }

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
                    const animationType = $element.data('animation');
                    
                    $element.addClass('animated');
                    $element.addClass(animationType);
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
    
    /**
     * Store all projects data for filtering and load more functionality
     */
    function storeAllProjectsData() {
        allProjectsData = [];
        $('.portfolio-item').each(function(index) {
            const $item = $(this);
            allProjectsData.push({
                element: $item,
                index: index,
                classes: $item.attr('class'),
                visible: index < projectsPerPage
            });
        });
        console.log('Stored project data for', allProjectsData.length, 'projects');
    }
    
    /**
     * Hide projects beyond the specified limit
     */
    function hideProjectsBeyondLimit(limit) {
        $('.portfolio-item').each(function(index) {
            if (index >= limit) {
                $(this).hide().addClass('load-more-hidden');
            } else {
                $(this).show().removeClass('load-more-hidden');
            }
        });
        
        // Update loaded projects count
        loadedProjects = Math.min(limit, totalProjects);
        
        console.log(`Showing ${loadedProjects} of ${totalProjects} projects`);
        updateDebugInfo();
    }
    
    /**
     * Get visible projects based on current filter
     */
    function getVisibleProjectsWithFilter(filter) {
        let visibleProjects = [];
        
        $('.portfolio-item').each(function(index) {
            const $item = $(this);
            let matchesFilter = true;
            
            if (filter !== '*') {
                matchesFilter = $item.hasClass(filter.substring(1)); // Remove the dot
            }
            
            if (matchesFilter) {
                visibleProjects.push({
                    element: $item,
                    index: index,
                    originalIndex: index
                });
            }
        });
        
        return visibleProjects;
    }
    
    /**
     * Apply load more logic to filtered items
     */
    function applyLoadMoreToFilteredItems(filter) {
        const visibleProjects = getVisibleProjectsWithFilter(filter);
        
        // Hide all items first
        $('.portfolio-item').hide().addClass('load-more-hidden');
        
        // Show only the first projectsPerPage items that match the filter
        let showCount = 0;
        visibleProjects.forEach(function(project, index) {
            if (showCount < projectsPerPage) {
                project.element.show().removeClass('load-more-hidden');
                showCount++;
            }
        });
        
        // Update loaded projects count for this filter
        loadedProjects = showCount;
        
        console.log(`Applied load more: showing ${showCount} of ${visibleProjects.length} filtered projects`);
        updateDebugInfo();
    }
    
    /**
     * Debug function to track load more status
     */
    function updateDebugInfo() {
        if (typeof console !== 'undefined' && console.log) {
            const filteredProjects = getVisibleProjectsWithFilter(currentFilter);
            const visibleProjects = $('.portfolio-item:visible:not(.load-more-hidden)').length;
            
            console.log('=== Portfolio Load More Debug ===');
            console.log('Total projects:', totalProjects);
            console.log('Current filter:', currentFilter);
            console.log('Projects matching filter:', filteredProjects.length);
            console.log('Currently visible:', visibleProjects);
            console.log('Loaded projects:', loadedProjects);
            console.log('Projects per page:', projectsPerPage);
            console.log('==================================');
        }    }

    /**
     * Open image in lightbox view
     */
    function openImageLightbox(imageSrc, gallery) {
        // Create lightbox overlay
        const lightbox = $(`
            <div class="image-lightbox">
                <div class="lightbox-overlay"></div>
                <div class="lightbox-container">
                    <img src="${imageSrc}" alt="">
                    <button class="lightbox-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `);
        
        // Add lightbox to body
        $('body').append(lightbox);
        
        // Show lightbox
        setTimeout(() => {
            lightbox.addClass('active');
        }, 10);
        
        // Close lightbox handlers
        lightbox.find('.lightbox-close, .lightbox-overlay').on('click', function() {
            lightbox.removeClass('active');
            setTimeout(() => {
                lightbox.remove();
            }, 300);
        });
        
        // ESC key to close
        $(document).on('keydown.lightbox', function(e) {
            if (e.keyCode === 27) {
                lightbox.find('.lightbox-close').click();
                $(document).off('keydown.lightbox');
            }
        });
    }
    
})(jQuery);