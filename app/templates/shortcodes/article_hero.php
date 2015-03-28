<?php
  $class_name = "hero";
  $style = "";
  if (has_post_thumbnail()) {
    $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0];
    $style .= 'background-image: url(' . $image . ');';
    $class_name .= " has-image";
  }
?>

<div class="<?= $class_name ?>">
  <div class="hero-background" style="<?= $style ?>"></div>
  <div class="hero-wrap">
    <div class="hero-content">
      <?= $content ?>
    </div>
  </div>
</div>
