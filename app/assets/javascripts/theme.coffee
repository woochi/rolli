# Theme JS
Bacon = require("bacon")
velocity = require("velocity")

scrolls = $(document).asEventStream("scroll").debounceImmediate(100)
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

navOpen.onValue (open) ->
  console.log "NAV OPEN", open
  $("body").toggleClass "nav-open", open
