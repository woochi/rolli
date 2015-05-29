$ = jQuery = require("jquery")
Modernizr = require("modernizr")
Foundation = require("foundation")
ScrollButton = require("./scroll_button.coffee")

$ ->
  $(document).foundation()
  ScrollButton.initialize()


# Theme JS
#StickyNavigation = require("./sticky_navigation.coffee")

#FastClick = require("fastclick")

#LazyLoad = require("./lazy_load.coffee")

#StickyNavigation.initialize()


#LazyLoad.initialize()
