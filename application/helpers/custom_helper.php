<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('convert_to_digital_time'))
{
	function convert_to_digital_time($raw_time, $shortcut = true, $colored = false) {

                $hour = $raw_time / 3600;
                $minute = ( $hour - intval( $hour ) ) * 60;
                $seconds = ( $minute - intval( $minute ) ) * 60;

                $total_hour = intval($hour);
                $total_minute = intval($minute);
                $total_second = intval($seconds);

                $hour_phrase = ( $shortcut ? get_phrase('hours') : get_phrase('hrs') );
                $min_phrase = ( $shortcut ? get_phrase('minutes') : get_phrase('min') );
                $sec_phrase = ( $shortcut ? get_phrase('seconds') : get_phrase('sec') );

                if( $colored ){
                        $style = ( ( $total_hour < 0 || $total_minute < 0 || $total_second < 0 ) ? ' style="color: red"' : ' style="color: green"' );
                        echo '<span'.$style.'>';
                }
                echo $total_hour .' '. $hour_phrase .', '. $total_minute .' '. $min_phrase . ', '. $total_second .' '. $sec_phrase;

                if( $colored ){
                        echo '</span>';       
                }

	}
}
