<?php
class Controller_logout extends Controller
{
	function action_index()
	{
		if (!isset($_SESSION))
			session_start();
		if(isset($_SESSION['user']))
			unset($_SESSION['user']);
    //  $host = 'https://'.$_SERVER['HTTP_HOST']."/";
		$host = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']."/";
      header('Location:'.$host.'main');
	}
}
?>
