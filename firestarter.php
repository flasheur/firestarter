<?php
class firestarter {
	
	// Constructor
	public function __construct()
	{
		
	}
	
	/****************************************************
	*
	*	FIRESTARTER OPTIONS
	*
	****************************************************/
	public function global_options() {
		global $data;
		return $data;
	}
	
	public function option( $option_id ) {
		$options = array();
		$options = $this->global_options();
		echo $options[$option_id];
	}
	
	public function get_option( $option_id ) {
		$options = array();
		$options = $this->global_options();
		return $options[$option_id];
	}
	
	/****************************************************
	*
	*	HEADER
	*
	****************************************************/
	public function custom_header_style() {
		if ( get_header_image() ) {
		?>
		<style type="text/css">
			/* See functions.php */
			#branding-content {
				background: url(<?php header_image(); ?>), no-repeat !important;
			}
		</style>
		<?php
		}
	}
	
	public function custom_header_admin_style() {
		?>
		<style type="text/css">
			/* See functions.php */
		</style>
		<?php
	}
	
	/****************************************************
	*
	*	GET PAGE LINK BY ITS TITLE
	*
	****************************************************/
	public function get_page_link_by_title( $page_title )
	{
		$page = get_page_by_title( $page_title );
		if ( $page->ID ) {
			return get_page_link( $page->ID );
		} else {
			
			$page = get_page_by_path( $page_title );
			
			if ( $page->ID ) {
				return get_page_link( $page->ID );
			} else {
				return '#';
			}
		}
	}
	
	/****************************************************
	*
	*	GET POST META
	*
	****************************************************/
	public function get_post_meta($post_id, $meta_id)
	{
		$meta = get_post_meta($post_id, $meta_id);
	
		if ($meta) {
			return $meta;
		} else {
			return false;
		}
	}
	
	/****************************************************
	*
	*	UPDATE POST META
	*
	****************************************************/
	public function update_post_meta($post_id, $meta_id, $value)
	{
		$meta = update_post_meta($post_id, $meta_id, $value);
	
		if ($meta) {
			return true;
		} else {
			return false;
		}
	}
	
	/****************************************************
	*
	*	POST TITLE
	*	Handle the alternative title option
	*
	****************************************************/
	public function title()
	{
		$title = '';
		if ( !is_single() ) {
			$title = '<a href="'.get_permalink().'">' . get_the_title() . '</a>';
		} else {
			$title = get_the_title();
		}
		
		return apply_filters( 'firestarter_title', $title );
	}
	
	/****************************************************
	*
	*	POST SUB TITLE
	*	Handle the alternative title option
	*
	****************************************************/
	public function sub_title()
	{
		$sub_title = $this->get_post_meta(get_the_ID(), 'fire_sub_title');
		$sub_title = $sub_title[0];
		
		if ($sub_title) {
			return apply_filters('firestarter_sub_title', $sub_title);
		}
	}
	
	/****************************************************
	*
	*	PAGE HEADER
	*
	****************************************************/
	public function page_header( $slider = true ) {
		
		if ($slider) {
			$this->get_post_slider('blog-feature');
		}
		
		$hide_title = $this->get_post_meta(get_the_ID(), 'fire_hide_title');
		$hide_title = $hide_title[0];
		
		$header_class = 'page-header';
		if (get_post_type() == 'post') {
			$header_class = 'post-header';
		}
		
		$title_tag = 'h1';
		$sub_title_tag = 'h2';
		
		if (!is_single()) {
			$title_tag = 'h2';
			$sub_title_tag = 'h3';
		}
		
		if ($hide_title != 'true') :
		?>
		<header class="<?php echo $header_class; ?>">
			<<?php echo $title_tag; ?> class="entry-title">
				<?php echo $this->title(); ?>
			</<?php echo $title_tag; ?>>
			<?php echo $this->sub_title(); ?>
		</header><!-- .entry-header -->
		<?php endif; 
	}
		
	/****************************************************
	*
	*	POST THUMBNAIL HANDLER
	*
	****************************************************/
	public function post_thumbnail( $size = 'blog_feature', $classes = '' ) {
		if(has_post_thumbnail()):
		?>
			<div class="entry-thumbnail <?php echo $classes; ?>">
				<?php
				$thumb_attr = array(
					'alt' => trim(strip_tags( get_the_title() )),
					'title' => trim(strip_tags( get_the_title() ))
				);
				?>
				<?php if ( !is_single() ) : ?>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( $size, $thumb_attr ); ?></a>
				<?php else : ?>
				<?php the_post_thumbnail( $size, $thumb_attr ); ?>
				<?php endif; ?>
			</div>
		<?php
		else:
			// if the option is enabled
			if ($this->get_option('fire_post_sliders_enabled')) {
				$this->get_post_slider('blog-feature');
			}
		endif;
	}
	
	/****************************************************
	*
	*	POST HEADER META
	*
	****************************************************/
	public function post_meta( $options = array('date', 'separator', 'author', 'separator', 'comment'), $color_variant = 'black' ) {
		
		if ($color_variant == 'white') { $icon_class = ' icon-white'; }
		
		$metas = array(
			'date' 			=> '<i class="icon-time'.$icon_class.'"></i><time datetime="' . get_the_date('Y-d-m') . '" class="entry-date">' . get_the_date( get_option('date-format') ) . '</time>',
			'author' 		=> '<i class="icon-user'.$icon_class.'"></i><span class="entry-author"><a href="' . get_author_posts_url(get_the_author_meta( 'ID' )) .'" title="' . get_the_author() . '">' . get_the_author() . '</a></span>',
			'comment' 		=> '<i class="icon-comment'.$icon_class.'"></i><span><a href="'.get_comments_link().'">' . get_comments_number( _x( '0 commentaire', 'firestarter' ), _x( '1 commentaire', 'comments number', 'firestarter' ), _x( '% commentaires', 'comments number', 'firestarter' ) ) . '</a></span>',
			'category' 		=> '<i class="icon-folder-close'.$icon_class.'"></i><span class="cat-links">' . get_the_category_list( __( ', ', 'firestarter' ) ) . '</span>',
			'tag' 			=> '<i class="icon-tag'.$icon_class.'"></i><span class="tag-links">' . get_the_tag_list( '', __( ', ', 'firestarter' ) ) . '</span>',
			'reply' 		=> '<i class="icon-repeat"></i><span><a href="#respond">' . __('Répondre', 'firestarter') . '</a></span>',
			'share' 		=> '<i class="icon-share"></i><span><a data-target="#single-modal" data-toggle="modal">' . __('Share', 'firestarter') . '</a></span>',
			'separator' 	=> '<span class="separator"> / </span>'
		);
		
		$prev_item_is_empty = false;
		
		foreach ($options as $item) :		
			
			if ( $item == 'tag' ) {
				if ( get_the_tag_list() ) {
					echo $metas[$item] . "\n";
				} else {
					$prev_item_is_empty = true;
				}
			} elseif ( $item == 'separator' ) {
				if ( $prev_item_is_empty != true ) {
					echo $metas[$item] . "\n";
				}
			} else {
				echo $metas[$item] . "\n";
				$prev_item_is_empty = false;
			}
		
		endforeach;
	}
	
	/****************************************************
	*
	*	EXCERPT
	*
	****************************************************/
	public function short_excerpt( $length = 20, $show_more_link = true )
	{
		// get the excerpt
		$original_excerpt = get_the_excerpt();
		// count the words
		$words = str_word_count( $original_excerpt, 1 );
		// if there are words slice them, otherwise take the original excerpt
		if ( count($words) ) {
			$words = array_slice($words, 0, $length);
			$new_excerpt = implode(" ", $words);
		} else {
			$new_excerpt = $original_excerpt;
		}
		if ( $show_more_link ) {
			$new_excerpt .= $this->excerpt_more('');
		} else {
			$new_excerpt .= '...';
		}
		return $new_excerpt;
	}
	
	/****************************************************
	*
	*	DEFINE EXCERPT LENGTH
	*
	****************************************************/
	public function excerpt_length( $length ) {
		return 50;
	}
	
	/****************************************************
	*
	*	CUSTOMIZE THE 'READ MORE' OUTPUT
	*
	****************************************************/
	public function excerpt_more( $more ) {
		global $post;
		return ' <a href="'.get_permalink().'" class="excerpt-more"><strong>' . __('[...]', 'firestarter') . '</strong></a>';
	}	
		
	/****************************************************
	*
	*	RETURN IMAGES ATTACHED TO A POST WITHIN A SLIDER
	*
	****************************************************/
	public function get_post_slider($image_size = 'medium', $classes = '') {
		
		$image1 = $this->get_post_meta('fire_slider_image_1_id', get_the_ID());
		$image1 = $image1[0];
		$image1_link = $this->get_post_meta('fire_slider_image_1_link', get_the_ID());
		$image1_link = $image1_link[0];
		
		$image2 = $this->get_post_meta('fire_slider_image_2_id', get_the_ID());
		$image2 = $image2[0];
		$image2_link = $this->get_post_meta('fire_slider_image_2_link', get_the_ID());
		$image2_link = $image2_link[0];
		
		$image3 = $this->get_post_meta('fire_slider_image_3_id', get_the_ID());
		$image3 = $image3[0];
		$image3_link = $this->get_post_meta('fire_slider_image_3_link', get_the_ID());
		$image3_link = $image3_link[0];
		
		$image4 = $this->get_post_meta('fire_slider_image_4_id', get_the_ID());
		$image4 = $image4[0];
		$image4_link = $this->get_post_meta('fire_slider_image_4_link', get_the_ID());
		$image4_link = $image4_link[0];
		
		$image5 = $this->get_post_meta('fire_slider_image_5_id', get_the_ID());
		$image5 = $image5[0];
		$image5_link = $this->get_post_meta('fire_slider_image_5_link', get_the_ID());
		$image5_link = $image5_link[0];
		
		$attachments = array();
		if ($image1) {$attachments[] = $image1;}
		if ($image2) {$attachments[] = $image2;}
		if ($image3) {$attachments[] = $image3;}
		if ($image4) {$attachments[] = $image4;}
		if ($image5) {$attachments[] = $image5;}
		
		$attachments_link = array();
		if ($image1 && $image1_link) {$attachments_link[] = $image1_link;}
		if ($image2 && $image2_link) {$attachments_link[] = $image2_link;}
		if ($image3 && $image3_link) {$attachments_link[] = $image3_link;}
		if ($image4 && $image4_link) {$attachments_link[] = $image4_link;}
		if ($image5 && $image5_link) {$attachments_link[] = $image5_link;}
		
		$post_id = get_the_ID();
		
		if (count($attachments) > 0) {
			
			$slider_classes = 'carousel slide';
			if ($classes) {
				$slider_classes .= ' ' . $classes;
			}
			
			echo '<div id="single-carousel-'.$post_id.'" class="' . $slider_classes . '">';
				echo '<div class="carousel-inner">';
				$active = 'active ';
				for ($i = 0; $i < count($attachments); $i++) {
					if ($attachments[$i]) {
						echo '<div class="'.$active.'item">';
							if (!is_singular()) {echo '<a href="'.get_permalink().'">';}
							if ($attachments_link[$i]) {echo '<a href="'.$attachments_link[$i].'">';}
								echo wp_get_attachment_image($attachments[$i], $image_size, false, false);
							if ($attachments_link[$i]) {echo '</a>';}
							if (!is_singular()) {echo '</a>';}
						echo '</div>';
						$active = '';
					}
				}
				echo '</div>';
				echo '<a class="carousel-control left" href="#single-carousel-'.$post_id.'" data-slide="prev">&lsaquo;</a>';
		 		echo '<a class="carousel-control right" href="#single-carousel-'.$post_id.'" data-slide="next">&rsaquo;</a>';
			echo '</div>';
		}
	}
	
	/****************************************************
	*
	*	BREADCRUMB
	*
	****************************************************/
	public function breadcrumb() {
	 
		$delimiter = '<span class="divider">&gt;</span>';
		$home = 'Home'; // text for the 'Home' link
		$before = '<span class="current">'; // tag before the current crumb
		$after = '</span>'; // tag after the current crumb
		
		if ( function_exists('yoast_breadcrumb') ) {
			yoast_breadcrumb( '<div class="breadcrumb">', '</div>' );
		}
		else {
		
			echo '<div class="breadcrumb">';
			
			global $post;
			$homeLink = get_bloginfo('url');
			echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
			
			if ( is_category() ) {
			  global $wp_query;
			  $cat_obj = $wp_query->get_queried_object();
			  $thisCat = $cat_obj->term_id;
			  $thisCat = get_category($thisCat);
			  $parentCat = get_category($thisCat->parent);
			  if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
			  echo $before . single_cat_title('', false) . $after;
			
			} elseif ( is_day() ) {
			  echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			  echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
			  echo $before . get_the_time('d') . $after;
			
			} elseif ( is_month() ) {
			  echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			  echo $before . get_the_time('F') . $after;
			
			} elseif ( is_year() ) {
			  echo $before . get_the_time('Y') . $after;
			
			} elseif ( is_single() && !is_attachment() ) {
				
				if ( get_post_type() == 'product' ) {
						if ($terms = get_the_terms( $post->ID, 'product_cat' )) :
						$term = current($terms);
						$parents = array();
						$parent = $term->parent;
						while ($parent):
							$parents[] = $parent;
							$new_parent = get_term_by( 'id', $parent, 'product_cat');
							$parent = $new_parent->parent;
						endwhile;
						if(!empty($parents)):
							$parents = array_reverse($parents);
							foreach ($parents as $parent):
								$item = get_term_by( 'id', $parent, 'product_cat');
								echo $before . '<a href="' . get_term_link( $item->slug, 'product_cat' ) . '">' . $item->name . '</a>' . $after . $delimiter;
							endforeach;
						endif;
						echo $before . '<a href="' . get_term_link( $term->slug, 'product_cat' ) . '">' . $term->name . '</a>' . $after . $delimiter;
					endif;
			
					echo $before . get_the_title() . $after;
				} elseif ( get_post_type() != 'post' ) {
			        $post_type = get_post_type_object(get_post_type());
			        $slug = $post_type->rewrite;
			        echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
			        //echo $before . get_the_title() . $after;
			        echo $before . $this->title() . $after;
				} else {
			        $cat = get_the_category(); $cat = $cat[0];
			        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
			        //echo $before . get_the_title() . $after;
			        echo $before . $this->title() . $after;
				}
			
			} elseif ( is_search() ) {
			  echo $before . 'Recherche : "' . get_search_query() . '"' . $after;
			
			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			  $post_type = get_post_type_object(get_post_type());
			  echo $before . $post_type->labels->singular_name . $after;
			
			} elseif ( is_attachment() ) {
			  $parent = get_post($post->post_parent);
			  $cat = get_the_category($parent->ID); $cat = $cat[0];
			  echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
			  echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
			  //echo $before . get_the_title() . $after;
			  echo $before . $this->title() . $after;
				
				} elseif ( is_page() && !$post->post_parent ) {
			  //echo $before . get_the_title() . $after;
			  echo $before . $this->title() . $after;
			
			} elseif ( is_page() && $post->post_parent ) {
			  $parent_id  = $post->post_parent;
			  $breadcrumbs = array();
			  while ($parent_id) {
			    $page = get_page($parent_id);
			    $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
			    $parent_id  = $page->post_parent;
			  }
			  $breadcrumbs = array_reverse($breadcrumbs);
			  foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
			  //echo $before . get_the_title() . $after;
			  echo $before . $this->title() . $after;
			
			} elseif ( is_tag() ) {
			  echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
			
			} elseif ( is_author() ) {
			   global $author;
			  $userdata = get_userdata($author);
			  echo $before . 'Articles de ' . $userdata->display_name . $after;
			
			} elseif ( is_404() ) {
			  echo $before . 'Erreur 404' . $after;
			}
			
			if ( get_query_var('paged') ) {
			  if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			  echo __('Page') . ' ' . get_query_var('paged');
			  if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
			  
			  echo ' (' . __('Page') . ' ' . get_query_var('paged') . ')';
			}
			
			echo '</div>';
		}
	}
	
	/****************************************************
	*
	*	RELATED POSTS
	*
	****************************************************/
	public function related_posts() {
		
		$categories = get_the_category();
		
		$current_cat = array();
		
		foreach ($categories as $category) {
			array_push($current_cat, $category->cat_ID);
		}
				
		$related_posts_args = array(
			'post_type' => array('post'),
			'category__in' => $current_cat,
			'posts_per_page' => 5,
			'post__not_in' => array(get_the_ID())
		);
		
		$related_posts_query = new WP_Query($related_posts_args);
		
		if ( !$related_posts_query->have_posts() ) {
				
			$related_posts_args = array(
				'post_type' => array('post'),
				'posts_per_page' => 5,
				'post__not_in' => array(get_the_ID())
			);
			
			$related_posts_query = new WP_Query($related_posts_args);
		}
		
		echo '<div class="related-posts">';
		
		printf('<h3 class="related-posts-title">%s</h3>', __('Related posts', 'firestarter'));
		
		if ( $related_posts_query->have_posts() ) :
		
		while ($related_posts_query->have_posts()) : $related_posts_query->the_post();
			
			?>
			<aside id="related-post-<?php the_ID(); ?>" <?php post_class(array('related-post', 'row')); ?>>
				<div class="post-thumbnail span1">
					<a href="<?php the_permalink(); ?>" target="_self" title="<?php the_title_attribute(); ?>">
					<?php if(has_post_thumbnail()): ?>
						<?php the_post_thumbnail( array(50, 50), array('alt' => the_title_attribute('echo=0'), 'title' => the_title_attribute('echo=0'), 'class' => 'thumbnail')); ?>
					<?php else: ?>	
						<img src="<?php echo get_template_directory_uri(); ?>/images/default-post-thumbnail.jpg" alt="post_thumb_default" width="50" height="50" class="thumbnail" />
					<?php endif; ?>
					</a>
				</div>
				<hgroup class="post-info span6">
					<h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
			
					<div class="entry-excerpt">
						<?php echo $this->short_excerpt(); ?>
					</div><!-- .entry-meta -->
				</hgroup>
			</aside><!-- #aside-<?php the_ID(); ?> -->
			<?php
		endwhile;
		
		else :
			
			_e('No related posts.', 'firestarter');
		
		endif;
		
		wp_reset_postdata();
		
		echo '</div>';
	}
	
	/****************************************************
	*
	*	OVERRIDE DEFAULT AVATAR CSS CLASS
	*
	****************************************************/
	public function custom_avatar_class( $class ) {
		$class = str_replace("class='avatar", 'class="thumbnail" ', $class) ;
		return $class;
	}

	/****************************************************
	*
	*	OVERRIDE THE GALLERY SHORTCODE
	*
	****************************************************/
	public function custom_gallery_shortcode($null, $attr = array()) {
		global $post;
	
		static $instance = 0;
		$instance++;
	
		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( !$attr['orderby'] )
				unset( $attr['orderby'] );
		}
	
		extract(shortcode_atts(array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post->ID,
			'itemtag'    => 'dl',
			'icontag'    => 'dt',
			'captiontag' => 'dd',
			'columns'    => 3,
			'size'       => 'thumbnail',
			'include'    => '',
			'exclude'    => ''
		), $attr));
		
		$id = intval($id);
		if ( 'RAND' == $order )
			$orderby = 'none';
	
		if ( !empty($include) ) {
			$include = preg_replace( '/[^0-9,]+/', '', $include );
			$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	
			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( !empty($exclude) ) {
			$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
			$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		} else {
			$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		}
	
		if ( empty($attachments) )
			return '';
	
		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment )
				$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
			return $output;
		}
	
		$itemtag = tag_escape($itemtag);
		$captiontag = tag_escape($captiontag);
		$columns = intval($columns);
		$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
		$float = is_rtl() ? 'right' : 'left';
	
		$selector = "gallery-{$instance}";
	
		$gallery_style = $gallery_div = '';
		if ( apply_filters( 'use_default_gallery_style', true ) )
			$gallery_style = "
			<style type='text/css'>
				#{$selector} {
					margin: auto;
				}
				#{$selector} .gallery-item {
					float: {$float};
					text-align: center;
					width: {$itemwidth}%;
				}
				#{$selector} .gallery-caption {
					margin-left: 0;
				}
			</style>
			<!-- see gallery_shortcode() in wp-includes/media.php -->";
		$size_class = sanitize_html_class( $size );
		$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class} thumbnails'>";
		$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
	
		$i = 0;
		foreach ( $attachments as $id => $attachment ) {
			$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
			
			$imageSrc = wp_get_attachment_image_src($id, $size);
			$image = '<a href="'.wp_get_attachment_url($id).'" class="lightbox" rel="group" title="' . $attachment->post_title . '"><img src="' . $imageSrc[0] . '" width="' . $imageSrc[1] . '" height="' . $imageSrc[2] . '" class="thumbnail" /></a>';
	
			$output .= "<{$itemtag} class='gallery-item'>";
			$output .= "
				<{$icontag} class='gallery-icon'>
					$image
				</{$icontag}>";
			if ( $captiontag && trim($attachment->post_excerpt) ) {
				$output .= "
					<{$captiontag} class='wp-caption-text gallery-caption'>
					" . wptexturize($attachment->post_excerpt) . "
					</{$captiontag}>";
			}
			$output .= "</{$itemtag}>";
			if ( $columns > 0 && ++$i % $columns == 0 )
				$output .= '<br style="clear: both" />';
		}
	
		$output .= "
				<br style='clear: both;' />
			</div>\n";
	
		return $output;
	}
	
	/****************************************************
	*
	*	ADD A CUSTOM REL ATTRIBUTE TO POST IMG
	*
	****************************************************/
	public function lightbox_rel($content) {
		global $post;
		$pattern ="/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
		$replacement = '<a$1href=$2$3.$4$5 class="lightbox" title="'.$post->post_title.'"$6>';
		$content = preg_replace($pattern, $replacement, $content);
		return $content;
	}
	
	/****************************************************
	*
	*	OVERRIDE COMMENT LIST
	*
	****************************************************/
	public function comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'firestarter' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'firestarter' ), '<span class="edit-link">', '</span>' ); ?></p>
		<?php
				break;
			default :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment-entry">
				<header class="comment-meta">
					<div class="comment-author vcard">
						<div class="avatar">
						<?php
							$avatar_size = 68;
							if ( '0' != $comment->comment_parent )
								$avatar_size = 39;
	
							echo get_avatar( $comment, $avatar_size );
							?>
						</div>
					</div><!-- .comment-author .vcard -->
	
					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'firestarter' ); ?></em>
						<br />
					<?php endif; ?>
	
				</header>
				<div class="author">	
					<?php
					/* translators: 1: comment author, 2: date and time */
					printf( __( '%1$s on %2$s', 'firestarter' ),
						sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
						sprintf( '<time pubdate datetime="%1$s">%2$s</time>',
							get_comment_time( 'c' ),
							/* translators: 1: date, 2: time */
							sprintf( __( '%1$s', 'firestarter' ), get_comment_date() )
						)
					);
				?>
				</div>
				<div class="comment-content"><?php comment_text(); ?></div>
				<div class="reply">
					<span class="label"><?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'firestarter' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
				</div><!-- .reply -->
	
			</article><!-- #comment-## -->
	
		<?php
				break;
		endswitch;
	}
	
	/****************************************************
	*
	*	DEFAULT NAVIGATION
	*
	****************************************************/
	public function navigation() {
		global $wp_query;
		
		if ( function_exists('wp_pagenavi' )) {
			wp_pagenavi();
		} else {
		
			if ( $wp_query->max_num_pages > 1 ) : ?>
				<nav class="pager">
					<h3 class="assistive-text"><?php _e( 'Post navigation', 'firestarter' ); ?></h3>
					<div class="previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'firestarter' ) ); ?></div>
					<div class="next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'firestarter' ) ); ?></div>
				</nav><!-- #nav-above -->
			<?php endif;
		}
	}
	
	/****************************************************
	*
	*	CUSTOMIZE TINYMCE STYLE DROPDOWN LIST
	*
	****************************************************/
	public function tinymce_buttons($buttons)
	{
		array_unshift($buttons, 'styleselect');
		return $buttons;
	}
	public function tinymce_before_init( $settings )
	{
		$settings['theme_advanced_blockformats'] = 'h2,h3,h4,h5,h6,p,pre,code';
		// http://www.tinymce.com/wiki.php/Buttons/controls
		$settings['theme_advanced_disable'] = 'justifyfull, indent, outdent, forecolor';
		
		// http://alisothegeek.com/2011/05/tinymce-styles-dropdown-wordpress-visual-editor/
		$style_formats = array(
			array(
				'title' 	=> 	'Bouton',
				'selector' 	=> 	'a',
				'classes'	=>	'button'
			),
			array(
				'title'		=>	'Callout box',
				'block'		=>	'div',
				'classes'	=>	'callout',
				'wrapper'	=>	true
			),
			array(
				'title'		=>	'Bold red text',
				'inline'	=>	'span',
				'styles'	=>	array(
									'color' => '#f00',
									'fontWeight' => 'bold'
								)
			)
		);
		
		$settings['style_formats'] = json_encode( $style_formats );
		
		return $settings;
	}
	
	/****************************************************
	*
	*	POST COLUMNS
	*
	****************************************************/
	public function posts_columns( $defaults ) {
		$defaults['post_thumb'] = __('Thumbs', 'firestarter');
		$defaults['sticky_post'] = __('Sticky post', 'firestarter');
		return $defaults;
	}
	
	public function posts_custom_columns( $column_name, $post_id ) {
	
		switch ($column_name) {
			
			case 'post_thumb':
				the_post_thumbnail( array(50, 50) );
				break;
			case 'sticky_post';
				echo is_sticky($post_id) ? '<img src="'.URI.'/res/images/favorite.png" />' : '';
				break;				
		}
	}
	
	/****************************************************
	*
	*	WORDPRESS LOGIN LOGO
	*
	****************************************************/
	public function login_logo()
	{
		?>
		<style type="text/css">
			h1 a {
				background-image: url(<?php $this->option('fire_upload_admin_logo') ?>) !important;
			}
			.login form {
				background: #22509A;
			}
			.login label {
				color: #fff;
				font-weight: bold;
			}
			.login .button-primary {
				background: #5A87C0;
				border-color: #ccc;
				border-radius: 0;
			}
			
		</style>
		<?php
	}
	
	/****************************************************
	*
	*	WORDPRESS LOGIN LOGO URL
	*
	****************************************************/
	public function login_logo_url( $url )
	{
		return get_bloginfo('url');
	}
	
	/****************************************************
	*
	*	JIGOSHOP SINGLE PRODUCT DESCRIPTION TABS
	*
	****************************************************/
	public function jigoshop_output_product_data_tabs() {

		if (isset($_COOKIE["current_tab"])) $current_tab = $_COOKIE["current_tab"]; else $current_tab = '#tab-description';
		?>
		<div class="tabbable" id="product-tabs">
			<ul class="nav nav-tabs">
	
				<?php do_action('jigoshop_product_tabs', $current_tab); ?>
	
			</ul>
			<div class="tab-content">
			<?php do_action('jigoshop_product_tab_panels'); ?>
			</div>
		</div>
	<?php
	}
	
	/****************************************************
	*
	*	JIGOSHOP SINGLE PRODUCT TABS
	*
	****************************************************/
	function jigoshop_product_description_tab( $current_tab ) {
		global $post;
		if( ! $post->post_content )
			return false;
		?>
		<li <?php if ($current_tab=='#tab-description') echo 'class="active"'; ?>><a href="#tab-description" data-toggle="tab"><?php _e('Description', 'jigoshop'); ?></a></li>
		<?php
	}
	function jigoshop_product_attributes_tab( $current_tab ) {

		global $_product;
		if( ( $_product->has_attributes() || $_product->has_dimensions() || $_product->has_weight() ) ):
		?>
		<li <?php if ($current_tab=='#tab-attributes') echo 'class="active"'; ?>><a href="#tab-attributes" data-toggle="tab"><?php _e('Additional Information', 'jigoshop'); ?></a></li><?php endif;

	}
	function jigoshop_product_reviews_tab( $current_tab ) {

		if ( comments_open() ) : ?><li <?php if ($current_tab=='#tab-reviews') echo 'class="active"'; ?>><a href="#tab-reviews" data-toggle="tab"><?php _e('Reviews', 'jigoshop'); ?><?php echo comments_number(' (0)', ' (1)', ' (%)'); ?></a></li><?php endif;

	}
	function jigoshop_product_customize_tab( $current_tab ) {

		global $_product;

		if ( get_post_meta( $_product->ID , 'customizable', true ) == 'yes' ) {
			?>
			<li <?php if ($current_tab=='#tab-customize') echo 'class="active"'; ?>><a href="#tab-customize" data-toggle="tab"><?php _e('Personalize', 'jigoshop'); ?></a></li>
			<?php

		}
	}
	
	/****************************************************
	*
	*	JIGOSHOP PAGE TAB PANELS
	*
	****************************************************/
	public function jigoshop_product_description_panel() {
		echo '<div class="tab-pane fade in active" id="tab-description">';
		echo '<h2>' . apply_filters('jigoshop_product_description_heading', __('Product Description', 'jigoshop')) . '</h2>';
		the_content();
		echo '</div>';
	}
	public function jigoshop_product_attributes_panel() {
		global $_product;
		echo '<div class="tab-pane fade in" id="tab-attributes">';
		echo '<h2>' . apply_filters('jigoshop_product_attributes_heading', __('Additional Information', 'jigoshop')) . '</h2>';
		echo $_product->list_attributes();
		echo '</div>';
	}
	public function jigoshop_product_reviews_panel() {
		echo '<div class="tab-pane fade in" id="tab-reviews">';
		comments_template();
		echo '</div>';
	}
	public function jigoshop_product_customize_panel() {
		global $_product;

		if ( isset( $_POST['Submit'] ) && $_POST['Submit'] == 'Save Personalization' ) {
			$custom_products = (array) jigoshop_session::instance()->customized_products;
			$custom_products[$_POST['customized_id']] = trim( wptexturize( $_POST['jigoshop_customized_product'] ));
			jigoshop_session::instance()->customized_products = $custom_products;
		}

		if ( get_post_meta( $_product->ID , 'customizable', true ) == 'yes' ) :
			$custom_products = (array) jigoshop_session::instance()->customized_products;
			$custom = isset( $custom_products[$_product->ID] ) ? $custom_products[$_product->ID] : '';
			$custom_length = get_post_meta( $_product->ID , 'customized_length', true );
			$length_str = $custom_length == '' ? '' : sprintf( __( 'You may enter a maximum of %s characters.', 'jigoshop' ), $custom_length );
			
			echo '<div class="tab-pane fade in" id="tab-customize">';
			echo '<p>' . apply_filters('jigoshop_product_customize_heading', __('Enter your personal information as you want it to appear on the product.<br />'.$length_str, 'jigoshop')) . '</p>';

			?>

				<form action="" method="post">

					<input type="hidden" name="customized_id" value="<?php echo esc_attr( $_product->ID ); ?>" />

					<?php
					if ( $custom_length == '' ) :
					?>
						<textarea
							id="jigoshop_customized_product"
							name="jigoshop_customized_product"
							cols="60"
							rows="4"><?php echo esc_textarea( $custom ); ?>
						</textarea>
					<?php else : ?>
						<input 
							type="text"
							id="jigoshop_customized_product"
							name="jigoshop_customized_product"
							size="<?php echo $custom_length; ?>"
							maxlength="<?php echo $custom_length; ?>"
							value="<?php echo esc_attr( $custom ); ?>" />
					<?php endif; ?>
					
					<p class="submit"><input name="Submit" type="submit" class="button-alt add_personalization" value="<?php _e( "Save Personalization", 'jigoshop' ); ?>" /></p>

				</form>

			<?php
			echo '</div>';
		endif;
	}
	
	/****************************************************
	*
	*	JIGOSHOP ADD TO CART BTN
	*
	****************************************************/
	public function jigoshop_simple_add_to_cart() {

		global $_product; $availability = $_product->get_availability();

		// do not show "add to cart" button if product's price isn't announced
		if( $_product->get_price() === '') return;

		?>
		<form action="<?php echo esc_url( $_product->add_to_cart_url() ); ?>" class="cart" method="post">
			<?php do_action('jigoshop_before_add_to_cart_form_button'); ?>
		 	<div class="quantity"><input name="quantity" value="1" size="4" title="Qty" class="input-text qty text" maxlength="12" /></div>
		 	<button type="submit" class="btn btn-primary"><?php _e('Add to cart', 'jigoshop'); ?></button>
		 	<?php do_action('jigoshop_add_to_cart_form'); ?>
		</form>
		<?php
	}
	
	/****************************************************
	*
	*	JIGOSHOP PRODUCT IMAGES
	*
	****************************************************/
	public function jigoshop_show_product_images() {

		global $_product, $post;

		echo '<div class="images">';

		do_action( 'jigoshop_before_single_product_summary_thumbnails', $post, $_product );

		$thumb_id = 0;
		if (has_post_thumbnail()) :
			$thumb_id = get_post_thumbnail_id();
			$large_thumbnail_size = jigoshop_get_image_size( 'shop_large' );
			echo '<a href="'.wp_get_attachment_url($thumb_id).'" class="lightbox thumbnail" rel="thumbnails">';
			the_post_thumbnail($large_thumbnail_size);
			echo '</a>';
		else :
			echo jigoshop_get_image_placeholder( 'shop_large' );
		endif;

		do_action('jigoshop_product_thumbnails');

		echo '</div>';
	}
	
	/****************************************************
	*
	*	JIGOSHOP PRODUCT THUMBNAILS
	*
	****************************************************/
	public function jigoshop_show_product_thumbnails() {

		global $_product, $post;

		echo '<ul class="thumbnails">';

		$thumb_id = get_post_thumbnail_id();
		$small_thumbnail_size = jigoshop_get_image_size( 'shop_thumbnail' );

		$args = array( 'post_type' => 'attachment', 'post_mime_type' => 'image', 'numberposts' => -1, 'post_status' => null, 'post_parent' => $post->ID, 'orderby' => 'id', 'order' => 'asc' );

		$attachments = get_posts($args);
		if ($attachments) :
			$loop = 0;
			$columns = apply_filters( 'single_thumbnail_columns', 3 );
			foreach ( $attachments as $attachment ) :

				if ($thumb_id==$attachment->ID) continue;

				$loop++;

				$_post =  get_post( $attachment->ID );
				$url = wp_get_attachment_url($_post->ID);
				$post_title = esc_attr($_post->post_title);
				$image = wp_get_attachment_image($attachment->ID, $small_thumbnail_size);

				if ( ! $image || $url == get_post_meta($post->ID, 'file_path', true) )
					continue;

				echo '<li class="product-thumb"><a href="'.esc_url($url).'" title="'.esc_attr($post_title).'" rel="thumbnails" class="thumbnail lightbox" class="zoom ';
				if ($loop==1 || ($loop-1)%$columns==0) echo 'first';
				if ($loop%$columns==0) echo 'last';
				echo '">'.$image.'</a></li>';

			endforeach;
		endif;
		wp_reset_query();

		echo '</ul>';
	}
	
	/****************************************************
	*
	*	JIGOSHOP PRODUCT LIST PRICE
	*
	****************************************************/
	public function jigoshop_template_loop_price( $post, $_product ) {
		?><span class="price label label-warning"><?php echo $_product->get_price_html(); ?></span><?php
	}
	
	/****************************************************
	*
	*	JIGOSHOP PRODUCT LIST ADD TO CART BUTTON
	*
	****************************************************/
	public function jigoshop_template_loop_add_to_cart( $post, $_product ) {

		do_action('jigoshop_before_add_to_cart_button');
		
		// do not show "add to cart" button if product's price isn't announced
		if ( $_product->get_price() === '' AND ! ($_product->is_type(array('variable', 'grouped', 'external'))) ) return;

		if ( $_product->is_in_stock() OR $_product->is_type('external') ) :
			if ( $_product->is_type(array('variable', 'grouped')) ) :
				$output = '<a href="'.get_permalink($_product->id).'" class="btn add-to-cart">'.__('Select', 'jigoshop').'</a>';
			elseif ( $_product->is_type('external') ) :
				$output = '<a href="'.get_post_meta( $_product->id, 'external_url', true ).'" class="btn add-to-cart">'.__('Buy product', 'jigoshop').'</a>';
			else :
				$output = '<a href="'.esc_url($_product->add_to_cart_url()).'" class="btn add-to-cart">'.__('Add to cart', 'jigoshop').'</a>';
			endif;
		elseif ( ($_product->is_type(array('grouped')) ) ) :
			return;
		else :
			$output = '<span class="nostock">'.__('Out of Stock', 'jigoshop').'</span>';
		endif;
		echo $output;

		do_action('jigoshop_after_add_to_cart_button');

	}
	
	/****************************************************
	*
	*	WPML + JIGOSHOP OVERRIDE DEFAULT CART & CHECKOUT
	*	LINKS
	*
	****************************************************/
	public function jigoshop_get_cart_url( $default_url ) {
		
		$cart_page = get_page_by_title('Cart');
		
		if (function_exists('icl_object_id')) {
			$cart_url = get_permalink( icl_object_id($cart_page->ID, 'page', true) );
		} else {
			$cart_url = $default_url;
		}
		
		return $cart_url;
	}
	
	public function jigoshop_get_checkout_url( $default_url ) {
		
		$cart_page = get_page_by_title('Checkout');
		
		if (function_exists('icl_object_id')) {
			$cart_url = get_permalink( icl_object_id($cart_page->ID, 'page', true) );
		} else {
			$cart_url = $default_url;
		}
		
		return $cart_url;
	}
	
	/****************************************************
	*
	*	JIGOSHOP SEARCH WIDGET
	*
	****************************************************/
	public function jigoshop_product_search_form( $form ) {
		
		$form = '<form role="search" method="get" id="searchform" class="form-horizontal" action="' . home_url() . '">';
		$form .= '<fieldset>';
			$form .= '<div class="control-group">';
				$form .= '<label class="assistive-text" for="s">' . __('Search for:', 'jigoshop') . '</label>';
				$form .= '<div class="input-append">';
					$form .= '<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __('Search for products', 'jigoshop') . '" />';
					$form .= '<button type="submit" class="submit btn" id="searchsubmit"><i class="icon-search"></i></button>';
				$form .= '</div>';
				$form .= '<input type="hidden" name="post_type" value="product" />';
			$form .= '</div>';
		$form .= '<fieldset>';
		$form .= '</form>';
		
		return $form;
	}
	
	/****************************************************
	*
	*	WMPL CUSTOM LANGUAGE SWITCHER
	*	@lang_display_type : native_name, translated_name, language_code (default)
	*
	****************************************************/
	public function lang_switcher( $lang_display_type = 'language_code' ) {
		if ( function_exists('icl_get_languages')) {
			
			$languages = icl_get_languages('orderby=code');
					
			if ($languages) {
				
				echo '<ul>';
			
				foreach($languages as $lang) {
					
					// if the lang is the active one, no link is displayed
					if ($lang[active] == 0) {
						$surrounding_tag = '<a href="' . $lang[url] . '">';
						$surrounding_tag_end = '</a>';
					} else {
						$surrounding_tag = '<span class="active">';
						$surrounding_tag_end = '</span>';
					}
					
					echo '<li>';
											
						echo $surrounding_tag . $lang[$lang_display_type] . $surrounding_tag_end;
						
					echo '</li>';
				}
				echo '</ul>';
			}
		}
	}
	
	/****************************************************
	*
	*	WPML - CATEGORIE ID FINDER
	*
	****************************************************/
	public function get_cat_id( $id ) {
		if ( function_exists('icl_object_id')) {
			return icl_object_id($id, 'category', true);
		} else {
			return $id;
		}
	}
	
	/****************************************************
	*
	*	CONTENT VIEW COUNTER
	*
	****************************************************/
	public function update_view_counter() {
		$nb_array = $this->get_post_meta('fire_views', get_the_ID());
		$nb = $nb_array[0];
		if ( empty($nb) ) { $nb = 0; }
		
		$this->update_post_meta('fire_views', get_the_ID(), $nb+1);
	}
	
}
?>