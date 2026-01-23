// This is show or hide the mobile version of the primary menu.

import { debounce } from './0_utils';

/**
 * Toggle the mobile menu.
 */
document.querySelector("button[aria-controls='mobile-menu']").addEventListener('click', function (event) {
    let mobileMenu = document.querySelector('#mobile-menu');
    let isActive = mobileMenu.classList.contains('active');
    let scrollPosition = window.pageYOffset;
    this.classList.toggle('active');

    if (isActive) {
        setTimeout(function () {
            mobileMenu.classList.remove('active');
            document.body.removeAttribute('data-scroll-position');
        }, 200);

        document.body.classList.toggle('is-menu-open');

        let root = document.getElementsByTagName('html')[0];
        root.classList.toggle('is-menu-open');
    } else {
        mobileMenu.classList.toggle('active');
        document.body.setAttribute('data-scroll-position', scrollPosition);

        setTimeout(function () {
            document.body.classList.toggle('is-menu-open');

            let root = document.getElementsByTagName('html')[0];
            root.classList.toggle('is-menu-open');
        }, 200);
    }

    document.getElementById('header').classList.toggle('is-menu-open');

    // Restore scroll position
    let scrollAttr = parseInt(document.body.getAttribute('data-scroll-position'));
    if (scrollAttr !== 0) {
        if (!isActive) {
            document.body.scrollTop = scrollAttr;
        } else {
            window.scrollTo(0, scrollAttr);
        }
        header.classList.add('slide-in');
    }

    if (document.querySelector('.primary-submenu.active')) {
        document.querySelector('.primary-submenu.active').classList.remove('active');
    }
});

/**
 * Show/Hide Header on scroll.
 */
let prevScrollPos = window.pageYOffset;
const header = document.querySelector('#header .header-inner');
window.onscroll = function () {
    const currentScrollPos = window.pageYOffset;
    if (!header) {
        return;
    }

    if (currentScrollPos > 100) {
        if (prevScrollPos < currentScrollPos && !document.getElementById('header').classList.contains('header-hover')) {
            header.classList.remove('transparent', 'slide-in');
            header.classList.add('slide-out');
        } else {
            header.classList.remove('transparent', 'slide-out');
            header.classList.add('slide-in');
        }
    } else {
        header.classList.remove('slide-in', 'slide-out');
        header.classList.add('transparent');
    }

    prevScrollPos = currentScrollPos;
};

/**
 * Drilldown menu handlers.
 */

initializeDrilldownHandlers();

function initializeDrilldownHandlers() {
    const drilldownBackBtn = document.querySelectorAll('.js-drilldown-back');
    const drilldownOpenBtn = document.querySelectorAll('.js-open-drilldown');

    drilldownBackBtn.forEach((btn) => {
        btn.addEventListener('click', function (event) {
            if (window.innerWidth > 1024) {
                return;
            }

            event.stopPropagation();
            event.preventDefault();
            const parentMenu = this.closest('li.menu-item');
            const subMenu = parentMenu.querySelector('.primary-submenu');
            subMenu.classList.remove('active');
        });
    });

    drilldownOpenBtn.forEach((btn) => {
        btn.addEventListener('click', function (event) {
            if (window.innerWidth > 1024) {
                return;
            }

            event.stopPropagation();
            event.preventDefault();
            const parentMenu = this.closest('li.menu-item');
            const subMenu = parentMenu.querySelector('.primary-submenu');
            subMenu.classList.add('active');
        });
    });
}

const closeDrilldownCallback = debounce(closeDrilldownMenu, 200);

addEventListener('resize', (event) => {
    closeDrilldownCallback();
});

function closeDrilldownMenu() {
    document.getElementById('header').classList.remove('is-menu-open');
    document.getElementById('mobile-menu').classList.remove('active');
    document.querySelector("button[aria-controls='mobile-menu']").classList.remove('active');

    if (document.querySelector('.primary-submenu.active')) {
        document.querySelector('.primary-submenu.active').classList.remove('active');
    }
}
