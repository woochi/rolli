<?php
  $class_name = "cover";
  $style = "";
  if (has_post_thumbnail()) {
    $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0];
    $style .= 'background-image: url(' . $image . ');';
    $class_name .= " has-image";
  }
?>

<div class="<?= $class_name ?>">
  <div class="cover-background" style="<?= $style ?>"></div>
  <div class="cover-wrap">
    <div class="cover-content">
      <?= $content ?>
    </div>
    <a class="cover-scroll-btn"></a>
  </div>
</div>
