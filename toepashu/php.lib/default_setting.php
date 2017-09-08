<?php
    ob_start();
	if(!isset($_SESSION)) session_start();
	if(@date_default_timezone_get() != 'Asia/Taipei'){
		date_default_timezone_set('Asia/Taipei');
	}
	header("Content-Type:text/html; charset=utf-8");
?>