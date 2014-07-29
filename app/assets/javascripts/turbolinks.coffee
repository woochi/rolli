Bacon = require("bacon")

replaceContent = (href, contentSelector, eventBus) ->
  eventBus.push "page:loading"
  $.get(href).done (data) ->
    $(contentSelector).replaceWith data
    eventBus.push "page:loaded"
    eventBus.end()

Turbolinks =

  initialize: (contentSelector) ->
    events = new Bacon.Bus()
    linkClicks = $("a").asEventStream("click").takeUntil(events)
    localLinkClicks = linkClicks.filter (e) ->
      link = e.target
      link.hostname && link.hostname == location.hostname

    localLinkClicks.onValue (e) ->
      e.preventDefault()
      replaceContent e.target.href, contentSelector, events

    events

module.exports = Turbolinks
