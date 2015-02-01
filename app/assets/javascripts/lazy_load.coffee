LazyLoad =

  initialize: ->
    for el in $(".lazy-load")
      $el = $(el)
      uri = $el.data("image-uri")
      console.log uri, $el
      $el.css("background-image", "url(#{uri})")

module.exports = LazyLoad
