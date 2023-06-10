<?php
class EasySEOAdminOptions{
	
	// constructor
	public function __construct(){
		add_action( 'admin_menu', array( $this, 'easy_seo_admin_menu') );
		add_action( 'crawl_task_hook', array( $this, 'crawl_task' ) );
		add_action( 'crawl_recurring_task_hook', array( $this, 'crawl_recurring_task' ) );
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

		// Delete the results from the last crawl if they exist
        $this->delete_previous_results();

        // Delete the sitemap.html file if it exists
        $this->delete_sitemap_file();

        // Start at the website's root URL (home page)
        $root_url = home_url();

        // Extract all internal hyperlinks (results)
        $results = $this->extract_hyperlinks( $root_url );

        // Store results temporarily in the database
        $this->store_results( $results );

        // Save the home page's .php file as a .html file
        $this->save_as_html( $root_url );

        // Create a sitemap.html file that shows the results as a sitemap list structure
        $this->create_sitemap();

		// Run the task immediately
        wp_schedule_single_event( time(), 'crawl_task_hook' );

        // Set a hourly recurring task
        if ( ! wp_next_scheduled( 'crawl_recurring_task_hook' ) ) {
            wp_schedule_event( time(), 'hourly', 'crawl_recurring_task_hook' );
        }
	}


	// Delete the results from the last crawl if they exist
    public function delete_previous_results() {
        // Implementation for deleting previous results
    }

    // Delete the sitemap.html file if it exists
    public function delete_sitemap_file() {
        // Implementation for deleting sitemap.html file
    }

    // Extract all internal hyperlinks (results)
    public function extract_hyperlinks( $url ) {
        // Implementation for extracting hyperlinks
        return $results;
    }

    // Store results temporarily in the database
    public function store_results( $results ) {
        // Implementation for storing results
    }

    // Save the home page's .php file as a .html file
    public function save_as_html( $url ) {
        // Implementation for saving as .html file
    }

    // Create a sitemap.html file that shows the results as a sitemap list structure
    public function create_sitemap() {
        // Implementation for creating sitemap.html file
    }

    // Display the crawl results on the admin page
    public function display_results() {
        // Implementation for displaying results
    }

	// Crawl task 
    public function crawl_task() {
        // Perform the crawl
        // Save the results
    }

    // Recurring crawl task 
    public function crawl_recurring_task() {
        // Perform the crawl
        // Save the  results
    }

}