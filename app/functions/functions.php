<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

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
	'default-image'			=> get_template_directory_uri() . '/images/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

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

// Load HTML5 Blank styles
function html5blank_styles()
{
    wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('html5blank'); // Enqueue it!
}

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

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

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

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($class_name = '', $length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p class="' . $class_name . '">' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    return '';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
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

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

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

function new_excerpt_more( $more ) {
  global $post;
  if ($post->post_type == 'testimonial'){
    return '';
  }
}
add_filter('excerpt_more', 'new_excerpt_more');
// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 99);
add_filter( 'the_content', 'shortcode_unautop', 100);

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Allow SVG uploads
add_filter('upload_mimes', 'svg_mime_types');

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.
add_shortcode('rolli-recent_posts', 'rolli_recent_posts');
add_shortcode('rolli-header', 'rolli_header');
add_shortcode('rolli-quote', 'rolli_quote');
add_shortcode('rolli-image-banner', 'rolli_image_banner');
add_shortcode('rolli-icon-button', 'rolli_icon_button');
add_shortcode('rolli-feature', 'rolli_feature');
add_shortcode('rolli-image-feature', 'rolli_image_feature');
add_shortcode('rolli-icon-feature', 'rolli_icon_feature');
add_shortcode('rolli-countdown', 'rolli_countdown');

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

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

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}

// Shortcode Demo with simple <h2> tag
function rolli_recent_posts($atts) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    $query = new WP_Query(
        array( 'orderby' => 'date', 'posts_per_page' => '1')
    );

    while($query->have_posts()) : $query->the_post();
        $style = "";
        $wrapper_class_name = "recent-post-wrapper";
        if (has_post_thumbnail()) {
            $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0];
            $style .= 'background-image: url(' . $image . ');';
            $wrapper_class_name .= " has-image";
        }

        $section = '<section class="' . $wrapper_class_name . '" style="' . $style . '">';
        $section .= '<a class="recent-post-link" href="' . get_permalink() . '">';
        $section .= '<div class="row"><div class="column medium-10 medium-centered">';
        $section .= '<div class="recent-post-list-header">' . __('Latest from the blog', 'html5blank') . '</div>';
        $section .= '<ul class="recent-post-list">';
        $section .= '<li class="recent-post">';
        $section .= '<h3 class="recent-post-title">' . get_the_title() . '</h3>';
        $section .= '<div class="recent-post-excerpt">' . get_the_excerpt() . '</div>';
        $section .= '</li>';
        $section .= '</ul></div></div></a></section>';
    endwhile;

    return $section;
}

function rolli_header($atts, $content = "")
{
    $style = "";
    $header_class_name = "hero";
    if (has_post_thumbnail()) {
        $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0];
        $style .= 'background-image: url(' . $image . ');';
        $header_class_name .= " has-image";
    }
    $header = '<header class="'.$header_class_name.'">';
    $header .= '<span class="hero-background" style="'.$style.'"></span>';
    $header .= '<div class="hero-content-wrapper">';
    $header .= '<div class="hero-content">';
    $header .= do_shortcode($content);
    $header .= '</div><div class="scroll-down-button" role="button" title="Siirry alaspäin"></div>';
    $header .= '</div></header>';
    return do_shortcode($header);
}

function rolli_quote($atts, $content = "")
{
    $quote = '<blockquote class="feature-quote">' . $content . '</blockquote>';
    return $quote;
}

function rolli_facebook_feed($atts, $content = "")
{

    return "";
}

function create_image_section($content, $background)
{

    $wrapper_class_name = "recent-post-wrapper has-image";
    $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0];
    $style = 'background-image: url(' . $image . ');';

    $section = '<section class="' . $wrapper_class_name . '" style="' . $style . '">';
    $section .= '<a class="recent-post-link" href="' . get_permalink() . '">';
    $section .= '<div class="row"><div class="column medium-10 medium-centered">';
    $section .= '<div class="recent-post-list-header">' . __('Latest from the blog', 'html5blank') . '</div>';
    $section .= '<ul class="recent-post-list">';
    $section .= '<li class="recent-post">';
    $section .= '<h3 class="recent-post-title">' . get_the_title() . '</h3>';
    $section .= '<div class="recent-post-excerpt">' . get_the_excerpt() . '</div>';
    $section .= '</li>';
    $section .= '</ul></div></div></a></section>';

    return $section;
}

function rolli_image_banner($atts, $content)
{
    $wrapper_class_name = "image-banner has-image";
    $style = 'background-image: url(' . $atts["image"] . ');';

    $section = '<section class="' . $wrapper_class_name . '" style="' . $style . '">';
    $section .= '<div class="image-banner-content">';
    $section .= '<div class="row"><div class="column medium-10 medium-centered">';
    $section .= $content;
    $section .= '</div></div></div></section>';

    return $section;
}

function rolli_icon_button($atts, $content)
{
    $icon = "";
    ob_start();
    get_template_part("images/inline", $atts["icon"] . ".svg");
    $icon .= ob_get_contents();
    ob_end_clean();

    $href = $atts["href"];

    $class_name = "";
    if ($atts["class"]) {
        $class_name = $atts["class"];
    } else {
        $class_name = "button";
    }

    $properties = "class='" . $class_name . "'";
    if ($href) $properties .= " href='" . $href . "' target='_blank'";

    $button = "<a " . $properties . ">";
    $button .= $icon;
    $button .= $content;
    $button .= "</a>";
    return $button;
}

function rolli_image_feature($atts, $content)
{
    $image = $atts['image'];
    $align = $atts['align'];

    $el = "<section class='image-feature'>";
    $el .= "<div class='image-feature-media lazy-load' data-image-uri='".$image."'></div>";
    $el .= "<div class='image-feature-content row ".$align."'>";
    $el .= "<div class='column small-11 medium-12 small-centered'>";
    $el .= $content;
    $el .= "</div>";
    $el .= "</div>";
    $el .= "</section>";
    return do_shortcode($el);
}

function rolli_icon_feature($atts, $content)
{
    $image = $atts['image'];

    $el = "<section class='feature'>";
    $el .= "<div class='feature-content'>";
    $el .= "<div class='row'>";
    $el .= "<div class='column small-6 medium-4 small-centered large-uncentered'>";
    $el .= "<img class='feature-image' src='".$image."'>";
    $el .= "</div>";
    $el .= "<div class='column small-11 medium-8 large-7 large-push-1 small-centered large-uncentered'>";
    $el .= $content;
    $el .= "</div></div></div>";
    $el .= "</section>";
    return do_shortcode($el);
}

function rolli_feature($atts, $content)
{
    $attributes = "";
    $id = $atts['id'];
    if (id) {$attributes .= "id='".$id."'";};

    $el = "<section class='feature' ".$attributes.">";
    $el .= "<div class='feature-content'>";
    $el .= $content;
    $el .= "</div>";
    $el .= "</section>";
    return do_shortcode($el);
}

function deg_to_rad($deg)
{
    return pi()*$deg/180;
}

function seconds_to_days($seconds)
{
    $dtf = new DateTime("@0");
    $dtt = new DateTime("@$seconds");
    return $dtf->diff($dtt)->format("%a");
}

function rolli_countdown($atts)
{
    $options = shortcode_atts(array(
        'start' => new DateTime(),
        'end' => new DateTime()
    ), $atts);

    $radius = 240;
    $start_time = strtotime($options['start']); //1433203200
    $current_time = time(); //1423235577
    $end_time = strtotime($options['end']); // 1433462400
    $remaining = $end_time - $current_time;
    $relative_remaining = ($end_time - $current_time) / ($end_time - $start_time);
    $dash_array = pi()*$radius*2;
    $dash_offset = pi()*$radius*2*(1-$relative_remaining);


    // TODO: Handle 0 remaining

    $el = "<div class='countdown'>";
    $el .= "<svg class='countdown' viewBox='0 0 500 500' preserveAspectRatio='xMinYMin meet'>";
    $el .= sprintf("<circle cx='250' cy='250' r='%u' class='countdown-full'></circle>", $radius);
    $el .= sprintf("<circle cx='250' cy='250' r='%u' class='countdown-remaining' stroke-dasharray='%f' stroke-dashoffset='0' style='stroke-dashoffset: %fpx;'></circle>", $radius, $dash_array, $dash_offset);
    $el .= "</svg>";
    $el .= sprintf("<label class='countdown-amount'>%u <span class='countdown-unit'>päivää</span></label>", seconds_to_days($remaining));
    $el .= "</div>";
    return $el;
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

function svg_mime_types( $mimes )
{
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}

?>
