import gsap from 'gsap';

/**
 * Show Submenu on Hover
 */
const menuItems = document.querySelectorAll( ".primary-menu > .level-0" );
const primaryMenu = document.querySelector( ".primary-menu" );
const activeClass = "hover-active";
let openDropdownTimeout;
let closeDropdownTimeout;
let closeAllMenuTimeout;

if ( menuItems ) {
	menuItems.forEach( function( menuItem ) {
		// Open submenu on hover
		menuItem.addEventListener( "mouseenter", handleParentItemHover );
		// Close submenu on hover out
		menuItem.addEventListener( "mouseleave", handleParentItemOut );
	} );

	// Close all submenu on main menu hover out
	primaryMenu.addEventListener( "mouseleave", function() {
		closeAllMenuTimeout = setTimeout( function() {
			if ( closeDropdownTimeout ) {
				clearTimeout( closeDropdownTimeout );
			}

			closeAllSubMenus();
		}, 300 );
	} );

	// Prevent closing all submenu on main menu hover
	primaryMenu.addEventListener( "mouseenter", function() {
		if ( closeAllMenuTimeout ) {
			clearTimeout( closeAllMenuTimeout );
		}
	} );

	// Close all submenu on escape key press
	document.addEventListener( "keyup", function( event ) {
		if ( event.key === "Escape" ) {
			closeAllSubMenus();
		}
	} );
}

/**
 * Close all submenu
 */
function closeAllSubMenus() {
	// Prevent queued submenu open
	if ( openDropdownTimeout ) {
		clearTimeout( openDropdownTimeout );
	}

	// Close all submenu
	menuItems.forEach( function( menuItem ) {
		closeSubMenu( menuItem );
	} );
}

/**
 * Handle menu item submenu open
 */
function handleParentItemHover() {
	if ( this.classList.contains( activeClass ) ) {
		if ( closeDropdownTimeout ) {
			clearTimeout( closeDropdownTimeout );
		}
	}

	// Add delay for hover effect to prevent accidental submenu appearance
	let delay = this.classList.contains( "menu-item-has-children" ) ? 100 : 0;

	openDropdownTimeout = setTimeout( () => {
		if ( window.innerWidth < 1024 ) {
			return;
		}

		// Close all other dropdowns
		let otherMenuItems = Array.from( menuItems ).filter( item => item !== this );
		otherMenuItems.forEach( item => {
			closeSubMenu( item );
		} );

		openSubMenu( this );
	}, delay );
}

/**
 * Handle menu item submenu close
 */
function handleParentItemOut( event ) {
	event.stopPropagation();
	if ( openDropdownTimeout ) {
		clearTimeout( openDropdownTimeout );
	}

	if ( window.innerWidth < 1024 ) {
		return;
	}

	closeDropdownTimeout = setTimeout( () => {
		closeSubMenu( this );
	}, 300 );
}

/**
 * Close submenu
 */
function closeSubMenu( menuItem ) {
	const subMenu = menuItem.querySelector( '.primary-submenu' );
	menuItem.classList.remove( activeClass );
	gsap.killTweensOf( subMenu );

	if ( subMenu ) {
		gsap.set( subMenu, { pointerEvents: 'none' } );
		gsap.to( subMenu, { delay: 0, opacity: 0, duration: 0.2 } );
	}
}

/**
 * Open submenu
 */
function openSubMenu( menuItem ) {
	const subMenu = menuItem.querySelector( '.primary-submenu' );
	menuItem.classList.add( activeClass );
	gsap.killTweensOf( subMenu );

	if ( subMenu ) {
		gsap.set( subMenu, { pointerEvents: 'auto' } );
		gsap.to( subMenu, { opacity: 1, pointerEvents: 'auto', duration: 0.2 } );
	}
}