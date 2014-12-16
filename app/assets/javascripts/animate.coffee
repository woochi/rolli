$ = require("jquery")
Helpers = require("./helpers.coffee")

exports.hero = ->
  animationend = Helpers.transitionend()
  transitionClass = "fade-in-down"
  transitionActiveClass = "#{transitionClass}-active"

  $elements = $(".hero-title, .hero-subtitle, .scroll-down-button")
  $elements.addClass(transitionClass)
  $elements.removeClass("hidden")

  setTimeout ->
    $elements.addClass(transitionActiveClass).one animationend, (e) ->
      transitionClasses = [transitionClass, transitionActiveClass].join(" ")
      $(e.target).removeClass(transitionClasses)
  , 0
