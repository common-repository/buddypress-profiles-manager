=== Plugin Name ===
Contributors: Elgunvo
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=BCLHW7DFYDCQS
Tags: Buddypress, Profile, Social Network
Requires at least: 2.8
Tested up to: 3.0.1
Stable tag: 1.3

A simple bridge between s2Member (or similar) and Buddypress to hide and show profile groups depending on the membership status thus monitizing your BuddyPress Site.

== Description ==

This plugin acts as a go between for s2Member (or similar) and buddypress and enables you to hide certain profile sections to non-paid/low level members. You can also specify a message to give people on pages where the user can fill in the info but its not visible to the public until they upgrade. 

Features:

* A simple to use interface for managing profile groups.
* Hide/show Profile Catergories
* Teaser profiles (where the user can fill out the information but its not viewable to other users)
* Create Nav Link for upgrade on pages where the message is displayed.

Suggestions:

I want this plugin to be useful so if you have any suggestions on how to improve it please let me know. 

== Installation ==

Before you activate this plugin make sure that you have Buddypress v1.2.7 or higher.

1. Upload the buddypress-profiles folder to plugins folder.
2. Go to your buddy-press template and search for edit.php under members/single/profile.
3. Change bp_profile_group_tabs(); with  bp_pm_group_tabs();
4. Activate the BP-Profiles Manager in wp-admin under plugins.
5. Go to settings -> BP-Profiles Manager
6. Your Good to go!

== Removing the plugin ==

All should be fine should you want to deactivate this plugin however do make sure that you replace bp_pm_group_tabs(); with bp_profile_group_tabs(); (reverse to install info number 3) otherwise the profile edit tabs will dissapear.

== Frequently Asked Questions ==

-- Where is edit.php? --

In the buddy-press template it should be located at members/single/profile/edit.php


-- Other Information --

If you are having difficulties getting this plugin to work please email me with the details 
at hallo@elgunvo.de or comment on the plugin page.

== Screenshots ==

1. Admin Panel for managing functionality.
2. Front End Example.

== Changelog ==

= 1.3 =
* Fixed bp_head function for higher versions of wordpress

= 1.2 =
* Cleaned the code where older code was not in use.
* Fixed mysql error within the profile hider.

= 1.1.1 =
* Fixed Broken Images and re-wrote the upgrade script.

= 1.1 =
* Added an option to create a navigation item that links to your profile upgrades page.
* re-wrote 1 database
* Wrote a database update script.
* Back end modifications

= 1.0 =
* Written Initial Version
* Programmed backend
* Developed Front End

<?php code(); // goes in backticks ?>