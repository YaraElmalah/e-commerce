<?php

function lang($phrase){
	static $English = array(
		// Dashboard Navbar Reference
		'brand'            => 'Buy IT',
		'sections'         => 'Categories',
		'edit-profile'     => 'Edit Profile',
		'settings'         => 'Settings',
		'items'            => 'Items',
		'members'          => 'Members',
		'statistics'       => 'Statistics',
		'logs'             => 'Logs'
	);
	return $English[$phrase];
}