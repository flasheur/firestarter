<?php
function firestarter_widget_latest_activity_init() {
	register_widget('firestarter_widget_latest_activity');
}
add_action('widgets_init', 'firestarter_widget_latest_activity_init');

class firestarter_widget_latest_activity extends WP_Widget {
	
	var $default_title = '';
	var $default_thumb = '/images/default-post-thumbnail.jpg';
	
	
	/**********************************************
	*
	*	CONSTRUCTOR
	*
	**********************************************/
	public function __construct()
	{
		$this->default_title = __('Latest activity', 'firestarter');
	
		parent::__construct(
			'firestarter_widget_latest_activity', // Base ID
			__('WnG: latest activity', 'firestarter'), // Name
			array( 
				'description' => __('Display your latest activity (posts and comments) with thumbnail', 'firestarter' ),
				'classname' => 'firestarter_widget_latest_activity'
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
		
		global $post;
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo $before_widget;
		
		if ( !empty($title) ) {
			echo $before_title . $title . $after_title;
		}
		
		?>
		<div class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#posts-list" data-toggle="tab">Posts</a></li>
			<li><a href="#comments-list" data-toggle="tab">Comments</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active fade in" id="posts-list">
			<?php
			$post_query_args = array(
				'post_type' => 'post',
				'posts_per_page' => $instance['count'],
				'order' => 'DESC',
				'ignore_sticky_posts' => true
			);
			
			$post_query = new WP_Query($post_query_args);
			
			if ($post_query->have_posts()):
			
			echo '<ul class="list">';
			
			while( $post_query->have_posts()) : $post_query->the_post();
				
				echo '<li>';
				
					if ( has_post_thumbnail() ) {
						$image = get_the_post_thumbnail( $post->ID, array(50, 50) );
					} else {
						$image = '<img src="' . get_template_directory_uri() . $this->default_thumb . '" width="50" height="50" />';
					}
					
					echo '<div class="thumbnail"><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . $image . '</a></div>';
					echo '<h4 class="title"><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h4>';
					echo '<div class="clear"></div>';
				echo '</li>';
				
			endwhile;
			
			echo '</ul>';
			
			endif;
			
			wp_reset_postdata();
			?>
			</div>
			<div class="tab-pane fade in" id="comments-list">
			<?php
			$comments = get_comments( array(
				'number' => $instance['count'],
				'status' => 'approve'
			) );
			
			if ( $comments ) {
				
				echo '<ul class="list">';	
				
				foreach ( (array) $comments as $comment ) {
				
					echo '<li>';
					
					$comment_content = substr( $comment->comment_content, 0, 50 ) . '...';
					$default_image_url = get_template_directory_uri() . $this->default_thumb;
					
					$image = get_avatar( $comment->comment_author_email, 50, $default_image_url);
					$image = str_replace( 'class="thumbnail"', "class='", $image);
					
					echo '<div class="thumbnail"><a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '" title="' . get_the_title() . '">' . $image . '</a></div>';
				
					echo '<span class="title">' . get_comment_author_link($comment->comment_ID) . ' on <a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '">' . get_the_title($comment->comment_post_ID) . '</a>' . '</span>';
					
					echo '<span>' . $comment_content . '</span>';
					
					echo '<div class="clear"></div>';
					
					echo '</li>';
				}
				
				echo '</ul>';
				
			}
			?>
			</div>
		</div>
		</div>
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
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number of posts:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
		</p>
		<?php
	}
	
}
?>