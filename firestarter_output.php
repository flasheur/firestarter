<?php
/******************************************************
*
*	CUSTOM CSS
*	Output css based on custom header and footer colors
*	the css is pushed in the header using the wp_head hook
*
******************************************************/
function custom_style() {
	global $firestarter;
?>
	<style>
		/* See firestarter output */
		#branding #logo-link a {
			color: <?php $firestarter->option('fire_color_header'); ?> !important;
		}
		#colophon {
			background: <?php $firestarter->option('fire_color_footer'); ?> !important;
		}
	</style>
<?php
}
add_action('wp_head', 'custom_style');

/******************************************************
*
*	CUSTOM FAVICON
*	Output favicon tag
*
******************************************************/
function custom_favicon() {
	global $firestarter;
	echo '<link rel="shortcut icon" type="image/png" href="'.$firestarter->get_option('fire_upload_favicon').'" />' . "\n";
}
add_action('wp_head', 'custom_favicon');
?>