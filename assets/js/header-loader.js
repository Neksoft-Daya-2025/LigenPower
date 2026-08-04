/**
 * Universal Header Loader
 * Loads header dynamically and dispatches event for mobile-menu-clean.js
 */

(function() {
    'use strict';

    var DEFAULT_ANNOUNCEMENT = 'Beat the Heat with Ligen Power Grid / Solar Inverters';
    var STALE_ANNOUNCEMENT_MARKERS = ['Republic Day', 'Jai Hind', '77 Years of Indian Democracy'];

    function isStaleAnnouncementText(text) {
        if (!text) return true;
        for (var i = 0; i < STALE_ANNOUNCEMENT_MARKERS.length; i++) {
            if (text.indexOf(STALE_ANNOUNCEMENT_MARKERS[i]) !== -1) return true;
        }
        return false;
    }

    function loadSiteAnnouncement() {
        var el = document.getElementById('announcement-marquee');
        if (!el) return;

        fetch('/api/get-announcement.php?_=' + Date.now(), { cache: 'no-store' })
            .then(function(r) {
                if (!r.ok) throw new Error('announcement fetch failed');
                return r.json();
            })
            .then(function(d) {
                var text = (d && d.success && d.text) ? String(d.text).trim() : '';
                if (!text) throw new Error('empty announcement');
                el.textContent = text;
                try { localStorage.setItem('announcement_text', text); } catch (e) {}
            })
            .catch(function() {
                var cached = '';
                try { cached = localStorage.getItem('announcement_text') || ''; } catch (e) {}
                if (cached && !isStaleAnnouncementText(cached)) {
                    el.textContent = cached;
                    return;
                }
                el.textContent = DEFAULT_ANNOUNCEMENT;
                try { localStorage.setItem('announcement_text', DEFAULT_ANNOUNCEMENT); } catch (e) {}
            });
    }

    function getSiteRoot() {
        var path = window.location.pathname || '';
        if (/\/blog\/[^/]+(?:\.html)?\/?$/i.test(path)) return '/';
        var idx = path.lastIndexOf('/');
        return idx >= 0 ? path.substring(0, idx + 1) : '/';
    }

    // --- LOAD HEADER & FOOTER ---
    async function loadHeaderFooter() {
        try {
            var siteRoot = getSiteRoot();
            // Check if header is already present (to avoid double loading)
            const headerPlaceholder = document.getElementById('header-placeholder');
            const existingHeader = document.querySelector('header.elementor-2530');
            
            if (!existingHeader && headerPlaceholder) {
                const headerResponse = await fetch(siteRoot + 'partials/header.html?v=2.8');
                if (headerResponse.ok) {
                    const headerContent = await headerResponse.text();
                    
                    // A. Parse HTML
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = headerContent;
                    
                    // B. Extract scripts (remove them from HTML so they don't run prematurely)
                    const scripts = Array.from(tempDiv.querySelectorAll('script'));
                    scripts.forEach(script => script.remove());
                    
                    // C. INSERT HTML NOW (Critical: Must happen before scripts run)
                    headerPlaceholder.outerHTML = tempDiv.innerHTML;
                    
                    // D. Execute scripts safely
                    for (const oldScript of scripts) {
                        const newScript = document.createElement('script');
                        Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value));
                        newScript.textContent = oldScript.textContent;
                        document.body.appendChild(newScript);
                    }

                    loadSiteAnnouncement();

                    // F. Dispatch headerLoaded event for mobile-menu-clean.js
                    setTimeout(function() {
                        document.dispatchEvent(new CustomEvent('headerLoaded'));
                        console.log('✅ Header loaded, headerLoaded event dispatched');
                    }, 400);
                }
            } else if (existingHeader) {
                loadSiteAnnouncement();
                setTimeout(function() {
                    document.dispatchEvent(new CustomEvent('headerLoaded'));
                    console.log('✅ Header already exists, headerLoaded event dispatched');
                }, 200);
            }

            // Load Footer
            const footerPlaceholder = document.getElementById('footer-placeholder');
            if (footerPlaceholder) {
                const footerResponse = await fetch(siteRoot + 'partials/footer.html');
                if (footerResponse.ok) {
                    footerPlaceholder.outerHTML = await footerResponse.text();
                }
            }
            
            // Load Search Script if missing
            if (!document.querySelector('script[src*="search.js"]')) {
                const searchScript = document.createElement('script');
                searchScript.src = siteRoot + 'assets/js/search.js';
                document.body.appendChild(searchScript);
            }

            // Disable right-click on frontend (not loaded on dashboard/admin pages)
            if (!document.querySelector('script[src*="disable-context-menu.js"]')) {
                const contextMenuScript = document.createElement('script');
                contextMenuScript.src = siteRoot + 'assets/js/disable-context-menu.js';
                document.body.appendChild(contextMenuScript);
            }
            
        } catch (error) {
            console.error('Error loading partials:', error);
        }
        ensureImageAlts();
    }

    function humanizeImageSrc(src) {
        if (!src || src.indexOf('data:') === 0) return 'Ligen Power image';
        var name = src.split('?')[0].split('/').pop().replace(/\.[^.]+$/, '');
        name = name.replace(/[-_]+/g, ' ').replace(/\s+/g, ' ').trim();
        if (!name || /^image post/i.test(name)) return 'Ligen Power image';
        if (name.toLowerCase().indexOf('ligen') === -1) return 'Ligen Power ' + name;
        return name;
    }

    function ensureImageAlts(root) {
        var scope = root || document;
        scope.querySelectorAll('img').forEach(function(img) {
            var alt = (img.getAttribute('alt') || '').trim();
            if (!alt) {
                img.setAttribute('alt', humanizeImageSrc(img.getAttribute('src') || ''));
            }
        });
    }

    window.ensureImageAlts = ensureImageAlts;

    // Run on load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            ensureImageAlts();
            loadHeaderFooter();
        });
    } else {
        ensureImageAlts();
        loadHeaderFooter();
    }

})();
