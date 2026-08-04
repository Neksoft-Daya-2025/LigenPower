/**
 * Blog URL helpers — slug-based paths like /blog/your-post-title
 */
(function (window) {
    'use strict';

    function slugifyTitle(title) {
        return (title || '')
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    function postUrl(post) {
        return prettyPostUrl(post);
    }

    function prettyPostUrl(post) {
        var slug = (post && post.slug) ? String(post.slug).trim() : slugifyTitle(post && post.title);
        if (!slug) slug = 'post';
        return 'blog/' + slug;
    }

    function getSlugFromLocation() {
        var path = window.location.pathname || '';
        var match = path.match(/\/blog\/([^/]+?)(?:\.html)?\/?$/i);
        if (match) return decodeURIComponent(match[1]);
        var params = new URLSearchParams(window.location.search);
        return params.get('slug');
    }

    function getLegacyIdFromLocation() {
        return new URLSearchParams(window.location.search).get('id');
    }

    function canonicalPostUrl(post) {
        var origin = window.location.origin || '';
        var slug = (post && post.slug) ? String(post.slug).trim() : slugifyTitle(post && post.title);
        if (!slug) slug = 'post';
        return origin + '/blog/' + slug;
    }

    window.LigenBlogUrls = {
        slugifyTitle: slugifyTitle,
        postUrl: postUrl,
        prettyPostUrl: prettyPostUrl,
        getSlugFromLocation: getSlugFromLocation,
        getLegacyIdFromLocation: getLegacyIdFromLocation,
        canonicalPostUrl: canonicalPostUrl
    };
})(window);
