<?php
function firestarter_widget_actualite_init() {
	register_widget('firestarter_widget_actualite');
}
add_action('widgets_init', 'firestarter_widget_actualite_init');

class firestarter_widget_actualite extends WP_Widget {
	
	var $default_title = '';
	var $default_thumb = '/images/default-post-thumbnail.jpg';
	
	/**********************************************
	*
	*	CONSTRUCTOR
	*
	**********************************************/
	public function __construct()
	{
		$this->default_title = __('Actualités', 'firestarter');
	
		parent::__construct(
			'firestarter_widget_actualite', // Base ID
			__('FREDI: Actualités', 'firestarter'), // Name
			array( 
				'description' => __('Affiche les derniers posts', 'firestarter' ),
				'classname' => 'firestarter_widget_actualite'
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
		global $utils;
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo $before_widget;
		
		if ( !empty($title) ) {
			echo '<i class="widget-icon"></i>'.$before_title . $title . $after_title;
		}
		
		$post_query_args = array(
			'post_type' => 'post',
			'posts_per_page' => $instance['count'],
			'order' => 'DESC',
			'ignore_sticky_posts' => true
		);
		
		$post_query = new WP_Query($post_query_args);
		
		echo '<ul class="unstyled">';
		
			while( $post_query->have_posts()) : $post_query->the_post();		
			?>		
				
				<li>
					<i class="widget-icon-dot"></i>
					<?php the_title(); ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" ><span>[...]</span></a>
				</li>
			<?php		
			endwhile;
			
			wp_reset_postdata();

		echo '</ul>';
		?>
		<a href="<?php echo $utils->firestarter_get_page_link_by_title( 'actualites' ); ?>" class="btn btn-success floatRight"><?php _e("Voir plus d'actualités", 'firestarter'); ?><i class="chevron"></i></a>
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
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number of posts:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
		</p>
		<?php
	}
	
}
?>