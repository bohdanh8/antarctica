/**
 * *** DO NOT EDIT ***
 */

const LOADED_CLASS = 'loaded';
const IMAGE_WRAPPER_CLASS = 'image-wrapper';

module.exports = class ImageLoader {
    constructor() {
        require('./main.css');

        const observer = new MutationObserver(() => {
            // Execute the Image loader function when a DOM element has been dynamically added or removed.
            this._run();
        });

        observer.observe(document.body, {
            attributes: false,
            childList: true,
            subtree: true,
        });
    }
    _run() {
        let imgElements = document.querySelectorAll(`.${IMAGE_WRAPPER_CLASS}>img`);

        if (imgElements && imgElements.length) {
            for (var i = 0; i < imgElements.length; i++) {
                let img = imgElements[i];

                // Add a load event listener to each img element
                img.addEventListener('load', function () {
                    // Image is loaded, add a class to the img element
                    this.classList.add(LOADED_CLASS);
                    this.style.removeProperty('background-image');
                    this.parentElement.classList.add(LOADED_CLASS);
                });

                // Check if the image is already loaded (cached)
                if (img.complete) {
                    // Image is already loaded, add a class to the img element
                    requestAnimationFrame(() => {
                        img.classList.add(LOADED_CLASS);
                        img.style.removeProperty('background-image');
                        img.parentElement.classList.add(LOADED_CLASS);
                    });
                }
            }
        }
    }
};
