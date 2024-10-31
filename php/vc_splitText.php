<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'WPMP_Split_Text' ) ) {
	/**
	 * WPMP_Split_Text Class
	 *
	 * @since	1.0
	 */
	class WPMP_Split_Text extends WPBakeryShortCode{

		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			add_action( 'init', array( $this, 'init' ) );
			add_shortcode( 'split_text', array( $this, 'split_text' ) );
			if ( defined( 'WPB_VC_VERSION' ) && function_exists( 'vc_add_param' ) ) {
				$this->add_split_text();
			}
		}
		public function add_split_text() {
            $represent = 'wpmp-splittext_';
			vc_map( array(
		        'name'                      => esc_html__( 'Split Text', 'wpmp' ),
				'description'				=> esc_html__( '', 'wpmp' ),
		        'base'                      => 'split_text',
		        'category'                  => esc_html( sprintf( esc_html__( 'Magic Page', 'wpmp' ), 'wpmp' ) ),
				'icon' 						=> 'wpmp_icon_split_text',
				'params' => array(
                    array(
                        'type' => 'textarea_html',
                        'holder' => 'div',
                        'heading' => __( 'Text', 'js_composer' ),
                        'param_name' => 'wpmp_st_content',
                        'value' => __( '<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'js_composer' ),
                    ),
                    vc_map_add_css_animation(),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Opacity', 'wpmp' ),
                        'param_name' => $represent.'opacity',
                        'description' => esc_html__( 'Enter value for opacity element.', 'wpmp' ),
                        
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Display', 'wpmp' ),
                        'param_name' => $represent.'display',
                        'value' => array(
                            esc_html__("Block", "wpmp")=> 'block',
                            esc_html__("Inline", "wpmp")=> 'inline' ,
                            esc_html__("Inline block", "wpmp") =>'inline block',
                            esc_html__("None", "wpmp") =>'none',
                            esc_html__("Flex", "wpmp") =>'flex' ,
                            esc_html__("Inline-flex", "wpmp") =>'inline-flex',
                            esc_html__("Inherit", "wpmp") =>'inherit',
                            esc_html__("Initial", "wpmp") =>'initial',
                        ),
                        'description' => esc_html__( '', 'wpmp' ),
                        'param_holder_class' => 'vc_colored-dropdown',
                        
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Transform origin', 'wpmp' ),
                        'param_name' => $represent.'transform-origin',
                        'value' => array(
                            esc_html__( 'Top Left', 'wpmp' ) => 'top-left'  ,
                            esc_html__( 'Top Center', 'wpmp' ) =>'top-center' ,
                            esc_html__( 'Top Right', 'wpmp' )=>'top-right' ,
                            esc_html__( 'Middle Left', 'wpmp' )=>'center-left' ,
                            esc_html__( 'Middle Center', 'wpmp' )=>'center-center' ,
                            esc_html__( 'Middle Right', 'wpmp' )=>'center-right' ,
                            esc_html__( 'Bottom Lef', 'wpmp' )=>'bottom-left'  ,
                            esc_html__( 'Bottom Center', 'wpmp' )=>'bottom-center',
                            esc_html__( 'Bottom Right', 'wpmp' )=>'bottom-right' ,
                        ),
                        'description' => esc_html__( '', 'wpmp' ),
                        'param_holder_class' => 'vc_colored-dropdown',
                        
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Translate-X', 'wpmp' ),
                        'param_name' => $represent.'translate_x',
                        'description' => esc_html__( '', 'wpmp' ),
                        
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Translate-Y', 'wpmp' ),
                        'param_name' => $represent.'translate_y',
                        'description' => esc_html__( '', 'wpmp' ),
                        
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Translate-Z', 'wpmp' ),
                        'param_name' => $represent.'translate_z',
                        'description' => esc_html__( '', 'wpmp' ),
                        
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Scale', 'wpmp' ),
                        'param_name' => $represent.'scale',
                        'description' => esc_html__( '', 'wpmp' ),
                        
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Rotate-X', 'wpmp' ),
                        'param_name' => $represent.'rotate_x',
                        'description' => esc_html__( '', 'wpmp' ),
                        
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Rotate-Y', 'wpmp' ),
                        'param_name' => $represent.'rotate_y',
                        'description' => esc_html__( '', 'wpmp' ),
                        
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Rotate-Z', 'wpmp' ),
                        'param_name' => $represent.'rotate_z',
                        'description' => esc_html__( '', 'wpmp' ),
                        
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Skew-X', 'wpmp' ),
                        'param_name' => $represent.'skew_x',
                        'description' => esc_html__( '', 'wpmp' ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Skew-Y', 'wpmp' ),
                        'param_name' => $represent.'skew_y',
                        'description' => esc_html__( '', 'wpmp' ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Stagger', 'wpmp' ),
                        'param_name' => $represent.'stagger',
                        'value' => 0.01,
                        'description' => esc_html__( '', 'wpmp' ),
                        
                    ),
                    array(
                        'type' => 'el_id',
                        'heading' => __( 'Element ID', 'js_composer' ),
                        'param_name' => 'el_id',
                        'description' => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'js_composer' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Extra class name', 'js_composer' ),
                        'param_name' => 'el_class',
                        'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
                    ),
                    // array(
                    //     'type' => 'css_editor',
                    //     'heading' => __( 'CSS box', 'js_composer' ),
                    //     'param_name' => 'css',
                    //     'group' => __( 'Design Options', 'js_composer' ),
                    // ),
                ),
		    ));
        }
		
		public function split_text( $atts ){
            
            $exten = new Wpmp_extention();
            $span = $exten->get_field_options($atts);

			$atts = shortcode_atts( array(
                'css' => '',
				'el_id' => '',
				'el_class' => '',
				'wpmp_st_content' => '',
            ), $atts );

            // $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->settings['base'], $atts );

            return $span.'<div  id="'.$atts['el_id'].'" class=" splitText '.$atts['el_class'].'">
                    <div class="wpb_wrapper">
                    ' . wpb_js_remove_wpautop( $atts['wpmp_st_content'], true ) . '
                    </div>
                </div>';
		}
        
    }
	
	new WPMP_Split_Text();
}

