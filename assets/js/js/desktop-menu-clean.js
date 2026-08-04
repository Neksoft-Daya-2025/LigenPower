/**
 * Clean Desktop Menu - Dropdown Functionality
 * No Elementor Dependencies
 */
(function() {
    'use strict';

    let menuInitialized = false;
    let retryCount = 0;
    const maxRetries = 50; // Try for 5 seconds (50 * 100ms)

    function initDesktopMenu() {
        // Find all menu items with dropdowns
        const menuItems = document.querySelectorAll('.desktop-menu-item-has-children');
        
        if (menuItems.length === 0) {
            retryCount++;
            if (retryCount < maxRetries) {
                // Retry after short delay if elements aren't ready
                setTimeout(initDesktopMenu, 100);
                if (retryCount % 10 === 0) {
                    console.log('⏳ Desktop menu: Waiting for menu elements...', 'Retry:', retryCount);
                }
            } else {
                console.warn('⚠️ Desktop menu: Could not find menu elements after', maxRetries, 'attempts');
            }
            return;
        }

        // Prevent double initialization
        if (menuInitialized) {
            console.log('⚠️ Desktop menu already initialized, skipping...');
            return;
        }

        menuInitialized = true;
        retryCount = 0; // Reset retry count on success

        console.log('✅ Desktop menu: Found', menuItems.length, 'dropdown menu items');

        menuItems.forEach(function(item, index) {
            const button = item.querySelector('.desktop-menu-link');
            const dropdown = item.querySelector('.desktop-menu-dropdown');
            
            if (!button || !dropdown) {
                console.warn('⚠️ Desktop menu: Missing button or dropdown for item', index);
                return;
            }

            // Clone button to remove any existing listeners
            const newButton = button.cloneNode(true);
            button.parentNode.replaceChild(newButton, button);
            const finalButton = newButton;

            console.log('✅ Desktop menu: Initializing dropdown', index, '-', finalButton.textContent.trim());

            // Toggle dropdown on button click
            finalButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const isExpanded = item.getAttribute('aria-expanded') === 'true';
                
                console.log('🖱️ Desktop menu: Clicked', finalButton.textContent.trim(), '- Currently:', isExpanded ? 'OPEN' : 'CLOSED');
                
                // Close all other dropdowns
                menuItems.forEach(function(otherItem) {
                    if (otherItem !== item) {
                        otherItem.setAttribute('aria-expanded', 'false');
                        const otherButton = otherItem.querySelector('.desktop-menu-link');
                        if (otherButton) {
                            otherButton.setAttribute('aria-expanded', 'false');
                        }
                    }
                });
                
                // Toggle current dropdown
                if (isExpanded) {
                    item.setAttribute('aria-expanded', 'false');
                    finalButton.setAttribute('aria-expanded', 'false');
                    console.log('⬇️ Desktop menu: Closing dropdown');
                } else {
                    item.setAttribute('aria-expanded', 'true');
                    finalButton.setAttribute('aria-expanded', 'true');
                    console.log('⬆️ Desktop menu: Opening dropdown');
                }
            });
        });

        // Close dropdowns when clicking outside (only add once)
        if (!window.desktopMenuOutsideClickAdded) {
            window.desktopMenuOutsideClickAdded = true;
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.desktop-menu-item-has-children')) {
                    const allMenuItems = document.querySelectorAll('.desktop-menu-item-has-children');
                    allMenuItems.forEach(function(item) {
                        item.setAttribute('aria-expanded', 'false');
                        const button = item.querySelector('.desktop-menu-link');
                        if (button) {
                            button.setAttribute('aria-expanded', 'false');
                        }
                    });
                }
            });
        }

        // Close dropdowns on Escape key (only add once)
        if (!window.desktopMenuEscapeAdded) {
            window.desktopMenuEscapeAdded = true;
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const allMenuItems = document.querySelectorAll('.desktop-menu-item-has-children');
                    allMenuItems.forEach(function(item) {
                        item.setAttribute('aria-expanded', 'false');
                        const button = item.querySelector('.desktop-menu-link');
                        if (button) {
                            button.setAttribute('aria-expanded', 'false');
                        }
                    });
                }
            });
        }

        console.log('✅ Clean Desktop Menu initialized successfully');
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            console.log('📱 Desktop menu: DOMContentLoaded - starting initialization');
            setTimeout(initDesktopMenu, 100);
        });
    } else {
        console.log('📱 Desktop menu: DOM already loaded - starting initialization');
        initDesktopMenu();
    }

    // Also initialize after header is loaded (for dynamically loaded headers)
    document.addEventListener('headerLoaded', function() {
        console.log('📢 Desktop menu: headerLoaded event received - reinitializing...');
        menuInitialized = false; // Reset to allow re-initialization
        retryCount = 0; // Reset retry count
        setTimeout(initDesktopMenu, 300);
    });

})();
