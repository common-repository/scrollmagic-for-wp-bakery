<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Wpmp_extention' ) ) {
    
    class Wpmp_extention{
        function __construct(){
        }
        
        function get_field_options($atts){
            $idcustom = uniqid();
            $controls = $effect = $style = $before = '';
            $transforms = "transform:";
            $split_text = 'split-text = {';
            if($atts != NULL){
                foreach ($atts as $key => $att) {
                    if(strpos( $key,"wpmp_effect_") > -1 ){
                        $opt = vc_param_group_parse_atts($att);
                        $effect.= 'effect = {';
                        foreach ( $opt as $key2 => $att2 ){
                            $effect.=  "'".$key2."':{";
                            $transform = "'transform':'";
                            foreach ( $att2 as $key3 => $att3 ){
                                if(in_array($key3, ['wpmp_translateX','wpmp_translateY','wpmp_translateZ'] )){
                                    $transform .= $key3."(".$att3."px)";
                                }elseif(in_array($key3, ['wpmp_scaleX','wpmp_scaleY','wpmp_scaleZ'] )){
                                    $transform .= $key3."(".$att3.")";
                                }elseif(in_array($key3, ['wpmp_rotateX','wpmp_rotateY','wpmp_rotateZ','wpmp_skewX','wpmp_skewY'] )){
                                    $transform .= $key3."(".$att3."deg)";
                                }else{
                                    $effect.="'".$key3."':'".$att3."',";
                                }
                            }
                            $transform .= "',";
                            $effect.= $transform.'},';
                        }
                        $effect.= '} ';
                    }elseif( strpos( $key,"wpmp-splittext_") > -1 ){

                        if(strpos( $key,"translate_x") > -1){
                            $trans=str_replace ('_x','X','"'.$key.'":"'.$att.'",');
                            $split_text .=$trans;
                        }elseif(strpos( $key,"translate_y") > -1){
                            $trans=str_replace ('_y','Y','"'.$key.'":"'.$att.'",');
                            $split_text .=$trans;
                        }elseif(strpos( $key,"translate_z") > -1){
                            $trans=str_replace ('_z','Z','"'.$key.'":"'.$att.'",');
                            $split_text .=$trans;
                        }
                        elseif(strpos( $key,"rotate_x") > -1){
                            $trans=str_replace ('_x','X','"'.$key.'":"'.$att.'",');
                            $split_text .=$trans;
                        }
                        elseif(strpos( $key,"rotate_y") > -1){
                            $trans=str_replace ('_y','Y','"'.$key.'":"'.$att.'",');
                            $split_text .=$trans;
                        }
                        elseif(strpos( $key,"rotate_z") > -1){
                            $trans=str_replace ('_z','Z','"'.$key.'":"'.$att.'",');
                            $split_text .=$trans;
                        }
                        elseif(strpos( $key,"skew_x") > -1){
                            $trans=str_replace ('_x','X','"'.$key.'":"'.$att.'",');
                            $split_text .=$trans;
                        }
                        elseif(strpos( $key,"skew_y") > -1){
                            $trans=str_replace ('_y','Y','"'.$key.'":"'.$att.'",');
                            $split_text .=$trans;
                        }
                        $split_text .= '"'.$key.'":"'.$att.'",';
                    }else{
                        if($att != ''){
                            if(strpos( $key,"wpmpbefore_") > -1 ){
                                if(strpos( $key,"width") > -1){
                                    $before .= $key.':'.$att.'px;overflow: hidden;';
                                }elseif(strpos( $key,"height") > -1 ){
                                    $before .= $key.': '.$att.'px;overflow: hidden;';
                                }elseif(strpos( $key,"color") > -1 ){
                                    $before .= $key.': '.$att.';';
                                }elseif(strpos( $key,"opacity") > -1 ){
                                    $before .= $key.': '.$att.';';
                                }elseif(strpos( $key,"translate_x") > -1){
                                    $trans = str_replace (['wpmpbefore_','_x'],['','X'],$key.'('.$att.'px)');
                                    $transforms .= $trans;
                                }elseif(strpos( $key,"translate_y") > -1){
                                    $trans = str_replace (['wpmpbefore_','_y'],['','Y'],$key.'('.$att.'px)');
                                    $transforms .= $trans;
                                }elseif(strpos( $key,"translate_z") > -1){
                                    $trans = str_replace (['wpmpbefore_','_z'],['','Z'],$key.'('.$att.'px)');
                                    $transforms .= $trans;
                                }elseif(strpos( $key,"scale_x") > -1){
                                    $trans = str_replace (['wpmpbefore_','_x'],['','X'],$key.'('.$att.')');
                                    $transforms .= $trans;
                                }elseif(strpos( $key,"scale_y") > -1){
                                    $trans = str_replace (['wpmpbefore_','_y'],['','Y'],$key.'('.$att.')');
                                    $transforms .= $trans;
                                }elseif(strpos( $key,"scale_z") > -1){
                                    $trans = str_replace (['wpmpbefore_','_z'],['','Z'],$key.'('.$att.')');
                                    $transforms .= $trans;
                                }elseif(strpos( $key,"rotate_x") > -1){
                                    $trans = str_replace (['wpmpbefore_','_x'],['','X'],$key.'('.$att.'deg)');
                                    $transforms .= $trans;
                                }elseif(strpos( $key,"rotate_y") > -1){
                                    $trans = str_replace (['wpmpbefore_','_y'],['','Y'],$key.'('.$att.'deg)');
                                    $transforms .= $trans;
                                }elseif(strpos( $key,"rotate_z") > -1){
                                    $trans = str_replace (['wpmpbefore_','_z'],['','Z'],$key.'('.$att.'deg)');
                                    $transforms .= $trans;
                                }elseif(strpos( $key,"skew_x") > -1){
                                    $trans = str_replace (['wpmpbefore_','_x'],['','X'],$key.'('.$att.'deg)');
                                    $transforms .= $trans;
                                }elseif(strpos( $key,"skew_y") > -1){
                                    $trans = str_replace (['wpmpbefore_','_y'],['','Y'],$key.'('.$att.'deg)');
                                    $transforms .= $trans;
                                }
                                $before = str_replace ('wpmpbefore_','',$before);
                            }
                            $controls .= $key.'="'.$att.'" ';
                        }
                    }
                }
                $split_text.= '}';
            }
            return '<style type="text/css" data-type="vc_custom-css"> #scroll'.$idcustom.'~.animated,#scroll'.$idcustom.'~*>.animated{'.$before.$transforms.'}</style><span id="scroll'.$idcustom.'" '.$controls.' class="scrollMagicControl" '.$effect.$split_text.'> </span>';
        }
    }

    new Wpmp_extention();
}