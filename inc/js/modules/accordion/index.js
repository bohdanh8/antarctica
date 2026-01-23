/**
 * *** DO NOT EDIT ***
 */

const DEFAULT_ELEMENT_CLASS = 'accordion-item';
const DEFAULT_TRIGGER_CLASS = 'accordion-trigger';
const DEFAULT_PANEL_CLASS = 'accordion-body';
const DEFAULT_ACTIVE_CLASS = 'is-active';
const DEFUALT_DURATION = 600;
const DEFAULT_ARIA_ENABLED_STATUS = true;
const DEFAULT_COLLAPSE_STATUS = true;
const DEFAULT_SHOW_MULTIPLE_STATUS = false;
const DEFAULT_ONLY_CHILD_NODES_STATUS = true;

module.exports = class Accordion {
    constructor({ selector = '', duration = DEFUALT_DURATION, openOnInit = [], ariaEnabled = DEFAULT_ARIA_ENABLED_STATUS, collapse = DEFAULT_COLLAPSE_STATUS, showMultiple = DEFAULT_SHOW_MULTIPLE_STATUS, onlyChildNodes = DEFAULT_ONLY_CHILD_NODES_STATUS, elementClass = DEFAULT_ELEMENT_CLASS, triggerClass = DEFAULT_TRIGGER_CLASS, panelClass = DEFAULT_PANEL_CLASS, activeClass = DEFAULT_ACTIVE_CLASS, beforeOpen = () => {}, onOpen = () => {}, beforeClose = () => {}, onClose = () => {} }) {
        this.instance = null;

        require('./main.css');

        if (selector && document.querySelector(selector)) {
            let accordion = require('accordion-js');

            // Prepare options object
            const options = {
                duration: duration,
                ariaEnabled: ariaEnabled,
                collapse: collapse,
                showMultiple: showMultiple,
                onlyChildNodes: onlyChildNodes,
                openOnInit: openOnInit,
                elementClass: elementClass,
                triggerClass: triggerClass,
                panelClass: panelClass,
                activeClass: activeClass,
                beforeOpen: beforeOpen,
                onOpen: onOpen,
                beforeClose: beforeClose,
                onClose: onClose,
            };

            // Store accordion instance for direct access
            this.instance = new accordion(selector, options);
        }
    }

    getInstance() {
        return this.instance;
    }
};
