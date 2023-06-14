<?php

namespace Inc;

class Database
{
	function __construct(){

	}


    // Store results temporarily in the database
    public function store_results( $results ) 
    {
        // Implementation for storing results
        global $wpdb;

	    $this->create_crawl_results_table();
		$this->remove_crawl_results_table();
	    // Create a table name based on the WordPress database prefix
	    $table_name = $wpdb->prefix . 'crawl_results';

	    // Insert the crawl results into the table
	    foreach ($results as $result) {
	        $wpdb->insert(
	            $table_name,
	            array(
	                'url' => $result
	            ),
	            array(
	                '%s'
	            )
	        );
	    }
    }

    // Get the stored crawl results from the database
	public function get_stored_results() 
	{
	    global $wpdb;

	    // Create a table name based on the WordPress database prefix
	    $table_name = $wpdb->prefix . 'crawl_results';

	    // Query the database to retrieve the crawl results
	    $results = $wpdb->get_col("SELECT url FROM $table_name");

	    return $results;
	}


	// Create the crawl_results table
	public function create_crawl_results_table() 
	{
	    global $wpdb;

	    // Create a table name based on the WordPress database prefix
	    $table_name = $wpdb->prefix . 'crawl_results';

	    // Create the table if it doesn't exist
	    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") !== $table_name) {
	        $charset_collate = $wpdb->get_charset_collate();
	        $sql = "CREATE TABLE $table_name (
	            id mediumint(9) NOT NULL AUTO_INCREMENT,
	            url varchar(255) NOT NULL,
	            date DATE,
	            PRIMARY KEY (id)
	        ) $charset_collate;";
	        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	        dbDelta($sql);
	    }
	}

	// Delete the crawl_results table
	function delete_crawl_results_table() 
	{
	    global $wpdb;

	    // Drop the crawl_results table
	    $table_name = $wpdb->prefix . 'crawl_results';
	    $wpdb->query("DROP TABLE IF EXISTS $table_name");
	}

	// Delete the crawl_results table
	function remove_crawl_results_table() 
	{
	    global $wpdb;

	    // Drop the crawl_results table
	    $table_name = $wpdb->prefix . 'crawl_results';
	    $wpdb->query("TRUNCATE TABLE $table_name");
	}
	
}