( function ( $ ) {
	/**
	 * Class Loadmore.
	 */
	class LoadMore {
		/**
		 * Contructor.
		 */
		constructor() {
			this.ajaxUrl = ajaxConfig?.ajaxUrl ?? ''
			this.ajaxNonce = ajaxConfig?.ajax_nonce ?? ''
			this.loadMoreBtn = $( '#load-more' )

			this.init()
		}

		init() {
			if ( ! this.loadMoreBtn.length ) {
				return;
			}

			this.loadMoreBtn.on('click', () => this.handleLoadMorePosts() )
		}

		/**
		 * Load more posts.
		 */
		handleLoadMorePosts() {
			// Get page no from data attribute of load-more button.
			const page = this.loadMoreBtn.data( 'page' )
			if ( ! page ) {
				return null
			}

			const newPage = parseInt( page ) + 1; // Increment page count by one.

			$.ajax( {
				url: this.ajaxUrl,
				type: 'post',
				data: {
					page: page,
					action: 'load_more',
					ajax_nonce: this.ajaxNonce,
				},
				success: ( response ) => {
               if ( 0 === parseInt( response )) {
                  this.loadMoreBtn.remove();
               } else {
                  this.loadMoreBtn.data( 'page', newPage )
                  $( '#load-more-content' ).append( response )
               }
				},
				error: ( response ) => {
					console.log( response );
				},
			} );
		}
		
	}

	new LoadMore();
} )( jQuery );
