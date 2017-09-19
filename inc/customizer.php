<?php
/**
 * coller Theme Customizer
 *
 * @package coller
 */
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function coller_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		
	//Logo Settings
	$wp_customize->add_section( 'title_tagline' , array(
	    'title'      => __( 'Title, Tagline & Logo', 'coller' ),
	    'priority'   => 30,
	) );
	
	$wp_customize->add_setting( 'coller_logo' , array(
	    'default'     => '',
	    'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control(
	    new WP_Customize_Image_Control(
	        $wp_customize,
	        'coller_logo',
	        array(
	            'label' => __('Upload Logo','coller'),
	            'section' => 'title_tagline',
	            'settings' => 'coller_logo',
	            'priority' => 5,
	        )
		)
	);
	
	$wp_customize->add_setting( 'coller_logo_resize' , array(
	    'default'     => 100,
	    'sanitize_callback' => 'coller_sanitize_positive_number',
	) );
	$wp_customize->add_control(
	        'coller_logo_resize',
	        array(
	            'label' => __('Resize & Adjust Logo','coller'),
	            'section' => 'title_tagline',
	            'settings' => 'coller_logo_resize',
	            'priority' => 6,
	            'type' => 'range',
	            'active_callback' => 'coller_logo_enabled',
	            'input_attrs' => array(
			        'min'   => 30,
			        'max'   => 200,
			        'step'  => 5,
			    ),
	        )
	);
	
	function coller_logo_enabled($control) {
		$option = $control->manager->get_setting('coller_logo');
		return $option->value() == true;
	}
	
	
	
	//Replace Header Text Color with, separate colors for Title and Description
	//Override coller_site_titlecolor
	$wp_customize->remove_control('display_header_text');
	$wp_customize->remove_setting('header_textcolor');
	$wp_customize->add_setting('coller_site_titlecolor', array(
	    'default'     => '#e10d0d',
	    'sanitize_callback' => 'sanitize_hex_color',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize, 
		'coller_site_titlecolor', array(
			'label' => __('Site Title Color','coller'),
			'section' => 'colors',
			'settings' => 'coller_site_titlecolor',
			'type' => 'color'
		) ) 
	);
	
	$wp_customize->add_setting('coller_header_desccolor', array(
	    'default'     => '#777',
	    'sanitize_callback' => 'sanitize_hex_color',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize, 
		'coller_header_desccolor', array(
			'label' => __('Site Tagline Color','coller'),
			'section' => 'colors',
			'settings' => 'coller_header_desccolor',
			'type' => 'color'
		) ) 
	);
	
	
	//Settings for Header Image
	$wp_customize->add_setting( 'coller_himg_style' , array(
	    'default'     => 'cover',
	    'sanitize_callback' => 'coller_sanitize_himg_style'
	) );
	
	/* Sanitization Function */
	function coller_sanitize_himg_style( $input ) {
		if (in_array( $input, array('contain','cover') ) )
			return $input;
		else
			return '';	
	}
	
	$wp_customize->add_control(
	'coller_himg_style', array(
		'label' => __('Header Image Arrangement','coller'),
		'section' => 'header_image',
		'settings' => 'coller_himg_style',
		'type' => 'select',
		'choices' => array(
				'contain' => __('Contain','coller'),
				'cover' => __('Cover Completely (Recommended)','coller'),
				)
	) );
	
	$wp_customize->add_setting( 'coller_himg_align' , array(
	    'default'     => 'center',
	    'sanitize_callback' => 'coller_sanitize_himg_align'
	) );
	
	/* Sanitization Function */
	function coller_sanitize_himg_align( $input ) {
		if (in_array( $input, array('center','left','right') ) )
			return $input;
		else
			return '';	
	}
	
	$wp_customize->add_control(
	'coller_himg_align', array(
		'label' => __('Header Image Alignment','coller'),
		'section' => 'header_image',
		'settings' => 'coller_himg_align',
		'type' => 'select',
		'choices' => array(
				'center' => __('Center','coller'),
				'left' => __('Left','coller'),
				'right' => __('Right','coller'),
			)
	) );
	
	$wp_customize->add_setting( 'coller_himg_repeat' , array(
	    'default'     => true,
	    'sanitize_callback' => 'coller_sanitize_checkbox'
	) );
	
	$wp_customize->add_control(
	'coller_himg_repeat', array(
		'label' => __('Repeat Header Image','coller'),
		'section' => 'header_image',
		'settings' => 'coller_himg_repeat',
		'type' => 'checkbox',
	) );
	
	
	//Settings For Logo Area
	
	$wp_customize->add_setting(
		'coller_hide_title_tagline',
		array( 'sanitize_callback' => 'coller_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'coller_hide_title_tagline', array(
		    'settings' => 'coller_hide_title_tagline',
		    'label'    => __( 'Hide Title and Tagline.', 'coller' ),
		    'section'  => 'title_tagline',
		    'type'     => 'checkbox',
		)
	);
	
	$wp_customize->add_setting(
		'coller_branding_below_logo',
		array( 'sanitize_callback' => 'coller_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'coller_branding_below_logo', array(
		    'settings' => 'coller_branding_below_logo',
		    'label'    => __( 'Display Site Title and Tagline Below the Logo.', 'coller' ),
		    'section'  => 'title_tagline',
		    'type'     => 'checkbox',
		    'active_callback' => 'coller_title_visible'
		)
	);
	
	function coller_title_visible( $control ) {
		$option = $control->manager->get_setting('coller_hide_title_tagline');
	    return $option->value() == false ;
	}
	
	
	// SLIDER PANEL
	$wp_customize->add_panel( 'coller_slider_panel', array(
	    'priority'       => 35,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => 'Main Slider',
	) );
	
	$wp_customize->add_section(
	    'coller_sec_slider_options',
	    array(
	        'title'     => 'Enable/Disable',
	        'priority'  => 0,
	        'panel'     => 'coller_slider_panel'
	    )
	);
	
	
	$wp_customize->add_setting(
		'coller_main_slider_enable',
		array( 'sanitize_callback' => 'coller_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'coller_main_slider_enable', array(
		    'settings' => 'coller_main_slider_enable',
		    'label'    => __( 'Enable Slider.', 'coller' ),
		    'section'  => 'coller_sec_slider_options',
		    'type'     => 'checkbox',
		)
	);
	
	$wp_customize->add_setting(
		'coller_main_slider_count',
			array(
				'default' => '0',
				'sanitize_callback' => 'coller_sanitize_positive_number'
			)
	);
	
	// Select How Many Slides the User wants, and Reload the Page.
	$wp_customize->add_control(
			'coller_main_slider_count', array(
		    'settings' => 'coller_main_slider_count',
		    'label'    => __( 'No. of Slides(Min:0, Max: 10)' ,'coller'),
		    'section'  => 'coller_sec_slider_options',
		    'type'     => 'number',
		    'description' => __('Save the Settings, and Reload this page to Configure the Slides.','coller'),
		    
		)
	);
	
	
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
		
	
	if ( get_theme_mod('coller_main_slider_count') > 0 ) :
		$slides = get_theme_mod('coller_main_slider_count');
		
		for ( $i = 1 ; $i <= $slides ; $i++ ) :
			
			//Create the settings Once, and Loop through it.
			
			$wp_customize->add_setting(
				'coller_slide_img'.$i,
				array( 'sanitize_callback' => 'esc_url_raw' )
			);
			
			$wp_customize->add_control(
			    new WP_Customize_Image_Control(
			        $wp_customize,
			        'coller_slide_img'.$i,
			        array(
			            'label' => '',
			            'section' => 'coller_slide_sec'.$i,
			            'settings' => 'coller_slide_img'.$i,			       
			        )
				)
			);
			
			
			$wp_customize->add_section(
			    'coller_slide_sec'.$i,
			    array(
			        'title'     => 'Slide '.$i,
			        'priority'  => $i,
			        'panel'     => 'coller_slider_panel'
			    )
			);
			
			$wp_customize->add_setting(
				'coller_slide_title'.$i,
				array( 'sanitize_callback' => 'sanitize_text_field' )
			);
			
			$wp_customize->add_control(
					'coller_slide_title'.$i, array(
				    'settings' => 'coller_slide_title'.$i,
				    'label'    => __( 'Slide Title','coller' ),
				    'section'  => 'coller_slide_sec'.$i,
				    'type'     => 'text',
				)
			);
			
			$wp_customize->add_setting(
				'coller_slide_desc'.$i,
				array( 'sanitize_callback' => 'sanitize_text_field' )
			);
			
			$wp_customize->add_control(
					'coller_slide_desc'.$i, array(
				    'settings' => 'coller_slide_desc'.$i,
				    'label'    => __( 'Slide Description','coller' ),
				    'section'  => 'coller_slide_sec'.$i,
				    'type'     => 'text',
				)
			);
			
			
			$wp_customize->add_setting(
				'coller_slide_url'.$i,
				array( 'sanitize_callback' => 'esc_url_raw' )
			);
			
			$wp_customize->add_control(
					'coller_slide_url'.$i, array(
				    'settings' => 'coller_slide_url'.$i,
				    'label'    => __( 'Target URL','coller' ),
				    'section'  => 'coller_slide_sec'.$i,
				    'type'     => 'url',
				)
			);
			
		endfor;
	
	
	endif;
	
			
	// Layout and Design
	$wp_customize->add_panel( 'coller_design_panel', array(
	    'priority'       => 40,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => __('Design & Layout','coller'),
	) );
	
	$wp_customize->add_section(
	    'coller_design_options',
	    array(
	        'title'     => __('Blog Layout','coller'),
	        'priority'  => 0,
	        'panel'     => 'coller_design_panel'
	    )
	);
	
	
	$wp_customize->add_setting(
		'coller_blog_layout',
		array( 'sanitize_callback' => 'coller_sanitize_blog_layout' )
	);
	
	function coller_sanitize_blog_layout( $input ) {
		if ( in_array($input, array('grid','grid_2_column','grid_3_column','coller') ) )
			return $input;
		else 
			return '';	
	}
	
	$wp_customize->add_control(
		'coller_blog_layout',array(
				'label' => __('Select Layout','coller'),
				'settings' => 'coller_blog_layout',
				'section'  => 'coller_design_options',
				'type' => 'select',
				'choices' => array(
						'coller' => __('Coller Theme Layout','coller'),
						'coller_flat' => __('Coller Flattened','coller'),
					)
			)
	);
	
	$wp_customize->add_section(
	    'coller_sidebar_options',
	    array(
	        'title'     => __('Sidebar Layout','coller'),
	        'priority'  => 0,
	        'panel'     => 'coller_design_panel'
	    )
	);
	
	$wp_customize->add_setting(
		'coller_disable_sidebar',
		array( 'sanitize_callback' => 'coller_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'coller_disable_sidebar', array(
		    'settings' => 'coller_disable_sidebar',
		    'label'    => __( 'Disable Sidebar Everywhere.','coller' ),
		    'section'  => 'coller_sidebar_options',
		    'type'     => 'checkbox',
		    'default'  => false
		)
	);
	
	$wp_customize->add_setting(
		'coller_disable_sidebar_home',
		array( 'sanitize_callback' => 'coller_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'coller_disable_sidebar_home', array(
		    'settings' => 'coller_disable_sidebar_home',
		    'label'    => __( 'Disable Sidebar on Home/Blog.','coller' ),
		    'section'  => 'coller_sidebar_options',
		    'type'     => 'checkbox',
		    'active_callback' => 'coller_show_sidebar_options',
		    'default'  => false
		)
	);
	
	$wp_customize->add_setting(
		'coller_disable_sidebar_front',
		array( 'sanitize_callback' => 'coller_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'coller_disable_sidebar_front', array(
		    'settings' => 'coller_disable_sidebar_front',
		    'label'    => __( 'Disable Sidebar on Front Page.','coller' ),
		    'section'  => 'coller_sidebar_options',
		    'type'     => 'checkbox',
		    'active_callback' => 'coller_show_sidebar_options',
		    'default'  => false
		)
	);
	
	
	$wp_customize->add_setting(
		'coller_sidebar_width',
		array(
			'default' => 4,
		    'sanitize_callback' => 'coller_sanitize_positive_number' )
	);
	
	$wp_customize->add_control(
			'coller_sidebar_width', array(
		    'settings' => 'coller_sidebar_width',
		    'label'    => __( 'Sidebar Width','coller' ),
		    'description' => __('Min: 25%, Default: 33%, Max: 40%','coller'),
		    'section'  => 'coller_sidebar_options',
		    'type'     => 'range',
		    'active_callback' => 'coller_show_sidebar_options',
		    'input_attrs' => array(
		        'min'   => 3,
		        'max'   => 5,
		        'step'  => 1,
		        'class' => 'sidebar-width-range',
		        'style' => 'color: #0a0',
		    ),
		)
	);
	
	/* Active Callback Function */
	function coller_show_sidebar_options($control) {
	   
	    $option = $control->manager->get_setting('coller_disable_sidebar');
	    return $option->value() == false ;
	    
	}
	
	class Coller_Custom_CSS_Control extends WP_Customize_Control {
	    public $type = 'textarea';
	 
	    public function render_content() {
	        ?>
	            <label>
	                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	                <textarea rows="8" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
	            </label>
	        <?php
	    }
	}
	
	$wp_customize-> add_section(
    'coller_custom_codes',
    array(
    	'title'			=> __('Custom CSS','coller'),
    	'description'	=> __('Enter your Custom CSS to Modify design.','coller'),
    	'priority'		=> 11,
    	'panel'			=> 'coller_design_panel'
    	)
    );
    
	$wp_customize->add_setting(
	'coller_custom_css',
	array(
		'default'		=> '',
		'sanitize_callback'	=> 'coller_sanitize_text'
		)
	);
	
	$wp_customize->add_control(
	    new Coller_Custom_CSS_Control(
	        $wp_customize,
	        'coller_custom_css',
	        array(
	            'section' => 'coller_custom_codes',
	            'settings' => 'coller_custom_css'
	        )
	    )
	);
	
	function coller_sanitize_text( $input ) {
	    return wp_kses_post( force_balance_tags( $input ) );
	}
	
	$wp_customize-> add_section(
    'coller_custom_footer',
    array(
    	'title'			=> __('Custom Footer Text','coller'),
    	'description'	=> __('Enter your Own Copyright Text.','coller'),
    	'priority'		=> 11,
    	'panel'			=> 'coller_design_panel'
    	)
    );
    
	$wp_customize->add_setting(
	'coller_footer_text',
	array(
		'default'		=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
		)
	);
	
	$wp_customize->add_control(	 
	       'coller_footer_text',
	        array(
	            'section' => 'coller_custom_footer',
	            'settings' => 'coller_footer_text',
	            'type' => 'text'
	        )
	);	
	
	
	// Social Icons
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
	
	
	/* Sanitization Functions Common to Multiple Settings go Here, Specific Sanitization Functions are defined along with add_setting() */
	function coller_sanitize_checkbox( $input ) {
	    if ( $input == 1 ) {
	        return 1;
	    } else {
	        return '';
	    }
	}
	
	function coller_sanitize_positive_number( $input ) {
		if ( ($input >= 0) && is_numeric($input) )
			return $input;
		else
			return '';	
	}
	
	function coller_sanitize_category( $input ) {
		if ( term_exists(get_cat_name( $input ), 'category') )
			return $input;
		else 
			return '';	
	}
	
	
}
add_action( 'customize_register', 'coller_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function coller_customize_preview_js() {
	wp_enqueue_script( 'coller_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'coller_customize_preview_js' );
