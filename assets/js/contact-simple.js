/**
 * Simplified Contact Form JavaScript
 * 
 * @package Stylefolio
 * @version 2.1
 * @author abdulhaseeb2002
 * @updated 2025-06-15
 */

(function($) {
    'use strict';
    
    console.log('Simple contact form initialization started');
    
    $(document).ready(function() {
        initSimpleContactForm();
        initFormAnimations();
    });
    
    /**
     * Initialize simple contact form functionality
     */
    function initSimpleContactForm() {
        const $form = $('#contact-form');
        
        if ($form.length === 0) {
            console.log('Contact form not found');
            return;
        }
        
        console.log('Contact form found, initializing...');
        
        // Simple form submission handler - just add visual feedback
        $form.on('submit', function(e) {
            console.log('Form submission detected');
            
            const $submitBtn = $(this).find('.submit-button');
            const $btnText = $submitBtn.find('.btn-text');
            
            if ($submitBtn.length && $btnText.length) {
                // Add loading state
                $submitBtn.addClass('loading').prop('disabled', true);
                $btnText.text('Sending...');
                console.log('Loading state applied');
            }
            
            // Let the form submit normally - DO NOT prevent default
            return true;
        });
        
        console.log('Simple contact form initialized');
    }
    
    /**
     * Initialize form animations and interactions
     */
    function initFormAnimations() {
        const $inputs = $('.contact-form input, .contact-form textarea');
        
        if ($inputs.length === 0) {
            return;
        }
        
        // Enhanced focus/blur animations
        $inputs.on('focus', function() {
            const $group = $(this).closest('.form-group');
            $group.addClass('focused');
            $(this).parent().addClass('input-focused');
        });
        
        $inputs.on('blur', function() {
            const $group = $(this).closest('.form-group');
            const $input = $(this);
            
            $group.removeClass('focused');
            $(this).parent().removeClass('input-focused');
            
            // Add filled state for non-empty inputs
            if ($input.val().trim() !== '') {
                $group.addClass('filled');
            } else {
                $group.removeClass('filled');
            }
        });
        
        // Initial state check
        $inputs.each(function() {
            const $input = $(this);
            const $group = $input.closest('.form-group');
            
            if ($input.val().trim() !== '') {
                $group.addClass('filled');
            }
        });
        
        // Submit button hover effects
        $('.submit-button').on('mouseenter', function() {
            $(this).addClass('btn-hover');
        }).on('mouseleave', function() {
            $(this).removeClass('btn-hover');
        });
        
        console.log('Form animations initialized');
    }
    
    // Log completion
    console.log('Simple contact form script loaded');
    
})(jQuery);
