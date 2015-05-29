<?php

add_shortcode('cover', 'cover');
add_shortcode('feature', 'feature');
add_shortcode('countdown', 'countdown');
add_shortcode('intro', 'intro');
add_shortcode('article-section', 'article_section');
add_shortcode('article-footer', 'article_footer');
add_shortcode('article-hero', 'article_hero');
add_shortcode('article-intro', 'article_intro');

function cover($atts, $content){
    return render_template("cover.php", $atts, $content);
}

function feature($atts, $content){
    $locals = shortcode_atts(array(
        "id" => NULL,
        "align" => "left",
        "class_name" => "feature"
    ), $atts);
    if (array_key_exists("background", $atts)) {
        $locals["style"] = "background-image: url('".$atts["background"]."');";
        $locals["class_name"] = "feature image-feature";
    }
    return render_template("feature.php", $locals, $content);
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

function countdown($atts)
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
    $days_remaining = seconds_to_days($remaining);

    // TODO: Handle 0 remaining
    $locals = array(
        'radius' => $radius,
        'dash_array' => $dash_array,
        'dash_offset' => $dash_offset,
        'days_remaining' => $days_remaining
    );

    error_log("COUNTDOWN");
    return render_template("countdown.php", $locals);
}

function intro($atts, $content)
{
    return render_template("intro.php", $atts, $content);
}

function article_section($atts, $content){
    return render_template("article_section.php", $atts, $content);
}

function article_footer($atts, $content){
    return render_template("article_footer.php", $atts, $content);
}

function article_hero($atts, $content){
    return render_template("article_hero.php", $atts, $content);
}

function article_intro($atts, $content){
    return render_template("article_intro.php", $atts, $content);
}

?>
