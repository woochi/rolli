Helpers =

	animationstart: ->
		animationStartNames =
			'WebkitAnimation' : 'webkitAnimationStart'
			'OAnimation' : 'oAnimationSart'
			'msAnimation' : 'MSAnimationStart'
			'animation' : 'animationstart'
		animationStartNames[Modernizr.prefixed( 'animation' )]

	animationend: ->
		animationEndNames =
			'WebkitAnimation' : 'webkitAnimationEnd'
			'OAnimation' : 'oAnimationEnd'
			'msAnimation' : 'MSAnimationEnd'
			'animation' : 'animationend'
		animationEndNames[Modernizr.prefixed( 'animation' )]

	animationiteration: ->
		animationIterationNames =
			'WebkitAnimation' : 'webkitAnimationIteration'
			'OAnimation' : 'oAnimationIteration'
			'msAnimation' : 'MSAnimationIteration'
			'animation' : 'animationiteration'
		animationIterationNames[Modernizr.prefixed( 'animation' )]

	transitionend: ->
		transitionEndNames =
			animationEndNames =
			'WebkitTransition' : 'webkitTransitionEnd'
			'OTransition' : 'oTransitionEnd'
			'msTransition' : 'MSTransitionEnd'
			'transition' : 'transitionend'
		transitionEndNames[Modernizr.prefixed( 'transition' )]

module.exports = Helpers
