<?php
/*
Plugin Name: VIDEO POST Widget
Description: Display Indicated Youtube Video on Sidebar. [Usage] Set Custom Field in most recent new/modified  post > Key : "video_post", Value : Youtube Video ID.
Version: 1.0
Author: Jam Toast a.k.a dyampyon
*/

// Start class video_post_widget //

class video_post_widget extends WP_Widget {

// Constructor //

	function video_post_widget() {
		$widget_ops = array( 'classname' => 'video_post_widget', 'description' => 'Display Indicated Youtube Video on Sidebar. [Usage] Set Custom Field in most recent new/modified  post > Key : "video_post", Value : Youtube Video ID ' ); // Widget Settings
		$control_ops = array( 'id_base' => 'video_post_widget' ); // Widget Control Settings
		$this->WP_Widget( 'video_post_widget', 'VIDEO POST Widget', $widget_ops, $control_ops ); // Create the widget
	}

// Extract Args //

		function widget($args, $instance) {
			extract( $args );

			$title = apply_filters('widget_title', $instance['title']); // the widget title
			$v_width = apply_filters('widget_width', $instance['v_width']);
			$v_height = apply_filters('widget_height', $instance['v_height']);

//			$cp_id		= 3; // category id
			// $rssid 		= $instance['rssid']; // rss feed link
			// $newsletterurl 	= $instance['newsletter_url'];  URL of newsletter signup
			// $authorcredit	= isset($instance['author_credit']) ? $instance['author_credit'] : false ; give plugin author credit


// Before widget //

			echo $before_widget;

	// Title of widget //

			if ( $title ) { echo $before_title . $title . $after_title; }

	// Widget output //

?>

	<?php $postquery = new WP_Query(array( 'post_per_page' => 1, 'meta_key' => 'video-post', 'orderby' => 'modified' ));



	if ($postquery->have_posts()) {

		$postquery->the_post();


$metas = get_post_custom($post->ID);
if ($metas['video-caption'][0] != '') { $metas['video-caption'][0] = "<br>".$metas['video-caption'][0];}

echo '<iframe width='.$v_width.' height='.$v_height.' src="http://www.youtube.com/embed/';
echo $metas['video-post'][0];
echo '" frameborder="0" allowfullscreen></iframe>';
echo $metas['video-caption'][0];
}
?>




<?php

	// After widget //

			echo $after_widget;
		} 


// Update Settings //

 		function update($new_instance, $old_instance) {
 			$instance['title'] = strip_tags($new_instance['title']);
 			$instance['v_width'] = strip_tags($new_instance['v_width']);
 			$instance['v_height'] = strip_tags($new_instance['v_height']);
 			return $instance;
 		}



// Widget Control Panel //

 function form($instance) {

 $defaults = array( 'title' => 'Video Post', 'v_width' => '160', 'v_height' => '120' );
 		
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>

 		<p>
 			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
 <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id('v_width'); ?>">Width:</label>
 <input class="widefat" id="<?php echo $this->get_field_id('v_width'); ?>" name="<?php echo $this->get_field_name('v_width'); ?>'" type="text" value="<?php echo $instance['v_width']; ?>" />
 		</p>
 		<p>
 			<label for="<?php echo $this->get_field_id('v_height'); ?>">Height:</label>
 <input class="widefat" id="<?php echo $this->get_field_id('v_height'); ?>" name="<?php echo $this->get_field_name('v_height'); ?>'" type="text" value="<?php echo $instance['v_height']; ?>" />
 		</p>

        <?php }

}

// End class category_posts_widget

	add_action('widgets_init', create_function('', 'return register_widget("video_post_widget");'));	

?>