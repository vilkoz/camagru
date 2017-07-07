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
	  $answer = $this->action_register($_POST['mail'], $_POST['login'],
		  $_POST['pass']);
	$data = array('title' => 'Registration');
	if (isset($answer))
		$data['answer'] = $answer;
    $this->view->generate('register_view.php', 'template_view.php', $data);
  }

  function send_confirm($mail)
  {
	  $token = $this->model->get_token($mail);
	  $to = $mail;
	  $subject = "New User Validation";
	  $from = 'no-reply@'.$_SERVER['SERVER_NAME'];
	  $body = 'Hi, <br/> <br/>Your login is ' ."placeholder" .
' <br><br>Click here to validate your account '.
'http://localhost:8080/activate/?' . $token . ' <br/>';
	  $headers = "From: " . strip_tags($from) . "\r\n";
	  $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
	  $headers .= "MIME-Version: 1.0\r\n";
	  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	  if (mail($to, $subject, $body, $headers))
		  return ("mail accepted for deliverly");
	  else
		  return ("send fail");
  }

  function action_register($mail, $login, $pass)
  {
	  if (($ret = $this->model->register($mail, $login, $pass)) == "OK")
	  {
		  $mail_ret = $this->send_confirm($mail);
		  return ("Register successful! " .
				"Please folow the link from validtion e-mail." .
				$mail_ret);
	  }
	  else
		  return ($ret);
  }
}

 ?>
