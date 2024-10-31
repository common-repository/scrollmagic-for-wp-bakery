<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Gitem_Post_Categories
 */


$exten = new Wpmp_extention();
$span = $exten->get_field_options($atts);

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

?>
{{ post_categories:<?php echo $span; echo http_build_query( array(
	'atts' => $atts,
) ); ?> }}
