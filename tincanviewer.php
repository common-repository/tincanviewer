<?php
/**
 * @package Tin Can API Viewer 
 * @version 1.0.2
 */
/*
Plugin Name: Tin Can API Viewer
Plugin URI: http://www.vtrainingtracker.com
Description: Tin Can API (Experience API or xAPI) Viewer will launch Tin Can API content inside an iframe.  Go to Settings > TinCan LRS Settings for details and example usage. 
Author: vTrainingRoom, Inc.
Version: 1.0.2
Author URI: https://www.vtrainingtracker.com
*/

function tincanviewer($attr) {
	$current_user = wp_get_current_user();
	
	if(empty($current_user))
	return "Please login.";
	
	 $shortcode_atts = shortcode_atts ( array(
			'version' => '0.95',
			'extra' => '',
			'tag' => 'iframe',
			'width' => '960px',
			'height' => '640px',
			'endpoint' => 'https://www.vtrainingtracker.com/TCAPI/',
			'auth' => '',
			'user' => '',
			'pass' => '',
			'src' => ''
			), $attr);

	extract($shortcode_atts);

    	// Read in existing option value from database
    if(empty($endpoint))
    	$endpoint = get_option( 'tincan_endpoint' );

	if(empty($user))
    	$user = get_option('tincan_user');

	if(empty($pass))
    	$pass = get_option('tincan_password');


	if($version == "0.90")
	$actor = array('mbox' => array($current_user->user_email), 'name' => array($current_user->user_firstname." ".$current_user->user_lastname));
	else
	$actor = array('mbox' => "mailto:".$current_user->user_email, 'name' => $current_user->user_firstname." ".$current_user->user_lastname);
	
	$actor = "actor=".rawurlencode(json_encode($actor));
	
	if(!empty($auth))
	$auth = "auth=".rawurlencode($auth);
	else
	$auth = "auth=".rawurlencode("Basic ".base64_encode($user.":".$pass));

	$endpoint = 'endpoint='.rawurlencode($endpoint);
	if(strpos($src,"?") !== false)
		$src = $src."&".$actor."&".$auth."&".$endpoint;
	else
		$src = $src."?".$actor."&".$auth."&".$endpoint;

	if($tag == 'iframe')
	return "<iframe frameBorder='0' src='$src' width='$width' height='$height'></iframe>";
	
}
add_shortcode("tincanviewer", "tincanviewer");

add_action('admin_menu', 'tincanviewer_menu');
function tincanviewer_menu() {
add_submenu_page("options-general.php", "TinCan LRS Settings", "TinCan LRS Settings",'manage_options','tincan-lrs-settings', 'tincanviewer_menu_page');
}
function tincanviewer_menu_page() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    //Read in existing option value from database
    $tincan_endpoint = "https://www.vtrainingtracker.com/TCAPI/";
    $tincan_user = get_option('tincan_user');
    $tincan_password = get_option('tincan_password');

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ "update_TinCanLRSSettings" ]) ) {
        // Read their posted value
        $tincan_user = $_POST['tincan_user'];
        $tincan_password = $_POST['tincan_password'];

        // Save the posted value in the database
        update_option( 'tincan_user', $tincan_user);
        update_option( 'tincan_password', $tincan_password);
        // Put an settings updated message on the screen

?>
<div class="updated"><p><strong><?php _e('settings saved.', 'TinCanLRSSettings' ); ?></strong></p></div>
<?php

    }
?>
<div class=wrap>
<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
<h2>TinCan LRS Settings</h2>
<p>Enter your credentials from the My Account > <a href='http://www.vtrainingtracker.com/api-access' target="_blank">API Access Page</a> of vTrainingTracker.com.
<h3>vTrainingTracker Username:</h3>
<input name="tincan_user" style="min-width:30%" value="<?php _e(apply_filters('format_to_edit',$tincan_user), 'TinCanLRSSettings') ?>" />
<h3>vTrainingTracker API Auth Password:</h3>
<input name="tincan_password" style="min-width:30%" value="<?php _e(apply_filters('format_to_edit',$tincan_password), 'TinCanLRSSettings') ?>" />
<div class="submit">
<input type="submit" name="update_TinCanLRSSettings" value="<?php _e('Update Settings', 'TinCanLRSSettings') ?>" /></div>
</form>
Don't have a vTraininingTracker account? <a href='http://www.vtrainingtracker.com/' target="_blank">Signup</a> for a FREE Learning Record Store (LRS) account.
<br><br>
<h3>&nbsp;</h3>
<h3>Shortcode Format:</h3>
<p>[tincanviewer src='url' width='600px' height='480px' version='0.95']</p>
<p>Example 1: This shortcode will launch the page url http://vtrainingtracker.com/sample/story.html in a default size iframe: <br>
  <b>[tincanviewer src='http://vtrainingtracker.com/sample/story.html']</b>
  <br>
</p>
<p>Example 2: This shortcode will launch the page url http://vtrainingtracker.com/sample/story.html in a 900 X 600px iframe:   <br>
  <b>[tincanviewer src='http://vtrainingtracker.com/sample/story.html' width='900px' height='600px']</b><br>
</p>
<h3>Parameters:</h3>
<p><b>src</b>: Required. URL of content
<br>
<b>width</b>: Optional. Default 960px.
<br>
<b>height</b>: Optional. Default 640px.
<br>
<b>version</b>: Optional. Default <b>0.95</b>. If using 0.90 content, set the version to 0.90
</p>

 </div>
<?php
}

// Add settings link on plugin page
function tincan_plugin_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=tincan-lrs-settings">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'tincan_plugin_settings_link' );
