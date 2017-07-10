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
	  if ($answer == 'Wrong Credentials! <a href="/login/reset">Reset?</a>' ||
		  $answer == "Please activate your accaunt via link in e-mail!")
		{
		  if ($answer == "Please activate your accaunt via link in e-mail!")
		    $answer .= " <a href='/register/send_confirm/?token" .
		      base64_encode($mail) ."'>Resend?</a>";
      return ($answer);
		}
    else
    {
		if (!isset($_SESSION))
			session_start();
      $_SESSION['user'] = base64_encode(serialize($answer));
      /* $host = 'http://'.$_SERVER['HTTP_HOST']."/"; */
      /* header('Location:'.$host.'main'); */
      return ($answer);
    }
  }

  function randomPassword()
  {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
	for ($i = 0; $i < 8; $i++)
	{
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
  }

  private function reset_password($user, $token)
  {
	  return ($this->model->update_pass($user, $token, $this->randomPassword()));
  }

  private function send_reset_link($user)
  {
	  $mail = $user;
	  $token = $this->model->get_token($mail);
	  $to = $mail;
	  $subject = "Camagru password reset";
	  $from = 'no-reply@'.$_SERVER['SERVER_NAME'];
	  $body = 'Hi, <br/> <br/>Your login is ' ."placeholder" .
' <br><br>Click here to reset your password '.
'http://localhost:8080/login/reset/?token=' . $token . ' &user='.$mail.'<br/>';
	  $headers = "From: " . strip_tags($from) . "\r\n";
	  $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
	  $headers .= "MIME-Version: 1.0\r\n";
	  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	  if (mail($to, $subject, $body, $headers))
		  return ("Please follow link in e-mail to reset your password");
	  else
		  return ("send fail");
  }

  function action_reset()
  {
	  if (isset($_GET) &&
		  isset($_GET['user']) && !empty($_GET['user']) &&
		  isset($_GET['token']) && !empty($_GET['token']))
	  {
		  $answer = $this->reset_password($_GET['user'], $_GET['token']);
		  $data = array('answer' => $answer);
		  $this->view->generate('login_reset_view.php',
			  'template_view.php', $data);
	  }
	  else if (
		  isset($_GET['user']) && !empty($_GET['user']) &&
		  (!isset($_GET['token']) || empty($_GET['token'])))
	  {
		  $answer = $this->send_reset_link($_GET['user']);
		  $data = array('answer' => $answer);
		  $this->view->generate('login_reset_view.php',
			  'template_view.php', $data);
	  }
	  else
		  $this->view->generate('login_reset_view.php', 'template_view.php');
  }
}

 ?>
