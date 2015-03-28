Helpers = require("./helpers.coffee")

Sidebar =

  initialize: ->
    $toggle = $(".nav-toggle")
    return if $toggle.length is 0
    $body = $("body")
    $content = $(".content")
    $mask = $("<div>").addClass("overlay-mask")

    transitionend = Helpers.transitionend()

    bindToggles = ->
      $mask.on "click", toggleSidebar
      $toggle.on "click", toggleSidebar

    unbindToggles = ->
      $mask.off "click", toggleSidebar
      $toggle.off "click", toggleSidebar

    startOpen = ->
      $content.on transitionend, finishOpen
      $body.addClass("sidebar-open-active")

    startClose = ->
      $content.on transitionend, finishClose
      $body.addClass("sidebar-close-active")

    finishOpen = (e) ->
      return unless e.target is $content[0]
      $body.removeClass("sidebar-open")
      bindToggles()
      $content.off transitionend, finishOpen

    finishClose = (e) ->
      return unless e.target is $content[0]
      $body.removeClass("sidebar-close")
      $body.removeClass("sidebar-close-active")
      $mask.detach()
      bindToggles()
      $content.off transitionend, finishClose

    toggleSidebar = (e) ->
      e.stopImmediatePropagation()
      unbindToggles()
      if !$body.hasClass("sidebar-open-active")
        $content.append $mask
        $body.addClass("sidebar-open")
        setTimeout startOpen, 0
      else
        $body.addClass("sidebar-close")
        $body.removeClass("sidebar-open-active")
        setTimeout startClose, 0

    bindToggles()

module.exports = Sidebar
