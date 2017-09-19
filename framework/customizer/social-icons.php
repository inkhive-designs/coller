<?php
// Social Icons
function coller_customize_register_social( $wp_customize ) {
$wp_customize->add_section('coller_social_section', array(
    'title' => __('Social Icons','coller'),
    'priority' => 44 ,
));

$social_networks = array( //Redefinied in Sanitization Function.
    'none' => __('-','coller'),
    'facebook' => __('Facebook','coller'),
    'twitter' => __('Twitter','coller'),
    'google-plus' => __('Google Plus','coller'),
    'instagram' => __('Instagram','coller'),
    'rss' => __('RSS Feeds','coller'),
    'vine' => __('Vine','coller'),
    'vimeo-square' => __('Vimeo','coller'),
    'youtube' => __('Youtube','coller'),
    'flickr' => __('Flickr','coller'),
);

$social_count = count($social_networks);

for ($x = 1 ; $x <= ($social_count - 3) ; $x++) :

    $wp_customize->add_setting(
        'coller_social_'.$x, array(
        'sanitize_callback' => 'coller_sanitize_social',
        'default' => 'none'
    ));

    $wp_customize->add_control( 'coller_social_'.$x, array(
        'settings' => 'coller_social_'.$x,
        'label' => __('Icon ','coller').$x,
        'section' => 'coller_social_section',
        'type' => 'select',
        'choices' => $social_networks,
    ));

    $wp_customize->add_setting(
        'coller_social_url'.$x, array(
        'sanitize_callback' => 'esc_url_raw'
    ));

    $wp_customize->add_control( 'coller_social_url'.$x, array(
        'settings' => 'coller_social_url'.$x,
        'description' => __('Icon ','coller').$x.__(' Url','coller'),
        'section' => 'coller_social_section',
        'type' => 'url',
        'choices' => $social_networks,
    ));

endfor;

function coller_sanitize_social( $input ) {
    $social_networks = array(
        'none' ,
        'facebook',
        'twitter',
        'google-plus',
        'instagram',
        'rss',
        'vine',
        'vimeo-square',
        'youtube',
        'flickr'
    );
    if ( in_array($input, $social_networks) )
        return $input;
    else
        return '';
}
}
add_action( 'customize_register', 'coller_customize_register_social' );