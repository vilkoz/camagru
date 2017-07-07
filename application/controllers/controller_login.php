<?php
/**
 *
 */
class Controller_login extends Controller
{
  function __construct()
  {
    parent::__construct();
    $this->model = new Model_login();
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
    if (isset($_POST) && isset($_POST['mail']) && !empty($_POST['mail'])
      && isset($_POST['pass']) && !empty($_POST['pass']))
      $answer = $this->action_login($_POST['mail'], $_POST['pass']);
    $this->check_session();
    $data = array('title' => 'Login Page');
    if (isset($answer))
      $data['answer'] = $answer;
    $this->view->generate('login_view.php', 'template_view.php', $data);
  }

  function action_login($mail, $pass)
  {
    $answer = $this->model->login($mail, $pass);
	if ($answer == 'Wrong Credentials!' ||
		$answer == "Please activate your accaunt via link in e-mail!")
      return ($answer);
    else
    {
      session_start();
      $_SESSION['user'] = $answer;
      return ($answer);
    }
  }
}

 ?>
