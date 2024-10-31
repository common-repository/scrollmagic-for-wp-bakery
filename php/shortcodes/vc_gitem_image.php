<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$exten = new Wpmp_extention();
$span = $exten->get_field_options($atts);

?>{{ featured_image:<?php echo $span; echo http_build_query( $atts ) ?> }}
