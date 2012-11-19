<?php

function firestarter_get_admin_page()
{
	global $pagenow;
	
	$current_page = trim($_GET['page']);
	
	if ( $pagenow == 'options.php' )
	{
		// get the page name
		$parts = explode( 'page=', $_POST['_wp_http_referer'] );
		$page = $parts[1];
		
		$t = strpos( $page, "&" );
		if ( $t !== FALSE )
		{
			$page = substr( $parts[1], 0, $t );
		}
		
		$current_page = trim( $page );
	}
	
	return $current_page;
}

?>