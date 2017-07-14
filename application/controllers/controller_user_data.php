<?php
class Controller_user_data extends Controller
{
	public function action_index()
	{
		echo "Don't try to use this by yourself!";
	}

	public function action_stickers()
	{
		$arr = explode('/', $_SERVER['REQUEST_URI']);
		if (count($arr) != 4)
		{
			echo "SUCK IT!";
			return;
		}
		$img_name = $arr[3];
		if (file_exists("stickers/".$img_name))
		{
			header("Content-Type: image/png");
			echo file_get_contents("stickers/".$img_name);
		}
		else
		{
			$host = 'http://'.$_SERVER['HTTP_HOST']."/";
			header('HTTP/1.1 404 Not Found');
			header('Status: 404 Not Found');
			header('Location:'.$host.'404');
		}
	}

	public function action_view()
	{
		$arr = explode('/', $_SERVER['REQUEST_URI']);
		if (count($arr) != 4)
		{
			echo "SUCK IT!";
			return;
		}
		$img_name = $arr[3];
		if (file_exists("user_data/".$img_name))
		{
			header("Content-Type: image/png");
			echo file_get_contents("user_data/".$img_name);
		}
		else
		{
			$host = 'https://'.$_SERVER['HTTP_HOST']."/";
			header('HTTP/1.1 404 Not Found');
			header('Status: 404 Not Found');
			header('Location:'.$host.'404');
		}
	}
	
	public function action_thumb()
	{
		$arr = explode('/', $_SERVER['REQUEST_URI']);
		if (count($arr) != 4)
		{
			echo "SUCK IT!";
			return;
		}
		$img_name = $arr[3];
		if (file_exists("user_data/".$img_name))
		{
			$img = imagecreatefrompng("user_data/".$img_name);
			list($w, $h) = getimagesize("user_data/".$img_name);
			$small = 150;
			if ($w < $h)
			{
				$ws = $small;
				$hs = $h * ($small / $w);
			}
			else
			{
				$hs = $small;
				$ws = $w * ($small / $h);
			}
			$tn = imagecreatetruecolor($ws, $hs);
			imagecopyresampled($tn, $img, 0, 0, 0, 0, $ws, $hs, $w, $h);
			header("Content-Type: image/jpeg");
			imagejpeg($tn, NULL, 75);
			imagedestroy($img);
			imagedestroy($tn);
			// echo file_get_contents("user_data/".$img_name);
		}
		else
		{
			$host = 'https://'.$_SERVER['HTTP_HOST']."/";
			header('HTTP/1.1 404 Not Found');
			header('Status: 404 Not Found');
			header('Location:'.$host.'404');
		}
	}
}
?>
