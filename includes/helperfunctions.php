<?php

namespace Badabingbreda;

/**
 * Convert hexdec color string to rgb(a) string
 * @param  string  			$color   	color in hex format (#ff0000 of #f00)
 * @param  boolean/float 	$opacity 	transparancy
 * @return string           			[description]
 */
function hex2rgba($color, $opacity = false) {

	$default = 'rgba(0,0,0)';

	//Return default if no color provided
	if(empty($color))
          return $default;

	//Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if( $opacity >= 0 ){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
}

/**
 * @param array      $array
 * @param int|string $position
 * @param mixed      $insert
 */
function array_insert(&$array, $insert, $position=0, $offset=null )
{
    if (is_int($position) && $keyname==null) {
        array_splice($array, $position, 0, $insert);
    } else {
        $pos   = array_search($position, array_keys($array));
        if ( $offset ) {
        	$array = array_merge(
        		array_slice( $array , 0, $offset ),
        		$insert,
        		array_slice( $array, $offset )
        	);
        } else {
	        $array = array_merge(
	            array_slice($array, 0, $pos),
	            $insert,
	            array_slice($array, $pos)
	        );
    	}
    }
}
