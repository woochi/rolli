console.log "PREVIEW COFFEE"
wp.customize "rolli_header_logo", (change) ->
  change.bind (val) ->
    console.log "UPDATE", val, $("#header-logo").length
    $("#header-logo").css("background-image", "url(#{val})")
