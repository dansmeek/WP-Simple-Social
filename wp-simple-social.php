<?php 
/*
Plugin Name: WP Simple Social
Plugin URI: http://dallasbass.com
Description: A simple social plugin. Upload a image, write a paragraph, or add social icons.
Version: 1.0
Author: Dallas Bass
Author URI: http://dallasbass.com
License: GPLv2
*/

// use widgets_init action hook to execute custom function
add_action( 'widgets_init', 'wp_simple_social_register_widgets' );

 //register our widget
function wp_simple_social_register_widgets() {
    register_widget( 'wp_simple_social_my_info' );
}

//Load necessary image upload scripts

function my_admin_scripts() {
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_register_script('my-upload', WP_PLUGIN_URL.'/WP-Simple-Social/wp-simple-social-image.js', array('jquery','media-upload','thickbox'));
wp_enqueue_script('my-upload');
}
 
function my_admin_styles() {
wp_enqueue_style('thickbox');
}
 
add_action('admin_print_scripts', 'my_admin_scripts');
add_action('admin_print_styles', 'my_admin_styles');


 //Load the stylesheet
function wp_simple_social_styles() {
        wp_enqueue_style( 'wp-simple-social-style', plugin_dir_url( __FILE__ ) . 'styles.css', array(), '0.1', 'screen' );
}
add_action( 'wp_enqueue_scripts', 'wp_simple_social_styles' );


//Load the farbtastic color picker

function sample_load_color_picker_script() {
	wp_enqueue_script('farbtastic');
}
function sample_load_color_picker_style() {
	wp_enqueue_style('farbtastic');	
}
add_action('admin_print_scripts-widgets.php', 'sample_load_color_picker_script');
add_action('admin_print_styles-widgets.php', 'sample_load_color_picker_style');


//boj_widget_my_info class
class wp_simple_social_my_info extends WP_Widget {

    //process the new widget
    function wp_simple_social_my_info() {
        $widget_ops = array( 
			'classname' => 'wp_simple_social_widget_class', 
			'description' => 'Display awesome things.' 
			); 
        $this->WP_Widget( 'wp_simple_social_my_info', 'WP Simple Social', $widget_ops );
    }
 
     //build the widget settings form
    function form($instance) {
        $defaults = array( 'iconshape' => 'square', 'image' => '', 'bio' => 'Enter a short bio', 'twitter' => 'Add your Twitter username', 'linkedin' => 'Add your LinkedIn username', 'dribbble' => 'Add your Dribbble username', 'facebook' => 'Add your facebook username', 'iconsize' => '', 'iconbgcolor' => '' ); 
        $instance = wp_parse_args( (array) $instance, $defaults );
        $image = $instance['image'];
        $bio = $instance['bio'];
        $twitter = $instance['twitter'];
        $linkedin = $instance['linkedin'];
        $dribbble = $instance['dribbble'];
        $facebook = $instance['facebook'];
        $iconsize = $instance['iconsize'];
        $iconcolor = $instance['iconcolor'];
        $iconbgcolor = $instance['iconbgcolor'];
        $iconshape = esc_attr($instance['iconshape']);

       
        ?>
        
        <script type="text/javascript">
        jQuery(document).ready(function() {
 
jQuery('#upload_image_button').click(function() {
 formfield = jQuery('#upload_image').attr('name');
 tb_show('', 'media-upload.php?type=image&TB_iframe=true');
 return false;
});
 
window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src');
 jQuery('#upload_image').val(imgurl);
 tb_remove();
}
 
});
</script>
        	<script type="text/javascript">
			//<![CDATA[
				jQuery(document).ready(function()
				{
					// colorpicker field
					jQuery('.cw-color-picker').each(function(){
						var $this = jQuery(this),
							id = $this.attr('rel');

						$this.farbtastic('#' + id);
					});
				});
			//]]>   
		  </script>

<input id="upload_image" class="widefat" type="text" size="36" name="upload_image" value="<?php echo esc_url( $image ); ?>" />
<input id="upload_image_button" type="button" value="Upload Image" />     

			<p>Bio: <textarea class="widefat" name="<?php echo $this->get_field_name( 'bio' ); ?>" / ><?php echo esc_attr( $bio ); ?></textarea></p>
            <p>Twitter: <input class="widefat" name="<?php echo $this->get_field_name( 'twitter' ); ?>"  type="text" value="<?php echo esc_attr( $twitter ); ?>" /></p>
            <p>LinkedIn: <input class="widefat" name="<?php echo $this->get_field_name( 'linkedin' ); ?>"  type="text" value="<?php echo esc_attr( $linkedin ); ?>" /></p>
            <p>Dribbble: <input class="widefat" name="<?php echo $this->get_field_name( 'dribbble' ); ?>"  type="text" value="<?php echo esc_attr( $dribbble ); ?>" /></p>
            <p>Facebook: <input class="widefat" name="<?php echo $this->get_field_name( 'facebook' ); ?>"  type="text" value="<?php echo esc_attr( $facebook ); ?>" /></p>
            
	<p>
		<label for="<?php echo $this->get_field_id('iconshape'); ?>"><?php _e('Select Your Icon Shape'); ?></label>
		<select name="<?php echo $this->get_field_name('iconshape'); ?>" id="<?php echo $this->get_field_id('iconshape'); ?>" class="widefat">
			<?php
			$options = array('circle', 'square');
			foreach ($options as $option) {
				echo '<option value="' . $option . '" id="' . $option . '"', $iconshape == $option ? ' selected="selected"' : '', '>', $option, '</option>';
			}
			?>
		</select>
	</p>

	  <label for="<?php echo $this->get_field_id('iconbgcolor'); ?>"><?php _e('Icon Background Color:'); ?></label> 
	  <input class="widefat" id="<?php echo $this->get_field_id('iconbgcolor'); ?>" name="<?php echo $this->get_field_name('iconbgcolor'); ?>" type="text" value="<?php if($iconbgcolor) { echo $iconbgcolor; } else { echo '#fff'; } ?>" />
	  <div class="cw-color-picker" rel="<?php echo $this->get_field_id('iconbgcolor'); ?>"></div>
	  
	  <label for="<?php echo $this->get_field_id('iconcolor'); ?>"><?php _e('Icon Color:'); ?></label> 
	  <input class="widefat" id="<?php echo $this->get_field_id('iconcolor'); ?>" name="<?php echo $this->get_field_name('iconcolor'); ?>" type="text" value="<?php if($iconcolor) { echo $iconcolor; } else { echo '#fff'; } ?>" />
	  <div class="cw-color-picker" rel="<?php echo $this->get_field_id('iconcolor'); ?>"></div>
	</p>
		    
<?php
    }
 
    //save the widget settings
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['image'] = strip_tags( $new_instance['image'] );
        $instance['bio'] = strip_tags( $new_instance['bio'] );
        $instance['twitter'] = strip_tags( $new_instance['twitter'] );
        $instance['linkedin'] = strip_tags( $new_instance['linkedin'] );
        $instance['dribbble'] = strip_tags( $new_instance['dribbble'] );
        $instance['facebook'] = strip_tags( $new_instance['facebook'] );
        $instance['iconshape'] = strip_tags($new_instance['iconshape']);
        $instance['iconsize'] = strip_tags( $new_instance['iconsize'] );
        $instance['iconcolor'] = strip_tags( $new_instance['iconcolor'] );
        $instance['iconbgcolor'] = strip_tags($new_instance['iconbgcolor']);
 
        return $instance;
    }
 
    //display the widget
    function widget($args, $instance) {
        extract($args);
 
        echo $before_widget;
      
        $image = empty( $instance['image'] ) ? '&nbsp;' : $instance['image'];
        $bio = empty( $instance['bio'] ) ? '&nbsp;' : $instance['bio'];
        $twitter = empty( $instance['twitter'] ) ? '&nbsp;' : $instance['twitter']; 
        $linkedin = empty( $instance['linkedin'] ) ? '&nbsp;' : $instance['linkedin']; 
        $dribbble = empty( $instance['dribbble'] ) ? '&nbsp;' : $instance['dribbble']; 
        $facebook = empty( $instance['facebook'] ) ? '&nbsp;' : $instance['facebook'];
        $iconsize = empty( $instance['iconsize'] ) ? '&nbsp;' : $instance['iconsize']; 
        $iconbgcolor = empty( $instance['iconbgcolor'] ) ? '&nbsp;' : $instance['iconbgcolor'];
        $iconcolor = empty( $instance['iconcolor'] ) ? '&nbsp;' : $instance['iconcolor'];
        $iconshape = empty( $instance['iconshape'] ) ? '&nbsp;' : $instance['iconshape'];  
        
		if ( $iconshape == 'circle' ) {
			echo '<style>';
			echo '.icon {border-radius:50%};';
			echo '</style>';
		} else {
			echo '';
		}
        
        echo '<li>' . esc_url($image) . '</li>';
        echo '<li>' . $bio . '</li>';
        echo '<ul class="wp-simple-social-icons">'; 
        echo '<li><a href="http://twitter.com/' . $twitter . '"><span class="twitter icon" style="background-color:' . $iconbgcolor . '; color:' . $iconcolor . '">L</span></a>';
        echo '<li><a href="http://linkedin.com/' . $linkedin . '"><span class="linkedin icon" style="background-color:' . $iconbgcolor . '; color:' . $iconcolor . '">I</span></a>';
        echo '<li><a href="http://dribbble.com/' . $dribbble . '"><span class="dribbble icon" style="background-color:' . $iconbgcolor . '; color:' . $iconcolor . '">D</span></a>';
        echo '<li><a href="http://facebook.com/' . $facebook . '"><span class="facebook icon" style="background-color:' . $iconbgcolor . '; color:' . $iconcolor . '">F</span></a>';
        echo '</ul>';
        
        echo $after_widget;
        
    }
}
?>