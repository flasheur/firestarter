<?php
function firestarter_widget_sub_menu_init() {
	register_widget('firestarter_widget_sub_menu');
}
add_action('widgets_init', 'firestarter_widget_sub_menu_init');

class firestarter_widget_sub_menu extends WP_Widget {
	
	var $default_title = '';
	
	
	/****************************************************
	*
	*	CONSTRUCTOR
	*
	****************************************************/
	public function __construct()
	{
		$this->default_title = __('', 'firestarter');
	
		parent::__construct(
			'firestarter_widget_template', // Base ID
			__('WnG: Sub menu', 'firestarter'), // Name
			array( 'description' => __('Display a sub menu, is based on page hierarchy and not on menu!', 'firestarter' ))
		);
	}
	
	/****************************************************
	*
	*	WIDGET
	*	Output the content of the widget
	*
	****************************************************/
	public function widget( $args, $instance )
	{
		global $post;
	
		extract($args);
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo $before_widget;
		
		if ( !$title ) {
			$title = get_the_title($post->post_parent);
		}
		
		if ( !empty($title) ) {
			echo $before_title . $title . $after_title;
		}
		
		// define subpages
		$has_subpages = false;
		
		// get page children
		$children = wp_list_pages(array(
			'child_of'	=>	$post->ID,
			'echo'		=>	false
		));
		
		// if it has subpages
		if ($children) { $has_subpages = true; }
		
		// reset children
		$children = null;
		
		// this is a subpage
		if ( is_page() && $post->post_parent ) {
			$ancestors = $post->ancestors;
			
			if ( count($ancestors) > 1 ) {
				for ($i = 1; $i < count($ancestors); $i++) {
					$children .= wp_list_pages(array(
						'title_li'	=>	'',
						'child_of'	=>	$ancestors[$i],
						'echo'		=>	false
					));
				}
			} else {
				$children .= wp_list_pages(array(
					'title_li'	=>	'',
					'child_of'	=>	$post->post_parent,
					'echo'		=>	false
				));
			}
		// parent page with subpage(s)	
		} else if ( $has_subpages ) {
			$children = wp_list_pages(array(
				'title_li'	=>	'',
				'child_of'	=>	$post->ID,
				'echo'		=>	false
			));
		}
		
		// if children are stored, print them
		if ( $children ) {
			echo '<ul>';
				echo $children;
			echo '</ul>';
		}
		
		echo $after_widget;
	}
	
	/****************************************************
	*
	*	UPDATE
	*	Processes widget options to be saved
	*
	****************************************************/
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		return $instance;
	}
	
	/****************************************************
	*
	*	FORM
	*	Output the options form on admin
	*
	****************************************************/
	public function form( $instance )
	{
		$defaults = array(
			'title' => __($this->default_title, 'firestarter')
		);
	
		$instance = wp_parse_args( $instance, $defaults );
		
		extract( $instance );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
	}
	
}
?>