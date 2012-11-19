<?php
/******************************************************
*
*	CLEAR
*	[clear]
*
******************************************************/
function firestarter_shortcode_clear() {
	return '<div class="clear"></div>';
}
add_shortcode( 'clear', 'firestarter_shortcode_clear' );

/******************************************************
*
*	SPACER
*	[spacer height="20"]
*
******************************************************/
function firestarter_shortcode_spacer( $atts ) {
	
	extract( shortcode_atts( array(
		'height' => '20'
	), $atts) );
	
	return '<div class="spacer" style="height:'.$height.'px"></div>';
}
add_shortcode( 'spacer', 'firestarter_shortcode_spacer' );

/******************************************************
*
*	TOOLTIP
*	[tooltip href="#" title=""]
*
******************************************************/
function firestarter_shortcode_tooltip( $atts, $content ) {
	
	extract( shortcode_atts( array(
		'href' => '#',
		'title' => ''
	), $atts) );
	
	return '<a href="'.$href.'" rel="tooltip" title="'.$title.'">'.$content.'</a>';
}
add_shortcode( 'tooltip', 'firestarter_shortcode_tooltip' );

/****************************************************
*
*	COLUMNS CONTAINER
*	[columns]
*
****************************************************/
function firestarter_shortcode_columns( $atts, $content ) {
		
	return '<div class="row-fluid columns-container">';
	
}
add_shortcode( 'columns', 'firestarter_shortcode_columns' );

/****************************************************
*
*	COLUMNS CONTAINER END
*	[columns_end]
*
****************************************************/
function firestarter_shortcode_columns_end( $atts, $content ) {
		
	return '</div>' . do_shortcode('[spacer]');
	
}
add_shortcode( 'columns_end', 'firestarter_shortcode_columns_end' );

/****************************************************
*
*	COLUMN ONE-THIRD
*	[column_one_third]
*
****************************************************/
function firestarter_shortcode_column_one_third( $atts, $content ) {
		
	return '<div class="span4 content-column column_one_third">'.$content.'</div>';
	
}
add_shortcode( 'column_one_third', 'firestarter_shortcode_column_one_third' );

/****************************************************
*
*	COLUMN HALF
*	[column_half]
*
****************************************************/
function firestarter_shortcode_column_half( $atts, $content ) {
		
	return '<div class="span6 content-column column_half">'.$content.'</div>';
	
}
add_shortcode( 'column_half', 'firestarter_shortcode_column_half' );

/****************************************************
*
*	BUTTON
*	[button color="blue" size="large" href="http://www.example.com" target="_self"]
*
****************************************************/
function firestarter_shortcode_button( $atts, $content ) {
	
	extract( shortcode_atts( array(
		'color' => '',
		'size' => '',
		'href' => '#',
		'target' => '_self'
	), $atts) );
	
	switch ($color) {
		case 'blue':
			$color = ' btn-primary';
			break;
		case 'lightblue':
			$color = ' btn-info';
			break;
		case 'green':
			$color = ' btn-success';
			break;
		case 'yellow':
			$color = ' btn-warning';
			break;
		case 'red':
			$color = ' btn-danger';
			break;
		case 'black':
			$color = ' btn-inverse';
			break;
	}
	
	switch ($size) {
		case 'large':
			$size = ' btn-large';
			break;
		case 'small':
			$size = ' btn-small';
			break;
		case 'mini':
			$size = ' btn-mini';
			break;
	}
	
	return '<a href="' . $href . '" class="btn' . $color . $size . '">'.$content.'</a>';
	
}
add_shortcode( 'button', 'firestarter_shortcode_button' );

/****************************************************
*
*	YOUTUBE
*	[youtube id="" width="580" height="326"]
*
****************************************************/
function firestarter_shortcode_youtube( $atts, $content )
{
	extract( shortcode_atts( array(
		'id' 		=> '',
		'width' 	=> '580',
		'height'	=> '326'
	), $atts));
	
	return '<iframe src="http://www.youtube.com/embed/'. $id .'" frameborder="0" width="'. $width .'" height="'. $height .'"></iframe>' . do_shortcode('[spacer]');
}
add_shortcode( 'youtube', 'firestarter_shortcode_youtube' );

/****************************************************
*
*	VIMEO
*	[vimeo id="" width="580" height="326"]
*
****************************************************/
function firestarter_shortcode_vimeo( $atts, $content )
{
	extract( shortcode_atts( array(
		'id' 		=> '',
		'width' 	=> '580',
		'height'	=> '326'
	), $atts));
	
	return '<iframe src="http://player.vimeo.com/video/'. $id .'" frameborder="0" width="'. $width .'" height="'. $height .'" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>' . do_shortcode('[spacer]');
}
add_shortcode( 'vimeo', 'firestarter_shortcode_vimeo' );

/****************************************************
*
*	GOOGLE MAPS
*	[googlemaps lat="46.520359" lon="6.637883" zoom="15" width="580" height="350" type="sat/map"]
*
****************************************************/
function firestarter_shortcode_googlemaps( $atts, $content )
{
	extract( shortcode_atts( array(
		'lat' 		=> '46.520359',
		'lon' 		=> '6.637883',
		'zoom'		=> '15',
		'width' 	=> '580',
		'height' 	=> '350',
		'type'		=> 'sat'
	), $atts));
	
	// convert map type
	switch ($type) {
		case 'sat':
			$type = 'h';
			break;
		case 'map':
			$type = 'm';
			break;
		default:
			$type = 'h';
	}
	
	return '<iframe width="'. $width .'" height="'. $height .'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.ch/maps?f=q&amp;source=s_q&amp;hl=fr&amp;geocode=&amp;q=&amp;aq=0&amp;oq=marte&amp;sll='. $lat .','. $lon .'&amp;sspn=0.002164,0.002411&amp;t='. $type .'&amp;ie=UTF8&amp;ll='. $lat .','. $lon .'&amp;spn=0.002164,0.002411&amp;z='. $zoom .'&amp;output=embed"></iframe>' . do_shortcode('[spacer]');
}
add_shortcode( 'googlemaps', 'firestarter_shortcode_googlemaps' );

/****************************************************
*
*	ALERT
*	[alert type="block/error/success/info" title="Title"]Content[/alert]
*
****************************************************/
function firestarter_shortcode_alert( $atts, $content )
{
	extract( shortcode_atts( array(
		'type' 		=> 'block',
		'title' 	=> ''
	), $atts));
	
	$class = "alert-" . $type;	
	
	$output = '<div class="alert '. $class .'">';
	$output .= '<a class="close" data-dismiss="alert" href="#">&times;</a>';
	$output .= '<h4 class="alert-heading">'. $title .'</h4>';
	$output .= $content;
	$output .= '</div>';
	
	return $output;
	
}
add_shortcode( 'alert', 'firestarter_shortcode_alert' );

/****************************************************
*
*	SHARE BOX
*	Display the common social networks share button
*	[sharebox]
*
****************************************************/
function firestarter_shortcode_sharebox( $atts, $content )
{	
	$output = '<div class="share-box">';
		$output .= '<div class="fb-like" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>';
		$output .= '<div class="twitter-tweet">';
			$output .= '<a href="https://twitter.com/share" class="twitter-share-button" data-lang="fr">Tweeter</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
		$output .= '</div>';
	$output .= '</div>';
	
	return $output;
	
}
add_shortcode( 'sharebox', 'firestarter_shortcode_sharebox' );


?>