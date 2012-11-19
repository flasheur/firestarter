<?php
function _init() {
	register_widget('firestarter_widget_template');
}
add_action('widgets_init', '_init');

class firestarter_widget_template extends WP_Widget {
	
	var $default_title = '';
	
	
	/****************************************************
	*
	*	CONSTRUCTOR
	*
	****************************************************/
	public function __construct()
	{
		$this->default_title = __('Firestarter default title', 'firestarter');
	
		parent::__construct(
			'firestarter_widget_template', // Base ID
			__('WnG: title', 'firestarter'), // Name
			array( 'description' => __('Template description', 'firestarter' ))
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
		extract($args);
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo $before_widget;
		
		if ( !empty($title) ) {
			echo $before_title . $title . $after_title;
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