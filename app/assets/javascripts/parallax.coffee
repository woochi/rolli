$ = require("jquery")

Parallax =

  initialize: ->
    $scroller = $(".content")
    $background = $(".cover-background")
    $content = $(".cover-wrap")
    $scrollerNode = $scroller[0]
    $contentNode = $content[0]
    $backgroundNode = $background[0]
    heroHeight = $(".cover").outerHeight()

    scrollPosition = 0
    scrollRatio = 0
    opacity = 1
    offset = 0

    checkScrollState = ->
      if $scrollerNode.scrollTop < heroHeight
        $scroller.off "scroll", checkScrollState
        followScroll()

    applyStyles = ->
      scrollRatio = $scrollerNode.scrollTop / heroHeight
      opacity = 1 - scrollRatio
      offset = 200 * scrollRatio
      if scrollRatio > 1
        unfollowScroll()

      $contentNode.style["opacity"] = opacity + ""
      $backgroundNode.style["transform"] = "translateY(#{offset}px)"

    followScroll = ->
      $contentNode.style["will-change"] = "opacity"
      $backgroundNode.style["will-change"] = "transform"
      $scroller.on "scroll", applyStyles
      applyStyles()

    unfollowScroll = ->
      $contentNode.style["will-change"] = ""
      $backgroundNode.style["will-change"] = ""
      $scroller.off("scroll", applyStyles)
      $scroller.on("scroll", checkScrollState)

    followScroll()

module.exports = Parallax
