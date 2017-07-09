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
		$stmt = $this->pdo->prepare("
SELECT `users`.`login`, `photos`.`path`,`photos`.`caption`,
(SELECT count(`comments`.`cid`) FROM `comments` WHERE `comments`.`pid` = `photos`.`pid`) AS 'comm_count',
(SELECT count(`likes`.`pid`) FROM `likes` WHERE `likes`.`pid` = `photos`.`pid`) AS 'like_count'
FROM `photos`
INNER JOIN `users` ON `photos`.`uid` = `users`.`uid`
ORDER BY `photos`.`pid` DESC LIMIT 16 OFFSET 0".intval($offset * 16));
		$stmt->execute();
		$out = array();
		while ($ret = $stmt->fetch())
		{
			$out[] = $ret;
		}
		return ($out);
	}

	public function get_perview_info($pic_path)
	{
		$stmt = $this->pdo->prepare(
			"SELECT `photos`.`caption`,`users`.`login`
			FROM `photos`
			INNER JOIN `users` ON `photos`.`uid` = `users`.`uid`
			WHERE `photos`.`path` = :path");
		$stmt->bindParam(':path', $pic_path);
		$stmt->execute();
		$row = $stmt->fetch();
		return ($row);
	}

	public function get_comments($pic_path)
	{
		$stmt = $this->pdo->prepare(
			"SELECT `users`.`login`, `comments`.`text`, `comments`.`cid` FROM `comments`
			INNER JOIN `photos` ON `photos`.`pid` = `comments`.`pid`
			INNER JOIN `users` ON `users`.`uid` = `comments`.`uid`
			WHERE `photos`.`path` = :path
			ORDER BY `comments`.`cid`");
		$stmt->bindParam(':path', $pic_path);
		$stmt->execute();
		$out = array();
		while ($row = $stmt->fetch())
		{
			$out[] = $row;
		}
		return ($out);
	}

	public function new_comment($pic_path, $uid, $text)
	{
		$stmt = $this->pdo->prepare("INSERT INTO `comments` (`cid`, `pid`, `uid`, `text`) VALUES (NULL, (SELECT `pid` FROM `photos` WHERE `path` = :path), :uid, :text)");
		$stmt->bindParam(':path', $pic_path);
		$stmt->bindParam(':uid', $uid);
		$stmt->bindParam(':text', $text);
		$stmt->execute();
	}

	public function count_likes($pic_path)
	{
		$stmt = $this->pdo->prepare("
		SELECT count(`photos`.`pid`) as 'count' FROM `likes`
		INNER JOIN `photos` ON `likes`.`pid` = `photos`.`pid`
		WHERE `photos`.`path` = :path");
		$stmt->bindParam(':path', $pic_path);
		$stmt->execute();
		$row = $stmt->fetch();
		return ($row['count']);
	}

	public function like($pic_path, $uid)
	{
		$stmt = $this->pdo->prepare("
		SELECT count(`pid`) AS 'count' FROM `likes`
		WHERE `likes`.`pid` = (SELECT `pid` FROM `photos` WHERE `path` = :path)
		AND `likes`.`uid` = ". intval($uid));
		$stmt->bindParam(':path', $pic_path);
		$stmt->execute();
		$row = $stmt->fetch();
		if ($row['count'] == 0)
		{
			$stmt = $this->pdo->prepare("
				INSERT INTO `likes` (`uid`, `pid`, `cid`)
				VALUES (".intval($uid).", 
				(SELECT `pid` FROM `photos` WHERE `path` = :path),
				'0');");
			$stmt->bindParam(':path', $pic_path);
			$stmt->execute();
		}
		else
		{
			$stmt = $this->pdo->prepare("
			DELETE FROM `likes`
			WHERE `pid` = (SELECT `pid` FROM `photos` WHERE `path` = :path)
			AND `uid` = ".intval($uid));
			$stmt->bindParam(':path', $pic_path);
			$stmt->execute();
		}
		return($this->count_likes($pic_path));
	}

	public function delete($path, $uid)
	{
		$stmt = $this->pdo->prepare("SELECT count(`caption`) AS 'number'
			FROM `photos`
			WHERE `photos`.`path` = :path
			AND `photos`.`uid` = ".intval($uid));
		$stmt->bindParam(":path", $real_path);
		$real_path = "/user_data/view/".end(explode("/", $path));
		$stmt->execute();
		if ($stmt->fetch()['number'] != 0)
		{
			$stmt = $this->pdo->prepare("DELETE FROM `photos` WHERE `photos`.`path` = :path AND `photos`.`uid` = ".intval($uid));
			$stmt->bindParam(":path", $real_path);
			if ($stmt->execute())
			{
				$tmp = "user_data/".end(explode("/", $path));
				unlink($tmp);
			}
			return True;
		}
		else
			return False;
	}
}
?>
