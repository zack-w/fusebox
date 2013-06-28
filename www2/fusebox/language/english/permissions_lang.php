<?php

	// This is the file for permissions- WHICH ARE USED FOR USERGROUPS ONLY

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	/*
		Down here is going to be the title for each permission category
	*/
	
	$lang['permissioncategory_general_title'] = "General";
	$lang['permissioncategory_support_title'] = "Support";
	$lang['permissioncategory_title'] = "Users";
	
	/*
		Down here is going to be the title & description for each permission
	*/
	
	$lang['permission_general_isadmin_title'] = "Is Full Admin?";
    $lang['permission_general_isadmin_desc'] = "Does this usergroup get full unrestricted access?";
	