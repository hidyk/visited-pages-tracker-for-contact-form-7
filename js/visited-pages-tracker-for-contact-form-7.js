document.addEventListener('DOMContentLoaded', function() {
    var pageUrl = window.location.href;
    var visitedPages = JSON.parse(sessionStorage.getItem('visited_pages')) || [];

    if (!visitedPages.includes(pageUrl)) {
        visitedPages.push(pageUrl);
    }

    sessionStorage.setItem('visited_pages', JSON.stringify(visitedPages));
});

document.addEventListener('wpcf7beforesubmit', function(event) {
    event.detail.formData.append('visited_pages', sessionStorage.getItem('visited_pages'));
});
