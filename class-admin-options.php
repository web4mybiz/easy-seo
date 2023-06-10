<?php
class EasySEOAdminOptions{
	
	// constructor
	public function __construct(){
		add_action( 'admin_menu', array( $this, 'easy_seo_admin_menu') );
	}

	// Add the admin  menu
	public function easy_seo_admin_menu(){
		add_options_page( 'Easy SEO', 'Easy SEO', 'manage_options', 'easy-seo', array( $this, 'easy_seo_admin_page') );
	}

	// Render admin page
	function easy_seo_admin_page(){
		// Render admin page content
		if( isset( $_POST['crawl_trigger'] ) ){
			// Execute trigger
			$this->trigger_crawl();
		}
	}

	// Function that trigger the crawl process
	function trigger_crawl(){

	}

}