<?php

class EasySEOAdminOptions{
	
	function __construct(){
		add_action( 'admin_menu', array( $this, 'easy_seo_admin_menu') );
		add_action( 'admin_init', array( $this, 'easy_seo_admin_page') );
	}

	function easy_seo_admin_menu(){
		add_options_page( 'Easy SEO', 'Easy SEO', 'manage_options', 'easy-seo', array( $this, 'easy_seo_admin_page') );
	}

	function easy_seo_admin_page(){
		// displays the menu item for Easy SEO plugin admin page settings
	}
}