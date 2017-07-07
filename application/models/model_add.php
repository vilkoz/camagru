<?php
class Model_add extends Model
{
	private $pdo;

	function __construct()
	{
		parent::__construct();
		$this->pdo = parent::get_pdo();
	}

	public function add_image($path, $caption, $user)
	{
		$stmt = $this->pdo->prepare("INSERT INTO `photos` ".
			"(`pid`, `uid`, `path`, `caption`, `likes`) ".
			"VALUES (NULL, :uid, :path, :caption, '0')");
		$caption = htmlspecialchars($caption, ENT_QUOTES);
		$uid = unserialize(base64_decode($user))['uid'];
		$path = "user_data/view/".$path;
		$stmt->bindParam(":uid", $uid);
		$stmt->bindParam(":caption", $caption);
		$stmt->bindParam(":path", $path);
		$stmt->execute();
	}

	public function load_recent($start, $uid)
	{
		$stmt = $this->pdo->prepare("SELECT `path`, `caption` FROM `photos` WHERE `uid` = :uid ORDER BY `pid` DESC LIMIT 5 OFFSET ".intval($start));
		$stmt->bindParam(":uid", $uid);
		/* $stmt->bindParam(":start", $start); */
		$stmt->execute();
		$out = array();
		while ($res = $stmt->fetch())
		{
			$out[] = $res;
		}
		return ($out);
	}

	public function delete($path, $uid)
	{
		$stmt = $this->pdo->prepare("DELETE FROM `photos` WHERE `photos`.`path` = :path AND `photos`.`uid` = :uid");
		$stmt->bindParam(":path", $real_path);
		$stmt->bindParam(":uid", $uid);
		$real_path = "user_data/view/".end(explode("/", $path));
		$stmt->execute();
		$tmp = "user_data/".end(explode("/", $path));
		unlink($tmp);
	}
}
?>
