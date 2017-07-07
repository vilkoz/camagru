<?php
/**
 *
 */
class Model_login extends Model
{
  private $pdo;

  function __construct()
  {
    parent::__construct();
    $this->pdo = parent::get_pdo();
  }

  function new_token($mail)
  {
	  $stmt = $this->pdo->prepare("SELECT `login`, `pass` FROM `users` WHERE `mail` = :mail");
	  $stmt->bindParam(":mail", $mail);
	  $ret = $stmt->execute();
	  $login = $ret['login'];
	  $pass = $ret['pass'];
    return (hash('sha256', $mail.$login.$pass.time()));
  }

  public function login($mail, $pass)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `users`".
      "WHERE `mail` = :mail AND `pass` = :pass");
    $stmt->bindParam(':mail', $mail);
    $stmt->bindParam(':pass', $pass);
	$pass = $this->pass_hash($pass);
	$stmt->execute();
    if ($row = $stmt->fetch())
    {
		if ($row['active'] === 0)
			return ("Please activate your accaunt via link in e-mail!");
      return ($row);
    }
    else
      return ('Wrong Credentials!');
  }

  public function update_pass($user, $token, $pass)
  {
	  $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `mail` = :mail AND `token` = :token");
	  $stmt->bindParam(":mail", $user);
	  $stmt->bindParam(":token", $token);
	  $stmt->execute();
	  if (!($ret = $stmt->fetch()))
	  {
		  return ("Wrong password reset data!");
	  }
	  $stmt = $this->pdo->prepare("UPDATE `users` SET `users`.`pass` = :password WHERE `mail` = :mail AND `token` = :token");
	  $stmt->bindParam(":mail", $user);
	  $stmt->bindParam(":token", $token);
	  $stmt->bindParam(":password", $pass_hash);
	  $pass_hash = $this->pass_hash($pass);
	  $stmt->execute();
	  $stmt = $this->pdo->prepare("UPDATE `users` SET `users`.`token` = :new_token WHERE `mail` = :mail AND `token` = :token");
	  $stmt->bindParam(":mail", $user);
	  $stmt->bindParam(":token", $token);
	  $stmt->bindParam(":new_token", $new_token);
	  $new_token = $this->new_token($user);
	  $stmt->execute();
	  return("Password has been reseted! Your new password is: <b>". $pass."</b>");
  }

  public function get_token($mail)
  {
	  $stmt = $this->pdo->prepare("SELECT `token` FROM `users` ".
		  "WHERE `mail` = :mail");
	  $stmt->bindParam(':mail', $mail);
	  $stmt->execute();
	  return ($stmt->fetch()['token']);
  }
}

 ?>
