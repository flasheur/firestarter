<?php
add_action( 'init', 'firestarter_slider' );
function firestarter_slider() {
	
	$post_type_id = 'slider';
	
	$labels = array(
		'name' => _x('Sliders', 'post type general name'),
		'singular_name' => _x('Slider', 'post type singular name'),
		'add_new' => _x('Add New', 'firestarter'),
		'add_new_item' => __('Add New slider'),
		'edit_item' => __('Edit slider'),
		'new_item' => __('New slider'),
		'all_items' => __('All sliders'),
		'view_item' => __('View slider'),
		'search_items' => __('Search sliders'),
		'not_found' =>  __('No sliders found'),
		'not_found_in_trash' => __('No sliders found in Trash'), 
		'parent_item_colon' => '',
		'menu_name' => 'Sliders'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array( 'title', 'excerpt', 'thumbnail' )
	);
	
	register_post_type($post_type_id, $args);
}

function firestarter_slider_rewrite_flush() {
	// call once the init function
	firestarter_slider();
	// flush the rules during activation hook
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'firestarter_slider_rewrite_flush' );

?>