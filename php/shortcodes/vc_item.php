<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * Shortcode class
 * @var $this WPBakeryShortCode
 */
$el_class = '';

$exten = new Wpmp_extention();
$span = $exten->get_field_options($atts);

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$css = $this->getExtraClass( $el_class );

echo $span.'<div class="vc_items' . esc_attr( $css ) . '">' . __( 'Item', 'js_composer' ) . '</div>';
