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
  public function login($mail, $pass)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `users`".
      "WHERE `mail` = :mail AND `pass` = :pass");
    $stmt->bindParam(':mail', $mail);
    $stmt->bindParam(':pass', $pass);
    $pass = $this->pass_hash($pass);
    if ($stmt->execute())
    {
      $row = $stmt->fetch();
      return ($row);
    }
    else
      return ('Wrong Credentials!');
  }
}

 ?>
