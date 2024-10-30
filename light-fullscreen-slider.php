<?php
/*
Plugin Name: Light Full Screen Slider
Plugin URI: http://itapplication.net/it/category/wordpress/
Description: Light weight Full Screen slide show plugin build with clean and bloat-less code.  
Version: 1.0
Author: Shivcharan Patil
Author URI: http://itweb.in/web-designer-shivcharan-patil/
Domain Path: /languages
Text Domain: lfs-slider
License URI: https://www.gnu.org/licenses/gpl-2.0.html
License: GPL2
 
'Light Full Screen Slider' is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
'Light Full Screen Slider' is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with 'Light Full Screen Slider'. If not, see {https://www.gnu.org/licenses/gpl-2.0.html.
*/

function lfs_slider_plugin_css_js() {
    $plugin_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'commonstyle', $plugin_url . 'css/style.css' ); //Front-end CSS
	wp_enqueue_script( 'script-name', $plugin_url . '/js/responsiveslides.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'lfs_slider_plugin_css_js' );
function lfs_slider_admin_style() {
    wp_enqueue_style('lfs-admin', plugins_url('css/adminstyle.css', __FILE__));
}
    add_action('admin_enqueue_scripts', 'lfs_slider_admin_style');
    add_action('login_enqueue_scripts', 'lfs_slider_admin_style');
add_action('wp_head','hook_lfs_js');
function hook_lfs_js() {
$outputlfs='<script>jQuery(function() {
    jQuery(".rslides").responsiveSlides({
	pause: false, 
	speed: 1500, 
	timeout: 4000,
	});
  }); </script>';
echo $outputlfs;
}
function lfs_slider_menu()
{
  add_options_page('Light Full Screen Slider Options', 'Light Full Screen Slider', 'manage_options', 'lfs-slider-admin-page', 'lfs_slider_menu_page');  
}
add_action('admin_menu', 'lfs_slider_menu');     
function lfs_slider_menu_page()
{
?>
    <div class="section panel">
      <h1>Light Full Screen Slider Options</h1>
      <form method="post" enctype="multipart/form-data" action="options.php">
        <?php 
          settings_fields('lfs_slider_option');        
          do_settings_sections('lfs-slider-admin-page');
        ?>
            <p class="submit">  
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />  
            </p>              
      </form>      
      <p>Created by <a href="http://itweb.in">Shivcharan</a>.</p>
    </div>
    <?php
}
add_action( 'admin_init', 'pu_register_settings' );
function pu_register_settings() {
    register_setting( 'lfs_slider_option', 'lfs_slider_option', 'pu_validate_settings' );
    add_settings_section( 'pu_url_section', 'Add slide show image path', 'pu_display_section', 'lfs-slider-admin-page' );
    $firstimg_args = array(
      'type'      => 'url',	  
      'id'        => 'first_img',
      'name'      => 'first_img',
      'desc'      => 'Input image path',
      'std'       => '',
      'label_for' => 'first_img',		
      'class'     => 'firstimg'
    );
    $secondimg_args = array(
      'type'      => 'url',	  
      'id'        => 'second_img',
      'name'      => 'second_img',
      'desc'      => 'Input image path',
      'std'       => '',
      'label_for' => 'second_img',
      'class'     => 'secondimg'
    );
    $thirdimg_args = array(
      'type'      => 'url',	  
      'id'        => 'third_img',
      'name'      => 'third_img',
      'desc'      => 'Input image path',
      'std'       => '',
      'label_for' => 'third_img',
      'class'     => 'thirdimg'
	);
    add_settings_field( 'first_image', 'First Image', 'pu_display_setting', 'lfs-slider-admin-page', 'pu_url_section', $firstimg_args );
	add_settings_field( 'second_image', 'Second Image', 'pu_display_setting', 'lfs-slider-admin-page', 'pu_url_section', $secondimg_args );
	add_settings_field( 'third_image', 'Third Image', 'pu_display_setting', 'lfs-slider-admin-page', 'pu_url_section', $thirdimg_args );
    add_settings_section( 'pu_text_section', 'Add slide show caption', 'pu_display_section', 'lfs-slider-admin-page' );
    $firsttext_args = array(
      'type'      => 'text',	  
      'id'        => 'first_caption',
      'name'      => 'first_caption',
      'desc'      => 'Input Caption',
      'std'       => '',
      'label_for' => 'first_caption',
      'class'     => 'firstcaption'
    );
    $secondtext_args = array(
      'type'      => 'text',	  
      'id'        => 'second_caption',
      'name'      => 'second_caption',
      'desc'      => 'Input Caption',
      'std'       => '',
      'label_for' => 'second_caption',
      'class'     => 'secondcaption'
    );
    $thirdtext_args = array(
      'type'      => 'text',	  
      'id'        => 'third_caption',
      'name'      => 'third_caption',
      'desc'      => 'Input Caption',
      'std'       => '',
      'label_for' => 'third_caption',
      'class'     => 'thirdcaption'
	);
    add_settings_field( 'first_image', 'First Caption', 'pu_display_setting', 'lfs-slider-admin-page', 'pu_text_section', $firsttext_args );
	add_settings_field( 'second_image', 'Second Caption', 'pu_display_setting', 'lfs-slider-admin-page', 'pu_text_section', $secondtext_args );
	add_settings_field( 'third_image', 'Third Caption', 'pu_display_setting', 'lfs-slider-admin-page', 'pu_text_section', $thirdtext_args );
}
function pu_display_section($section){}
function pu_display_setting($args) {
    extract( $args );
    $option_name = 'lfs_slider_option';
    $options = get_option( $option_name );
    switch ( $type ) {  
          case 'url':  
              echo "<input class='imgurl img-$class' id='$id' name='" . $option_name . "[$id]' value='$options[$id]' />";  
              echo ($desc != '') ? "'<br /><span class='description'>$desc</span>" : "";  
          break;
          case 'text':  
              echo "<input class='caption cap-$class' id='$id' name='" . $option_name . "[$id]' value='$options[$id]' />";  
              echo ($desc != '') ? "'<br /><span class='description'>$desc</span>" : "";  
          break;		  
    }
}
function pu_validate_settings($input) {
  foreach($input as $k => $v) {
    $newinput[$k] = trim($v); 
  }
  return $newinput;
}
function get_lfs(){
$options = get_option( 'lfs_slider_option' );
if( $options['first_img'] && $options['second_img'] && $options['second_img'] ) {
echo '<ul class="rslides">
		<li><img src="'.$options['first_img'].'" /><h2>'.$options['first_caption'].'</h2></li>
		<li><img src="'.$options['second_img'].'" /><h2>'.$options['second_caption'].'</h2></li>
		<li><img src="'.$options['third_img'].'" /><h2>'.$options['third_caption'].'</h2></li>
		</ul>';
	}
else {
echo '<ul class="rslides">
		<li><img src="'.plugins_url('img/lfs-slider1.png', __FILE__).'" /><h2>Welcome</h2></li>
		<li><img src="'.plugins_url('img/lfs-slider2.png', __FILE__).'" /><h2>This default slider will be disapper after you set your own. </h2></li>
		<li><img src="'.plugins_url('img/lfs-slider3.png', __FILE__).'" /><h2>Set your slider at <br>WP Administration dashboard -> Setting -> Light Full Screen Slider</h2></li>
		</ul>';
	}
}