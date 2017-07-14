<?php
/**
 *
 */
class Controller_server extends Controller
{
  function action_index()
  {
	  echo "<pre>";
	  print_r($_SERVER);
	  echo "</pre>";
  }
}

 ?>
