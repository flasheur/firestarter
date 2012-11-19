<?php
function firestarter_widget_login_init() {
	register_widget('firestarter_widget_login');
}
add_action('widgets_init', 'firestarter_widget_login_init');

class firestarter_widget_login extends WP_Widget {
	
	var $default_title = '';
	
	
	/****************************************************
	*
	*	CONSTRUCTOR
	*
	****************************************************/
	public function __construct()
	{
		$this->default_title = __('Login', 'firestarter');
	
		parent::__construct(
			'firestarter_widget_login', // Base ID
			__('WnG: login form', 'firestarter'), // Name
			array( 'description' => __('Display a login form', 'firestarter' ))
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
		$phrase = $instance['phrase'];
		
		echo $before_widget;
		
		if ( !empty($title) ) {
			echo $before_title . $title . $after_title;
		}
		
		if (is_user_logged_in()) {
			
			$current_user = wp_get_current_user();
			
			$phrase = str_replace('%username%', $current_user->user_nicename, $phrase);
			echo '<p>' . $phrase . '</p>';
			
			echo '<p><a href="'. wp_logout_url( $_SERVER['REQUEST_URI'] ) .'">'. __('Logout', 'firestarter') .'</a></p>';
			
		} else {
			wp_login_form();
			
			echo '<p>';
				echo '<a href="'. site_url('/wp-login.php?action=register&redirect_to=' . get_permalink()) .'">Register</a>';
			echo '</p>';
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
		$instance['phrase'] = $new_instance['phrase'];
		
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
			'title' 	=> __($this->default_title, 'firestarter'),
			'phrase'	=> __('Hello %username%')
		);
	
		$instance = wp_parse_args( $instance, $defaults );
		
		extract( $instance );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'phrase' ); ?>"><?php _e('Phrase:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'phrase' ); ?>" name="<?php echo $this->get_field_name( 'phrase' ); ?>" type="text" value="<?php echo esc_attr( $phrase ); ?>" />
		</p>
		<?php
	}
	
}
?>