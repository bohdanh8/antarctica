/**
 * MODAL Module
 *
 * This can be used to create one or more Modals.
 *
 * Usage:
 * ------
 *
 * // Import the Module
 * const modal = require(MODULES_PATH + '/modal');
 *
 * // Instantiate
 * let navCanvas = new modal({
 *    modalId: 'nav-canvas',
 *    openButtonClass: 'nav-open-button',
 *    closeButtonClass: 'nav-close-button',
 *    scrollTracker: false,
 *    scrollAdjust: false,
 *    center: true,
 *    closeOnWrapperClick: true,
 *    resetOnClose: true,
 *    keepHidden: false,
 *    debug: false,
 *    backdrop: {
 *        color: '#000000',
 *        opacity: 0.97,
 *        effect: true,
 *        blur: 10,
 *    },
 * });
 *
 * // Menu button click event
 * const menuButton = document.querySelector('a.mobile-menu-button');
 *
 * menuButton.addEventListener('pointerdown', () => {
 *    navCanvas.show();
 * });
 *
 * Properties:
 * -----------
 * modalId - ID of the HTML element that is used inside the modal (<div id='nav-canvas'> content </div>). Default: 'modal'.
 * addModalWrapperToBody - If set to 'true', the modal wrapper will be removed from the parent and added to the body. Default: 'true'
 * openButtonClass - The class name of the open button. You can use multiple buttons if needed. Default: '<modalID>-open-button'.
 * closeButtonClass - The class name of the close button. You can use multiple buttons if needed. Default: '<modalID>-close-button'.
 * scrollTracker - This will add the scroll position into the body tag so that you can use it for dynamic elements. Default: 'false'.
 * scrollAdjust - This will add the scrollbar width back into the modal. Default: 'false'.
 * center - Setting this to true will center the Modal content both vertically and horizontally. Default: 'true'.
 * closeOnWrapperClick - Close modal when the backdrop area is clicked. default: 'true'.
 * resetOnClose = This will reset all Forms when the modal is closed. Default: 'true'.
 * keepHidden - This will add the 'keep-hidden' class to both the backdrop and the modal wrapper so that they both stay hidden. Default: 'false'
 * debug - Setting this to 'true' will display console.log information. Default: 'false'.
 * backdrop -> color - Backdrop colour of the Modal. Default: '#000000'.
 * backdrop -> opacity - Backdrop opacity of the Modal. Default: '.5'.
 * backdrop -> blur - Backdrop blur. Default: '0'.
 * backdrop -> effect - This can be used to disable the fade effect of the Modal (for custom animations). Default: 'true'.
 *
 * Functions:
 * -----------
 * show() - This will display the Modal.
 * hide() - This will hide the Modal.
 * toggle() - This will display the Modal when it's hidden and viceversa.
 *
 * Triggers:
 * ----------
 * You can pass these triggers into the addEventListener() function to trigger custom animations, etc.
 *
 * openmodal - Will fire when the Modal is starting to render
 * closemodal - Will fire when the Modal is commanded to hide.
 * modalopened - Will fire when the Modal is fully rendered.
 * modalclosed - Will fire when the Modal is fully disposed.
 *
 * If the modalId is set to 'nav-canvas' for example, you will have these additional events as well.
 *
 * navcanvasopenmodal
 * navcanvasclosemodal
 * navcanvasmodalopened
 * navcanvasmodalclosed
 *
 * The event names will appear in the console log if needed.
 *
 *
 * *** DO NOT EDIT ***
 */

const CONTENT_CLASS = 'modal';
const BACKDROP_CLASS = 'modal-backdrop';
const WRAPPER_CLASS = 'modal-wrapper';
const OPEN_BODY_CLASS = 'modal-open';
const CENTER_CLASS = 'center';
const KEEP_HIDDEN_CLASS = 'keep-hidden';
const CLOSING_BODY_CLASS = 'modal-closing';
const OPENING_BODY_CLASS = 'modal-opening';
const BACKDROP_COLOR_VAR = '--modal-backdrop-color';
const BACKDROP_OPACITY_VAR = '--modal-backdrop-opacity';
const BACKDROP_BLUR_VAR = '--modal-backdrop-blur';
const SCROLLBAR_WIDTH_VAR = '--scrollbar-width';
const SCROLL_POSITION_CLASS_SUFFIX = 'scroll-position';
const ACTIVE_CLASS = 'active';
const FADE_CLASS = 'fade';
const SHOW_CLASS = 'show';
const CLOSE_BUTTON_CLASS_SUFFIX = 'close-button';
const OPEN_BUTTON_CLASS_SUFFIX = 'open-button';
const STYLE_ID = 'modal-module-css';

const EVENT_OPEN_MODAL = 'openmodal';
const EVENT_CLOSE_MODAL = 'closemodal';
const EVENT_MODAL_OPENED = 'modalopened';
const EVENT_MODAL_CLOSED = 'modalclosed';

const BACKDROP_COLOR_DEFAULT = '#000000';
const BACKDROP_OPACITY_DEFAULT = '.5';
const BACKDROP_EFFECT_DEFAULT = true;
const BACKDROP_BLUR_DEFAULT = 0;

const FORM_ERROR_CLASSES = ['.gform_validation_errors', '.gfield_validation_message'];
const FORM_MAIN_ERROR_CLASS = 'gfield_error';

module.exports = class Modal {
    constructor({
        modalId = CONTENT_CLASS,
        addModalWrapperToBody = true,
        openButtonClass = `${modalId}-${OPEN_BUTTON_CLASS_SUFFIX}`,
        closeButtonClass = `${modalId}-${CLOSE_BUTTON_CLASS_SUFFIX}`,
        scrollTracker = false,
        scrollAdjust = false,
        keepHidden = false,
        center = true,
        closeOnWrapperClick = true,
        resetOnClose = true,
        debug = false,
        backdrop = {
            color: BACKDROP_COLOR_DEFAULT,
            opacity: BACKDROP_OPACITY_DEFAULT,
            effect: BACKDROP_EFFECT_DEFAULT,
            blur: BACKDROP_BLUR_DEFAULT,
        },
    }) {
        require('./main.css');

        this._body = document.body;

        this._backdrop = backdrop;

        if (!backdrop.effect && backdrop.effect !== false) {
            this._backdrop.effect = BACKDROP_EFFECT_DEFAULT;
        }

        this._modalId = modalId;
        this._scrollTracker = scrollTracker;
        this._scrollAdjust = scrollAdjust;
        this._keepHidden = keepHidden;
        this._center = center;
        this._closeOnWrapperClick = closeOnWrapperClick;
        this._resetOnClose = resetOnClose;
        this._debug = debug;
        this._modalContent = document.getElementById(modalId);
        this._openButtons = document.querySelectorAll(`.${openButtonClass}`);
        this._closeButtons = document.querySelectorAll(`.${closeButtonClass}`);
        this._addModalWrapperToBody = addModalWrapperToBody;

        // Setting the opacity to the smallest value as a fix
        if (this._backdrop.opacity == 0) {
            this._backdrop.opacity = '0.01';
        }

        // Adding the 'modal' class in case it is not added in the main HTML.
        this._modalContent.classList.add(CONTENT_CLASS);

        // Creating the modal backdrop.
        this._modalBackdrop = document.createElement('div');
        this._modalBackdrop.setAttribute('id', `${BACKDROP_CLASS}-${this._modalId}`);
        this._modalBackdrop.classList.add(BACKDROP_CLASS);

        //this._modalBackdrop.style.backgroundColor = this._backdrop.color;

        // Creating a wrapper element for the modal.
        this._modalWrapper = document.createElement('div');
        this._modalWrapper.classList.add(WRAPPER_CLASS);

        if (this._center) {
            this._modalWrapper.classList.add(CENTER_CLASS);
        }

        this._modalWrapper.setAttribute('id', `${WRAPPER_CLASS}-${this._modalId}`);
        this._modalContent.parentNode.insertBefore(this._modalWrapper, this._modalContent);
        this._modalWrapper.appendChild(this._modalContent);

        if (this._addModalWrapperToBody) {
            this._body.appendChild(this._modalWrapper);
        }

        // open the modal when an element with the open button class is clicked.
        if (this._openButtons) {
            this._openButtons.forEach((element) => {
                element.addEventListener('pointerdown', () => {
                    this.show();
                });
            });
        }

        // close the modal when an element with the close button class is clicked.
        if (this._closeButtons) {
            this._closeButtons.forEach((element) => {
                element.addEventListener('pointerdown', () => {
                    this.hide();
                });
            });
        }

        // close the modal when the backdrop area is clicked.
        if (this._closeOnWrapperClick) {
            this._modalWrapper.addEventListener('pointerdown', (event) => {
                if (event.target === this._modalWrapper) {
                    this.hide();
                }
            });
        }
    }

    toggle() {
        if (this._body.classList.contains(OPEN_BODY_CLASS)) {
            this.hide();
        } else {
            this.show();
        }
    }

    show() {
        if (!this._body.classList.contains(OPEN_BODY_CLASS)) {
            this._setCssVariables();
            this._modalContent.classList.remove('hidden');
            if (this._scrollTracker) {
                this._modalScroller = () => {
                    this._body.style.setProperty(`--${WRAPPER_CLASS}-${this._modalId}-${SCROLL_POSITION_CLASS_SUFFIX}`, `${this._modalWrapper.scrollTop}px`);
                };
                this._modalWrapper.addEventListener('scroll', this._modalScroller);
            }
            this._triggerOpenEvent();
            this._hideScrollbar();
            this._addBackdrop();
            this._showModalWrapper();

            // close the modal if the Esacpe key is pressed.
            document.addEventListener(
                'keydown',
                (event) => {
                    if (event.key === 'Escape') {
                        event.preventDefault();
                        this.hide();
                    }
                },
                { once: true },
            );
        } else {
            console.error('A modal is already open. Please close the current one before opening another, as only one modal can be active at a time.');
        }
    }

    hide() {
        this._body.classList.add(CLOSING_BODY_CLASS);
        this._triggerCloseEvent();
        this._hideModalWrapper();
        this._removeBackdrop();
        this._showScrollbar();
    }

    _showModalWrapper() {
        this._modalContent.classList.add(ACTIVE_CLASS);
        this._modalWrapper.classList.add(ACTIVE_CLASS);
        if (this._backdrop.effect) {
            this._modalWrapper.classList.add(FADE_CLASS);
        }

        if (this._keepHidden) {
            this._modalWrapper.classList.add(KEEP_HIDDEN_CLASS);
        }

        let _showWrapper = () => {
            this._body.classList.remove(OPENING_BODY_CLASS);
            this._modalWrapper.classList.add(SHOW_CLASS);
            this._triggerOpenedEvent();
            if (this._backdrop.effect) {
                this._modalBackdrop.removeEventListener('transitionend', _showWrapper);
            }
        };

        this._scrollAdjuster();

        if (this._backdrop.effect) {
            const duration = parseFloat(getComputedStyle(this._modalBackdrop).transitionDuration) * 1000;
            setTimeout(_showWrapper, duration);
        } else {
            _showWrapper();
        }
    }

    _hideModalWrapper() {
        let _hideWrapper = () => {
            this._modalWrapper.scrollTop = 0;
            this._modalWrapper.classList.remove(ACTIVE_CLASS);

            if (this._backdrop.effect) {
                this._modalWrapper.classList.remove(FADE_CLASS);

                this._modalWrapper.removeEventListener('transitionend', _hideWrapper);
            }
        };
        this._modalWrapper.classList.remove(SHOW_CLASS);

        if (this._backdrop.effect) {
            this._modalWrapper.addEventListener('transitionend', _hideWrapper);
        } else {
            _hideWrapper();
        }
    }

    _getScrollBarWidth(element) {
        return parseFloat(getComputedStyle(element).paddingRight) + (window.innerWidth - element.scrollWidth);
    }

    _scrollAdjuster() {
        if (this._scrollAdjust) {
            if (!this._getScrollBarWidth(this._modalWrapper)) {
                this._modalWrapper.style.setProperty('padding-right', `${this._getScrollBarWidth(this._body)}px`, 'important');
            } else {
                this._modalWrapper.style.removeProperty('padding-right');
                this._modalWrapper.style.removeProperty('padding-left');
            }
        }
    }

    _addBackdrop() {
        if (!document.querySelector(`body > div.${BACKDROP_CLASS}`)) {
            this._body.appendChild(this._modalBackdrop);
        }

        this._modalBackdrop.classList.add(ACTIVE_CLASS);

        if (this._backdrop.effect) {
            this._modalBackdrop.classList.add(FADE_CLASS);
        }

        if (this._keepHidden) {
            this._modalBackdrop.classList.add(KEEP_HIDDEN_CLASS);
        }

        requestAnimationFrame(() => {
            this._modalBackdrop.classList.add(SHOW_CLASS);
        });
    }

    _removeBackdrop() {
        let _removeElement = () => {
            this._modalBackdrop.remove();
            this._triggerClosedEvent();
            this._removeCSSVariables();

            // Reset Modal on close
            if (this._resetOnClose) {
                this._resetForm();
            }

            if (this._backdrop.effect) {
                this._modalBackdrop.removeEventListener('transitionend', _removeElement);
            }
        };
        let _hideBackdrop = () => {
            this._modalBackdrop.classList.remove(SHOW_CLASS);

            if (this._backdrop.effect) {
                this._modalBackdrop.addEventListener('transitionend', _removeElement);
                this._modalWrapper.removeEventListener('transitionend', _hideBackdrop);
            }
        };

        if (this._backdrop.effect) {
            this._modalWrapper.addEventListener('transitionend', _hideBackdrop);
        } else {
            _hideBackdrop();
            _removeElement();
        }
    }

    _hideScrollbar() {
        let scrollbarWidth = this._getScrollBarWidth(this._body);

        this._body.classList.add(OPEN_BODY_CLASS, `modal-${this._modalId}`);
        this._backdrop.effect && this._body.classList.add(OPENING_BODY_CLASS);
        this._body.style.setProperty('overflow', 'hidden', 'important');
        if (scrollbarWidth > 0) {
            this._body.style.setProperty('padding-right', `${scrollbarWidth}px`, 'important');
        }
    }

    _showScrollbar() {
        let _showScrollbar = () => {
            this._body.style.removeProperty('overflow');
            this._body.style.removeProperty('padding-right');
            this._body.classList.remove(OPEN_BODY_CLASS);
            this._body.classList.remove(CLOSING_BODY_CLASS);
            this._body.classList.remove(`modal-${this._modalId}`);
            if (this._scrollTracker) {
                this._modalWrapper.removeEventListener('scroll', this._modalScroller);
            }
            this._body.style.removeProperty(`--${WRAPPER_CLASS}-${this._modalId}-${SCROLL_POSITION_CLASS_SUFFIX}`);

            if (this._backdrop.effect) {
                this._modalBackdrop.removeEventListener('transitionend', _showScrollbar);
            }
        };

        if (this._backdrop.effect) {
            this._modalBackdrop.addEventListener('transitionend', _showScrollbar);
        } else {
            _showScrollbar();
        }
    }

    _setCssVariables() {
        // Remove the variables if they already exist.
        let stylesheetElement = document.querySelector(`style#${STYLE_ID}`);
        if (stylesheetElement) {
            stylesheetElement.remove();
        }

        // Set CSS variables
        let stylesheet = document.createElement('style');
        document.head.appendChild(stylesheet);

        stylesheet.setAttribute('id', STYLE_ID);

        let cssRules = `
        :root{`;

        if (this._backdrop.color) {
            cssRules += `
            ${BACKDROP_COLOR_VAR}:${this._backdrop.color};`;
        }
        if (this._backdrop.opacity) {
            cssRules += `
            ${BACKDROP_OPACITY_VAR}:${this._backdrop.opacity};`;
        }
        if (this._backdrop.blur) {
            cssRules += `
            ${BACKDROP_BLUR_VAR}:${this._backdrop.blur}px;`;
        }
        cssRules += `
            ${SCROLLBAR_WIDTH_VAR}:${this._getScrollBarWidth(this._body)}px;`;

        cssRules += `
        }
        `;
        stylesheet.innerHTML = cssRules;
    }

    _removeCSSVariables() {
        let stylesheetElement = document.querySelector(`style#${STYLE_ID}`);
        if (stylesheetElement) {
            stylesheetElement.remove();
        }
    }

    _resetForm() {
        // Reset input Fields

        let inputFields = this._modalContent.querySelectorAll('input');
        let textareaFields = this._modalContent.querySelectorAll('textarea');
        let selectFields = this._modalContent.querySelectorAll('select');

        inputFields.forEach((inputField) => {
            if (inputField.type != 'submit' && inputField.type != 'button' && inputField.type != 'hidden') {
                if (inputField.type == 'radio' || inputField.type == 'checkbox') {
                    inputField.checked = false;
                } else {
                    inputField.value = '';
                }
            }
        });

        textareaFields.forEach((textareaField) => {
            textareaField.value = '';
        });

        selectFields.forEach((selectField) => {
            selectField.selectedIndex = 0;
        });

        //--

        // Reset Error Messages

        // Gravity Forms

        let mainErrorElements = this._modalContent.querySelectorAll(`.${FORM_MAIN_ERROR_CLASS}`);

        if (mainErrorElements) {
            mainErrorElements.forEach((mainErrorElement) => {
                mainErrorElement.classList.remove(FORM_MAIN_ERROR_CLASS);
                mainErrorElement.querySelector('input').setAttribute('aria-invalid', 'false');
            });
        }

        let errorElements = this._modalContent.querySelectorAll(FORM_ERROR_CLASSES);
        if (errorElements && errorElements.length) {
            errorElements.forEach((errorElement) => {
                errorElement.remove();
            });
        }

        //--
    }

    _triggerOpenEvent() {
        let event1 = new Event(EVENT_OPEN_MODAL);

        let event2Name = `${this._modalId.replace(/[-_]/g, '').toLowerCase()}${EVENT_OPEN_MODAL}`;

        let event2 = new Event(event2Name);

        document.dispatchEvent(event1);
        document.dispatchEvent(event2);

        this._debug && console.log(`Modal Module: '${EVENT_OPEN_MODAL}' and '${event2Name}' events fired.`);
    }
    _triggerCloseEvent() {
        let event1 = new Event(EVENT_CLOSE_MODAL);

        let event2Name = `${this._modalId.replace(/[-_]/g, '').toLowerCase()}${EVENT_CLOSE_MODAL}`;

        let event2 = new Event(event2Name);

        document.dispatchEvent(event1);
        document.dispatchEvent(event2);

        this._debug && console.log(`Modal Module: '${EVENT_CLOSE_MODAL}' and '${event2Name}' events fired.`);
    }

    _triggerOpenedEvent() {
        let event1 = new Event(EVENT_MODAL_OPENED);

        let event2Name = `${this._modalId.replace(/[-_]/g, '').toLowerCase()}${EVENT_MODAL_OPENED}`;

        let event2 = new Event(event2Name);

        document.dispatchEvent(event1);
        document.dispatchEvent(event2);

        this._debug && console.log(`Modal Module: '${EVENT_MODAL_OPENED}' and '${event2Name}' events fired.`);
    }
    _triggerClosedEvent() {
        let event1 = new Event(EVENT_MODAL_CLOSED);

        let event2Name = `${this._modalId.replace(/[-_]/g, '').toLowerCase()}${EVENT_MODAL_CLOSED}`;

        let event2 = new Event(event2Name);

        document.dispatchEvent(event1);
        document.dispatchEvent(event2);

        this._debug && console.log(`Modal Module: '${EVENT_MODAL_CLOSED}' and '${event2Name}' events fired.`);
    }
};
