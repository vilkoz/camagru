<?php
	if(!isset($_SESSION)) {session_start();}
	include 'application/views/'.$content_view;
?>
