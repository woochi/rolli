velocity = require("velocity")
require("velocity.ui")

exports.hero = ->
  options =
    display: "block"
    delay: 100
    easing: "easeOutExp"
    duration: 500
    stagger: 150
  $.Velocity.animate($(".hero-title, .hero-subtitle, .scroll-down-button"), "transition.slideDownIn", options)
    .then ->
      scrollButton = $(".scroll-down-button")
      scrollButtonBounce = setTimeout ->
        options =
          duration: 250
          easing: "easeOutQuad"
        scrollButton
          .velocity(translateY: [10, 0], options)
          .velocity(translateY: [0, 10], options)
          .velocity(translateY: [10, 0], options)
          .velocity(translateY: [0, 10], options)
      , 1000
      # TODO: cancel bounce if user scrolls
