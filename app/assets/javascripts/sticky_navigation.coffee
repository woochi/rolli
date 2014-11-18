Helpers = require("./helpers.coffee")

scrollingUp = ([previousPosition, offset], currentPosition) ->
  newOffset = Math.min(Math.max(0, offset + (previousPosition - currentPosition)), 10)
  return [currentPosition, newOffset]

StickyNavigation =

  initialize: ->
    nav = $(".nav-header").clone().toggleClass("nav-header nav-sticky")
    $(".content-wrapper").prepend nav
    content = $(".content")
    scroll = content.asEventStream("scroll").throttle(200)
    startingOffset = $(".hero").height() - 400

    isScrollingUp = scroll
      .map((e) -> content.scrollTop())
      .scan([0, 0], scrollingUp)
      .map(([previousPosition, offset]) -> offset is 10)
      .skipDuplicates()
    isBelowHeader = scroll
      .filter(isScrollingUp)
      .map((e) -> content.scrollTop() > 200)
      .skipDuplicates()
      .toProperty()

    isBelowHeader.and(isScrollingUp).onValue (visible) ->
      if visible
        nav.off(Helpers.animationend()).removeClass("nav-sticky-closing")
        nav.addClass("nav-sticky-visible nav-sticky-opening")
        nav.one Helpers.animationend(), ->
          nav.removeClass("nav-sticky-opening")
      else
        nav.off(Helpers.animationend()).removeClass("nav-sticky-opening")
        nav.addClass("nav-sticky-closing")
        nav.one Helpers.animationend(), ->
          nav.removeClass("nav-sticky-visible nav-sticky-closing")

module.exports = StickyNavigation
