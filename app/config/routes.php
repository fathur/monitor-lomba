<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "monitor";
/*
$default_controller = "race";

$controller_exceptions = array('ad','authentication','gallery','mimin','post','user','video');

$route['default_controller'] = $default_controller;
$route["^((?!\b".implode('\b|\b', $controller_exceptions)."\b).*)$"] = $default_controller.'/$1';
*/
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */