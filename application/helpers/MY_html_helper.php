<?php
/**
 * script_tag
 * Generates a javascript tag
 * 
 * @access public
 * @param string $script
 * @return string
 */
function script_tag($script)
{
	$CI =& get_instance();	
	return '<script type="text/javascript" src="' . $CI->config->slash_item('base_url') . $script . '"></script>';
}

/**
 * menu_links
 * Generates an array of <a> items
 * 
 * @param array items
 * @return array
 */
function menu_links($items)
{
	/*
	 * Menu item can either be a
	 * key->value pair
	 * or a simple heading (h3)
	 *
	 * This can be nested as well
	 * heading -> item, item, item
	 */

	// Use clojures for recursion!
	// This function can recursively call itself :)

	
	$menuEntries = array();
	
	array_walk($items, function(&$value, &$key) use(&$menuEntries){
		if (is_string($key) && empty($value)) {
			// Heading
			array_push($menuEntries, '<h3>'.$key.'</h3>');
	
		} else if (is_string($key) && is_string($value)) {
			// Simple link
			array_push($menuEntries, '<a href="'.$value.'">'.$key.'</a>');
	
		} else if (is_string($key) && is_array($value)) {
			// Nested entry with heading
			$nestedEntry = '<h3>'.$key.'</h3>' . ul(menu_links($value));
			array_push($menuEntries, $nestedEntry);
				
		}
	});

	return $menuEntries;
}

/**
 * gravatar - creates a gravatar <img> tag with the given image
 * 
 * @param $email
 */
	
function gravatar($email)
{
	$CI =& get_instance();
	$CI->load->helper('security');
	
	// sanitize the input, remove all whitespaces & make the email strtolower
	$email = strtolower(trim(xss_clean($email, FALSE)));
	$hash = do_hash($email, 'md5');
	
	return '<img src="https://wwww.gravatar.com/avatar/'.$hash.'"?d=mm">';
}