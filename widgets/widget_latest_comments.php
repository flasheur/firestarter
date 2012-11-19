<?php
function firestarter_widget_latest_comments_init() {
	register_widget('firestarter_widget_latest_comments');
}
add_action('widgets_init', 'firestarter_widget_latest_comments_init');

class firestarter_widget_latest_comments extends WP_Widget {
	
	var $default_title = '';
	var $default_thumb = '/images/default-post-thumbnail.jpg';
	
	/**********************************************
	*
	*	CONSTRUCTOR
	*
	**********************************************/
	public function __construct()
	{
		$this->default_title = __('Latest comments', 'firestarter');
	
		parent::__construct(
			'firestarter_widget_latest_comments', // Base ID
			__('WnG: latest comments', 'firestarter'), // Name
			array( 
				'description' => __('Display your latest comments with thumbnail', 'firestarter' ),
				'classname' => 'firestarter_widget_latest_comments'
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
		global $comments, $comment;
	
		extract($args);
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo $before_widget;
		
		if ( !empty($title) ) {
			echo $before_title . $title . $after_title;
		}
				
		$comments = get_comments( array(
			'number' => $instance['count'],
			'status' => 'approve',
			'post_status' => 'publish'
		) );
		
		if ( $comments ) {
			
			echo '<ul class="list">';	
			
			foreach ( (array) $comments as $comment ) {
				
				echo '<li>';
				
				$comment_content = substr( $comment->comment_content, 0, 50 ) . '...';
				
				$image = get_avatar( $comment->comment_author_email, 50, get_template_directory_uri() . $this->default_thumb);
				$image = str_replace( 'class="thumbnail"', "class='", $image);
				
				echo '<div class="thumbnail"><a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '" title="' . get_the_title() . '">' . $image . '</a></div>';
			
				echo '<span class="title">' . get_comment_author_link($comment->comment_ID) . ' on <a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '">' . get_the_title($comment->comment_post_ID) . '</a>' . '</span>';
				
				echo '<span>' . $comment_content . '</span>';
				
				echo '<div class="clear"></div>';
				
				echo '</li>';
			}
			
			echo '</ul>';
			
		}
		
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
		$instance['count'] = absint( $new_instance['count'] );
		
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
			'count' => 5
		);
	
		$instance = wp_parse_args( $instance, $defaults );
		
		extract( $instance );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number of comments:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
		</p>
		<?php
	}
	
}
?>