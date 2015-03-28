<?php

add_action( 'customize_preview_init' , 'rolli_customize_live_preview');

function rolli_customize_live_preview()
{
    wp_register_script('rolli_preview', get_template_directory_uri() . '/javascripts/preview.js', array('jquery'), '1.0.0', true); // Custom
    wp_enqueue_script('rolli_preview');
}

?>