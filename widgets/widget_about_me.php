<?php
function firestarter_widget_about_me_init() {
	register_widget('firestarter_widget_about_me');
}
add_action('widgets_init', 'firestarter_widget_about_me_init');

class firestarter_widget_about_me extends WP_Widget {
	
	var $default_title = '';
	var $default_thumb = '/images/default-post-thumbnail.jpg';
	
	/****************************************************
	*
	*	CONSTRUCTOR
	*
	****************************************************/
	public function __construct()
	{
		$this->default_title = __('About me', 'firestarter');
	
		parent::__construct(
			'firestarter_widget_about_me', // Base ID
			__('WnG: about me', 'firestarter'), // Name
			array( 'description' => __("Display one user's profile. Edit your profile and this widget will display your Gravatar using your e-mail, your public name, your website url and your biographical info", 'firestarter' ))
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
		$user_id = $instance['user_id'];
		
		echo $before_widget;
		
		if ( !empty($title) ) {
			echo $before_title . $title . $after_title;
		}
		
		$mail = get_the_author_meta( 'user_email', $user_id );
		$image = get_avatar( $mail, 50, get_template_directory_uri() . $this->default_thumb);
		$url = get_the_author_meta( 'user_url', $user_id );
		$description = get_the_author_meta( 'user_description', $user_id );
		
		echo '<div class="row">';
			echo '<div class="post-thumbnail span1">' . $image . ' </div>';
			echo '<h3 class="span2">' . get_the_author_meta( 'display_name', $user_id ) . '</h3>';
			echo '<a href="'.$url.'" target="_blank" class="span2">' . $url . '</a>';
		echo '</div>';
		
		echo '<div class="clear"></div>';
		echo do_shortcode( '[spacer]' );
		
		echo '<p>' . $description . '</p>';
		
				
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
		$instance['user_id'] = absint( $new_instance['user_id'] );
		
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
		
		if (empty($user_id)) {
			$user_id = '';
		}
		
		$user_args = array(
			'id' => $this->get_field_id('user_id'),
			'name' => $this->get_field_name('user_id'),
			'selected' => $user_id
		);
		
		wp_dropdown_users($user_args);
		
		
	}
	
}
?>