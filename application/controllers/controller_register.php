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
	  $subject = "New User Validation" . "\r\n";
	  $from = 'no-reply@'.$_SERVER['SERVER_NAME'] . "\r\n";
	  $body = 'Hi, <br/> <br/>Your login is ' ."placeholder" .
' <br><br>Click here to validate your account '.
'http://localhost:8080/activate/?token=' . $token . ' &user='.$mail.'<br/>'
. "\r\n";
	  $headers = "From: " . strip_tags($from) . "\r\n";
	  $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
	  $headers .= "MIME-Version: 1.0\r\n";
	  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	  file_put_contents("upload_data/mail.txt",
		  $headers . "Subject: " . $subject . $body);
	  if (mail($to, $subject, $body, $headers))
		  return ("mail accepted for deliverly");
	  else
		  return ("send fail");
  }

  function action_register($mail, $login, $pass)
  {
	  if (preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/", $pass) === false)
		  return ("Check your password complexity!");
	  if (preg_match("/\w+/", $login) === false)
		  return ("Enter a valid login!");
	  if (preg_match("/^[^@\s]+@[^@\s]+\.[^@\s]+$/", $mail) === false)
		  return ("This e-mail does not exist!");
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

  function action_activate()
  {
	  if (isset($_GET) &&
		  isset($_GET['user']) && !empty($_GET['user']) &&
		  isset($_GET['token']) && !empty($_GET['token']))
		  $answer = $this->model->activate_user($_GET['user'], $_GET['token']);
	  $data = array("answer" => $answer);
	  $this->view->generate('activate_view.php', 'template_view.php', $data);
  }
}

 ?>
