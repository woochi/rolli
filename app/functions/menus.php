<?php

// Register menus
add_action('init', 'register_menus');
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args');
add_filter('page_css_class', 'nav_item_class', 100, 1);
// Remove Navigation <li> injected classes (Commented out by default)
add_filter('nav_menu_css_class', 'nav_item_class', 100, 1);
// Remove Navigation <li> injected ID (Commented out by default)
add_filter('nav_menu_item_id', 'nav_item_class', 100, 1);

function register_menus()
{
    // Using array to specify more menus if needed
    register_nav_menus(array(
        'header' => __('Header Menu', 'html5blank'),
        'sidebar' => __('Sidebar Menu', 'html5blank'),
        'footer' => __("Footer Menu", "html5blank"),
        'kievari' => "Kievari Menu"
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    $args['menu_class'] = 'nav-list';
    return $args;
}

function nav_item_class($var) {
  $classes = array("nav-item");
  if (in_array('current_page_item', $var)) {
    array_push($classes, 'nav-item-current');
  }
  return is_array($var) ? $classes : "";
}

// Rolli navigation
function rolli_nav($custom_options = array())
{
    $defaults = array(
        'theme_location'  => 'header-menu',
        'menu'            => '',
        'menu_class'      => 'nav-list',
        'menu_id'         => '',
        'container'       => false,
        'container_class' => '',
        'container_id'    => '',
        'echo'            => true,
        'fallback_cb'     => '',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
        'depth'           => 0,
        'walker'          => ''
    );
    $options = array_merge($defaults, $custom_options);
    //$locations = get_nav_menu_locations();
    //$menu_name = $options['theme_location'];
    //$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
    //$items = wp_get_nav_menu_items($menu->term_id);

    wp_nav_menu($options);
}

function rolli_sidebar_toggle($class_name = "")
{
    $class_name = join(" ", array("sidebar-toggle", $class_name));
    $sidebar_toggle = '<a class="'.$class_name.'" role="button" title="Avaa sivuvalikko">';
    $sidebar_toggle .= '<span class="icon-menu"></span>Valikko</a>';
    return $sidebar_toggle;
}

?>
