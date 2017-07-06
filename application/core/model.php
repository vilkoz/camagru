<?php
/**
 *
 */
class Model
{
  private $pdo;

  function __construct()
  {
    include 'config/database.php';
    try
    {
      $this->pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
    } catch (PDOException $e)
    {
      echo "Error!: ".$e->getMessage()."<br/>";
      die();
    }
  }

  public function get_pdo()
  {
    return ($this->pdo);
  }

  public function pass_hash($pass)
  {
    return (hash('sha256', hash('sha256', $pass).
      "true_salt_shit_you_bitch"));
  }

  public function get_data()
  {
  }
}

 ?>
