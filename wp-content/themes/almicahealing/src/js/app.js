document.querySelectorAll( '[data-almicahealing-slider]' ).forEach( ( slider ) => {
	const slides = slider.querySelectorAll( '.testimonial-slide' );
	const dots = slider.querySelectorAll( '.testimonials__dot' );

	if ( slides.length < 2 ) {
		return;
	}

	const showSlide = ( index ) => {
		slides.forEach( ( slide, slideIndex ) => {
			slide.hidden = slideIndex !== index;
		} );
		dots.forEach( ( dot, dotIndex ) => {
			dot.setAttribute( 'aria-current', dotIndex === index ? 'true' : 'false' );
		} );
	};

	dots.forEach( ( dot ) => {
		dot.addEventListener( 'click', () => {
			showSlide( parseInt( dot.dataset.index, 10 ) );
		} );
	} );

	showSlide( 0 );
} );
