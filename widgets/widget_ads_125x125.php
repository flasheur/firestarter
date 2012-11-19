<?php
function firestarter_widget_ads_125x125_init() {
	register_widget('firestarter_widget_ads_125x125');
}
add_action('widgets_init', 'firestarter_widget_ads_125x125_init');

class firestarter_widget_ads_125x125 extends WP_Widget {
	
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
			'firestarter_widget_ads_125x125', // Base ID
			__('WnG: ads 125x125', 'firestarter'), // Name
			array( 'description' => __('Display your 125x125 ads', 'firestarter' )),
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
		
		$image2 = $instance['image2'];
		$url2 = $instance['url2'];
		
		$image3 = $instance['image3'];
		$url3 = $instance['url3'];
		
		$image4 = $instance['image4'];
		$url4 = $instance['url4'];
		
		// ad 1
		if ($image1 && $url1) {
			echo '<a href="'.$url1.'" target="'.$window.'"><img src="'.$image1.'" width="125" height="125" /></a>';
		}
		// ad 2
		if ($image2 && $url2) {
			echo '<a href="'.$url2.'" target="'.$window.'"><img src="'.$image2.'" width="125" height="125" /></a>';
		}
		// ad 3
		if ($image3 && $url3) {
			echo '<a href="'.$url3.'" target="'.$window.'"><img src="'.$image3.'" width="125" height="125" /></a>';
		}
		// ad 4
		if ($image4 && $url4) {
			echo '<a href="'.$url4.'" target="'.$window.'"><img src="'.$image4.'" width="125" height="125" /></a>';
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
		
		$instance['image2'] = strip_tags( $new_instance['image2'] );
		$instance['url2'] = strip_tags( $new_instance['url2'] );
		
		$instance['image3'] = strip_tags( $new_instance['image3'] );
		$instance['url3'] = strip_tags( $new_instance['url3'] );
		
		$instance['image4'] = strip_tags( $new_instance['image4'] );
		$instance['url4'] = strip_tags( $new_instance['url4'] );
		
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
			<h3>Ad 1</h3>
			<div class="widget_form_wrapper">
				<label for="<?php echo $this->get_field_id( 'image1' ); ?>"><?php _e('Image 1:'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'image1' ); ?>" name="<?php echo $this->get_field_name( 'image1' ); ?>" type="text" value="<?php echo esc_attr( $image1 ); ?>" />
				
				<label for="<?php echo $this->get_field_id( 'url1' ); ?>"><?php _e('URL 1:'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'url1' ); ?>" name="<?php echo $this->get_field_name( 'url1' ); ?>" type="text" value="<?php echo esc_attr( $url1 ); ?>" />
			</div>
		</p>
		<p>
			<h3>Ad 2</h3>
			<div class="widget_form_wrapper">
				<label for="<?php echo $this->get_field_id( 'image2' ); ?>"><?php _e('Image 2:'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'image2' ); ?>" name="<?php echo $this->get_field_name( 'image2' ); ?>" type="text" value="<?php echo esc_attr( $image2 ); ?>" />
				
				<label for="<?php echo $this->get_field_id( 'url2' ); ?>"><?php _e('URL 2:'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'url2' ); ?>" name="<?php echo $this->get_field_name( 'url2' ); ?>" type="text" value="<?php echo esc_attr( $url2 ); ?>" />
			</div>
		</p>
		<p>
			<h3>Ad 3</h3>
			<div class="widget_form_wrapper">
				<label for="<?php echo $this->get_field_id( 'image3' ); ?>"><?php _e('Image 3:'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'image3' ); ?>" name="<?php echo $this->get_field_name( 'image3' ); ?>" type="text" value="<?php echo esc_attr( $image3 ); ?>" />
				
				<label for="<?php echo $this->get_field_id( 'url3' ); ?>"><?php _e('URL 3:'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'url3' ); ?>" name="<?php echo $this->get_field_name( 'url3' ); ?>" type="text" value="<?php echo esc_attr( $url3 ); ?>" />
			</div>
		</p>
		<p>
			<h3>Ad 4</h3>
			<div class="widget_form_wrapper">
				<label for="<?php echo $this->get_field_id( 'image4' ); ?>"><?php _e('Image 4:'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'image4' ); ?>" name="<?php echo $this->get_field_name( 'image4' ); ?>" type="text" value="<?php echo esc_attr( $image4 ); ?>" />
				
				<label for="<?php echo $this->get_field_id( 'url4' ); ?>"><?php _e('URL 4:'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'url4' ); ?>" name="<?php echo $this->get_field_name( 'url4' ); ?>" type="text" value="<?php echo esc_attr( $url4 ); ?>" />
			</div>
		</p>
		<?php
	}
	
}
?>