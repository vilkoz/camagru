<?php
/**
 *
 */
class Model_register extends Model
{
  private $pdo;

  function __construct()
  {
    parent::__construct();
    $this->pdo = parent::get_pdo();
  }

  function is_user_dubl($mail, $login)
  {
	  $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `mail` = :mail");
	  $stmt->bindParam(':mail', $mail);
	  $stmt->execute();
	  if ($stmt->fetch())
		  return ("User with same mail already registered!");
	  $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `login` = :login");
	  $stmt->bindParam(':login', $login);
	  $stmt->execute();
	  if ($stmt->fetch())
		  return ("User with same login already registered!");
	  return (False);
  }

  public function register($mail, $login, $pass)
  {
	  if ($ret = $this->is_user_dubl($mail, $login))
		  return ($ret);
    $stmt = $this->pdo->prepare("INSERT INTO `users`".
      "(`login`, `mail`, `pass`,`active`, `token`) ".
      "VALUES (:login, :mail, :pass, 0, :token)");
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':mail', $mail);
    $stmt->bindParam(':pass', $pass);
    $stmt->bindParam(':token', $token);
    $pass = $this->pass_hash($pass);
    $token = hash('sha256', $mail.$login.$pass.time());
	$stmt->execute();
	return ("OK");
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
