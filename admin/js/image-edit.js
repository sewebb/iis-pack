(function( $, wp, _ ) {
	var AdvancedImageDetailsView, frame;


	function addAdvancedView( view ) {
		var advancedView;

		advancedView = new AdvancedImageDetailsView( { model: view.model } );

		view.on( 'post-render', function() {
			view.views.insert( view.$el.find('.advanced-image'), advancedView.render().el );
		} );
	}

	wp.media.events.on( 'editor:image-edit', function( options ) {
		var dom = options.editor.dom,
			image = options.image,
			attributes;

		attributes = {
			borderWidth: dom.getStyle( image, 'borderWidth' ),
			borderColor: dom.getStyle( image, 'borderColor' ),
			marginTop: dom.getStyle( image, 'marginTop' ),
			marginLeft: dom.getStyle( image, 'marginLeft' ),
			marginRight: dom.getStyle( image, 'marginRight' ),
			marginBottom: dom.getStyle( image, 'marginBottom' )
		};

		options.metadata = _.extend( options.metadata, attributes );
	} );

	wp.media.events.on( 'editor:frame-create', function( options ) {
		frame = options.frame;
		frame.on( 'content:render:image-details', addAdvancedView );
	} );

	wp.media.events.on( 'editor:image-update', function( options ) {
		var dom = options.editor.dom,
			image  = options.image,
			model = frame.content.get().model;

		if ( model.get('borderWidth') ) {
			dom.setStyles( image, {
				'border-width': model.get('borderWidth') + 'px',
				'border-style': 'solid',
				'border-color': model.get('borderColor') ? model.get('borderColor' ) : '#000'
			} );
		}
	} );

	AdvancedImageDetailsView = wp.Backbone.View.extend({
		template: wp.media.template('image-details-extended'),

		prepare: function() {
			return this.model.toJSON();
		}
	});

})( jQuery, wp, _ );
