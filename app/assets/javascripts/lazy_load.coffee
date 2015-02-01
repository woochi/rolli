LazyLoad =

  initialize: ->
    for el in $(".lazy-load")
      $el = $(el)
      uri = $el.data("image-uri")
      $el.css("background-image", "url(#{uri})")

module.exports = LazyLoad
