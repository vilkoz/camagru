<?php
/**
 *
 */
class Controller_Main extends Controller
{
  function action_index()
  {
	  if (!isset($_SESSION))
		  session_start();
      if (isset($_SESSION) && isset($_SESSION['user']) &&
        !empty($_SESSION['user']))
        {
          //$host = 'https://'.$_SERVER['HTTP_HOST']."/";
		  $host = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']."/";
          header('Location:'.$host.'gallery');
	  }
	  $this->view->generate('main_view.php', 'template_view.php',
		array('title' => 'Camagru'));
  }
}

 ?>
