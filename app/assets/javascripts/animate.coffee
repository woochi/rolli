velocity = require("velocity")
require("velocity.ui")

exports.hero = ->
  $(".hero-title").velocity "transition.slideDownIn"
  $(".hero-subtitle").velocity "transition.slideUpIn", ->
    $(".nav-actions").velocity "transition.fadeIn"
