<?php
class Controller_gallery extends Controller
{
	function __construct()
	{
		parent::__construct();
		$this->model = new Model_gallery();
	}

	public function action_index()
	{
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		$offset = 0;
		if (isset($routes[3]))
			$offset = $routes[3];
		$img_arr = $this->model->get_images($offset);
		$data = array('img_arr' => $img_arr);
		$this->view->generate('gallery_view.php', 'template_view.php', $data);
	}

	public function action_load()
	{
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		$offset = 0;
		if (isset($routes[3]))
			$offset = $routes[3];
		$img_arr = $this->model->get_images($offset);
		echo json_encode($img_arr);
	}

	public function action_perview()
	{
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if (isset($routes[3]))
			$path = $routes[3];
		else
		{
			echo "Parrameter missing!";
			return;
		}
		$comments = $this->model->get_comments("/user_data/view/".$path);
		$info = $this->model->get_perview_info("/user_data/view/".$path);
		$data = array('path' => "/user_data/view/".$path,
		'comments' => $comments, 'info' => $info);
		$this->view->generate("gallery_perview_view.php",
			"template_empty_view.php", $data);
	}

	public function action_load_comments()
	{
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if (isset($routes[3]))
			$path = $routes[3];
		else
		{
			echo "Parrameter missing!1";
			return;
		}
		$comments = $this->model->get_comments("/user_data/view/".$path);
		echo (json_encode($comments));
	}

	public function action_new_comment()
	{
		if (!isset($_SESSION))
			session_start();
		if (!isset($_SESSION['user']) || empty($_SESSION['user']))
		{
			echo "you should be logged in to perform this action!";
			return ;
		}
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if (isset($routes[3]))
			$path = $routes[3];
		else
		{
			echo "Parrameter missing!1";
			return;
		}
		if (!isset($_POST) || !isset($_POST['text']) ||
			empty($_POST['text']))
		{
			print_r($_POST);
			echo "Parrameter missing!2";
			return;
		}
		$uid = unserialize(base64_decode($_SESSION['user']))['uid'];
		$this->model->new_comment("/user_data/view/".$path,
			$uid, htmlspecialchars($_POST['text']), ENT_QUOTES);
	}

	public function action_like()
	{
		if (!isset($_SESSION))
			session_start();
		if (!isset($_SESSION['user']) || empty($_SESSION['user']))
		{
			echo "you should be logged in to perform this action!";
			return ;
		}
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if (isset($routes[3]))
			$path = $routes[3];
		else
		{
			echo "Parrameter missing!1";
			return;
		}
		$uid = unserialize(base64_decode($_SESSION['user']))['uid'];
		echo $this->model->like("/user_data/view/".$path, intval($uid));
	}

	public function action_count_likes()
	{
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if (isset($routes[3]))
			$path = $routes[3];
		else
		{
			echo "Parrameter missing!1";
			return;
		}
		echo $this->model->count_likes("/user_data/view/".$path);
	}

	public function action_delete_photo()
	{
		if (!isset($_SESSION))
			session_start();
		if (!isset($_SESSION['user']) || empty($_SESSION['user']))
		{
			echo "you should be logged in to perform this action!";
			return ;
		}
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if (isset($routes[3]))
			$path = $routes[3];
		else
		{
			echo "Parrameter missing!1";
			return;
		}
		$uid = unserialize(base64_decode($_SESSION['user']))['uid'];
		if ($this->model->delete($path, $uid))
			echo "OK";
		else
			echo "This is not your photo!";
	}
}
?>
