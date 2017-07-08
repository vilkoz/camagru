<?php
class Model_gallery extends Model
{
	private $pdo;

	function __construct()
	{
		parent::__construct();
		$this->pdo = parent::get_pdo();
	}

	public function get_images($offset = 0)
	{
		$stmt = $this->pdo->prepare("SELECT `users`.`login`, `photos`.`path`,`photos`.`caption` FROM `photos` INNER JOIN `users` ON `photos`.`uid` = `users`.`uid` ORDER BY `photos`.`pid` DESC LIMIT 16 OFFSET ".intval($offset * 16));
		$stmt->execute();
		$out = array();
		while ($ret = $stmt->fetch())
			$out[] = $ret;
		return ($out);
	}
}
?>
