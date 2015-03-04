<?php

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
    'default-color' => 'FFF',
    'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    add_theme_support('custom-header', array(
    'default-image'         => get_template_directory_uri() . '/images/headers/default.jpg',
    'header-text'           => false,
    'default-text-color'        => '000',
    'width'             => 1000,
    'height'            => 198,
    'random-default'        => false,
    'wp-head-callback'      => $wphead_cb,
    'admin-head-callback'       => $adminhead_cb,
    'admin-preview-callback'    => $adminpreview_cb
    ));

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
    Functions
\*------------------------------------*/



// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Rolli navigation
function rolli_nav($custom_options = array())
{
    $defaults = array(
        'theme_location'  => 'header-menu',
        'menu'            => '',
        'menu_class'      => 'menu',
        'menu_id'         => '',
        'container'       => 'div',
        'container_class' => 'menu-container',
        'container_id'    => '',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
        'depth'           => 0,
        'walker'          => ''
    );
    $options = array_merge($defaults, $custom_options);
    $locations = get_nav_menu_locations();
    $menu_name = $options['theme_location'];
    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
    $items = wp_get_nav_menu_items($menu->term_id);
    $collapsable = $options['collapsable'];

    if (!$collapsable)
    {
        wp_nav_menu($options);
    }
    else if (sizeof($items) < 4)
    {
        echo rolli_sidebar_toggle("show-for-small-only");
        wp_nav_menu($options);
    }
    else
    {
        echo rolli_sidebar_toggle();
    }
}

function rolli_sidebar_toggle($class_name = "")
{
    $class_name = join(" ", array("sidebar-toggle", $class_name));
    $sidebar_toggle = '<a class="'.$class_name.'" role="button" title="Avaa sivuvalikko">';
    $sidebar_toggle .= '<span class="icon-menu"></span>Valikko</a>';
    return $sidebar_toggle;
}

?>