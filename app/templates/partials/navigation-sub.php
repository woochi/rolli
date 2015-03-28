<?php
if ($post->post_parent) {
  //get the parrent and see if it'a a top page (has no parent)
  $parent = get_page($post->post_parent);
  if ($parent->post_parent) {
    //if it's not a top page, then his parent should be
    $children = wp_list_pages('title_li=&child_of=' . $parent->post_parent . '&echo=0');
  } else {
    $children = wp_list_pages('title_li=&child_of=' . $post->post_parent . '&echo=0');
  }
} else {
  $children = wp_list_pages('title_li=&child_of=' . $post->ID . '&echo=0');
}
if ($children) { ?>
  <ul class="side-nav">
  <?php
    if ($post->ancestors[1]) {
      $ancestor_title = get_the_title($post->ancestors[1]);
      $ancestor_link = get_permalink($post->ancestors[1]);
    ?>
    <li><a href="<?php echo $ancestor_link; ?>"><?php echo $ancestor_title; ?></a></li>
    <?php } elseif ($post->post_parent) {
      $parent_title = get_the_title($post->post_parent);
      $parent_link = get_permalink($post->post_parent);
    ?>
    <li><a href="<?php echo $parent_link; ?>"><?php echo $parent_title; ?></a></li>
    <?php } else { ?>
    <li class="current_page_item"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></li>
    <?php } echo $children;?>
  </ul>
<?php } ?>
