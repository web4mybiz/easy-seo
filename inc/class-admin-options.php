<?php
class EasySEOAdminOptions
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
    public function delete_previous_results()
    {
        // Implementation for deleting previous results
    }

    // Delete the sitemap.html file if it exists
    public function delete_sitemap_file()
    {
        // Implementation for deleting sitemap.html file
    }

    // Extract all internal hyperlinks (results)
    public function extract_hyperlinks( $url )
    {
        // Implementation for extracting hyperlinks
        $home_url = $url;
	    $results = array();

	    // Fetch the content of the home page
	    $response = wp_remote_get( $home_url );
	    if ( is_wp_error( $response ) ) {
	        // Handle the error here
	        return $results;
	    }

	    // Retrieve the response body
	    $body = wp_remote_retrieve_body( $response );

	    // Create a DOM document
	    $dom = new DOMDocument();
	    libxml_use_internal_errors( true );

	    // Load the HTML content into the DOM document
	    $dom->loadHTML( $body );

	    // Create a DOM XPath object to query the document
	    $xpath = new DOMXPath( $dom );

	    // Query all anchor tags with an href attribute
	    $anchors = $xpath->query( '//a[@href]' );

	    // Iterate through the anchor tags
	    foreach ( $anchors as $anchor ) {
	        $href = $anchor->getAttribute( 'href' );

	        // Check if the href is an internal link
	        if ( strpos( $href, $home_url ) === 0 ) {
	            $results[] = $href;
	        }
	    }

	    return $results;

    }

    // Store results temporarily in the database
    public function store_results( $results ) 
    {
        // Implementation for storing results
        global $wpdb;

	    $this->create_crawl_results_table();

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
	function get_stored_results() 
	{
	    global $wpdb;

	    // Create a table name based on the WordPress database prefix
	    $table_name = $wpdb->prefix . 'crawl_results';

	    // Query the database to retrieve the crawl results
	    $results = $wpdb->get_col("SELECT url FROM $table_name");

	    return $results;
	}


	// Create the crawl_results table
	function create_crawl_results_table() 
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
	    $results = $this->get_stored_results();

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
	    echo '</tr>';
	    echo '</thead>';
	    echo '<tbody>';

	    foreach ($results as $result) {
	        echo '<tr>';
	        echo '<td>' . esc_html($result) . '</td>';
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

    // Activation hook callback
	function crawl_plugin_activation() {
	    // Create the crawl_results table
	    create_crawl_results_table();
	}

    // Deactivation hook callback
	function crawl_plugin_deactivation() {
	    // Delete the crawl_results table
	    delete_crawl_results_table();
	}

	/*
	// Register activation hook
	register_activation_hook( __FILE__, 'crawl_plugin_activation' );

	// Register deactivation hook
	register_deactivation_hook( __FILE__, 'crawl_plugin_deactivation' );
	*/

}