<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'WPMP_Sequence_Image' ) ) {
	/**
	 * WPMP_Sequence_Image Class
	 *
	 * @since	1.0
	 */
	class WPMP_Sequence_Image extends WPBakeryShortCode{

		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			add_action( 'init', array( $this, 'init' ) );

			add_shortcode( 'sequence_image', array( $this, 'sequence_image' ) );
			if ( defined( 'WPB_VC_VERSION' ) && function_exists( 'vc_add_param' ) ) {
				$this->add_sequence_image();
			}
		}
		public function add_sequence_image() {
			vc_map( array(
		        'name'                      => esc_html__( 'Sequence Image', 'wpmp' ),
				'description'				=> esc_html__( '', 'wpmp' ),
		        'base'                      => 'sequence_image',
		        'category'                  => esc_html( sprintf( esc_html__( 'Magic Page', 'wpmp' ), 'wpmp' ) ),
				'icon' 						=> 'wpmp_icon_sequence_image',
				'params'                    => array(
					array(
                        "type" => "attach_images",
                        "heading" => __( "Import image", "wpmp" ),
                        "param_name" => "image_sequence",
				   	),
					array(
						"type"       => "textfield",
						"heading"    => esc_html__( 'Repeat', 'wpmp' ),
						"param_name" => "wpmp_repeat_sequence_img",	
						'description' => __( '', 'wpmp' ),
					),
					array(
						"type"       => "textfield",
						"heading"    => esc_html__( 'Custom ID', 'wpmp' ),
						"param_name" => "el_id",	
						'description' => __( '', 'wpmp' ),
					),
					array(
						"type"       => "textfield",
						"heading"    => esc_html__( 'Custom Class CSS', 'wpmp' ),
						"param_name" => "el_class",	
						'description' => __( '', 'wpmp' ),
					),
					// array(
					// 	'type' => 'css_editor',
					// 	'heading' => __( 'CSS box', 'wpmp' ),
					// 	'param_name' => 'css',
					// 	'group' => __( 'Design Options', 'wpmp' ),
					// ),
		        ),
		    ));
        }
		
		public function sequence_image( $atts ){
			
		$exten = new Wpmp_extention();
		$span = $exten->get_field_options($atts);
		$css = '';

			$atts = shortcode_atts( array(
				'css' => '',
				'el_id' => '',
				'el_class' => '',
				'image_sequence' => '',
				'wpmp_repeat_sequence_img' => '',
			), $atts );
			
			// $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->settings['base'], $atts );
			
            $image_ids = explode(',',$atts['image_sequence']);
            $src = [];
			foreach( $image_ids as $image_id ){
				$images = wp_get_attachment_image_src( $image_id, 'company_logo' );
				array_push($src,$images[0]);
				$images++;
			}
			return  $span.'<div class=" scrollmagic-ele imageSequence">
						<img class="wpmp_image_sequence" wpmp_repeat_sequence_img="'.$atts['wpmp_repeat_sequence_img'].'" data-src="'.implode(",",$src).'"  src="'.$images[0].'" id="myimg"/><br>
	  				</div>';
			// $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
		}
        
    }
	
	new WPMP_Sequence_Image();
}

