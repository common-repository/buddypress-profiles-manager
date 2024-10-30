<?php

function bp_restrict_profile_head() { 

	global $bp;
	global $wpdb;
	global $pro_ite;
	
	
	$groups = BP_XProfile_Group::get( array(
		'fetch_fields' => true
	) );
	
	$user = new WP_User($bp->displayed_user->id);
	$user_role = $user->roles[0];
	
	$pub_hid = $wpdb->get_results("SELECT bb_group FROM bb_profiles WHERE public_hidden = 'hidden' AND membership_level = '$user_role'");
	
	echo '<style type="text/css">';
	
	foreach ($pub_hid as $pitem) {
	echo 'div.' . $pitem->bb_group . ' { display: none; }';
	}
	
	echo '</style>'; 
	
	
	//Get visitor/members membership level
	
	global $current_user;
	$user_roles = $current_user->roles[0];


	
	//Check the database to see if the membership level is matched in the database
	
	$mem_hid = $wpdb->get_results("SELECT bb_group FROM bb_profiles WHERE member_hidden = 'hidden' AND membership_level = '$user_roles'");
	
	echo '<style type="text/css">';
	
	foreach ($mem_hid as $mitem) {
	echo 'form.' . $mitem->bb_group . ' { display: none; }';
	echo 'li.' . $mitem->bb_group . ' { display: none; }';
	}
	
	echo '</style>'; 
	
	//Get message to be displayed when the user is updating a profile page that no one will see.
	
	$message = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM bb_profiles_settings WHERE option_name = 'message';"));
	
	//Get an array of public hidden profile items.
	
	$list = array();
	$pro_ite = $wpdb->get_results("SELECT * FROM bb_profiles WHERE public_hidden = 'hidden' AND membership_level = '$user_roles'");
	
	//Display message for the member updating his/her Profile.
	
	foreach ( $pro_ite as $proitem) {
		if ($proitem->bb_group == sanitize_title( bp_profile_group_name(false))) {
		bp_core_add_message( $message . " ", "buddypress", "error" );
		}
	
	}


	
	
	

function bp_pm_group_tabs() {
	global $bp, $group_name, $wpdb;
	
	global $current_user;
	$user_roles = $current_user->roles[0];
	
	$str = $wpdb->get_results("SELECT bb_group FROM bb_profiles WHERE member_hidden='shown' AND membership_level='$user_roles'");
	
	if ( !$groups = wp_cache_get( 'xprofile_groups_inc_empty', 'bp' ) ) {
		$groups = BP_XProfile_Group::get( array( 'fetch_fields' => true ) );
		wp_cache_set( 'xprofile_groups_inc_empty', $groups, 'bp' );
	}

	if ( empty( $group_name ) )
		$group_name = bp_profile_group_name(false);
	for ( $i = 0; $i < count($groups); $i++ ) {
		if ( $group_name == $groups[$i]->name ) {
			$selected = ' class="current"';
		} else {
			$selected = '';
		}
		
		foreach ( $str as $hide) {
		if ($hide->bb_group == sanitize_title($groups[$i]->name)) {
		echo '<li' . $selected . '><a href="' . $bp->displayed_user->domain . $bp->profile->slug . '/edit/group/' . $groups[$i]->id . '">' . esc_attr( $groups[$i]->name ) . '</a></li>';
		}
	
}	
}
	
	$upgrade_button = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM bb_profiles_settings WHERE option_name = 'button_en';"));
	$nav_text = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM bb_profiles_settings WHERE option_name = 'button_text';"));
	$nav_link = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM bb_profiles_settings WHERE option_name = 'button_link';"));
	$pro_ite = $wpdb->get_results("SELECT * FROM bb_profiles WHERE public_hidden = 'hidden' AND membership_level = '$user_roles'");
	
	foreach ( $pro_ite as $proitem) {
		if ($proitem->bb_group == sanitize_title( bp_profile_group_name(false))) {
		if ($upgrade_button == 'on') {
	echo '<li><a href="'.$nav_link.'">' . $nav_text . '</a></li>';
	}	
	}
	}
	
	
	
	echo "</ul>";
	do_action( 'bp_pm_group_tabs' );
}}
add_action( 'wp_head', 'bp_restrict_profile_head');


?>