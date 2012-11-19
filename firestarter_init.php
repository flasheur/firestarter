<?php
/****************************************************
*
*	CONSTANTS
*
****************************************************/
define('FIRESTARTER_SHORTNAME', 'fire'); // used to prefix setting fields id
define('FIRESTARTER_BASENAME', 'firestarter'); // settings page slug
define('FIRESTARTER_DIR', get_template_directory() . '/firestarter');
define('FIRESTARTER_URI', get_template_directory_uri() . '/firestarter');
define('FIRESTARTER_TITLE', __(	'WnG Solutions Admin Panel', 'firestarter'));
define('FIRESTARTER_VERSION', '1.5.0');

/******************************************************
*
*	FIRESTARTER SETTINGS
*
******************************************************/
require_once( 'admin/index.php' );

/****************************************************
*
*	INSTANCIATE FIRESTARTER UTILS
*
****************************************************/
require_once( 'firestarter.php' );
global $firestarter;
$firestarter = new firestarter();

/******************************************************
*
*	FIRESTARTER METABOXES FRAMEWORK
*
******************************************************/
require_once( 'metabox/firestarter_metabox_init.php' );

/******************************************************
*
*	FIRESTARTER SHORTCODES
*
******************************************************/
require_once( 'shortcodes/firestarter_shortcodes.php' );

/******************************************************
*
*	FIRESTARTER WIDGETS
*
******************************************************/
require_once( 'widgets/firestarter_widgets_init.php' );

/******************************************************
*
*	FIRESTARTER CUSTOM POST TYPES
*
******************************************************/
require_once( 'post_types/firestarter_post_types.php' );

/******************************************************
*
*	FIRESTARTER OUTPUT
*	Customizable file, used to output various code
*
******************************************************/
if (!is_admin()) {
	require_once( 'firestarter_output.php' );
}
?>