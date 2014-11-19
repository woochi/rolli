Helpers = require("./helpers.coffee")

Sidebar =

  initialize: ->
    $toggle = $(".sidebar-toggle")
    return if $toggle.length is 0
    $body = $("body")
    $content = $(".content")
    $mask = $("<div>").addClass("overlay-mask")

    bindToggles = ->
      $mask.on "click", toggleSidebar
      $toggle.on "click", toggleSidebar

    unbindToggles = ->
      $mask.off "click", toggleSidebar
      $toggle.off "click", toggleSidebar

    toggleSidebar = (e) ->
      e.stopImmediatePropagation()
      unbindToggles()
      if !$body.hasClass("sidebar-open-active")
        $content.append $mask
        $body.addClass("sidebar-open")
        setTimeout ->
          $body.addClass("sidebar-open-active")
          $body.one Helpers.transitionend(), ->
            $body.removeClass("sidebar-open")
            bindToggles()
        , 0
      else
        $body.addClass("sidebar-close")
        $body.removeClass("sidebar-open-active")
        $body.addClass("sidebar-close-active")
        $body.one Helpers.transitionend(), ->
          $body.removeClass("sidebar-close")
          $body.removeClass("sidebar-close-active")
          $mask.detach()
          bindToggles()

    bindToggles()

module.exports = Sidebar
