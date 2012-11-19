<?php
function firestarter_widget_youtube_favorites_init() {
	register_widget('firestarter_widget_youtube_favorites');
}
add_action('widgets_init', 'firestarter_widget_youtube_favorites_init');

class firestarter_widget_youtube_favorites extends WP_Widget {
	
	var $default_title = '';
	
	
	/****************************************************
	*
	*	CONSTRUCTOR
	*
	****************************************************/
	public function __construct()
	{
		$this->default_title = __('My favorite youtube videos', 'firestarter');
	
		parent::__construct(
			'firestarter_widget_youtube_favorites', // Base ID
			__('WnG: Youtube favorites videos', 'firestarter'), // Name
			array( 'description' => __('Display your favorites youtubes videos', 'firestarter' ))
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
		
		$feed = 'http://gdata.youtube.com/feeds/api/users/'.$instance['username'].'/favorites?max-results='.$instance['count'];
		$xml = simplexml_load_file($feed);
		
		foreach ($xml->entry as $entry) {
			$media = $entry->children('http://search.yahoo.com/mrss/');
			
			$attrs = $media->group->thumbnail[1]->attributes();
			$thumb = (string) $attrs['url'];
			
			$title = (string) $entry->title;
			
			$attrs = $entry->link->attributes();
			$link = (string) $attrs['href'];
			
			echo '<a href="'.$link.'" title="'.$title.'" target="_blank"><img src="'.$thumb.'" /></a>';
		}
		
		$user_link = (string) $xml->author->uri;
		
		echo '<a href="http://www.youtube.com/user/'.$instance['username'].'" class="youtube-more-link" target="_blank">' . __('Watch all the videos', 'firestarter') . '</a>';
		
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
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['count'] = absint( $new_instance['count'] );
		
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
			'username' => 'flasheurch',
			'count' => 4
		);
	
		$instance = wp_parse_args( $instance, $defaults );
		
		extract( $instance );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e('Username:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number of videos:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
		</p>
		<?php
	}
	
}
?>