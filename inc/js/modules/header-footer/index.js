/**
 * HEADER & FOOTER Module
 *
 * This module will calculate the <header> and <footer> heights dynamically and add those values to two CSS variables (--header-height & --footer-height). This will also add a minimum height to <main> based on these two values.
 *
 * Usage
 * -----
 * const headerFooter = require(MODULES_PATH + '/header-footer');
 * new headerFooter();
 *
 * *** DO NOT EDIT ***
 */

const STYLE_ID = 'header-footer-module-css';
const HEADER_HEIGHT_VAR = 'header-height';
const FOOTER_HEIGHT_VAR = 'footer-height';
const CALCULATED_HEIGHT_CLASS = 'calculated';
const HEADER_INNER_CLASS = 'header-inner';

module.exports = class HeaderFooter {
    constructor() {
        require('./main.css');

        this._run();
    }

    _run() {
        let onLoadSetCSSVariables = () => {
            let headerSection = document.querySelector('header');
            let footerSection = document.querySelector('footer');
            if (headerSection && footerSection) {
                this._setCSSVariables();
            } else {
                if (headerSection || footerSection) {
                    this._setCSSVariables();
                }
                requestAnimationFrame(onLoadSetCSSVariables);
            }
        };

        onLoadSetCSSVariables();

        window.addEventListener('resize', () => {
            this._setCSSVariables();
        });
    }

    _headerCalculation() {
        // Header Calculations
        let headerSection = document.querySelector(`header .${HEADER_INNER_CLASS}`);
        if (!headerSection) {
            headerSection = document.querySelector('header');
        }
        let headerStyling = window.getComputedStyle(headerSection);
        return headerStyling.height;
    }

    _footerCalculation() {
        // Footer Calculations
        let footerSection = document.querySelector('footer');
        let footerStyling = window.getComputedStyle(footerSection);
        return footerStyling.height;
    }

    _setCSSVariables() {
        // Remove the variables if they already exist.
        let stylesheetElement = document.querySelector(`style#${STYLE_ID}`);
        if (stylesheetElement) {
            stylesheetElement.remove();
        }

        // Get the Header and Footer heights
        let headerHeight = this._headerCalculation();
        let footerHeight = this._footerCalculation();

        // Add Header and Footer class to indicate that height is calculated
        let headerSection = document.querySelector('header');
        if (headerSection) {
            headerSection.classList.add(CALCULATED_HEIGHT_CLASS);
        }

        let footerSection = document.querySelector('footer');
        if (footerSection) {
            footerSection.classList.add(CALCULATED_HEIGHT_CLASS);
        }

        // Set CSS variables in <head>
        let stylesheet = document.createElement('style');

        document.head.appendChild(stylesheet);

        stylesheet.setAttribute('id', STYLE_ID);

        let cssRules = `
        :root {
            --${HEADER_HEIGHT_VAR}:${headerHeight};
            --${FOOTER_HEIGHT_VAR}:${footerHeight};
        }
        `;

        stylesheet.innerHTML = cssRules;
    }
};
