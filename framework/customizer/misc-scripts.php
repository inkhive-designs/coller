<?php
//upgrade
function coller_customize_register_misc( $wp_customize ) {
$wp_customize->add_section(
    'coller_sec_upgrade',
    array(
        'title'     => __('Discover Coller Pro','coller'),
        'priority'  => 45,
    )
);

$wp_customize->add_setting(
    'coller_upgrade',
    array( 'sanitize_callback' => 'esc_textarea' )
);

$wp_customize->add_control(
    new WP_Customize_Upgrade_Control(
        $wp_customize,
        'coller_upgrade',
        array(
            'label' => __('More of Everything','coller'),
            'description' => __('Coller Pro has more of Everything. More New Features, More Options, Unlimited Colors, 650+ Fonts, More Layouts, Configurable Slider, Inbuilt Advertising Options, Multiple Skins, More Widgets, and a lot more options and comes with Dedicated Support. To Know More about the Pro Version, click here: <a href="http://rohitink.com/product/coller-pro/">Upgrade to Pro</a>.','coller'),
            'section' => 'coller_sec_upgrade',
            'settings' => 'coller_upgrade',
        )
    )
);
}
add_action( 'customize_register', 'coller_customize_register_misc' );