<?php
/*
*
*	Context 	: normal, advanced, side
*	Priority 	: high, core, default, low
*
*/

$prefix = 'fire_';

function firestarter_metabox( $meta_boxes ) {
	global $prefix;
			
	// alternative title
	$meta_boxes[] = array(
		'id' => 'title_options',
		'title' => 'Title options',
		'pages' => array('page', 'post'),
		'context' => 'normal',
		'priority' => 'default',
		'show_names' => true,
		'fields' => array(
			array(
				'id' => $prefix . 'alternative_title',
				'name' => __('Alternative title', 'firestarter'),
				'desc' => __('Alternative title to this post/page', 'firestarter'),
				'type' => 'text'
			),
			array(
				'id' => $prefix . 'sub_title',
				'name' => __('Sub title', 'firestarter'),
				'desc' => __('Alternative title to this post/page', 'firestarter'),
				'type' => 'text'
			),
			array(
				'id' => $prefix . 'hide_title',
				'name' => __('Hide the title?', 'firestarter'),
				'desc' => __('Choose to display or hide the title.', 'firestarter'),
				'type' => 'checkbox',
				'std' => 'checked'
			),
		)
	);
			
	// slider manager
	$meta_boxes[] = array(
		'id' => 'slider_manager',
		'title' => 'Slider manager',
		'pages' => array('page', 'post'),
		'context' => 'normal',
		'priority' => 'default',
		'show_names' => true,
		'fields' => array(
			array(
				'name' => __('Image 1', 'firestarter'),
				'id' => $prefix . 'slider_image_1',
				'type' => 'file',
				'save_id' => true
			),
			array(
				'name' => __('Image 1 link', 'firestarter'),
				'desc' => __('Link applied to image 1', 'firestarter'),
				'id'   => $prefix . 'slider_image_1_link',
				'type' => 'text'
			),
			array(
				'name' => __('Image 2', 'firestarter'),
				'id' => $prefix . 'slider_image_2',
				'type' => 'file',
				'save_id' => true
			),
			array(
				'name' => __('Image 2 link', 'firestarter'),
				'desc' => __('Link applied to image 2', 'firestarter'),
				'id'   => $prefix . 'slider_image_2_link',
				'type' => 'text'
			),
			array(
				'name' => __('Image 3', 'firestarter'),
				'id' => $prefix . 'slider_image_3',
				'type' => 'file',
				'save_id' => true
			),
			array(
				'name' => __('Image 3 link', 'firestarter'),
				'desc' => __('Link applied to image 3', 'firestarter'),
				'id'   => $prefix . 'slider_image_3_link',
				'type' => 'text'
			),
			array(
				'name' => __('Image 4', 'firestarter'),
				'id' => $prefix . 'slider_image_4',
				'type' => 'file',
				'save_id' => true
			),
			array(
				'name' => __('Image 4 link', 'firestarter'),
				'desc' => __('Link applied to image 4', 'firestarter'),
				'id'   => $prefix . 'slider_image_4_link',
				'type' => 'text'
			),
			array(
				'name' => __('Image 5', 'firestarter'),
				'id' => $prefix . 'slider_image_5',
				'type' => 'file',
				'save_id' => true
			),
			array(
				'name' => __('Image 5 link', 'firestarter'),
				'desc' => __('Link applied to image 5', 'firestarter'),
				'id'   => $prefix . 'slider_image_5_link',
				'type' => 'text'
			),
		)
	);
		
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'firestarter_metabox' );

add_action( 'init', 'firestarter_metabox_init', 9999 );
function firestarter_metabox_init() {
	if ( !class_exists( 'cmb_Meta_Box' )) {
		require_once( 'init.php');
	}
}

?>