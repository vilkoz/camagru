<?php
/**
 *
 */
class Controller_register extends Controller
{

  function __construct()
  {
    parent::__construct();
    $this->model = new Model_register();
  }

  function check_session()
  {
    session_start();
    if (isset($_SESSION['user']) && !empty($_SESSION['user']))
    {
      $host = 'http://'.$_SERVER['HTTP_HOST']."/";
      header('Location:'.$host.'main');
    }
  }

  function action_index()
  {
    $this->check_session();
    if (isset($_POST) &&
      isset($_POST['mail']) && !empty($_POST['mail']) &&
      isset($_POST['login']) && !empty($_POST['login']) &&
      isset($_POST['pass']) && !empty($_POST['pass']))
      $this->action_register($_POST['mail'], $_POST['login'], $_POST['pass']);
    $data = array();
    $this->view->generate('register_view.php', 'template_view.php', $data);
  }

  function action_register($mail, $login, $pass)
  {
  }
}

 ?>
