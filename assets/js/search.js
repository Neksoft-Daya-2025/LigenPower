// Product Search Database
const searchDatabase = {
    products: [
        // Grid Inverters
        { name: 'Ligen Power®- 5000', category: 'Grid Inverters', url: 'ligen-power-5000', keywords: ['grid', 'inverter', '5000', '5000w', 'power', 'backup', 'ups'] },
        { name: 'LIGEN-INV3500 - 48VDC', category: 'Grid Inverters', url: 'ligen-power-3500', keywords: ['grid', 'inverter', '3500', '3500w', '48v', '48vdc', 'power', 'backup', 'ups'] },
        { name: 'LIGEN-INV2000 - 24VDC', category: 'Grid Inverters', url: 'ligen-inv2000-24vdc', keywords: ['grid', 'inverter', '2000', '2000w', '24v', '24vdc', 'power', 'backup', 'ups'] },
        { name: 'Ligen Power®- 1500', category: 'Grid Inverters', url: 'ligen-power-1500', keywords: ['grid', 'inverter', '1500', '1500w', '1500va', 'power', 'backup', 'ups'] },
        { name: 'Ligen Power®- 1000', category: 'Grid Inverters', url: 'ligen-power-1000', keywords: ['grid', 'inverter', '1000', '1000w', '1000va', 'power', 'backup', 'ups'] },
        { name: 'Ligen Power®- 850', category: 'Grid Inverters', url: 'ligen-power-850', keywords: ['grid', 'inverter', '850', '850w', '850va', 'power', 'backup', 'ups'] },
        { name: 'Ligen Power®- 600', category: 'Grid Inverters', url: 'ligen-power-600s', keywords: ['grid', 'inverter', '600', '600w', '600va', 'power', 'backup', 'ups'] },
        { name: 'Ligen Power®- 300', category: 'Grid Inverters', url: 'ligen-power-300', keywords: ['grid', 'inverter', '300', '300w', '300va', 'power', 'backup', 'ups'] },
        
        // Solar Inverters
        { name: 'LIGEN-INV5000 – 96 VDC', category: 'Solar Inverters', url: 'ligen-inv5000-96vdc', keywords: ['solar', 'inverter', '5000', '5000w', '5000va', '96v', '96vdc', 'pcu', 'mppt', 'charge', 'controller'] },
        { name: 'LIGEN-INV5000 - 48VDC', category: 'Solar Inverters', url: 'ligen-inv5000-48vdc', keywords: ['solar', 'inverter', '5000', '5000w', '5000va', '48v', '48vdc', 'pcu', 'mppt', 'charge', 'controller'] },
        { name: 'LIGEN-INV3500 - 48VDC', category: 'Solar Inverters', url: 'ligen-power-3500', keywords: ['solar', 'inverter', '3500', '3500w', '3500va', '48v', '48vdc', 'pcu', 'mppt', 'charge', 'controller'] },
        { name: 'LIGEN-INV2000 - 24VDC', category: 'Solar Inverters', url: 'ligen-inv2000-24vdc', keywords: ['solar', 'inverter', '2000', '2000w', '2000va', '24v', '24vdc', 'pcu', 'mppt', 'charge', 'controller'] },
        { name: 'Ligen Power® PWM PCU -2000VA', category: 'Solar Inverters', url: 'ligen-inv2000-pwm', keywords: ['solar', 'inverter', 'pwm', 'pcu', '2000', '2000va', '2000w', 'charge', 'controller', 'solar', 'charge'] },
        { name: 'Ligen Power® PWM PCU -1500VA', category: 'Solar Inverters', url: 'ligen-rrv1500-pwm', keywords: ['solar', 'inverter', 'pwm', 'pcu', '1500', '1500va', '1500w', 'charge', 'controller', 'solar', 'charge'] },
        { name: 'Ligen Power® PWM PCU -1000VA', category: 'Solar Inverters', url: 'ligen-inv1000-pwm', keywords: ['solar', 'inverter', 'pwm', 'pcu', '1000', '1000va', '1000w', 'charge', 'controller', 'solar', 'charge'] },
        { name: 'Ligen Power® PWM PCU -850VA', category: 'Solar Inverters', url: 'ligen-inv850-pwm', keywords: ['solar', 'inverter', 'pwm', 'pcu', '850', '850va', '850w', 'charge', 'controller', 'solar', 'charge'] },
        { name: 'Ligen Power® PWM PCU -600VA', category: 'Solar Inverters', url: 'ligen-inv600-pwm', keywords: ['solar', 'inverter', 'pwm', 'pcu', '600', '600va', '600w', 'charge', 'controller', 'solar', 'charge'] },
        { name: 'Ligen Power® PWM PCU -300VA', category: 'Solar Inverters', url: 'ligen-inv300-pwm', keywords: ['solar', 'inverter', 'pwm', 'pcu', '300', '300va', '300w', 'charge', 'controller', 'solar', 'charge'] },
        
        // BMS
        { name: 'BMS Overview', category: 'BMS', url: 'bms', keywords: ['bms', 'battery', 'management', 'system', 'overview', 'protection', 'monitoring'] },
        { name: 'BMS 16S', category: 'BMS', url: 'bms-16s', keywords: ['bms', 'battery', 'management', 'system', '16s', '16 cell', '16 series'] },
        { name: 'BMS 12S', category: 'BMS', url: 'bms-12s', keywords: ['bms', 'battery', 'management', 'system', '12s', '12 cell', '12 series'] },
        { name: 'BMS 10S', category: 'BMS', url: 'bms-10s', keywords: ['bms', 'battery', 'management', 'system', '10s', '10 cell', '10 series'] },
        { name: 'BMS 8S', category: 'BMS', url: 'bms-8s', keywords: ['bms', 'battery', 'management', 'system', '8s', '8 cell', '8 series'] },
        { name: 'BMS 4S', category: 'BMS', url: 'bms-4s', keywords: ['bms', 'battery', 'management', 'system', '4s', '4 cell', '4 series'] },
        { name: 'BMS 3S', category: 'BMS', url: 'bms-3s', keywords: ['bms', 'battery', 'management', 'system', '3s', '3 cell', '3 series'] },
        { name: 'BMS 2S', category: 'BMS', url: 'bms-2s', keywords: ['bms', 'battery', 'management', 'system', '2s', '2 cell', '2 series'] },
        { name: 'BMS 1S', category: 'BMS', url: 'bms-1s', keywords: ['bms', 'battery', 'management', 'system', '1s', '1 cell', 'single', 'cell'] },
        
        // Power Batteries
        { name: 'Power Battery Overview', category: 'Power Batteries', url: 'power-battery', keywords: ['battery', 'power', 'overview', 'lfp', 'lithium', 'iron', 'phosphate', 'energy', 'storage'] },
        { name: '240V 100Ah LFP Battery Bank', category: 'Power Batteries', url: 'battery-bank', keywords: ['battery', 'bank', '240v', '100ah', '24kwh', 'lfp', 'industrial', 'rack', 'storage', 'ess'] },
        { name: '12V 100Ah LFP Battery', category: 'Power Batteries', url: '12v-100ah-lfp-battery', keywords: ['battery', '12v', '100ah', 'lfp', 'lithium', 'iron', 'phosphate', 'power', 'energy', 'storage'] },
        { name: '48V LFP Batteries', category: 'Power Batteries', url: '48v-lfp-batteries', keywords: ['battery', '48v', 'lfp', 'lithium', 'iron', 'phosphate', 'power', 'energy', 'storage', '50ah'] },
        { name: '36V 15Ah LFP Battery', category: 'Power Batteries', url: '36v-15ah-lfp-battery', keywords: ['battery', '36v', '15ah', 'lfp', 'lithium', 'iron', 'phosphate', 'power', 'energy', 'storage'] },
        
        
        // Solar Street Light
        { name: '48W Hybrid Solar Street Light', category: 'Solar Street Light', url: '48w-hybrid-solar-street-light', keywords: ['solar', 'street', 'light', '48w', 'hybrid', 'led', 'lighting', 'lamp', 'outdoor'] },
        { name: '24W Hybrid Solar Street Light', category: 'Solar Street Light', url: '24w-hybrid-solar-street-light', keywords: ['solar', 'street', 'light', '24w', 'hybrid', 'led', 'lighting', 'lamp', 'outdoor'] }
    ],
    categories: [
        { name: 'Grid Inverters', url: 'power-inverter', keywords: ['grid', 'inverter', 'power', 'backup', 'ups'] },
        { name: 'Solar Inverters', url: 'solar-inverter', keywords: ['solar', 'inverter', 'pcu', 'mppt', 'pwm', 'solar power'] },
        { name: 'BMS', url: 'bms', keywords: ['bms', 'battery', 'management', 'system', 'protection'] },
        { name: 'Power Batteries', url: 'power-battery', keywords: ['battery', 'power', 'lfp', 'lithium', 'iron', 'phosphate'] },
        { name: 'Mobility Solutions', url: 'mobility', keywords: ['mobility', 'transport', 'two wheeler', 'three wheeler', 'e-rickshaw', 'ev battery', 'lfp pack'] },
        { name: '48V 30Ah Two-Wheeler LFP Pack', category: 'Mobility', url: 'mobility#two-wheeler-packs', keywords: ['48v', '30ah', 'two wheeler', '2w', 'scooter', 'lfp', 'battery pack'] },
        { name: '48V 100Ah E-Rickshaw LFP Pack', category: 'Mobility', url: 'mobility#three-wheeler-packs', keywords: ['48v', '100ah', 'three wheeler', 'e-rickshaw', 'rikshaw', '3w', 'lfp'] },
        { name: 'Solar Street Light', url: 'solar-street-light', keywords: ['solar', 'street', 'light', 'led', 'lighting', 'hybrid'] }
    ]
};

// Search function
function performSearch(query) {
    if (!query || query.trim().length < 2) {
        return { products: [], categories: [] };
    }
    
    const searchTerm = query.toLowerCase().trim();
    const results = {
        products: [],
        categories: []
    };
    
    // Search products
    searchDatabase.products.forEach(product => {
        const nameMatch = product.name.toLowerCase().includes(searchTerm);
        const categoryMatch = product.category.toLowerCase().includes(searchTerm);
        const keywordMatch = product.keywords.some(keyword => keyword.includes(searchTerm));
        
        if (nameMatch || categoryMatch || keywordMatch) {
            results.products.push(product);
        }
    });
    
    // Search categories
    searchDatabase.categories.forEach(category => {
        const nameMatch = category.name.toLowerCase().includes(searchTerm);
        const keywordMatch = category.keywords.some(keyword => keyword.includes(searchTerm));
        
        if (nameMatch || keywordMatch) {
            results.categories.push(category);
        }
    });
    
    return results;
}

// Display search results
function displaySearchResults(results, container) {
    if (!container) return;
    
    container.innerHTML = '';
    
    if (results.products.length === 0 && results.categories.length === 0) {
        container.innerHTML = '<div class="search-no-results">No results found</div>';
        return;
    }
    
    let html = '';
    
    // Display categories first
    if (results.categories.length > 0) {
        html += '<div class="search-section"><h3 class="search-section-title">Categories</h3><div class="search-results-grid">';
        results.categories.forEach(category => {
            html += `
                <a href="${category.url}" class="search-result-item search-category-item">
                    <div class="search-result-content">
                        <h4>${category.name}</h4>
                        <span class="search-result-type">Category</span>
                    </div>
                </a>
            `;
        });
        html += '</div></div>';
    }
    
    // Display products
    if (results.products.length > 0) {
        html += '<div class="search-section"><h3 class="search-section-title">Products</h3><div class="search-results-grid">';
        results.products.forEach(product => {
            html += `
                <a href="${product.url}" class="search-result-item search-product-item">
                    <div class="search-result-content">
                        <h4>${product.name}</h4>
                        <span class="search-result-category">${product.category}</span>
                    </div>
                </a>
            `;
        });
        html += '</div></div>';
    }
    
    container.innerHTML = html;
}

// Initialize search functionality
(function() {
    'use strict';
    
    function initSearch() {
        // Try multiple selectors to find the search input
        let searchInput = document.querySelector('.etheme-search-form-input[type="search"]');
        if (!searchInput) {
            searchInput = document.querySelector('input.etheme-search-form-input[type="search"]');
        }
        if (!searchInput) {
            searchInput = document.querySelector('form.etheme-search-form input[type="search"]');
        }
        
        const searchForm = document.querySelector('.etheme-search-form');
        const ajaxResults = document.querySelector('.etheme-search-ajax-results');
        
        console.log('Search initialization - searchInput found:', !!searchInput);
        console.log('Search initialization - searchForm found:', !!searchForm);
        console.log('Search initialization - ajaxResults found:', !!ajaxResults);
        
        if (!searchInput) {
            console.error('Search input not found. Available inputs:', document.querySelectorAll('input[type="search"]'));
            return;
        }
        
        if (searchInput) {
            console.log('Search input element:', searchInput);
            console.log('Search input disabled:', searchInput.disabled);
            console.log('Search input readonly:', searchInput.readOnly);
            console.log('Search input style:', window.getComputedStyle(searchInput).pointerEvents);
            console.log('Search input z-index:', window.getComputedStyle(searchInput).zIndex);
        }
        
        let searchTimeout;
        let isSearching = false;
        
        // Remove any placeholder spans that might be blocking
        const placeholderSpan = document.querySelector('.etheme-search-input-placeholder');
        if (placeholderSpan) {
            console.log('Removing placeholder span that was blocking input');
            placeholderSpan.remove();
        }
        
        // Force input to be on top and clickable - use setProperty for important
        searchInput.style.setProperty('z-index', '999', 'important');
        searchInput.style.setProperty('pointer-events', 'auto', 'important');
        searchInput.style.setProperty('position', 'relative', 'important');
        searchInput.style.setProperty('background', 'transparent', 'important');
        searchInput.style.setProperty('width', '100%', 'important');
        searchInput.style.setProperty('min-height', '46px', 'important');
        searchInput.style.setProperty('padding', '12px 15px', 'important');
        searchInput.style.setProperty('cursor', 'text', 'important');
        
        // Make sure input is not disabled or readonly
        searchInput.removeAttribute('disabled');
        searchInput.removeAttribute('readonly');
        searchInput.setAttribute('tabindex', '0');
        
        // Check for any overlaying elements
        const inputWrapper = searchInput.closest('.etheme-search-input-wrapper');
        if (inputWrapper) {
            const wrapperStyle = window.getComputedStyle(inputWrapper);
            console.log('Input wrapper pointer-events:', wrapperStyle.pointerEvents);
            console.log('Input wrapper position:', wrapperStyle.position);
            
            // Make sure wrapper doesn't block
            inputWrapper.style.setProperty('position', 'relative', 'important');
            
            // Handle clicking on the input wrapper - focus input when clicking anywhere
            inputWrapper.addEventListener('click', function(e) {
                console.log('Input wrapper clicked, focusing input. Target:', e.target.tagName, e.target.className);
                // Always focus the input
                searchInput.focus();
            }, false);
            
            // Also handle mousedown
            inputWrapper.addEventListener('mousedown', function(e) {
                console.log('Input wrapper mousedown');
                searchInput.focus();
            }, false);
        }
        
        // Add direct click handler to input
        searchInput.addEventListener('click', function(e) {
            console.log('Input directly clicked');
            e.stopPropagation();
            searchInput.focus();
        }, true);
        
        // Add direct focus handler to input
        searchInput.addEventListener('focus', function(e) {
            console.log('Input focused');
        });
        
        searchInput.addEventListener('blur', function(e) {
            console.log('Input blurred');
        });
        
        // Make sure input can receive keyboard input
        searchInput.addEventListener('keydown', function(e) {
            console.log('Key pressed:', e.key, 'Value:', searchInput.value);
        });
        
        searchInput.addEventListener('keyup', function(e) {
            console.log('Key released:', e.key, 'Value:', searchInput.value);
        });
        
        // Create results container if it doesn't exist
        let resultsContainer = document.querySelector('.custom-search-results');
        if (!resultsContainer) {
            resultsContainer = document.createElement('div');
            resultsContainer.className = 'custom-search-results';
            resultsContainer.style.display = 'none';
            const formWrapper = searchInput.closest('.etheme-search-input-form-wrapper');
            if (formWrapper) {
                formWrapper.style.position = 'relative';
                formWrapper.appendChild(resultsContainer);
                console.log('Results container created and appended to formWrapper');
            } else if (ajaxResults) {
                ajaxResults.appendChild(resultsContainer);
                console.log('Results container created and appended to ajaxResults');
            } else {
                // Fallback: append to input wrapper
                const inputWrapper = searchInput.closest('.etheme-search-input-wrapper');
                if (inputWrapper && inputWrapper.parentElement) {
                    inputWrapper.parentElement.style.position = 'relative';
                    inputWrapper.parentElement.appendChild(resultsContainer);
                    console.log('Results container created and appended to inputWrapper parent');
                } else {
                    console.error('Could not find suitable container for search results');
                }
            }
        } else {
            console.log('Results container already exists');
        }
        
        // Handle input focus
        searchInput.addEventListener('focus', function() {
            console.log('Input focused');
        });
        
        // Handle input blur
        searchInput.addEventListener('blur', function() {
            // Delay to allow click events on results
        });
        
        // Handle input - single event listener for search functionality
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value;
            console.log('Input changed:', query);
            
            clearTimeout(searchTimeout);
            
            if (query.length < 2) {
                resultsContainer.innerHTML = '';
                resultsContainer.style.display = 'none';
                return;
            }
            
            searchTimeout = setTimeout(() => {
                const results = performSearch(query);
                console.log('Search results:', results);
                console.log('Results container:', resultsContainer);
                console.log('Products found:', results.products.length);
                console.log('Categories found:', results.categories.length);
                
                if (results.products.length > 0 || results.categories.length > 0) {
                    displaySearchResults(results, resultsContainer);
                    resultsContainer.style.display = 'block';
                    console.log('Results displayed, container display:', resultsContainer.style.display);
                } else {
                    resultsContainer.innerHTML = '<div class="search-no-results">No results found</div>';
                    resultsContainer.style.display = 'block';
                }
            }, 300);
        });
        
        // Handle form submission
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const query = searchInput.value.trim();
                console.log('Form submitted with query:', query);
                
                if (query.length >= 2) {
                    const results = performSearch(query);
                    if (results.products.length > 0 || results.categories.length > 0) {
                        // Redirect to first result or create a search results page
                        if (results.categories.length > 0) {
                            window.location.href = results.categories[0].url;
                        } else if (results.products.length > 0) {
                            window.location.href = results.products[0].url;
                        }
                    }
                }
            });
        }
        
        // Hide results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && 
                !resultsContainer.contains(e.target)) {
                resultsContainer.style.display = 'none';
            }
        });
        
        console.log('Search functionality initialized successfully');
    }
    
    // Try to initialize immediately if DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSearch);
    } else {
        // DOM is already ready
        initSearch();
    }
    
    // Also try after a short delay in case elements are loaded dynamically
    setTimeout(initSearch, 500);
})();

