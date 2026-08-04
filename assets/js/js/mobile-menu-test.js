/**
 * Simple Mobile Menu Test - Direct Implementation
 * This is a standalone test to verify mobile menu functionality
 */

(function() {
    'use strict';
    
    // DISABLED - Using permanent push-up menu solution
    return;
    
    console.log('=== MOBILE MENU TEST SCRIPT LOADED ===');
    
    function testMobileMenu() {
        console.log('Testing mobile menu initialization...');
        
        // FIX: Use scoped selector to target ONLY mobile menu button, not social icons
        const toggle = document.querySelector('.elementor-element-780ca1f .etheme-elementor-off-canvas__toggle_button');
        const container = document.querySelector('.etheme-elementor-off-canvas__container');
        
        console.log('Toggle button:', toggle);
        console.log('Container:', container);
        
        if (!toggle || !container) {
            console.warn('Elements not found, will retry...');
            setTimeout(testMobileMenu, 500);
            return;
        }
        
        console.log('✓ Elements found!');
        console.log('Toggle href:', toggle.getAttribute('href'));
        console.log('Toggle onclick:', toggle.onclick);
        console.log('Container classes:', container.className);
        
        // Force attach handler
        toggle.setAttribute('href', '#');
        toggle.style.cursor = 'pointer';
        toggle.style.pointerEvents = 'auto';
        toggle.style.zIndex = '10000';
        
        // Remove any existing handlers by cloning
        const newToggle = toggle.cloneNode(true);
        toggle.parentNode.replaceChild(newToggle, toggle);
        // FIX: Use scoped selector again after cloning
        const freshBtn = document.querySelector('.elementor-element-780ca1f .etheme-elementor-off-canvas__toggle_button');
        
        if (!freshBtn) {
            console.error('Failed to get fresh button');
            return;
        }
        
        freshBtn.setAttribute('href', '#');
        
        // Simple toggle function
        function toggleMenu() {
            const cont = document.querySelector('.etheme-elementor-off-canvas__container');
            const body = document.body;
            
            if (cont.classList.contains('mobile-menu-active')) {
                cont.classList.remove('mobile-menu-active');
                body.classList.remove('mobile-menu-open');
                body.style.overflow = '';
                console.log('Menu CLOSED');
            } else {
                cont.classList.add('mobile-menu-active');
                body.classList.add('mobile-menu-open');
                body.style.overflow = 'hidden';
                console.log('Menu OPENED');
            }
        }
        
        // Attach handler
        freshBtn.onclick = function(e) {
            console.log('BUTTON CLICKED!');
            e.preventDefault();
            e.stopPropagation();
            toggleMenu();
            return false;
        };
        
        freshBtn.addEventListener('click', function(e) {
            console.log('BUTTON CLICKED (listener)!');
            e.preventDefault();
            toggleMenu();
        }, true);
        
        console.log('✓ Handlers attached!');
        console.log('Fresh button onclick:', freshBtn.onclick ? 'SET' : 'NOT SET');
        
        // Test click
        setTimeout(function() {
            console.log('Testing programmatic click...');
            freshBtn.click();
            setTimeout(function() {
                freshBtn.click();
            }, 1000);
        }, 500);
    }
    
    // Try multiple times
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', testMobileMenu);
    } else {
        testMobileMenu();
    }
    
    setTimeout(testMobileMenu, 1000);
    setTimeout(testMobileMenu, 2000);
    setTimeout(testMobileMenu, 3000);
    
    window.testMobileMenu = testMobileMenu;
    console.log('Test function available: window.testMobileMenu()');
    
})();



