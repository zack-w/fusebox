<?php

	// This is the file for permissions- WHICH ARE USED FOR USERGROUPS ONLY

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	/*
		Down here is going to be the title for each permission category
	*/
	
	$lang['permissioncategory_general_title'] = "General";
	$lang['permissioncategory_support_title'] = "Support";
	$lang['permissioncategory_users_title'] = "Users";
	$lang['permissioncategory_billing_title'] = "Billing";
	
	/*
		Down here is going to be the title & description for each permission
	*/
	
	$lang['permission_general_isadmin_title'] = "Is Full Admin?";
    $lang['permission_general_isadmin_desc'] = "Does this usergroup get full unrestricted access?";
	
	$lang['permission_users_cansuspend_title'] = "Can suspend users?";
    $lang['permission_users_cansuspend_desc'] = "Can this usergroup suspend users?";
	
	$lang['permission_support_canclose_title'] = "Can close tickets?";
    $lang['permission_support_canclose_desc'] = "Can this usergroup close support tickets in their department?";
	
	$lang['permission_support_canclose_title'] = "Can close tickets?";
    $lang['permission_support_canclose_desc'] = "Can this usergroup close support tickets in their department?";
	
	$lang['permission_users_canview_title'] = "Can view user profiles?";
    $lang['permission_users_canview_desc'] = "Can this usergroup view personal user information?";
	
	$lang['permission_users_canview_title'] = "Can view user profiles?";
    $lang['permission_users_canview_desc'] = "Can this usergroup view personal user information?";
	
	$lang['permission_users_canedit_title'] = "Can edit user profiles?";
    $lang['permission_users_canedit_desc'] = "Can this usergroup edit personal user information?";
	
	$lang['permission_support_canopen_title'] = "Can open new tickets?";
    $lang['permission_support_canopen_desc'] = "Can this usergroup open new support tickets?";
	
	$lang['permission_support_candelegate_title'] = "Can change department?";
    $lang['permission_support_candelegate_desc'] = "Can this usergroup change the department of a support ticket?";