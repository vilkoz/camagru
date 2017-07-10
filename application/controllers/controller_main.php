<?php
/**
 *
 */
class Controller_Main extends Controller
{
  function action_index()
  {
	  $this->view->generate('main_view.php', 'template_view.php',
		array('title' => 'Camagru'));
      $host = 'http://'.$_SERVER['HTTP_HOST']."/";
      header('Location:'.$host.'gallery');
  }
}

 ?>
