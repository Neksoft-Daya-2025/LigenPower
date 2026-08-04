/**
 * Clean Mobile Menu Handler - No Elementor Dependencies
 * Simple, clean JavaScript for mobile menu toggle
 */

(function() {
    'use strict';

    function initMobileMenu() {
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const closeBtn = document.getElementById('mobile-menu-close');
        const menuPanel = document.getElementById('mobile-menu-panel');
        const body = document.body;

        if (!toggleBtn || !menuPanel) {
            // Elements not found yet
            return;
        }
        
        if (menuInitialized) {
            // Already initialized, don't add listeners again
            console.log('⚠️ Menu already initialized, skipping...');
            return;
        }
        
        menuInitialized = true; // Mark as initialized BEFORE adding listeners

        // Remove any existing listeners by cloning the button
        const newToggleBtn = toggleBtn.cloneNode(true);
        toggleBtn.parentNode.replaceChild(newToggleBtn, toggleBtn);
        const finalToggleBtn = newToggleBtn;

        function openMenu() {
            menuPanel.classList.add('active');
            body.classList.add('mobile-menu-open');
            finalToggleBtn.setAttribute('aria-expanded', 'true');
            // Prevent body scroll
            body.style.overflow = 'hidden';
        }

        function closeMenu() {
            menuPanel.classList.remove('active');
            body.classList.remove('mobile-menu-open');
            finalToggleBtn.setAttribute('aria-expanded', 'false');
            // Restore body scroll
            body.style.overflow = '';
        }

        // Toggle menu on button click
        finalToggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (menuPanel.classList.contains('active')) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        // Close menu on close button click - clone to remove old listeners
        if (closeBtn) {
            const newCloseBtn = closeBtn.cloneNode(true);
            closeBtn.parentNode.replaceChild(newCloseBtn, closeBtn);
            const finalCloseBtn = newCloseBtn;
            
            finalCloseBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeMenu();
            });
        }

        // Close menu when clicking outside menu panel (on menu panel itself when it covers screen)
        menuPanel.addEventListener('click', function(e) {
            // If clicking on the panel background (not on content), close menu
            if (e.target === menuPanel) {
                closeMenu();
            }
        });

        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && menuPanel.classList.contains('active')) {
                closeMenu();
            }
        });

        // Handle mobile menu dropdown toggles (Resources submenu)
        const dropdownToggles = menuPanel.querySelectorAll('.mobile-menu-dropdown-toggle');
        dropdownToggles.forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const parentItem = toggle.closest('.mobile-menu-item-has-children');
                const isExpanded = parentItem.getAttribute('aria-expanded') === 'true';
                
                // Close all other dropdowns
                menuPanel.querySelectorAll('.mobile-menu-item-has-children').forEach(function(item) {
                    if (item !== parentItem) {
                        item.setAttribute('aria-expanded', 'false');
                    }
                });
                
                // Toggle current dropdown
                parentItem.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
            });
        });

        // Close menu when clicking regular menu links (but not dropdown toggles)
        const menuLinks = menuPanel.querySelectorAll('.mobile-menu-nav a');
        menuLinks.forEach(function(link) {
            // Skip if parent is a dropdown toggle (Resources button)
            const parentItem = link.closest('.mobile-menu-item-has-children');
            if (parentItem && parentItem.querySelector('.mobile-menu-dropdown-toggle') !== link) {
                link.addEventListener('click', function() {
                    setTimeout(closeMenu, 100);
                });
            }
        });

        // Handle window resize - close menu on desktop
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth > 1024 && menuPanel.classList.contains('active')) {
                    closeMenu();
                }
            }, 250);
        });

        console.log('✅ Clean mobile menu initialized successfully');
    }

    // Track if already initialized to prevent duplicates
    let menuInitialized = false;
    let retryCount = 0;
    const maxRetries = 100; // Try for 15 seconds (100 * 150ms)

    function initWithRetry() {
        if (menuInitialized) return;
        
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const menuPanel = document.getElementById('mobile-menu-panel');
        
        if (!toggleBtn) {
            if (retryCount === 0 || retryCount % 10 === 0) {
                console.log('⏳ Waiting for mobile-menu-toggle button...', 'Retry:', retryCount);
            }
            return;
        }
        
        if (!menuPanel) {
            if (retryCount === 0 || retryCount % 10 === 0) {
                console.log('⏳ Waiting for mobile-menu-panel...', 'Retry:', retryCount);
            }
            return;
        }
        
        // Both elements found, initialize now
        console.log('✅ Both menu elements found - initializing...');
        initMobileMenu();
        // Note: initMobileMenu() sets menuInitialized = true internally
        console.log('✅ Mobile menu initialization complete');
    }

    // Keep trying until elements are found
    function keepTrying() {
        initWithRetry();
        if (!menuInitialized && retryCount < maxRetries) {
            retryCount++;
            setTimeout(keepTrying, 150);
        } else if (!menuInitialized && retryCount >= maxRetries) {
            console.warn('⚠️ Mobile menu: Could not find elements after', maxRetries, 'attempts');
            const toggleBtn = document.getElementById('mobile-menu-toggle');
            const menuPanel = document.getElementById('mobile-menu-panel');
            console.log('Toggle button found:', !!toggleBtn);
            console.log('Menu panel found:', !!menuPanel);
            if (toggleBtn) console.log('Toggle button element:', toggleBtn);
            if (menuPanel) console.log('Menu panel element:', menuPanel);
        }
    }

    // Start trying when DOM is ready
    console.log('📱 Mobile menu script loaded, starting initialization...');
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            console.log('📱 DOMContentLoaded - starting menu initialization');
            setTimeout(keepTrying, 100);
        });
    } else {
        // DOM already loaded, start trying
        console.log('📱 DOM already loaded - starting menu initialization');
        keepTrying();
    }

    // Listen for header load event (for dynamically loaded headers like index.html)
    document.addEventListener('headerLoaded', function() {
        console.log('📢 headerLoaded event received');
        
        // Check if elements exist - if they do and menu is already initialized, don't re-init
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const menuPanel = document.getElementById('mobile-menu-panel');
        
        if (toggleBtn && menuPanel && menuInitialized) {
            console.log('✅ Menu already initialized with loaded header - skipping re-init');
            return;
        }
        
        // Only reset if elements don't exist or menu isn't initialized
        console.log('🔄 Resetting and retrying initialization...');
        menuInitialized = false; // Reset to allow re-initialization
        retryCount = 0; // Reset retry counter
        setTimeout(function() {
            keepTrying();
        }, 400);
    });

})();