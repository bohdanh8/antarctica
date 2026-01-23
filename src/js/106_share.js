const shareButtons = document.querySelectorAll('.js-share-button');
const copyButtons = document.querySelectorAll('.js-copy-button');

/**
 * Open Mini window to share in social network
 */
const shareLinks = document.querySelectorAll('.js-share-link');
shareLinks.forEach((elem) => {
    elem.addEventListener('click', function (e) {
        e.preventDefault();
        const link = this;
        const windowWidth = window.innerWidth,
            windowHeight = window.innerHeight;
        window.open(link.href, 'Share', 'top=' + (windowHeight - 400) / 2 + ',left=' + (windowWidth - 600) / 2 + ',width=600,height=400');
    });
});

/**
 * Handle native device Share functionality
 */
shareButtons.forEach((button) => {
    button.addEventListener('click', function () {
        if (navigator.share) {
            navigator
                .share({
                    title: document.title,
                    url: window.location.href,
                })
                .catch(console.error);
        } else {
            alert('Sharing is not supported on this device.');
        }
    });
});

/**
 * Handle Copy button click to copy link to clipboard
 */
copyButtons.forEach((button) => {
    button.addEventListener('click', function () {
        const link = button.getAttribute('data-url');
        if (navigator.clipboard && navigator.clipboard.writeText && link) {
            navigator.clipboard
                .writeText(link)
                .then(() => {
                    button.classList.add('active');
                    setTimeout(() => {
                        button.classList.remove('active');
                    }, 2500);
                })
                .catch(() => alert('Failed to copy the link.'));
        } else {
            alert('Clipboard API not supported in this browser or context.');
        }
    });
});
