ScrollButton =

  initialize: ->
    $hero = $(".hero")
    $content = $(".content")
    $button = $(".scroll-down-button")
    $button.click ->
      $content.animate(scrollTop: $hero.height())

module.exports = ScrollButton
