capitalize = (text) ->
	text[0].toUpperCase() + text.slice(1)

prefixed = (feature) ->
	if head.browser.webkit or head.browser.chrome
		"Webkit#{capitalize(feature)}"
	else if head.browser.ie
		"ms#{capitalize(feature)}"
	else if head.browser.opera
		"O#{capitalize(feature)}"
	else
		feature

Helpers =

	animationstart: ->
		animationStartNames =
			'WebkitAnimation' : 'webkitAnimationStart'
			'OAnimation' : 'oAnimationSart'
			'msAnimation' : 'MSAnimationStart'
			'animation' : 'animationstart'
		animationStartNames[prefixed( 'animation' )]

	animationend: ->
		animationEndNames =
			'WebkitAnimation' : 'webkitAnimationEnd'
			'OAnimation' : 'oAnimationEnd'
			'msAnimation' : 'MSAnimationEnd'
			'animation' : 'animationend'
		animationEndNames[prefixed( 'animation' )]

	animationiteration: ->
		animationIterationNames =
			'WebkitAnimation' : 'webkitAnimationIteration'
			'OAnimation' : 'oAnimationIteration'
			'msAnimation' : 'MSAnimationIteration'
			'animation' : 'animationiteration'
		animationIterationNames[prefixed( 'animation' )]

	transitionend: ->
		transitionEndNames =
			'WebkitTransition' : 'webkitTransitionEnd'
			'OTransition' : 'oTransitionEnd'
			'msTransition' : 'MSTransitionEnd'
			'transition' : 'transitionend'
		transitionEndNames[prefixed( 'transition' )]

module.exports = Helpers
