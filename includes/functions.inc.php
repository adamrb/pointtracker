<?php

function roundnum ($num, $nearest)
{
   $ret = 0;
   $mod = $num % $nearest;
   if ($mod >= 0)
     $ret = ( $mod > ( $nearest / 2)) ? $num + ( $nearest - $mod) : $num - $mod;
    else
     $ret = ( $mod > (-$nearest / 2)) ? $num - $mod : $num + ( -$nearest - $mod);
    return $ret;
}
/**
 * Crucial Functions for Application
 *
 * @package tpc_tutorials
 * @file    /includes/functions.inc.php
 */
 
/**
 * Redirects to specified page
 *
 * @param string $page Page to redirect user to
 * @return void
 */
function redirect($page) {
	header('Location: ' . $page);
	exit();
}
 
/**
 * Check login status
 *
 * @return boolean Login status
 */
function check_login_status() {
	// If $_SESSION['logged_in'] is set, return the status
	if (isset($_SESSION['logged_in'])) {
		return $_SESSION['logged_in'];
	}
	return false;
}
