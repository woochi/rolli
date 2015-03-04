<?php

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

?>
