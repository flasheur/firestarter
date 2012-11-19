<?php
function firestarter_widget_social_media_init() {
	register_widget('firestarter_widget_social_media');
}
add_action('widgets_init', 'firestarter_widget_social_media_init');

class firestarter_widget_social_media extends WP_Widget {
	
	var $default_title = '';
	
	
	/**********************************************
	*
	*	CONSTRUCTOR
	*
	**********************************************/
	public function __construct()
	{
		$this->default_title = __('Social medias', 'firestarter');
		
		parent::__construct(
			'firestarter_widget_social_media', // Base ID
			__('WnG: social medias', 'firestarter'), // Name
			array( 
				'description' => __('Display links pointing to your favorite social networks', 'firestarter' ),
				'classname' => 'firestarter_widget_social_media'
			)
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
		extract($instance);
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo $before_widget;
		
		if ( !empty($title) ) {
			echo $before_title . $title . $after_title;
		}
		
		echo '<ul>';
			
			foreach ($social_links as $link) {
				if ( !empty($link['url']) ) {
					echo '<li class="' . $link['class'] . '"><a href="' . $link['url'] . '" title="' . $link['title'] . '" class="' . $icn_color . '">' . $link['class'] . '</a></li>';
				}
			}
			
		echo '</ul>';
		
		echo '<div class="clear"></div>';
		
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
		$instance['icn_color'] = strip_tags( $new_instance['icn_color'] );
		
		// links
		$instance['social_links'] = array(
			'feedrss' => array( 'url' => strip_tags( $new_instance['feedrss'] ), 'class' => 'feedrss', 'title' => 'Feed RSS'),
			'mail' => array( 'url' => strip_tags( $new_instance['mail'] ), 'class' => 'mail', 'title' => 'Mail'),
			'twitter' => array( 'url' => strip_tags( $new_instance['twitter'] ), 'class' => 'twitter', 'title' => 'Twitter'),
			'facebook' => array( 'url' => strip_tags( $new_instance['facebook'] ), 'class' => 'facebook', 'title' => 'Facebook'),
			'googleplus' => array( 'url' => strip_tags( $new_instance['googleplus'] ), 'class' => 'googleplus', 'title' => 'Google+'),
			'youtube' => array( 'url' => strip_tags( $new_instance['youtube'] ), 'class' => 'youtube', 'title' => 'Youtube'),
			'linkedin' => array( 'url' => strip_tags( $new_instance['linkedin'] ), 'class' => 'linkedin', 'title' => 'Linkedin'),
			'flickr' => array( 'url' => strip_tags( $new_instance['flickr'] ), 'class' => 'flickr', 'title' => 'Flickr')
		);
		
		$instance['feedrss'] = strip_tags( $new_instance['feedrss'] );
		$instance['twitter'] = strip_tags( $new_instance['twitter'] );
		$instance['facebook'] = strip_tags( $new_instance['facebook'] );
		$instance['googleplus'] = strip_tags( $new_instance['googleplus'] );
		$instance['youtube'] = strip_tags( $new_instance['youtube'] );
		$instance['linkedin'] = strip_tags( $new_instance['linkedin'] );
		$instance['flickr'] = strip_tags( $new_instance['flickr'] );
		
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
			'icn_color' => 'black',
			'feedrss' => get_bloginfo('rss2_url')
		);
	
		$instance = wp_parse_args( $instance, $defaults );
		
		extract( $instance );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'icn_color' ); ?>"><?php _e('Icon color:'); ?></label>
			<select id="<?php echo $this->get_field_id( 'icn_color' ); ?>" name="<?php echo $this->get_field_name( 'icn_color' ); ?>">
				<option value="black"<?php echo ($icn_color == 'black') ? 'selected' : ''; ?>><?php _e('Black'); ?></option>
				<option value="white"<?php echo ($icn_color == 'white') ? 'selected' : ''; ?>><?php _e('White'); ?></option>
			</select>
		<p>
		</p>
			<label for="<?php echo $this->get_field_id( 'feedrss' ); ?>"><?php _e('Feed RSS:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'feedrss' ); ?>" name="<?php echo $this->get_field_name( 'feedrss' ); ?>" type="text" value="<?php echo esc_attr( $feedrss ); ?>" />
		</p>
		</p>
			<label for="<?php echo $this->get_field_id( 'mail' ); ?>"><?php _e('Mail:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'mail' ); ?>" name="<?php echo $this->get_field_name( 'mail' ); ?>" type="text" value="<?php echo esc_attr( $feedrss ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		<p>
		<p>
			<label for="<?php echo $this->get_field_id( 'behance' ); ?>"><?php _e('Behance:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'behance' ); ?>" name="<?php echo $this->get_field_name( 'behance' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		<p>
		</p>
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e('Facebook:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>" />
		</p>
		</p>
			<label for="<?php echo $this->get_field_id( 'googleplus' ); ?>"><?php _e('Google +:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'googleplus' ); ?>" name="<?php echo $this->get_field_name( 'googleplus' ); ?>" type="text" value="<?php echo esc_attr( $googleplus ); ?>" />
		</p>
		</p>
			<label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e('Instagram:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" type="text" value="<?php echo esc_attr( $googleplus ); ?>" />
		</p>
		</p>
			<label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php _e('LinkedIn:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" type="text" value="<?php echo esc_attr( $linkedin ); ?>" />
		</p>
		</p>
			<label for="<?php echo $this->get_field_id( 'pinterest' ); ?>"><?php _e('Pinterest:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>" />
		</p>
		</p>
			<label for="<?php echo $this->get_field_id( 'skype' ); ?>"><?php _e('Skype:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'skype' ); ?>" name="<?php echo $this->get_field_name( 'skype' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>" />
		</p>
		</p>
			<label for="<?php echo $this->get_field_id( 'tumblr' ); ?>"><?php _e('Tumblr:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tumblr' ); ?>" name="<?php echo $this->get_field_name( 'tumblr' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>" />
		</p>
		</p>
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e('Twitter:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>" />
		</p>
		</p>
			<label for="<?php echo $this->get_field_id( 'vimeo' ); ?>"><?php _e('Vimeo:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'vimeo' ); ?>" name="<?php echo $this->get_field_name( 'vimeo' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>" />
		</p>
		</p>
			<label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e('Youtube:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>" />
		</p>
		<?php
	}
	
}
?>