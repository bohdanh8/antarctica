const modal = require( MODULES_PATH + '/modal' );

if ( document.querySelector( '#modal-form' ) ) {
	let modalForm = new modal( {
		modalId: 'modal-form',
		openButtonClass: 'open-modal',
		closeButtonClass: 'close-modal',
		backdrop: {
			color: '#000',
			opacity: 0.8,
			effect: true,
			blur: 5,
		},
	} );
}
