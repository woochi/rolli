<?php

// Load HTML5 Blank styles
function html5blank_styles()
{
    wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('html5blank'); // Enqueue it!
}

function script_uri($path = "")
{
    return (get_template_directory_uri() . '/javascripts/' . $path);
}

function rolli_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

        // Deregister default scripts
        wp_deregister_script('jquery');
        wp_deregister_script('comment-reply');

        // Register head.js for async script loading
        wp_register_script('head.js', script_uri('head.min.js'));
        wp_enqueue_script('head.js');
    }
}

// Add Actions
add_action( 'admin_enqueue_scripts', 'rolli_admin_styles' );
add_action('init', 'rolli_scripts'); // Add Custom Scripts to wp_head
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
//add_action('init', 'create_post_type_html5'); // Add our HTML5 Blank Custom Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination
add_action('customize_register', 'rolli_customize_register'); // Customization menus
add_action('wp_head', 'rolli_customize_css');
add_action( 'customize_preview_init' , 'rolli_customize_live_preview');

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation
        'sticky-menu' => __('Sticky Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

function rolli_admin_styles()
{
    wp_register_style( 'rolli_admin', get_template_directory_uri() . '/admin.css' );
    wp_enqueue_style( 'rolli_admin' );
}

function rolli_customize_css()
{
    /*
    ?>
    <!--Customizer CSS-->
    <style type="text/css">
        <?php css_rule('#site-title a', 'color', 'header_textcolor', '#'); ?>
        <?php css_rule('body', 'background-color', 'background_color', '#'); ?>
        <?php css_rule('a', 'color', 'link_textcolor'); ?>
    </style>
    <!--/Customizer CSS-->
    <?php
    */
}

function rolli_customize_live_preview()
{
    wp_register_script('rolli_preview', get_template_directory_uri() . '/javascripts/preview.js', array('jquery'), '1.0.0', true); // Custom
    wp_enqueue_script('rolli_preview');
}

function css_rule($selector, $prop, $style)
{
    $rule = "";
    $rule = sprintf('%s {$s:$s;}', $selector, $prop, $style);
    return $rule;
}

// Create 1 Custom Post type for a Demo, called HTML5-Blank
function create_post_type_html5()
{
    register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'html5-blank');
    register_post_type('html5-blank', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('HTML5 Blank Custom Post', 'html5blank'), // Rename these to suit
            'singular_name' => __('HTML5 Blank Custom Post', 'html5blank'),
            'add_new' => __('Add New', 'html5blank'),
            'add_new_item' => __('Add New HTML5 Blank Custom Post', 'html5blank'),
            'edit' => __('Edit', 'html5blank'),
            'edit_item' => __('Edit HTML5 Blank Custom Post', 'html5blank'),
            'new_item' => __('New HTML5 Blank Custom Post', 'html5blank'),
            'view' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'view_item' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'search_items' => __('Search HTML5 Blank Custom Post', 'html5blank'),
            'not_found' => __('No HTML5 Blank Custom Posts found', 'html5blank'),
            'not_found_in_trash' => __('No HTML5 Blank Custom Posts found in Trash', 'html5blank')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}

function rolli_customize_register($wp_customize)
{

    // Customizable theme options
    $wp_customize->add_setting('rolli_header_logo', array(
        'default' => '',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('rolli_footer_logo', array(
        'default' => '',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('rolli_theme_options[footer_text_left]', array(
        'default' => get_bloginfo("name")
    ));
    $wp_customize->add_setting('rolli_theme_options[footer_text_right]', array(
        'default' => get_bloginfo("description")
    ));

    // Customization menus

    // Logos
    $wp_customize->add_section("rolli_theme_logos", array(
        'title' => __('Site Logos', 'rolli'),
        'description' => ''
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'rolli_header_logo',
        array(
            'label' => __('Header Logo', 'rolli'),
            'section' => 'rolli_theme_logos',
            'settings' => 'rolli_header_logo',
            'priority' => 1
        )
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'rolli_footer_logo',
        array(
            'label' => __('Footer Logo', 'rolli'),
            'section' => 'rolli_theme_logos',
            'settings' => 'rolli_footer_logo',
            'priority' => 2
        )
    ));

    // Texts
    $wp_customize->add_section("rolli_theme_texts", array(
        'title' => __('Site Texts', 'rolli'),
        'description' => ''
    ));
    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'rolli_control_footer_text_left',
        array(
            'label' => __('Footer Left Side Text', 'rolli'),
            'section' => 'rolli_theme_texts',
            'settings' => 'rolli_theme_options[footer_text_left]',
            'priority' => 1
        )
    ));
    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'rolli_control_footer_text_right',
        array(
            'label' => __('Footer Right Side Text', 'rolli'),
            'section' => 'rolli_theme_texts',
            'settings' => 'rolli_theme_options[footer_text_right]',
            'priority' => 2
        )
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

?>
