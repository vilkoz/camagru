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
}
?>
