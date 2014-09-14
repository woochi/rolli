velocity = require("velocity")
require("velocity.ui")

exports.hero = ->
  $(".hero-title").velocity "transition.slideDownIn", display: "block", easing: "easeOutQuint"
  $(".hero-subtitle").velocity "transition.slideUpIn", display: "block", easing: "easeOutQuint"
