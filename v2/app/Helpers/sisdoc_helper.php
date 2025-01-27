<?php

function get($var)
{
	$vlr = '';
	if (isset($_GET[$var])) {
		$vlr = $_GET[$var];
	} else {
		if (isset($_POST[$var])) {
			$vlr = $_POST[$var];
		} else {
			$vlr = '';
		}
	}
	return $vlr;
}

function pre($dt,$stop=true)
{
	echo '<pre>';
	print_r($dt);
	echo '</pre>';

	if ($stop == true) {
		exit;
	}
}
