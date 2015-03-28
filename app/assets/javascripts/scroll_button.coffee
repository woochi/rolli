ScrollButton =

  initialize: ->
    $hero = $(".hero")
    $content = $(".content")
    $button = $(".scroll-down-button")
    $scrollUp = $(".scroll-up")
    $button.click ->
      $content.animate(scrollTop: $hero.height())
    $scrollUp.click ->
      $content.animate(scrollTop: 0)

module.exports = ScrollButton
