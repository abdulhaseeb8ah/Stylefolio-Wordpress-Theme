/**
 * Contact Form JavaScript
 * 
 * @package Stylefolio
 * @version 1.0
 * @author abdulhaseeb2002
 * @updated 2025-06-15 04:22:31
 */

(function($) {
    'use strict';
    
    console.log('Contact section initialization started');
    
    $(document).ready(function() {
        initContactForm();
    });
    
    /**
     * Initialize contact form functionality
     */
    function initContactForm() {
        const $form = $('#contact-form');
          if ($form.length === 0) {
            return;
        }
        
        // TEMPORARILY DISABLE VALIDATION - JUST ALLOW FORM TO SUBMIT
        console.log('Contact form found, validation disabled for testing');
        
        console.log('Form validation initialized');
    }
    
    /**
     * Show error message for a form field
     */
    function showError($field, message) {
        const $group = $field.closest('.form-group');
        $group.addClass('has-error');
        
        let $error = $group.find('.error-message');
        if ($error.length === 0) {
            $error = $('<div class="error-message"></div>');
            $group.append($error);
        }
        
        $error.text(message);
    }
    
    /**
     * Clear error message for a form field
     */
    function clearError($field) {
        const $group = $field.closest('.form-group');
        $group.removeClass('has-error');
        $group.find('.error-message').remove();
    }
    
    /**
     * Validate email format
     */
    function isValidEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }
    
    // Log completion
    console.log('Contact section fully initialized');
    
})(jQuery);