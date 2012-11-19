<?php
function firestarter_widget_ads_300x250_init() {
	register_widget('firestarter_widget_ads_300x250');
}
add_action('widgets_init', 'firestarter_widget_ads_300x250_init');

class firestarter_widget_ads_300x250 extends WP_Widget {
	
	var $default_title = '';
	
	
	/****************************************************
	*
	*	CONSTRUCTOR
	*
	****************************************************/
	public function __construct()
	{
		$this->default_title = __('Firestarter ads', 'firestarter');
	
		parent::__construct(
			'firestarter_widget_ads_300x250', // Base ID
			__('WnG: ads 300x250', 'firestarter'), // Name
			array( 'description' => __('Display your 300x250 ad', 'firestarter' )),
			array( 'width' => 400)
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
		
		$window = $instance['window'];
		
		echo $before_widget;
		
		if ( !empty($title) ) {
			echo $before_title . $title . $after_title;
		}
		
		$image1 = $instance['image1'];
		$url1 = $instance['url1'];
		
		// ad 1
		if ($image1 && $url1) {
			echo '<a href="'.$url1.'" target="'.$window.'"><img src="'.$image1.'" width="300" height="250" /></a>';
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
		
		$instance['window'] = strip_tags( $new_instance['window'] );
		
		$instance['image1'] = strip_tags( $new_instance['image1'] );
		$instance['url1'] = strip_tags( $new_instance['url1'] );
		
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
			'title' => __($this->default_title, 'firestarter'),
			'window' => '_blank'
		);
	
		$instance = wp_parse_args( $instance, $defaults );
		
		extract( $instance );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'window' ); ?>"><?php _e('Links target:'); ?></label>
			<select id="<?php echo $this->get_field_id( 'window' ); ?>" name="<?php echo $this->get_field_name( 'window' ); ?>">
				<option value="_blank"<?php echo $window == '_blank' ? 'selected=selected' : ''; ?>>_blank</option>
				<option value="_self"<?php echo $window == '_self' ? 'selected=selected' : ''; ?>>_self</option>
			</select>
		</p>
		<p>
			<h3>Your ad</h3>
			<div class="widget_form_wrapper">
				<label for="<?php echo $this->get_field_id( 'image1' ); ?>"><?php _e('Image 1:'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'image1' ); ?>" name="<?php echo $this->get_field_name( 'image1' ); ?>" type="text" value="<?php echo esc_attr( $image1 ); ?>" />
				
				<label for="<?php echo $this->get_field_id( 'url1' ); ?>"><?php _e('URL 1:'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'url1' ); ?>" name="<?php echo $this->get_field_name( 'url1' ); ?>" type="text" value="<?php echo esc_attr( $url1 ); ?>" />
			</div>
		</p>
		<?php
	}
	
}
?>