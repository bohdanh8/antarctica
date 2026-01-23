/**
 *
 *  *** DO NOT EDIT ***
 *
 */

// Results Container
const LOADER_CLASS = 'wpgb-loader';

const FACET_CLASS = 'wpgb-facet';
const CHECKBOX_CLASS = 'wpgb-checkbox';

const RENDER_EVENT = 'wpgbrender';
const CHANGE_EVENT = 'wpgbchange';
const RESET_EVENT = 'wpgbreset';
const APPENDED_EVENT = 'wpgbappended';

const TITLE_ACTIVE_CLASS = 'active';
const FILTER_ACTIVE_CLASS = 'filter-active';

const START_ID = 'wpgb-search-filter-start';

window.WP_Grid_Builder &&
    WP_Grid_Builder.on('init', function (wpgb) {
        // Fired when content is appended.
        wpgb.facets.on('appended', function (slug) {
            let event = new Event(APPENDED_EVENT);
            document.dispatchEvent(event);
        });

        // Fires when any element (ex:checkbox, input) within a Facet changes state.
        wpgb.facets.on('change', function (slug) {
            // trigger an event on start.
            let event = new Event(CHANGE_EVENT);
            document.dispatchEvent(event);

            let facet = wpgb.facets.getFacet(slug);
            let facetSettings = facet[0].settings;

            if (facetSettings.load_more_event !== 'onscroll' && facetSettings.load_more_event !== 'onclick' && !facetSettings.search_engine) {
                _wpgbScrollToStart();
            }
        });

        let wpgbResultsContainer = document.querySelectorAll('.wpgb-search-filter-results .wp-grid-builder');
        let transitionDuration = '.3s';

        // Fires when the Facets/Results start to load after each state change or on reset.
        wpgb.facets.on('change', function (slug) {
            let facet = wpgb.facets.getFacet(slug);
            let facetSettings = facet[0].settings;

            if (facetSettings.load_more_event !== 'onscroll') {
                _wpgbActivateLoader();
            }

            _wpgbResetTitle();
        });
        wpgb.facets.on('reset', function () {
            // trigger an event on reset.
            let event = new Event(RESET_EVENT);
            document.dispatchEvent(event);

            _wpgbActivateLoader();
        });

        // Fires once the Results are rendered.
        wpgb.facets.on('render', function (element) {
            // trigger an event once the results are rendered.
            let event = new Event(RENDER_EVENT);
            document.dispatchEvent(event);

            //Deactivate the .wpgb-loader element once the results have been fetched.
            wpgbResultsContainer.forEach((element) => {
                let loader = element.parentNode.querySelector(`.${LOADER_CLASS}`);
                element.style.opacity = 1;

                loader.style.opacity = 0;
                loader.style.visibility = 'invisible';
            });

            // Add a class to the Facet if one or more checkboxes have been seleted.
            let wpgbFacetCheckbox = document.querySelectorAll(`.${FACET_CLASS}`);
            wpgbFacetCheckbox.forEach((element) => {
                let checkboxes = element.querySelectorAll(`.${FACET_CLASS} .${CHECKBOX_CLASS}`);
                let checked = false;
                checkboxes.forEach((checkbox) => {
                    if (checkbox.getAttribute('aria-pressed') == 'true') {
                        checked = true;
                    }
                });

                if (checked) {
                    element.classList.add(FILTER_ACTIVE_CLASS);
                } else {
                    element.classList.remove(FILTER_ACTIVE_CLASS);
                }
            });

            _wpgbResetTitle();

            // Clicking on the Facet Title will add an 'active' class that can be used to add extra styling.
            let facetTitle = element.querySelector('.wpgb-facet-title');
            if (facetTitle) {
                facetTitle.addEventListener('click', function () {
                    _wpgbResetTitle(element);
                    element.classList.toggle(TITLE_ACTIVE_CLASS);
                    _wpgbScrollToStart();
                });
            }
        });

        // Activate the .wpgb-loader element until the results are fetched.
        function _wpgbActivateLoader() {
            wpgbResultsContainer.forEach((element) => {
                let loader = element.parentNode.querySelector(`.${LOADER_CLASS}`);

                element.style.opacity = 0.1;
                element.style.transitionDuration = transitionDuration;

                loader.style.transitionDuration = transitionDuration;
                loader.style.opacity = 1;
                loader.style.visibility = 'visible';
            });
        }

        // Remove 'active' class from the Facet title
        function _wpgbResetTitle(element) {
            requestAnimationFrame(() => {
                let facets = document.querySelectorAll('.wpgb-facet');
                if (facets) {
                    facets.forEach((facet) => {
                        if (element) {
                            if (facet != element) {
                                facet.classList.remove(TITLE_ACTIVE_CLASS);
                            }
                        } else {
                            facet.classList.remove(TITLE_ACTIVE_CLASS);
                        }
                    });
                }
            });
        }

        // Scroll to start
        function _wpgbScrollToStart() {
            requestAnimationFrame(() => {
                let startAnchor = document.querySelector(`#${START_ID}`);
                if (startAnchor) {
                    startAnchor.scrollIntoView({
                        behavior: 'smooth',
                    });
                }
            });
        }
    });
