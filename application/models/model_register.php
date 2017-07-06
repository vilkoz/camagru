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

  public function register($mail, $login, $pass)
  {
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
  }
}

 ?>
