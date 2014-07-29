# Theme JS
Bacon = require("bacon")
Animate = require("./animate.coffee")
Turbolinks = require("./turbolinks.coffee")
Sidebar = require("./sidebar.coffee")

turbolinks = Turbolinks.initialize ".wrapper"
Sidebar.initialize turbolinks

turbolinks.onEnd ->
  turbolinks = Turbolinks.initialize ".wrapper"
  Sidebar.initialize turbolinks

Animate.hero()
