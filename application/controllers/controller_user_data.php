<?php
class Controller_user_data extends Controller
{
	public function action_index()
	{
		echo "Don't try to use this by yourself!";
	}

	public function action_view()
	{
		$img_name = explode('/', $_SERVER['REQUEST_URI'])[3];
		header("Content-Type: image/png");
		echo file_get_contents("user_data/".$img_name);
	}
}
?>
