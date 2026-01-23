/**
 * *** DO NOT EDIT ***
 */

const ACTIVE_CLASS = 'active';
const TABS_CLASS = 'tabs';
const TAB_CLASS = 'tab';
const TAB_PANES_CLASS = 'tab-panes';
const TAB_PANE_CLASS = 'tab-pane';

const { gsap } = require('gsap');

module.exports = class Tabs {
    constructor({ selectorClass = '' }) {
        require('./main.css');
        if (selectorClass) {
            this._selectorClass = selectorClass;
        }
        this._tabsContainer = document.querySelector(
            `.${this._selectorClass}.${TABS_CLASS}`
        );
        this._tabPanesContainers = document.querySelectorAll(
            `.${this._selectorClass}.${TAB_PANES_CLASS}`
        );

        if (this._tabsContainer && this._tabPanesContainers) {
            this._tabs = this._tabsContainer.querySelectorAll(`.${TAB_CLASS}`);

            if (this._tabs) {
                this._run();
            } else {
                console.error(`Missing Tab Class: ${TAB_CLASS}`);
            }
        }
        if (this._tabsContainer && !this._tabPanesContainers) {
            console.error('Missing Tab Panes Container');
        }
    }
    _run() {
        this._init();
        this._tabs.forEach((tab, index) => {
            tab.addEventListener('click', () => {
                this._toggle(index);
            });
        });
    }
    _toggle(index) {
        this._tabs.forEach((tab) => {
            tab.classList.remove(ACTIVE_CLASS);
        });

        this._tabPanesContainers.forEach((element) => {
            let tabPanes = element.querySelectorAll(
                `.${this._selectorClass}.${TAB_PANE_CLASS}`
            );
            tabPanes.forEach((tabPane) => {
                tabPane.classList.remove(ACTIVE_CLASS);
            });
            tabPanes[index].classList.add(ACTIVE_CLASS);
            gsap.to(tabPanes[index], {
                y: 0,
                autoAlpha: 1,
                ease: 'power1.out',
                duration: 1,
                startAt: {
                    opacity: 0,
                },
            });
        });

        this._tabs[index].classList.add(ACTIVE_CLASS);
    }
    _init() {
        this._tabPanesContainers.forEach((element) => {
            let tabPanes = element.querySelectorAll(
                `.${this._selectorClass}.${TAB_PANE_CLASS}`
            );
            tabPanes[0].classList.add(ACTIVE_CLASS);
        });
        this._tabs[0].classList.add(ACTIVE_CLASS);
    }
};
