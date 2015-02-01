# Theme JS
Sidebar = require("./sidebar.coffee")
#StickyNavigation = require("./sticky_navigation.coffee")
Parallax = require("./parallax.coffee")
FastClick = require("fastclick")
ScrollButton = require("./scroll_button.coffee")
LazyLoad = require("./lazy_load.coffee")

Sidebar.initialize()
#StickyNavigation.initialize()
Parallax.initialize() unless head.mobile
ScrollButton.initialize()
LazyLoad.initialize()
