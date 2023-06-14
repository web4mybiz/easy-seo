<?php

namespace Inc;

class Admin
{
	
	// constructor
	public function __construct()
	{
		add_action( 'admin_menu', array( $this, 'easy_seo_admin_menu') );
		add_action( 'crawl_task_hook', array( $this, 'crawl_task' ) );
		add_action( 'crawl_recurring_task_hook', array( $this, 'crawl_recurring_task' ) );

	}

	// Add the admin  menu
	public function easy_seo_admin_menu()
	{
		add_options_page( 'Easy SEO', 'Easy SEO', 'manage_options', 'easy-seo', array( $this, 'easy_seo_admin_page') );
	}

	// Render admin page
	function easy_seo_admin_page()
	{
		// Render admin page content
		if( isset( $_POST['crawl_trigger'] ) ){
			// Execute trigger
			$this->trigger_crawl();
		}

		// Easy SEO Crawler settings page
        echo '<div class="wrap">';
        echo '<h1>Crawler Settings</h1>';
        echo '<form method="post" action="">';
        echo '<p>Click the button below to trigger the crawl:</p>';
        echo '<input type="submit" name="crawl_trigger" class="button button-primary" value="Trigger Crawl">';
        echo '</form>';

        // Display the crawl results
        $this->display_results();

        echo '</div>';

	}

	// Function that trigger the crawl process
	function trigger_crawl()
	{

		// Delete the results from the last crawl if they exist
        $this->delete_previous_results();

        // Delete the sitemap.html file if it exists
        $this->delete_sitemap_file();

        // Start at the website's root URL (home page)
        $root_url = home_url();

        // Extract all internal hyperlinks (results)
        $results = \Inc\Dom::extract_hyperlinks( $root_url );

        // Store results temporarily in the database
        $database = new \Inc\Database();
        $database->store_results( $results );

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
    public function delete_previous_results()
    {
        // Implementation for deleting previous results
    }

    // Delete the sitemap.html file if it exists
    public function delete_sitemap_file()
    {
        // Implementation for deleting sitemap.html file
    }


    // Save the home page's .php file as a .html file
    public function save_as_html( $url ) 
    {
        // Implementation for saving as .html file
    }

    // Create a sitemap.html file that shows the results as a sitemap list structure
    public function create_sitemap() 
    {
        // Implementation for creating sitemap.html file
    }

    // Display the crawl results on the admin page
    public function display_results() 
    {
        // Implementation for displaying results

        // Retrieve the stored crawl results from the database
        $database = new \Inc\Database();
	    $results = $database->get_stored_results();

	    if (empty($results)) {
	        echo '<p>No results found.</p>';
	        return;
	    }

	    echo '<h2>Crawl Results</h2>';

	    // Output the crawl results as a table
	    echo '<table class="wp-list-table widefat">';
	    echo '<thead>';
	    echo '<tr>';
	    echo '<th>URL</th>';
	    echo '<th>Crawled Time</th>';
	    echo '</tr>';
	    echo '</thead>';
	    echo '<tbody>';

	    foreach ($results as $result) {
	        echo '<tr>';
	        echo '<td>' . esc_html($result->url) . '</td>';
	        echo '<td>' . esc_html($result->date) . '</td>';
	        echo '</tr>';
	    }

	    echo '</tbody>';
	    echo '</table>';

    }


	// Crawl task 
    public function crawl_task() 
    {
        // Perform the crawl
        // Save the results
    }

    // Recurring crawl task 
    public function crawl_recurring_task() 
    {
        // Perform the crawl
        // Save the  results
    }

}