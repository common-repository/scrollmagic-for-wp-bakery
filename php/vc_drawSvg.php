<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'WPMP_Svg_Image' ) ) {
	/**
	 * WPMP_Svg_Image Class
	 *
	 * @since	1.0
	 */
	class WPMP_Svg_Image extends WPBakeryShortCode{

		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			add_action( 'init', array( $this, 'init' ) );

			add_shortcode( 'svg_image', array( $this, 'add_svg' ) );
			if ( defined( 'WPB_VC_VERSION' ) && function_exists( 'vc_add_param' ) ) {
				$this->add_svg_image();
			}
		}
		public function add_svg_image() {
			vc_map( array(
		        'name'                      => esc_html__( 'Draw SVG', 'wpmp' ),
				'description'				=> esc_html__( 'Draw SVG(raw html of SVG)', 'wpmp' ),
		        'base'                      => 'svg_image',
		        'category'                  => esc_html( sprintf( esc_html__( 'Magic Page', 'wpmp' ), 'wpmp' ) ),
				'icon' 						=> 'wpmp_icon_draw_svg',
				'params'                    => array(
				   	array(
						"type" => "textarea_raw_html",
						"heading" => __( "Import raw html of SVG", "wpmp" ),
						"param_name" => "svg_html",
						'value' => base64_encode( '<svg version="1.1" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
						x="0px" y="0px" width="570px" height="150px" viewBox="0 0 570 150" xml:space="preserve">
						<circle fill="none" cx="71.5" cy="77.5" r="51.5" stroke="#88CE02" stroke-width="4"/>
						<ellipse fill="none" stroke="#88CE02" stroke-width="4" stroke-miterlimit="10" cx="241.4" cy="77.5" rx="78.9" ry="51.5"/>
						<rect x="354" y="26" fill="none" stroke="#88CE02" stroke-linecap="square" stroke-width="4" stroke-miterlimit="30" width="103" height="103" id="rect" />
						<polyline class="hu123" fill="none" stroke="#88CE02" stroke-width="4" stroke-miterlimit="10" points="536.1,129 487.3,74.2 536.1,26 "/>
						</svg>' ),
					),
					array(
						"type"       => "textfield",
						"heading"    => esc_html__( 'Draw from', 'wpmp' ),
						"param_name" => "wpmp_draw_from",
						'value' => 0,	
						'description' => __( '', 'wpmp' ),
					),
					array(
						"type"       => "textfield",
						"heading"    => esc_html__( 'Draw to', 'wpmp' ),
						"param_name" => "wpmp_draw_to",	
						'value' => 100,
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
		
		public function add_svg( $atts ){

		$exten = new Wpmp_extention();
		$span = $exten->get_field_options($atts);
		$css = $css_class = '';
			extract(shortcode_atts( array(
				'el_id' => '',
				'el_class' => '',
				'svg_html' => '',
				'css' => '',
			), $atts ));

			// $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

			$html = rawurldecode( base64_decode( strip_tags( $svg_html) ) );
			// $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

			return $span.'<div  id="'.$el_id.'" class="scrollmagic-wpb drawsvg '.$css_class.$el_class.'">'.$html.'</div>';
		}
        
    }
	
	new WPMP_Svg_Image();
}

