# Theme JS
Animate = require("./animate.coffee")
Sidebar = require("./sidebar.coffee")
#StickyNavigation = require("./sticky_navigation.coffee")
Parallax = require("./parallax.coffee")
FastClick = require("fastclick")
ScrollButton = require("./scroll_button.coffee")

Sidebar.initialize()
#StickyNavigation.initialize()
Parallax.initialize()
ScrollButton.initialize()

Animate.hero()
