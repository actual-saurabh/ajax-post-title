// yaAPT is localised with WordPress
jQuery( 'document' ).ready( function( $ ) {

	/**
	 * Semantically wraps Post Title and appends it to the Body
	 * 
	 * @param {string} title The post title
	 * @returns {undefined}
	 */
	function appendTitle( title ) {

		// create a new element
		var titleElement = $( '<h1/>' );
		// add the post title
		titleElement.html(title);
		// add a class
		titleElement.addClass( yaAPT.prefix+'title' );
		// add to body
		$( 'body' ).prepend( titleElement );

	}

	// if the localised variable is undefined, bail
	if ( typeof yaAPT === "undefined" ) {
		return;
	}

	// if localised variable is empty or not an object, bail
	if ( typeof yaAPT === null || typeof yaAPT !== "object" ) {
		return;
	}

	// form object to send with the request
	var postData = {
		'action': yaAPT.prefix+'ajax',
		'post_id': yaAPT.post_id,
		'nonce': yaAPT.nonce
	};

	// ajax request
	$.get( yaAPT.ajax_url, postData ).always( function( response ) {

		// if there's no response
		if ( typeof response === "undefined" || typeof response === null ) {
			console.log( yaAPT.msg_prefix + yaAPT.msg_ajax_fail );
			return;
		}

		response = JSON.parse(response);
		
		if ( typeof response.post_title === "undefined" || typeof response.post_title === null ) {
			console.log( yaAPT.msg_prefix + yaAPT.msg_title_fail );
			return;
		}

		appendTitle( response.post_title );

	} );

} );