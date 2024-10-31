<?php
/*
Plugin Name: Scrollmagic for WP Bakery
Description: Help you create post and pages with many effects, making it extremely impressive.
Author: Magic Pages
Version: 1.1.0
Author URI: https://scrollmagic-wpbakery.magicpages.tech/
Text Domain: magicpage
Domain Path: /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

defined( 'WPMP_SMG_WBPB_VERSION' ) or define('WPMP_SMG_WBPB_VERSION','1.1.0') ;
defined( 'WPMP_SMG_WBPB_URL' ) or define('WPMP_SMG_WBPB_URL', plugins_url( '/', __FILE__ )) ;

if ( ! class_exists( 'Wpmp_ScrollMagic_WPBakery' ) && class_exists( 'WPBakeryShortCode' )  ) {
	/**
	 * Wpmp_ScrollMagic_WPBakery Class
	 *
	 * @since	1.0
	 */
	class Wpmp_ScrollMagic_WPBakery extends WPBakeryShortCode{
		
		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */

		function __construct() {
			add_action( 'init', [ $this, 'actionInit' ] );
			add_action( 'vc_before_init', [ $this, 'wpmp_before_init_actions' ] );

			add_action( 'vc_after_init', [ $this, 'controls' ]);
			add_action( 'vc_after_init', [ $this, 'before_effect' ]);
			add_action( 'vc_after_init', [ $this, 'effects' ]);
		}

		public function actionInit() {
			if(is_admin()) {
				add_action( 'admin_enqueue_scripts',[ $this, 'admin_enqueue_scripts' ] );
			}
			add_action( 'wp_enqueue_scripts',[ $this, 'wp_enqueue_scripts' ] );
			include_once 'php/index.php';
		}
		public function admin_enqueue_scripts() {
			wp_enqueue_script( 'cookie-js', WPMP_SMG_WBPB_URL . 'assets/admin/js/setCookie.js', array( 'jquery' ), WPMP_SMG_WBPB_VERSION, true );
			wp_enqueue_style( 'wpmp-css', WPMP_SMG_WBPB_URL . 'assets/admin/css/wpmp.css' );
		}
		public function wp_enqueue_scripts() {
			wp_enqueue_style( 'wpmp-css', WPMP_SMG_WBPB_URL . 'assets/css/wpmp.css' );

			wp_enqueue_style( 'animate', WPMP_SMG_WBPB_URL . 'assets/lib/animate/animate.min.css' );
			wp_enqueue_style( 'magic', WPMP_SMG_WBPB_URL . 'assets/lib/animate/magic.min.css' );
			wp_enqueue_script( 'jQuery');
			wp_enqueue_script( 'gsap', WPMP_SMG_WBPB_URL . 'assets/lib/gsap/gsap.min.js',array( 'jquery' ), WPMP_SMG_WBPB_VERSION, true );
			wp_enqueue_script( 'DrawSVG', WPMP_SMG_WBPB_URL . 'assets/lib/gsap/DrawSVG.min.js',array( 'jquery' ), WPMP_SMG_WBPB_VERSION, true );
			wp_enqueue_script( 'SplitText3', WPMP_SMG_WBPB_URL . 'assets/lib/gsap/SplitText3.min.js',array( 'jquery' ), WPMP_SMG_WBPB_VERSION, true );
			wp_enqueue_script( 'ScrollMagic', WPMP_SMG_WBPB_URL . 'assets/lib/scrollmagic/minified/ScrollMagic.min.js',array( 'jquery' ), WPMP_SMG_WBPB_VERSION, true );
			wp_enqueue_script( 'uncompressed-ScrollMagic', WPMP_SMG_WBPB_URL . 'assets/lib/scrollmagic/uncompressed/ScrollMagic.js',array( 'jquery' ), WPMP_SMG_WBPB_VERSION, true );
			wp_enqueue_script( 'animation-scrollmagic', WPMP_SMG_WBPB_URL . 'assets/lib/scrollmagic/uncompressed/plugins/animation.gsap.js',array( 'jquery' ), WPMP_SMG_WBPB_VERSION, true );
			wp_enqueue_script( 'addIndicators-scrollmagic', WPMP_SMG_WBPB_URL . 'assets/lib/scrollmagic/uncompressed/plugins/debug.addIndicators.js',array( 'jquery' ), WPMP_SMG_WBPB_VERSION, true );
			wp_enqueue_script( 'wpmp-js', WPMP_SMG_WBPB_URL . 'assets/js/wpmp.js', array( 'jquery' ), WPMP_SMG_WBPB_VERSION, true );

		}

		function wpmp_before_init_actions() {
			if( function_exists('vc_set_shortcodes_templates_dir') ){ 
				vc_set_shortcodes_templates_dir( plugin_dir_path( __FILE__ ).'php/shortcodes/' );
			}
		}

		

		public function controls() {
			$represent = 'wpmp_';
			$controls = array(
				array(
					"type"       => "checkbox",
					"heading"    => esc_html__( 'Debug mode', 'wpmp' ),
					"param_name" => $represent."debug",	
					'description' => __( '', 'wpmp' ),
					'group' => esc_html__( 'Sroll Magic Control', 'wpmp' ),
				),
				array(
					"type"       => "checkbox",
					"heading"    => esc_html__( 'Hide on Desktop', 'wpmp' ),
					"param_name" => $represent."enable_desktop",	
					'description' => __( '', 'wpmp' ),
					'group' => esc_html__( 'Sroll Magic Control', 'wpmp' ),
				),
				array(
					"type"       => "checkbox",
					"heading"    => esc_html__( 'Hide on Tablet', 'wpmp' ),
					"param_name" => $represent."enable_tablet",	
					'description' => __( '', 'wpmp' ),
					'group' => esc_html__( 'Sroll Magic Control', 'wpmp' ),
				),
				array(
					"type"       => "checkbox",
					"heading"    => esc_html__( 'Hide on Mobile', 'wpmp' ),
					"param_name" => $represent."enable_mobile",	
					'description' => __( '', 'wpmp' ),
					'group' => esc_html__( 'Sroll Magic Control', 'wpmp' ),
				),
				array(
					"type"       => "textfield",
					"heading"    => esc_html__( 'Trigger Hook', 'wpmp' ),
					"param_name" => $represent."trigger_hook",	
					'description' => __( '', 'wpmp' ),
					'value' => 0.5,
					'group' => esc_html__( 'Sroll Magic Control', 'wpmp' ),
				),
				array(
					"type"       => "checkbox",
					"heading"    => esc_html__( 'Reverse', 'wpmp' ),
					"param_name" => $represent."reverse",
					'description' => __( '', 'wpmp' ),
					'value' => 'true',
					'group' => esc_html__( 'Sroll Magic Control', 'wpmp' ),
				),
				array(
					"type"       => "checkbox",
					"class"      => "",
					"heading"    => esc_html__( 'Pin', 'wpmp' ),
					"param_name" => $represent."pin",	
					'description' => __( '', 'wpmp' ),
					'group' => esc_html__( 'Sroll Magic Control', 'wpmp' ),
				),
				array(
					"type"       => "checkbox",
					"class"      => "",
					"heading"    => esc_html__( 'TweenChanges', 'wpmp' ),
					"param_name" => $represent."tweenchanges",	
					'description' => __( '', 'wpmp' ),
					'group' => esc_html__( 'Sroll Magic Control', 'wpmp' ),
				),
				array(
					"type"       => "textfield",
					"class"      => "",
					"heading"    => esc_html__( 'Duration', 'wpmp' ),
					"param_name" => $represent."duration",	
					'description' => __( '', 'wpmp' ),
					'group' => esc_html__( 'Sroll Magic Control', 'wpmp' ),
				),
				array(
					"type"       => "textfield",
					"class"      => "",
					"heading"    => esc_html__( 'Offset', 'wpmp' ),
					"param_name" => $represent."offset",	
					'description' => __( '', 'wpmp' ),
					'group' => esc_html__( 'Sroll Magic Control', 'wpmp' ),
				),
				array(
					"type"       => "textfield",
					"class"      => "",
					"heading"    => esc_html__( 'Delay', 'wpmp' ),
					"param_name" => $represent."delay",	
					'description' => __( '', 'wpmp' ),
					'group' => esc_html__( 'Sroll Magic Control', 'wpmp' ),
				),
				array(
					"type"       => "checkbox",
					"class"      => "",
					"heading"    => esc_html__( 'Enable Class toggle', 'wpmp' ),
					"param_name" => $represent."enable_class_toggle",	
					'description' => __( '', 'wpmp' ),
					'group' => esc_html__( 'Sroll Magic Control', 'wpmp' ),
				),
				array(
					'type' => 'dropdown',
					"heading"    => esc_html__( 'Class CSS', 'wpmp' ),
					'param_name' => $represent.'class_css',
					'value' => array(
						esc_html__("magic", "wpmp") => 'magic' ,
						esc_html__("twisterInDown", "wpmp") => 'twisterInDown' ,
						esc_html__("twisterInUp", "wpmp") => 'twisterInUp' ,
						esc_html__("swap", "wpmp") => 'swap' ,
						esc_html__("puffIn", "wpmp") => 'puffIn' ,
						esc_html__("puffOut", "wpmp") => 'puffOut' ,
						esc_html__("vanishOut", "wpmp") => 'vanishOut' ,
						esc_html__("openDownLeft", "wpmp") => 'openDownLeft' ,
						esc_html__("openDownRight", "wpmp") => 'openDownRight' ,
						esc_html__("openUpLeft", "wpmp") => 'openUpLeft' ,
						esc_html__("openUpRight", "wpmp") => 'openUpRight' ,
						esc_html__("openDownLeftReturn", "wpmp") => 'openDownLeftReturn' ,
						esc_html__("openDownRightReturn", "wpmp") => 'openDownRightReturn' ,
						esc_html__("openUpLeftReturn", "wpmp") => 'openUpLeftReturn' ,
						esc_html__("openUpRightReturn", "wpmp") => 'openUpRightReturn' ,
						esc_html__("openDownLeftOut", "wpmp") => 'openDownLeftOut',
						esc_html__("openDownRightOut", "wpmp") => 'openDownRightOut' ,
						esc_html__("openUpLeftOut", "wpmp") => 'openUpLeftOut',
						esc_html__("openUpRightOut", "wpmp") => 'openUpRightOut' ,
						esc_html__("perspectiveDown", "wpmp") => 'perspectiveDown' ,
						esc_html__("perspectiveUp", "wpmp") => 'perspectiveUp' ,
						esc_html__("perspectiveLeft", "wpmp") => 'perspectiveLeft' ,
						esc_html__("perspectiveRight", "wpmp") => 'perspectiveRight' ,
						esc_html__("perspectiveDownReturn", "wpmp") => 'perspectiveDownReturn' ,
						esc_html__("perspectiveUpReturn", "wpmp") => 'perspectiveUpReturn' ,
						esc_html__("perspectiveLeftReturn", "wpmp") => 'perspectiveLeftReturn' ,
						esc_html__("perspectiveRightReturn", "wpmp") => 'perspectiveRightReturn' ,
						esc_html__("rotateDown", "wpmp") => 'rotateDown' ,
						esc_html__("rotateUp", "wpmp") => 'rotateUp' ,
						esc_html__("rotateLeft", "wpmp") => 'rotateLeft' ,
						esc_html__("rotateRight", "wpmp") => 'rotateRight' ,
						esc_html__("slideDown", "wpmp") => 'slideDown' ,
						esc_html__("slideUp", "wpmp") => 'slideUp' ,
						esc_html__("slideLeft", "wpmp") => 'slideLeft' ,
						esc_html__("slideRight", "wpmp") => 'slideRight' ,
						esc_html__("slideDownReturn", "wpmp") => 'slideDownReturn',
						esc_html__("slideUpReturn", "wpmp") => 'slideUpReturn' ,
						esc_html__("slideLeftReturn", "wpmp") => 'slideLeftReturn' ,
						esc_html__("slideRightReturn", "wpmp") => 'slideRightReturn' ,
						esc_html__("swashOut", "wpmp") => 'swashOut' ,
						esc_html__("swashIn", "wpmp") => 'swashIn' ,
						esc_html__("foolishIn", "wpmp") => 'foolishIn' ,
						esc_html__("holeOut", "wpmp") => 'holeOut' ,
						esc_html__("tinRightOut", "wpmp") => 'tinRightOut' ,
						esc_html__("tinLeftOut", "wpmp") => 'tinLeftOut' ,
						esc_html__("tinUpOut", "wpmp") => 'tinUpOut' ,
						esc_html__("tinDownOut", "wpmp") => 'tinDownOut' ,
						esc_html__("tinRightIn", "wpmp") => 'tinRightIn' ,
						esc_html__("tinLeftIn", "wpmp") => 'tinLeftIn' ,
						esc_html__("tinUpIn", "wpmp") => 'tinUpIn' ,
						esc_html__("tinDownIn", "wpmp") => 'tinDownIn' ,
						esc_html__("bombRightOut", "wpmp") => 'bombRightOut' ,
						esc_html__("bombLeftOut", "wpmp") => 'bombLeftOut' ,
						esc_html__("boingInUp", "wpmp") => 'boingInUp' ,
						esc_html__("boingOutDown", "wpmp") => 'boingOutDown' ,
						esc_html__("spaceOutUp", "wpmp") => 'spaceOutUp' ,
						esc_html__("spaceOutRight", "wpmp") => 'spaceOutRight' ,
						esc_html__("spaceOutDown", "wpmp") => 'spaceOutDown' ,
						esc_html__("spaceOutLeft", "wpmp") => 'spaceOutLeft' ,
						esc_html__("spaceInUp", "wpmp") => 'spaceInUp' ,
						esc_html__("spaceInRight", "wpmp") => 'spaceInRight' ,
						esc_html__("spaceInDown", "wpmp") => 'spaceInDown' ,
						esc_html__("spaceInLeft", "wpmp") => 'spaceInLeft' ,
						esc_html__("bounce", "wpmp")=>'bounce',
						esc_html__("flash", "wpmp")=>'flash' ,
						esc_html__("pulse", "wpmp")=>'pulse' ,
						esc_html__("rubberBand", "wpmp")=>'rubberBand' ,
						esc_html__("shake", "wpmp")=>'shake' ,
						esc_html__("swing", "wpmp")=>'swing' ,
						esc_html__("tada", "wpmp")=>'tada' ,
						esc_html__("wobble", "wpmp")=>'wobble' ,
						esc_html__("jello", "wpmp")=>'jello' ,
						esc_html__("bounceIn", "wpmp")=>'bounceIn' ,
						esc_html__("bounceInDown", "wpmp")=>'bounceInDown' ,
						esc_html__("bounceInLeft", "wpmp")=>'bounceInLeft' ,
						esc_html__("bounceInRight", "wpmp")=>'bounceInRight' ,
						esc_html__("bounceInUp", "wpmp")=>'bounceInUp' ,
						esc_html__("bounceOut", "wpmp")=>'bounceOut' ,
						esc_html__("bounceOutDown", "wpmp")=>'bounceOutDown' ,
						esc_html__("bounceOutLeft", "wpmp")=>'bounceOutLeft' ,
						esc_html__("bounceOutRight", "wpmp"),
						esc_html__("bounceOutUp", "wpmp")=>'bounceOutUp' ,
						esc_html__("fadeIn", "wpmp")=>'fadeIn' ,
						esc_html__("fadeInDown", "wpmp")=>'fadeInDown',
						esc_html__("fadeInDownBig", "wpmp")=>'fadeInDownBig',
						esc_html__("fadeInLeft", "wpmp")=>'fadeInLeft' ,
						esc_html__("fadeInLeftBig", "wpmp")=>'fadeInLeftBig',
						esc_html__("fadeInRight", "wpmp")=>'fadeInRight' ,
						esc_html__("fadeInRightBig", "wpmp")=>'fadeInRightBig' ,
						esc_html__("fadeInUp", "wpmp")=>'fadeInUp' ,
						esc_html__("fadeInUpBig", "wpmp")=>'fadeInUpBig',
						esc_html__("fadeOut", "wpmp")=>'fadeOut' ,
						esc_html__("fadeOutDown", "wpmp")=>'fadeOutDown' ,
						esc_html__("fadeOutDownBig", "wpmp")=>'fadeOutDownBig' ,
						esc_html__("fadeOutLeft", "wpmp")=>'fadeOutLeft' ,
						esc_html__("fadeOutLeftBig", "wpmp")=>'fadeOutLeftBig' ,
						esc_html__("fadeOutRight", "wpmp")=>'fadeOutRight' ,
						esc_html__("fadeOutRightBig", "wpmp")=>'fadeOutRightBig' ,
						esc_html__("No", "wpmp")=>'fadeOutUp' ,
						esc_html__("fadeOutUpBig", "wpmp")=>'fadeOutUpBig' ,
						esc_html__("flip", "wpmp")=>'flip' ,
						esc_html__("flipInX", "wpmp")=>'flipInX' ,
						esc_html__("flipInY", "wpmp")=>'flipInY' ,
						esc_html__("flipOutX", "wpmp")=>'flipOutX' ,
						esc_html__("flipOutY", "wpmp")=>'flipOutY' ,
						esc_html__("lightSpeedIn", "wpmp")=>'lightSpeedIn' ,
						esc_html__("lightSpeedOut", "wpmp")=>'lightSpeedOut' ,
						esc_html__("rotateIn", "wpmp")=>'rotateIn' ,
						esc_html__("rotateInDownLeft", "wpmp")=>'rotateInDownLeft' ,
						esc_html__("rotateInDownRight", "wpmp")=>'rotateInDownRight' ,
						esc_html__("rotateInUpLeft", "wpmp")=>'rotateInUpLeft' ,
						esc_html__("rotateInUpRight", "wpmp")=>'rotateInUpRight' ,
						esc_html__("rotateOut", "wpmp")=>'rotateOut' ,
						esc_html__("rotateOutDownLeft", "wpmp")=>'rotateOutDownLeft' ,
						esc_html__("rotateOutDownRight", "wpmp")=>'rotateOutDownRight' ,
						esc_html__("rotateOutUpLeft", "wpmp")=>'rotateOutUpLeft' ,
						esc_html__("rotateOutUpRight", "wpmp")=>'rotateOutUpRight' ,
						esc_html__("slideInUp", "wpmp")=>'slideInUp' ,
						esc_html__("slideInDown", "wpmp")=>'slideInDown' ,
						esc_html__("slideInLeft", "wpmp")=>'slideInLeft' ,
						esc_html__("slideInRight", "wpmp")=>'slideInRight' ,
						esc_html__("slideOutUp", "wpmp")=>'slideOutUp' ,
						esc_html__("slideOutDown", "wpmp")=>'slideOutDown' ,
						esc_html__("slideOutLeft", "wpmp")=>'slideOutLeft' ,
						esc_html__("slideOutRight", "wpmp")=>'slideOutRight' ,
						esc_html__("zoomIn", "wpmp")=>'zoomIn' ,
						esc_html__("zoomInDown", "wpmp")=>'zoomInDown' ,
						esc_html__("zoomInLeft", "wpmp")=>'zoomInLeft' ,
						esc_html__("zoomInRight", "wpmp")=>'zoomInRight' ,
						esc_html__("zoomInUp", "wpmp")=>'zoomInUp' ,
						esc_html__("zoomOut", "wpmp")=>'zoomOut' ,
						esc_html__("zoomOutDown", "wpmp")=>'zoomOutDown' ,
						esc_html__("zoomOutLeft", "wpmp")=>'zoomOutLeft' ,
						esc_html__("zoomOutRight", "wpmp")=>'zoomOutRight' ,
						esc_html__("zoomOutUp", "wpmp")=>'zoomOutUp' ,
						esc_html__("hinge", "wpmp")=>'hinge' ,
						esc_html__("rollIn", "wpmp")=>'rollIn' ,
						esc_html__("rollOut", "wpmp")=>'rollOut' ,
						esc_html__("custom", "wpmp")=>'custom' 
					),
					'dependency' => array(),
					'group' => esc_html__( 'Sroll Magic Control', 'wpmp' ),
					'description' => __( 'Select filter alignment.', 'wpmp' ),
				),
				array(
					"type"       => "textfield",
					"class"      => "",
					"heading"    => esc_html__( 'Custom Class', 'wpmp' ),
					"param_name" => $represent."custom_class",	
					'description' => __( '', 'wpmp' ),
					'group' => esc_html__( 'Sroll Magic Control', 'wpmp' ),
				),
            );
			$arr = explode(",",$_COOKIE["allshortcode"]);
			array_push($arr, "vc_column");
			foreach ($arr as $key => $value) {
				vc_add_params($value,$controls);
			}
		}

		public function before_effect() {
			$represent = 'wpmpbefore_';
			$before = array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Width', 'wpmp' ),
					'param_name' => $represent.'width',
					'description' => esc_html__( 'Enter value for width element.', 'wpmp' ),
					'group' => esc_html__( 'Before Effect', 'wpmp' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Height', 'wpmp' ),
					'param_name' => $represent.'height',
					'description' => esc_html__( 'Enter value for hieght element.', 'wpmp' ),
					'group' => esc_html__( 'Before Effect', 'wpmp' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Opacity', 'wpmp' ),
					'param_name' => $represent.'opacity',
					'description' => esc_html__( 'Enter value for opacity element.', 'wpmp' ),
					'group' => esc_html__( 'Before Effect', 'wpmp' ),
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Color', 'wpmp' ),
					'param_name' => $represent.'color',
					'description' => esc_html__( 'Select color.', 'wpmp' ),
					'group' => esc_html__( 'Before Effect', 'wpmp' ),
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Background color', 'wpmp' ),
					'param_name' => $represent.'background-color',
					'description' => esc_html__( 'Select background color.', 'wpmp' ),
					'group' => esc_html__( 'Before Effect', 'wpmp' ),
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
					'group' => esc_html__( 'Before Effect', 'wpmp' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Transform origin', 'wpmp' ),
					'param_name' => $represent.'transform',
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
					'group' => esc_html__( 'Before Effect', 'wpmp' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Translate-X', 'wpmp' ),
					'param_name' => $represent.'translate_x',
					'description' => esc_html__( '', 'wpmp' ),
					'group' => esc_html__( 'Before Effect', 'wpmp' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Translate-Y', 'wpmp' ),
					'param_name' => $represent.'translate_y',
					'description' => esc_html__( '', 'wpmp' ),
					'group' => esc_html__( 'Before Effect', 'wpmp' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Translate-Z', 'wpmp' ),
					'param_name' => $represent.'translate_z',
					'description' => esc_html__( '', 'wpmp' ),
					'group' => esc_html__( 'Before Effect', 'wpmp' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Scale-X', 'wpmp' ),
					'param_name' => $represent.'scale_x',
					'description' => esc_html__( '', 'wpmp' ),
					'group' => esc_html__( 'Before Effect', 'wpmp' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Scale-Y', 'wpmp' ),
					'param_name' => $represent.'scale_y',
					'description' => esc_html__( '', 'wpmp' ),
					'group' => esc_html__( 'Before Effect', 'wpmp' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Scale-Z', 'wpmp' ),
					'param_name' => $represent.'scale_z',
					'description' => esc_html__( '', 'wpmp' ),
					'group' => esc_html__( 'Before Effect', 'wpmp' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Rotate-X', 'wpmp' ),
					'param_name' => $represent.'rotate_x',
					'description' => esc_html__( '', 'wpmp' ),
					'group' => esc_html__( 'Before Effect', 'wpmp' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Rotate-Y', 'wpmp' ),
					'param_name' => $represent.'rotate_y',
					'description' => esc_html__( '', 'wpmp' ),
					'group' => esc_html__( 'Before Effect', 'wpmp' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Rotate-Z', 'wpmp' ),
					'param_name' => $represent.'rotate_z',
					'description' => esc_html__( '', 'wpmp' ),
					'group' => esc_html__( 'Before Effect', 'wpmp' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Skew-X', 'wpmp' ),
					'param_name' => $represent.'skew_x',
					'description' => esc_html__( '', 'wpmp' ),
					'group' => esc_html__( 'Before Effect', 'wpmp' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Skew-Y', 'wpmp' ),
					'param_name' => $represent.'skew_y',
					'description' => esc_html__( '', 'wpmp' ),
					'group' => esc_html__( 'Before Effect', 'wpmp' ),
				),
			);
			$arr = explode(",",$_COOKIE["allshortcode"]);
			array_push($arr, "vc_column");
			foreach ($arr as $key => $value) {
				vc_add_params($value,$before);
			}
		}
		
		public function effects() {
			$represent = 'wpmp_';
			$effect = array(
				'type' => 'param_group',
				'heading' => esc_html__( 'Scenes', 'wpmp' ),
				'param_name' => 'wpmp_effect_scenes',
				'value' => '',
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Title', 'wpmp' ),
						'param_name' => $represent.'title',
						'std' => 'Effect1',
						'description' => esc_html__( 'Enter title for chart area.', 'wpmp' ),
						'admin_label' => true,
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Duration', 'wpmp' ),
						'param_name' => $represent.'duration',
						'value' => 1,
						'description' => __( 'Enter value for width element.', 'wpmp' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => __( 'Ease', 'wpmp' ),
						'param_name' => $represent.'ease',
						'value' => array(
							esc_html__("Power0.easeNone", "bestbug")=>'Power0.easeNone' ,
							esc_html__("Power1.easeIn", "bestbug")=>'Power1.easeIn',
							esc_html__("Power1.easeInOut", "bestbug")=> 'Power1.easeInOut',
							esc_html__("Power1.easeOut", "bestbug")=> 'Power1.easeOut' ,
							esc_html__("Power2.easeIn", "bestbug")=> 'Power2.easeIn',
							esc_html__("Power2.easeInOut", "bestbug")=> 'Power2.easeInOut',
							esc_html__("Power2.easeOut", "bestbug")=> 'Power2.easeOut' ,
							esc_html__("Power3.easeIn", "bestbug")=> 'Power3.easeIn',
							esc_html__("Power3.easeInOut", "bestbug")=> 'Power3.easeInOut',
							esc_html__("Power3.easeOut", "bestbug")=> 'Power3.easeOut',
							esc_html__("Power4.easeIn", "bestbug")=> 'Power4.easeIn',
							esc_html__("Power4.easeInOut", "bestbug")=> 'Power4.easeInOut',
							esc_html__("Power4.easeOut", "bestbug")=> 'Power4.easeOut',
							esc_html__("Back.easeIn", "bestbug")=> 'Back.easeIn.config(1.7)' ,
							esc_html__("Back.easeInOut", "bestbug")=> 'Back.easeInOut.config(1.7)',
							esc_html__("Back.easeOut.config", "bestbug")=> 'Back.easeOut.config(1.7)' ,
							esc_html__("Elastic.easeIn.config", "bestbug")=> 'Elastic.easeIn.config(1, 0.3)' ,
							esc_html__("Elastic.easeInOut.config(1, 0.3)", "bestbug")=> 'Elastic.easeInOut.config(1, 0.3)',
							esc_html__("Elastic.easeOut.config", "bestbug")=> 'Elastic.easeOut.config(1, 0.3)',
							esc_html__("Bounce.easeIn", "bestbug")=> 'Bounce.easeIn' ,
							esc_html__("Bounce.easeInOut", "bestbug")=> 'Bounce.easeInOut',
							esc_html__("SlowMo", "bestbug")=> 'SlowMo.ease.config(0.7, 0.7, false)',
							esc_html__("Stepped", "bestbug")=> 'SteppedEase.config(12)' ,
							esc_html__("Circ.easeIn", "bestbug")=> 'Circ.easeIn' ,
							esc_html__("Circ.easeInOut", "bestbug")=> 'Circ.easeInOut',
							esc_html__("Circ.easeOut", "bestbug")=> 'Circ.easeOut',
							esc_html__("Expo.easeIn", "bestbug")=> 'Expo.easeIn',
							esc_html__("Expo.easeInOut", "bestbug")=> 'Expo.easeInOut',
							esc_html__("Expo.easeOut", "bestbug")=> 'Expo.easeOut',
							esc_html__("Sine.easeIn", "bestbug")=> 'Sine.easeIn',
							esc_html__("Sine.easeInOut", "bestbug")=> 'Sine.easeInOut' ,
							esc_html__("Sine.easeOut", "bestbug")=> 'Sine.easeOut',
						),
						'param_holder_class' => 'vc_colored-dropdown',
						'dependency' => array(),
						'group' => esc_html__( 'Sroll Magic Control', 'wpmp' ),
						'description' => __( 'Select filter alignment.', 'wpmp' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Width', 'wpmp' ),
						'param_name' => $represent.'width',
						'description' => __( 'Enter value for width element.', 'wpmp' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Hieght', 'wpmp' ),
						'param_name' => $represent.'hieght',
						'description' => __( 'Enter value for hieght element.', 'wpmp' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Opacity', 'wpmp' ),
						'param_name' => $represent.'opacity',
						'description' => __( 'Enter value for opacity element.', 'wpmp' ),
					),
					array(
						'type' => 'colorpicker',
						'heading' => __( 'Color', 'wpmp' ),
						'param_name' => $represent.'color',
						'description' => __( 'Select color.', 'wpmp' ),
					),
					array(
						'type' => 'colorpicker',
						'heading' => __( 'Background color', 'wpmp' ),
						'param_name' => $represent.'backgroundColor',
						'description' => __( 'Select background color.', 'wpmp' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => __( 'Display', 'wpmp' ),
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
						'description' => __( '', 'wpmp' ),
						'param_holder_class' => 'vc_colored-dropdown',
					),
					array(
						'type' => 'dropdown',
						'heading' => __( 'Transform origin', 'wpmp' ),
						'param_name' => $represent.'transform',
						'value' => array(
							__( 'Top Left', 'wpmp' ) => 'top-left'  ,
							__( 'Top Center', 'wpmp' ) =>'top-center' ,
                            __( 'Top Right', 'wpmp' )=>'top-right' ,
							__( 'Middle Left', 'wpmp' )=>'center-left' ,
                            __( 'Middle Center', 'wpmp' )=>'center-center' ,
                            __( 'Middle Right', 'wpmp' )=>'center-right' ,
                            __( 'Bottom Lef', 'wpmp' )=>'bottom-left'  ,
                            __( 'Bottom Center', 'wpmp' )=>'bottom-center',
                            __( 'Bottom Right', 'wpmp' )=>'bottom-right' ,
						),
						'description' => __( '', 'wpmp' ),
						'param_holder_class' => 'vc_colored-dropdown',
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Translate-X', 'wpmp' ),
						'param_name' => $represent.'translateX',
						'description' => __( '', 'wpmp' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Translate-Y', 'wpmp' ),
						'param_name' => $represent.'translateY',
						'description' => __( '', 'wpmp' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Translate-Z', 'wpmp' ),
						'param_name' => $represent.'translateZ',
						'description' => __( '', 'wpmp' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Scale-X', 'wpmp' ),
						'param_name' => $represent.'scaleX',
						'description' => __( '', 'wpmp' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Scale-Y', 'wpmp' ),
						'param_name' => $represent.'scaleY',
						'description' => __( '', 'wpmp' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Scale-Z', 'wpmp' ),
						'param_name' => $represent.'scaleZ',
						'description' => __( '', 'wpmp' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Rotate-X', 'wpmp' ),
						'param_name' => $represent.'rotateX',
						'description' => __( '', 'wpmp' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Rotate-Y', 'wpmp' ),
						'param_name' => $represent.'rotateY',
						'description' => __( '', 'wpmp' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Rotate-Z', 'wpmp' ),
						'param_name' => $represent.'rotateZ',
						'description' => __( '', 'wpmp' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Skew-X', 'wpmp' ),
						'param_name' => $represent.'skewX',
						'description' => __( '', 'wpmp' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Skew-Y', 'wpmp' ),
						'param_name' => $represent.'skewY',
						'description' => __( '', 'wpmp' ),
					),
					array(
						"type"       => "checkbox",
						"heading"    => esc_html__( 'Set yoyo', 'wpmp' ),
						"param_name" => "yoyo",	
						'description' => __( '', 'wpmp' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Repeat effect', 'wpmp' ),
						'param_name' => $represent.'repeat',
						'description' => __( '', 'wpmp' ),
					),
				),
				'group' => __( 'Scrollmagic Effect', 'wpmp' ),
			);
			$arr = explode(",",$_COOKIE["allshortcode"]);
			array_push($arr, "vc_column");
			foreach ($arr as $key => $value) {
				vc_add_param($value,$effect);
			}
        }
	}
	new Wpmp_ScrollMagic_WPBakery();
}
