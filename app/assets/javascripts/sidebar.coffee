Bacon = require("bacon")

getDocumentHeight = -> $(document).height()

Sidebar =

  initialize: ->
    scrolls = $(document).asEventStream("scroll")
      .debounceImmediate(100)
    opens = $(".open-nav").asEventStream("click")
      .filter((e) ->
        e.stopImmediatePropagation()
        !$("body").hasClass("nav-open")
      ).map(true)
    closes = $(".wrapper").asEventStream("click")
      .map(false)

    navOpen = opens.merge(closes).merge(scrolls.map(false))
      .skipDuplicates()
      .toProperty($("body").hasClass("nav-open"))
    navCloses = navOpen.changes().filter((open) -> !open)

    navOpen.onValue (open) ->
      $("body").toggleClass "nav-open", open
      if open
        resizes = $(window).asEventStream("resize").takeUntil(navCloses).debounce(500)
        resizes.onEnd -> console.log "ENDED"
        resizes.map(getDocumentHeight)
          .skipDuplicates()
          .toProperty(getDocumentHeight())
          .onValue (height) ->
            $(".nav").height height

module.exports = Sidebar
