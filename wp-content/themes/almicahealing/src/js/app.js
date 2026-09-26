const AUTOPLAY_DELAY = 7000;

document.querySelectorAll( '[data-almicahealing-slider]' ).forEach( ( slider ) => {
	const slides = slider.querySelectorAll( '.testimonial-slide' );
	const dots = slider.querySelectorAll( '.testimonials__dot' );

	if ( slides.length < 2 ) {
		return;
	}

	let current = 0;
	let timer = null;

	const showSlide = ( index ) => {
		current = index;
		slides.forEach( ( slide, slideIndex ) => {
			slide.hidden = slideIndex !== index;
		} );
		dots.forEach( ( dot, dotIndex ) => {
			dot.setAttribute( 'aria-current', dotIndex === index ? 'true' : 'false' );
		} );
	};

	// Honour the OS setting: an unattended carousel is exactly the kind
	// of motion "reduce motion" is asking us not to start. The dots keep
	// working, so nothing becomes unreachable.
	const reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' );

	const stop = () => {
		window.clearInterval( timer );
		timer = null;
	};

	const start = () => {
		if ( timer || reduced.matches ) {
			return;
		}
		timer = window.setInterval( () => {
			showSlide( ( current + 1 ) % slides.length );
		}, AUTOPLAY_DELAY );
	};

	// Reading a quote should not be interrupted, and a slide that moves
	// out from under the pointer or keyboard focus takes its dots with
	// it.
	slider.addEventListener( 'mouseenter', stop );
	slider.addEventListener( 'mouseleave', start );
	slider.addEventListener( 'focusin', stop );
	slider.addEventListener( 'focusout', start );

	document.addEventListener( 'visibilitychange', () => {
		if ( document.hidden ) {
			stop();
		} else {
			start();
		}
	} );

	reduced.addEventListener( 'change', () => {
		if ( reduced.matches ) {
			stop();
		} else {
			start();
		}
	} );

	dots.forEach( ( dot ) => {
		dot.addEventListener( 'click', () => {
			showSlide( parseInt( dot.dataset.index, 10 ) );
			// Restart the countdown so a slide picked by hand gets a
			// full turn rather than whatever was left of the last one.
			stop();
			start();
		} );
	} );

	showSlide( 0 );
	start();
} );
