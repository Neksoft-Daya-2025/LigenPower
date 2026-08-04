/**
 * Disable right-click on public frontend pages.
 * Admin/backend pages (dashboard, SMTP tools, etc.) are excluded.
 */
(function () {
    'use strict';

    var path = (window.location.pathname || '').toLowerCase();
    var adminPatterns = [
        /\/dashboard\.html$/,
        /\/configure-and-test-smtp/,
        /\/test-smtp/,
        /\/test-email/,
        /\/test-menu/,
        /\/merchant\//,
        /\/warranty\//
    ];

    for (var i = 0; i < adminPatterns.length; i++) {
        if (adminPatterns[i].test(path)) {
            return;
        }
    }

    document.addEventListener('contextmenu', function (e) {
        e.preventDefault();
    });
})();
