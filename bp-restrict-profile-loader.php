<?php
/*
 Plugin Name: BuddyPress Profiles Manager
 Plugin URI: http://elgunvo.com
 Description: Restrict Profile Information for non-paid members
 Author: Ashley Johnson
 Author URI: http://www.elgunvo.com
 License: GNU GENERAL PUBLIC LICENSE 3.0 http://www.gnu.org/licenses/gpl.txt
 Version: 1.3
 Text Domain: bp-profile-restrictor
 Site Wide Only: true
*/

//Creating the Admin Panel

	

function bp_profile_restrictor_activate() {
	global $wpdb;

	if ( !empty($wpdb->charset) )
		$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
	
	$wpdb->query("CREATE TABLE bb_profiles (
		  		id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
		  		membership_level text, 
		  		bb_group text, 
		  		member_hidden text, 
		  		public_hidden text) {$charset_collate};");
		  		
		  		
	
	$wpdb->query("CREATE TABLE bb_profiles_settings (
		  		id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
		  		option_name text,
		  		option_value text) {$charset_collate};");
	
	$version = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM bb_profiles_settings WHERE option_name= 'version';"));
	
	if (!$version) {
	  		
	 $wpdb->query("INSERT INTO bb_profiles_settings (option_name, option_value) VALUES ('button_en', '')");
	 $wpdb->query("INSERT INTO bb_profiles_settings (option_name, option_value) VALUES ('button_text', 'sometext')");
	 $wpdb->query("INSERT INTO bb_profiles_settings (option_name, option_value) VALUES ('button_link', 'http://your.com/page')");
	 $wpdb->query("INSERT INTO bb_profiles_settings (option_name, option_value) VALUES ('version', '1.1.0')");
	 
	 } else {
	 
	  $wpdb->query("UPDATE bb_profiles_settings SET option_value='1.1.1' WHERE option_name='version'");
	 
	 }
	 
	 $old_version = $wpdb->get_var($wpdb->prepare("SELECT content FROM bb_profiles_text WHERE id= 1;"));
	
	if ($old_version > "") {
	$wpdb->query("INSERT INTO bb_profiles_settings (option_name, option_value) VALUES ('message', '$old_version')");
	$wpdb->query("DROP TABLE IF EXISTS bb_profiles_text");
	} else {
	$wpdb->query("INSERT INTO bb_profiles_settings (option_name, option_value) VALUES ('message', 'Text to display here')");
	} 
	
	
	 

}
register_activation_hook( __FILE__, 'bp_profile_restrictor_activate' );


//include essential code
require( dirname( __FILE__ ) . '/bp-restrict-profile.php' );


//add admin_menu page
function bp_profile_restrictor_admin_menu() {
	global $bp;
	
	if ( !is_super_admin() )
		return false;

	//Add the component's administration tab under the "BuddyPress" menu for site administrators
	require ( dirname( __FILE__ ) . '/admin/bp-restrict-profile-admin.php' );
	
	$page_title = 'BP - Profile Manager';
	$menu_title = 'BP - Profile Manager';
	$capability = 'manage_options';
	$menu_slug = 'profile-restrictor';
	$function ='profile_restrictor_admin';
	
	add_options_page($page_title, $menu_title, $capability, $menu_slug, $function);
	
}

add_action( 'admin_menu', 'bp_profile_restrictor_admin_menu' );


?>