/**
 * *** DO NOT EDIT ***
 */

const COOKIE_NAME = 'cookieconsent_status';
const COOKIE_EXPIRY = 'Thu, 18 Dec 3550 12:00:00 UTC';
const BANNER_CLASS = 'cookie-consent-banner';
const SHOW_CLASS = 'show';

module.exports = class CookieConsent {
    constructor({ buttonSelector = '', bannerSelector = '' }) {
        require('./main.css');
        this._buttonElement = document.querySelector(buttonSelector);
        this._bannerElement = document.querySelector(bannerSelector);
        this._run();
    }
    _run() {
        this._checkStatus();
        // Set Cookie if the button is clicked.
        if (this._buttonElement) {
            this._buttonElement.addEventListener('click', () => {
                document.cookie = `${COOKIE_NAME}=dismiss; expires=${COOKIE_EXPIRY}; path=/`;
                document.cookie = `hello_cookie=agree; expires=${COOKIE_EXPIRY}; path=/`;
                this._checkStatus();
            });
        }
        if (this._bannerElement) {
            this._bannerElement.classList.add(BANNER_CLASS);
        }
    }
    _getCookieValue(name) {
        let cookieString = document.cookie.replace(/\s+/g, '');
        let cookies = cookieString.split(';');
        let value = '';
        cookies.forEach((element) => {
            let cookie = element.split('=');
            if (name == cookie[0]) {
                value = cookie[1];
            }
        });
        return value;
    }
    _checkStatus() {
        // Add a class to the banner element if the cookie is set.
        if (this._bannerElement) {
            requestAnimationFrame(() => {
                if ('dismiss' == this._getCookieValue(COOKIE_NAME)) {
                    this._bannerElement.classList.remove(SHOW_CLASS);
                } else {
                    this._bannerElement.classList.add(SHOW_CLASS);
                }
            });
        }
    }
};
