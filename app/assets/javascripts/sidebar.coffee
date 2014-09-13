Bacon = require("bacon")
Helpers = require("./helpers.coffee")
velocity = require("velocity")
require("velocity.ui")

getDocumentHeight = -> $(document).height()

Sidebar =

  initialize: ->
    open = $(".sidebar-toggle").asEventStream("click").map(true)
    close = $(".overlay-mask").asEventStream("click").map(false)
    sidebarOpen = open.merge(close).toProperty(false)
    sidebarOpen.changes().onValue (isOpen) ->
      direction = if isOpen then "opening" else "closing"
      body = $("body")
      body.addClass "sidebar-#{direction}"
      body.toggleClass("sidebar-open", isOpen)
      body.one Helpers.transitionend(), ->
        body.removeClass("sidebar-#{direction}")

module.exports = Sidebar
