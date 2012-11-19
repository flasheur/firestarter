<?php
function firestarter_widget_articles_les_plus_lus_init() {
	register_widget('firestarter_widget_articles_les_plus_lus');
}
add_action('widgets_init', 'firestarter_widget_articles_les_plus_lus_init');

class firestarter_widget_articles_les_plus_lus extends WP_Widget {
	
	var $default_title = '';
	
	
	/****************************************************
	*
	*	CONSTRUCTOR
	*
	****************************************************/
	public function __construct()
	{
		$this->default_title = __('Articles les plus lus', 'firestarter');
	
		parent::__construct(
			'firestarter_widget_articles_les_plus_lus', // Base ID
			__('FREDI: Articles les plus lus', 'firestarter'), // Name
			array( 'description' => __('Afficher les articles les plus lus', 'firestarter' ))
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

		global $post;
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo $before_widget;
		
		if ( !empty($title) ) {
			echo '<i class="widget-icon"></i>'.$before_title . $title . $after_title;
		}
					
		$args = array( 	
			'post_type' => 'post', 'revision', 'attachment', 
			'posts_per_page' => $instance['count'],
			'orderby' => 'meta_value_num'
		);
		
		$query = new WP_Query($args);

		echo '<ul>';
				
			while ($query->have_posts()) : $query->the_post();
				?>
					
					<li>
						<i class="widget-icon-dot"></i>
						<?php the_title(); ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" ><span>[...]</span></a>
					</li>
				
				<?php
			endwhile;
		
			wp_reset_query();

		echo '</ul>';	
		
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