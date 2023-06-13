<?php

namespace Inc;

class Dom
{
	// Extract all internal hyperlinks (results)
    public static function extract_hyperlinks( $url )
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
	    $dom = new \DOMDocument();
	    libxml_use_internal_errors( true );

	    // Load the HTML content into the DOM document
	    $dom->loadHTML( $body );

	    // Create a DOM XPath object to query the document
	    $xpath = new \DOMXPath( $dom );

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
}