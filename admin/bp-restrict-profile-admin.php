<?php
function profile_restrictor_admin()
{
global $wpdb;

	$groups = BP_XProfile_Group::get( array(
		'fetch_fields' => true
	) );

if ($_GET['id']) {
$did = $_GET['id'];
$wpdb->query("DELETE FROM bb_profiles WHERE id='$did'");
}

if ($_GET['update']) {
$rndid = $_GET['update'];
$new_pub = $_POST['public'];
$new_mem = $_POST['member'];
$wpdb->query("UPDATE bb_profiles SET member_hidden='$new_mem', public_hidden='$new_pub' WHERE id='$rndid'");
}

if ( $_POST['formid'] == '1') {

$level = $_POST['level'];
$group = $_POST['group'];
$pub = $_POST['public'];
$member = $_POST['member'];
$wpdb->query("INSERT INTO bb_profiles (membership_level, bb_group, member_hidden, public_hidden) VALUES ('$level', '$group', '$member', '$pub')");
?>
<div id="message" class="updated" style="width:85%;">
	<p><strong>Profile Setting Has Been Saved!</strong></p>
</div>

<?php
}

if ( $_POST['formid'] == '2') {
$msg = $_POST['message'];
$btn_en = $_POST['button_en'];
$btn_link = $_POST['button_link'];
$btn_text = $_POST['button_text'];
$wpdb->query("UPDATE bb_profiles_settings SET option_value='$msg' WHERE option_name='message'");
$wpdb->query("UPDATE bb_profiles_settings SET option_value='$btn_en' WHERE option_name='button_en'");
$wpdb->query("UPDATE bb_profiles_settings SET option_value='$btn_text' WHERE option_name='button_text'");
$wpdb->query("UPDATE bb_profiles_settings SET option_value='$btn_link' WHERE option_name='button_link'");
?>
<div id="message" class="updated" style="width:85%;">
	<p><strong>Your text has been saved!</strong></p>
</div>

<?php
}
?>
<h2>BP Profile Manager (developed by elgunvo) | <a href="http://bp-profiles-manager.info">Visit Website</a></h2>
<p style="width: 95%;">The Buddy-Press Profile Manager makes it simple to bridge s2Member and Buddy-Press and provide premium/free profiles using the Hide/Show system below. You don't even need s2Member! If you have another system like the s2Member the roles will be shown below.</p>
<?php
$num = rand(1, 3);
switch ($num){
case 1:
?>
<table class="widefat page" cellspacing="0" style="width:95%; margin-top: 10px; margin-bottom: 10px;">
<thead>  
<tr>
<th colspan="2">
Need Help or Support?
</th>
</tr>
</thead> 
<tr>
<td><p>If you need help with this plugin and would like to submit a support request you can now do that through our website <a href="http://bp-profiles-manager.info">http://bp-profiles-manager.info</a>. Support costs &euro;10 euros for the lifetime of this product and it helps keep this free for all to use. It also enables you to help make decisions on new features and you will get pre-release versions to download.</p></td>
</tr>
</table>
<?php
break;
case 2:
?>
<table class="widefat page" cellspacing="0" style="width:95%; margin-top: 10px; margin-bottom: 10px;">
<thead>  
<tr>
<th colspan="2">
Advertisement
</th>
</tr>
</thead> 
<tr>
<td><a href='http://premium.wpmudev.org?ref=elgunvo-57581'>
<img src='http://wpmu.org/wp-content/uploads/2010/05/wpmudev_728_banner2.png' alt='WPMU DEV - The WordPress Experts' title='Check out WPMU DEV - The WordPress Experts' />
</a></td>
</tr>
</table>
<?php
break;
case 3:
?>
<table class="widefat page" cellspacing="0" style="width:95%; margin-top: 10px; margin-bottom: 10px;">
<thead>  
<tr>
<th colspan="2">
Care to donate?
</th>
</tr>
</thead> 
<tr>
<td><p>If you like this plugin and would like to see it maintained and updated please consider a donation to help keep the plugin free and available to all users. Alternatively you can support me buy getting your hosting from <a href="http://www.elgunvo-hosting.com">http://www.elgunvo-hosting.com</a></p></td><td><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="BCLHW7DFYDCQS">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form></td>
</tr>
</table>
<?php
break;
}
?>
<table class="widefat page" cellspacing="0" style="width:95%; margin-bottom: 10px;">
<thead>  
<tr>
<th>
Membership Level
</th>
<th>
BB Profile Group
</th>
<th>
Visibility (Member)
</th>
<th>
Visibility (Public)
</th>
<th>
Delete/Update
</th>
</tr>
</thead>
<?php 
$get_items = $wpdb->get_results("SELECT * FROM bb_profiles");
foreach ($get_items as $item) {
?>
<form method="post" action="?page=profile-restrictor&update=<?php echo $item->id; ?>" name="update">
<tr>
<td valign="middle">
<?php echo $item->membership_level; ?>
</td>
<td valign="middle">
<?php echo $item->bb_group; ?>
</td>
<td valign="middle" align="center">
<select name="member">
<option value="<?php echo $item->member_hidden; ?>"><?php echo $item->member_hidden; ?></option>
<option value="hidden">Hidden</option>
<option value="shown">Shown</option>
</select>
</td>
<td valign="middle" align="center">
<select name="public">
<option value="<?php echo $item->public_hidden; ?>"><?php echo $item->public_hidden; ?></option>
<option value="hidden">Hidden</option>
<option value="shown">Shown</option>
</select>
</td>
<td>
<a href="?page=profile-restrictor&id=<?php echo $item->id; ?>"><input type="image" src="<?php bloginfo('wpurl'); ?>/wp-content/plugins/buddypress-profiles-manager/admin/minus.png" width="25" height="25" alt="" border="0" /></a>
<input type="submit" class="button" value="Update Options" style="float: right;" />
</td>
</tr>
</form>
<?php } ?>
<form method="post" action="#" name="pr_form">
<tr>
<th valign="middle">
<select name="level">
<?php wp_dropdown_roles(); ?>
</select>
</th>
<th valign="middle">
<select name="group">
<?php
for ( $i = 0; $i < count($groups); $i++ ) { // TODO: foreach
echo "<option value='" . sanitize_title( $groups[$i]->name ) . "'>";
echo $groups[$i]->name;
echo "</option>";
}
?>

</select>
<input type="hidden" name="formid" value="1" />
</th>
<th valign="middle" align="center">
<select name="member">
<option value="hidden">Hidden</option>
<option value="shown">Shown</option>
</select>
</th>
<th valign="middle" align="center">
<select name="public">
<option value="hidden">Hidden</option>
<option value="shown">Shown</option>
</select>
</th>
<td>
<input type="submit" class="button" style="margin-top: 6px; float: right;" value="+ Add To Rules" />
</td>
</tr>
</table>
</form>

<form method="post" action="#" name="pr_form2">
<?php 
$message = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM bb_profiles_settings WHERE option_name = 'message';"));
$btn_en = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM bb_profiles_settings WHERE option_name = 'button_en';"));
$btn_text = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM bb_profiles_settings WHERE option_name = 'button_text';"));
$btn_link = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM bb_profiles_settings WHERE option_name = 'button_link';"));
?>
<table class="widefat page" cellspacing="0" style="width:95%">
<thead>  
<tr>
<th>
Extra Options 
</th>
</tr>
</thead> 
<tr>
<td style="background: #eee;"><input type="checkbox" <?php if ($btn_en == 'on') { echo 'checked'; } ?> name="button_en"> <i>Enable Upgrade Nav (Adds a nav item to profile edit menu that links to your membership upgrade page)</i></td>
</tr>
<tr>
<td>
Nav Text : <input type="text" value="<?php echo $btn_text; ?>" name="button_text" style="width: 300px;"> </td>
</tr>
<tr>
<td>
Nav Link : <input type="text" value="<?php echo $btn_link; ?>" name="button_link" style="width: 300px;"> </td>
</tr>
<tr>
<tr>
<td style="background: #eee;"><i>Message (Items Hidden To Public)</i></td>
</tr>
<tr>
<td><textarea style="width: 100%; height: 200px;" name="message"><?php echo $message; ?></textarea></td>
</tr>
<tr>
<td><input type="submit" class="button" value="Update Options" style="float: right;" /><input type="hidden" name="formid" value="2" /></td>
</tr>
</table>
</form>





<?php
}
?>
