<?php
  $content_class_name = join(" ", array(
    "feature-content",
    "feature-content-".$align
  ))
?>

<div class="<?= $class_name ?>" style="<?= $style ?>">
  <div class="feature-wrap">
    <div class="row">
      <?= $content ?>
    </div>
  </div>
</div>