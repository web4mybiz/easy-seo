<?php

namespace Inc;

class Admin
{
	public $plugin;
	// constructor
	public function __construct()
	{
		add_action( 'admin_menu', array( $this, 'easy_seo_admin_menu') );
		add_action( 'crawl_task_hook', array( $this, 'crawl_task' ) );
		add_action( 'set_recurring_crawl_task', array( $this, 'recurring_crawl_task' ) );

		$this->plugin = 'easy-seo/easy-seo.php';
		add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );

	}

	public function settings_link( $links ){
		$settings_link = '<a href="options-general.php?page=easy-seo">Settings</a>';
		array_push( $links, $settings_link );
		return $links;
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

        	// Set a hourly recurring task
	        if ( ! wp_next_scheduled( 'set_recurring_crawl_task' ) ) {
	            wp_schedule_event( time(), 'hourly', 'set_recurring_crawl_task' );
	        }
		}

		if( !isset( $_GET['crawl_results'] ) ){
		// Easy SEO Crawler settings page
        echo '<div class="wrap">';
        echo '<h1>Crawler Settings</h1>';
        echo '<form method="post" action="">';
        echo '<p>Click the button below to trigger the crawl:</p>';
        echo '<input type="submit" name="crawl_trigger" class="button button-primary" value="Trigger Crawl">';
        echo '</form>';

        echo '<p><a href="options-general.php?page=easy-seo&crawl_results=1">View Results</a></p>';

        }else{
        	// Display the crawl results
        	$this->display_results();
    	}

        echo '</div>';

	}

	// Function that trigger the crawl process
	function trigger_crawl(){

        // Start at the website's root URL (home page)
        $root_url = home_url();

        // Delete the sitemap.html file if it exists
        // Extract all internal hyperlinks (results)
        // Create a sitemap.html file that shows the results as a sitemap list structure
        $results = \Inc\Dom::extract_hyperlinks( $root_url );

        // Store results temporarily in the database
        $database = new \Inc\Database();

        // Delete the results from the last crawl if they exist
        //Save the results
        $database->store_results( $results );

        // Save the home page's .php file as a .html file
        $this->save_as_html( $root_url );

	}


    // Save the home page's .php file as a .html file
    public function save_as_html( $url ){
        // Implementation for saving as .html file
    }

    // Display the crawl results on the admin page
    public function display_results(){
        // Implementation for displaying results

        // Retrieve the stored crawl results from the database
        $database = new \Inc\Database();
	    $results = $database->get_stored_results();

	    if (empty($results)) {
	        echo '<p>No results found.</p>';
	        return;
	    }

	    echo '<h2>Crawl Results</h2>';

	    echo '<p><a href="options-general.php?page=easy-seo" class="button button-primary">New Trigger</a></p>';

	    // Output the crawl results as a table
	    echo '<table class="wp-list-table widefat">';
	    echo '<thead>';
	    echo '<tr>';
	    echo '<th>Title</th>';
	    echo '<th>URL</th>';
	    echo '<th>Crawled Time</th>';
	    echo '</tr>';
	    echo '</thead>';
	    echo '<tbody>';

	    foreach ( $results as $result ) {
	        echo '<tr>';
	        echo '<td>' . esc_html( $result->title ) . '</td>';
	        echo '<td>' . esc_html( $result->url ) . '</td>';
	        echo '<td>' . esc_html( $result->date ) . '</td>';
	        echo '</tr>';
	    }

	    echo '</tbody>';
	    echo '</table>';

    }

    // Recurring crawl task 
    public function recurring_crawl_task(){
        // Perform the crawl in the scheduled time.
        $this->trigger_crawl();
    }

}