<?php
class Controller_add extends Controller
{
	function __construct()
	{
		parent::__construct();
		$this->model = new Model_add();
	}

	public function action_index()
	{
		if (!isset($_SESSION))
			session_start();
		if (!isset($_SESSION['user']) || empty($_SESSION['user']))
		{
			$host = 'http://'.$_SERVER['HTTP_HOST']."/";
			header('Location:'.$host.'main');
		}
		$this->view->generate('add_view.php', 'template_view.php');
	}

	public function action_load()
	{
		if (!isset($_SESSION))
			session_start();
		if (!isset($_SESSION['user']) || empty($_SESSION['user']))
		{
			echo "you should be logged in to perform this action!";
			return ;
		}
		$uid = unserialize(base64_decode($_SESSION['user']))['uid'];
		$answer = $this->model->load_recent(intval($_GET['start']), $uid);
		echo json_encode($answer);
	}

	public function action_delete()
	{
		if (!isset($_SESSION))
			session_start();
		if (!isset($_SESSION['user']) || empty($_SESSION['user']))
		{
			echo "you should be logged in to perform this action!";
			return ;
		}
		$uid = unserialize(base64_decode($_SESSION['user']))['uid'];
		$answer = $this->model->delete(($_GET['path']), $uid);
	}

	public function action_image()
	{
		if (!isset($_SESSION))
			session_start();
		if (!isset($_SESSION['user']) || empty($_SESSION['user']))
		{
			echo "you should be logged in to perform this action!";
		}
		else
		{
			if (!isset($_POST['image']) || empty($_POST['image']) ||
				!isset($_POST['caption']) || empty($_POST['caption']))
			{
				echo "Wrong syntax! You should only use upload form!";
				return ;
			}
			define('UPLOAD_DIR', 'user_data/');
			$img = $_POST['image'];
			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$data = base64_decode($img);
			$file = uniqid() . '.png';
			$this->model->add_image($file, $_POST['caption'], $_SESSION['user']);
			echo (file_put_contents(UPLOAD_DIR.$file, $data)) ? $file : "Error!";
		}
	}
}
?>
