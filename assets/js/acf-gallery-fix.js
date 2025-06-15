/**
 * ACF Gallery Field Fix
 * 
 * @author abdulhaseeb2002
 * @updated 2025-06-14 16:17:19
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        console.log('ACF Gallery Fix: Initializing');
        fixGalleryFields();
        
        // Also try after a slight delay
        setTimeout(fixGalleryFields, 500);
    });
    
    /**
     * Fix gallery field initialization
     */
    function fixGalleryFields() {
        // Target any gallery fields that are on the page
        $('.acf-field-gallery').each(function() {
            const $field = $(this);
            const fieldKey = $field.attr('data-key');
            
            console.log('Found gallery field:', fieldKey);
            
            // Check if the field appears initialized
            const $content = $field.find('.acf-gallery-content');
            const $toolbar = $field.find('.acf-gallery-toolbar');
            
            if ($content.length === 0 || $toolbar.length === 0) {
                console.log('Gallery field needs fixing:', fieldKey);
                
                // Try to force refresh the field
                $field.hide().show();
                
                // If toolbar is still missing, add a custom one
                setTimeout(function() {
                    if ($field.find('.acf-gallery-toolbar').length === 0) {
                        console.log('Adding custom toolbar for gallery field:', fieldKey);
                        
                        // Create a basic toolbar with an add button
                        const $customToolbar = $('<div class="acf-gallery-toolbar"><a href="#" class="acf-button button button-primary add-to-gallery">+ Add Images</a></div>');
                        $field.append($customToolbar);
                        
                        // Handle click on the add button
                        $customToolbar.find('.add-to-gallery').on('click', function(e) {
                            e.preventDefault();
                            
                            // Open the media library
                            const frame = wp.media({
                                title: 'Select Images',
                                multiple: true,
                                library: { type: 'image' },
                                button: { text: 'Add to Gallery' }
                            });
                            
                            frame.on('select', function() {
                                const attachments = frame.state().get('selection').toJSON();
                                console.log('Selected attachments:', attachments.length);
                                
                                // Create a container for the images if it doesn't exist
                                let $container = $field.find('.acf-gallery-attachments');
                                if ($container.length === 0) {
                                    $container = $('<div class="acf-gallery-attachments"></div>');
                                    $field.prepend($container);
                                }
                                
                                // Add the selected images to the container
                                attachments.forEach(function(attachment) {
                                    const $image = $('<div class="acf-gallery-attachment" data-id="' + attachment.id + '">' +
                                        '<input type="hidden" name="' + fieldKey + '[]" value="' + attachment.id + '">' +
                                        '<div class="thumbnail"><img src="' + attachment.url + '"></div>' +
                                        '</div>');
                                    $container.append($image);
                                });
                                
                                // Alert the user
                                alert('Added ' + attachments.length + ' images to the gallery. Please save the post to finalize changes.');
                            });
                            
                            frame.open();
                        });
                    }
                }, 300);
            }
        });
    }
    
})(jQuery);