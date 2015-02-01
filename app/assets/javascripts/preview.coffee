wp.customize "rolli_header_logo", (change) ->
  change.bind (val) ->
    $("#header-logo").css("background-image", "url(#{val})")
