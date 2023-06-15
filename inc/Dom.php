<?php

namespace Inc;

class Dom
{
	public static $sitemap;

	// Extract all internal hyperlinks (results)
    public static function extract_hyperlinks( $url )
    {
        // Implementation for extracting hyperlinks
        $home_url = $url;
	    $results = ['Home' => $url];

	    // Fetch the content of the home page
	    $response = wp_remote_get( $home_url );
	    if ( is_wp_error( $response ) ) {
	        // Handle the error here
	        return $results;
	    }

	    // Retrieve the response body
	    $body = wp_remote_retrieve_body( $response );

	    // Create a DOM document
	    $dom = new \DOMDocument();
	    libxml_use_internal_errors( true );

	    // Load the HTML content into the DOM document
	    $dom->loadHTML( $body );

	    // Create a DOM XPath object to query the document
	    $xpath = new \DOMXPath( $dom );

	    // Query all anchor tags with an href attribute
	    $anchors = $xpath->query( '//a[@href]' );

	    //self::$sitemap .= '-<a href="'.$url.'">Home</a><br>';

	    // Iterate through the anchor tags
	    foreach ( $anchors as $anchor ) {
	    	// Get the link url
	        $href = $anchor->getAttribute( 'href' );
	        //Get the link text
	        $text = $anchor->textContent;

	        //Assign links to an array
	        $results[$text] = $href;

	    }


	    // Remove duplicates
	    $results = array_unique($results);

	    self::$sitemap = '<ul style="font-family: arial; font-size: 14px;">';
	    // Loop through the array to create sitemap with list structure
	    foreach ($results as $text=>$link) {

	    	// Check if the href is an internal link and add the proper dash
	    	if ( strpos( $link, $home_url ) === 0 ) {
	            self::$sitemap .= '<li><a href="'.$link.'" style="color: #666;">'.$text.'</a></li>';
	        }else{
	        	self::$sitemap .= '<li class="sub" style="margin-left: 15px;"><a href="'.$link.'" style="color: #666;">'.$text.'</a></li>';
	        }

	    }
	    
	    self::$sitemap .= '</ul>';

	    Dom::create_sitemap(self::$sitemap);

	    return $results;

    }

    //Create sitemap.html, remove the old one if exists
    public static function create_sitemap($sitemap){

    	
    	$file_name = 'sitemap.html';

        //Remove sitemap.html if exists
        if (file_exists( plugin_dir_path( __DIR__ ) . $file_name )) {
        	unlink( plugin_dir_path( __DIR__ ) . $file_name );	
        }

        //Generate sitemap.html file
        file_put_contents( plugin_dir_path( __DIR__ ) . $file_name, $sitemap, FILE_APPEND);

    }
}