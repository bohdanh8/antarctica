// Image loader Module
const imageLoader = require( MODULES_PATH + '/image-loader' );
new imageLoader();

// Cookie Consent Module
const cookieConsent = require( MODULES_PATH + '/cookie-consent' );
new cookieConsent( {
	buttonSelector: '.cookie-consent-banner__button',
	bannerSelector: '.cookie-consent-banner',
} );

// Header and Footer Module
const headerFooter = require( MODULES_PATH + '/header-footer' );
new headerFooter();
