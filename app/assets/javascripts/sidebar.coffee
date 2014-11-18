Helpers = require("./helpers.coffee")

Sidebar =

  initialize: ->
    $body = $("body")
    $toggle = $(".sidebar-toggle")
    $content = $(".content")
    $mask = $("<div>").addClass("overlay-mask")

    toggleSidebar = ->
      if !$body.hasClass("sidebar-open-active")
        $content.append $mask
        $body.addClass("sidebar-open")
        setTimeout ->
          $body.addClass("sidebar-open-active")
          $body.one Helpers.transitionend(), ->
            $body.removeClass("sidebar-open")
        , 0
      else
        $body.addClass("sidebar-close")
        $body.removeClass("sidebar-open-active")
        $body.addClass("sidebar-close-active")
        $body.one Helpers.transitionend(), ->
          $body.removeClass("sidebar-close")
          $body.removeClass("sidebar-close-active")
          $mask.detach()
    $mask.on "click", toggleSidebar
    $toggle.on "click", toggleSidebar

module.exports = Sidebar
