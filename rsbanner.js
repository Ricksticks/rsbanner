(function($) {
	var frame;

	$( function() {
		// Build the choose from library frame.
		$('.choose-from-library-link').click( function( event ) {
			var $el = $(this);
			event.preventDefault();

			// If the media frame already exists, reopen it.
			if ( frame ) {
				frame.open();
				return;
			}

			// Create the media frame.
			frame = wp.media.frames.customHeader = wp.media({
				// Set the title of the modal.
				title: $el.data('choose'),

				// Tell the modal to show only images.
				library: {
					type: 'image'
				},

				// Customize the submit button.
				button: {
					// Set the text of the button.
					text: $el.data('update'),
					// Tell the button not to close the modal, since we're
					// going to refresh the page when the image is selected.
					//close: false
				}
			});

			// When an image is selected, run a callback.
			frame.on( 'select', function() {
				// Grab the selected attachment.
				var attachment = frame.state().get('selection').first(),
					field = $el.data('field'),
					preview = $el.data('preview'),
					src = '';
				
				if ('undefined' !== typeof attachment.attributes.sizes.medium) {
					src = attachment.attributes.sizes.medium.url;
				}
				else {
					src = attachment.attributes.url;
				}
				
				$('[name='+field+']').val(attachment.id);
				$('[name='+preview+']').attr('src', src);
			});

			frame.open();
		});
		
		$('.remove-image-link').click( function( event ) {
			var $el = $(this);
			event.preventDefault();
			
			var field = $el.data('field'),
				preview = $el.data('preview');
			
			$('[name='+field+']').val('');
			$('[name='+preview+']').attr('src', '');
		});
	});
}(jQuery));

