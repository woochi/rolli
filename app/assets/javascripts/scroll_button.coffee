ScrollButton =

  initialize: ->
    $hero = $(".cover")
    $content = $(".off-canvas-wrap")
    $button = $(".cover-scroll-btn")
    $scrollUp = $(".scroll-up")
    console.log $button.length
    $button.click ->
      $content.animate(scrollTop: $hero.height())
    $scrollUp.click ->
      $content.animate(scrollTop: 0)

module.exports = ScrollButton
