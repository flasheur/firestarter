<?php
function firestarter_widget_latest_tweets_init() {
	register_widget('firestarter_widget_latest_tweets');
}
add_action('widgets_init', 'firestarter_widget_latest_tweets_init');

class firestarter_widget_latest_tweets extends WP_Widget {
	
	var $default_title = '';
	
	
	/**********************************************
	*
	*	CONSTRUCTOR
	*
	**********************************************/
	public function __construct()
	{
		$this->default_title = __('Latest tweets', 'firestarter');
		
		parent::__construct(
			'firestarter_widget_latest_tweets', // Base ID
			__('WnG: latest tweets', 'firestarter'), // Name
			array( 'description' => __('Display your latest tweets using the official Twitter widget', 'firestarter' ))
		);
	}
	
	/**********************************************
	*
	*	WIDGET
	*	Output the content of the widget
	*
	**********************************************/
	public function widget( $args, $instance )
	{
		extract($args);
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		$username = $instance['username'];
		$tweets_displayed = $instance['tweets_displayed'];
		$background = $instance['background'];
		$main_text_color = $instance['main_text_color'];
		$tweet_background = $instance['tweet_background'];
		$tweet_text_color = $instance['tweet_text_color'];
		$links_color = $instance['links_color'];
		
		echo $before_widget;
		
		if ( !empty($title) ) {
			echo $before_title . $title . $after_title;
		}
		
		?>
		<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
		<script>
		new TWTR.Widget({
		  version: 2,
		  type: 'profile',
		  rpp: <?php echo $tweets_displayed; ?>,
		  interval: 30000,
		  width: 'auto',
		  height: 300,
		  theme: {
		    shell: {
		      background: '<?php echo $background; ?>',
		      color: '<?php echo $main_text_color; ?>'
		    },
		    tweets: {
		      background: '<?php echo $tweet_background; ?>',
		      color: '<?php echo $tweet_text_color; ?>',
		      links: '<?php echo $links_color; ?>'
		    }
		  },
		  features: {
		    scrollbar: false,
		    loop: false,
		    live: false,
		    behavior: 'all'
		  }
		}).render().setUser('<?php echo $username; ?>').start();
		</script>
		<?php
		echo $after_widget;
		
	}
	
	/**********************************************
	*
	*	UPDATE
	*	Processes widget options to be saved
	*
	**********************************************/
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['tweets_displayed'] = strip_tags( $new_instance['tweets_displayed'] );
		$instance['background'] = strip_tags( $new_instance['background'] );
		$instance['tweet_background'] = strip_tags( $new_instance['tweet_background'] );
		$instance['main_text_color'] = strip_tags( $new_instance['main_text_color'] );
		$instance['tweet_text_color'] = strip_tags( $new_instance['tweet_text_color'] );
		$instance['links_color'] = strip_tags( $new_instance['links_color'] );
		
		return $instance;
	}
	
	/**********************************************
	*
	*	FORM
	*	Output the options form on admin
	*
	**********************************************/
	public function form( $instance )
	{
		$defaults = array(
			'title' => __($this->default_title, 'firestarter'),
			'username' => 'flasheur_ch',
			'tweets_displayed' => '3',
			'background' => '#c2e3ff',
			'tweet_background' => '#ffffff',
			'main_text_color' => '#333333',
			'tweet_text_color' => '#333333',
			'links_color' => '#336699'
		);
	
		$instance = wp_parse_args( $instance, $defaults );
		
		extract( $instance );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e('Username:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" />
			
			<label for="<?php echo $this->get_field_id( 'tweets_displayed' ); ?>"><?php _e('Tweets displayed:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tweets_displayed' ); ?>" name="<?php echo $this->get_field_name( 'tweets_displayed' ); ?>" type="text" value="<?php echo esc_attr( $tweets_displayed ); ?>" />
			
			<label for="<?php echo $this->get_field_id( 'background' ); ?>"><?php _e('Background color:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'background' ); ?>" name="<?php echo $this->get_field_name( 'background' ); ?>" type="text" value="<?php echo esc_attr( $background ); ?>" />
			
			<label for="<?php echo $this->get_field_id( 'tweet_background' ); ?>"><?php _e('Tweets background color:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tweet_background' ); ?>" name="<?php echo $this->get_field_name( 'tweet_background' ); ?>" type="text" value="<?php echo esc_attr( $tweet_background ); ?>" />
			
			<label for="<?php echo $this->get_field_id( 'main_text_color' ); ?>"><?php _e('Text color:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'main_text_color' ); ?>" name="<?php echo $this->get_field_name( 'main_text_color' ); ?>" type="text" value="<?php echo esc_attr( $main_text_color ); ?>" />
			
			<label for="<?php echo $this->get_field_id( 'tweet_text_color' ); ?>"><?php _e('Tweets text color:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tweet_text_color' ); ?>" name="<?php echo $this->get_field_name( 'tweet_text_color' ); ?>" type="text" value="<?php echo esc_attr( $tweet_text_color ); ?>" />
			
			<label for="<?php echo $this->get_field_id( 'links_color' ); ?>"><?php _e('Links color:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'links_color' ); ?>" name="<?php echo $this->get_field_name( 'links_color' ); ?>" type="text" value="<?php echo esc_attr( $links_color ); ?>" />
			
		</p>
		<?php
	}
	
}
?>