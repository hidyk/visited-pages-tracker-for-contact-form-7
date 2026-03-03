document.addEventListener('DOMContentLoaded', function() {
    var pageUrl = window.location.href;
    var visitedPages = JSON.parse(sessionStorage.getItem('visited_pages')) || [];

    if (!visitedPages.some(function(page) { return page.url === pageUrl; })) {
        visitedPages.push({
            url: pageUrl,
            visitedAt: new Date().toISOString()
        });
    }

    sessionStorage.setItem('visited_pages', JSON.stringify(visitedPages));
});

document.addEventListener('wpcf7beforesubmit', function(event) {
    event.detail.formData.append('visited_pages', sessionStorage.getItem('visited_pages'));
});
