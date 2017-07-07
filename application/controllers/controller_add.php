<?php
class Controller_add extends Controller
{
	public function action_index()
	{
		$this->view->generate('add_view.php', 'template_view.php');
	}
}
?>
