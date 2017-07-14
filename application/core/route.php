<?php
/**
 *
 */
class Route
{
  static function start()
  {
    $controller_name = 'main';
    $action_name = 'index';
    $routes = explode('/', $_SERVER['REQUEST_URI']);

    if (!empty($routes[1]))
    {
      if ($routes[1] == 'favicon.ico')
      {
        Route::show_favicon();
        return ;
      }
      $controller_name = $routes[1];
    }

    if (!empty($routes[2]))
      $action_name = $routes[2];

    $model_name = 'model_'.$controller_name;
	$controller_name = 'controller_'.$controller_name;
    $action_name = 'action_'.$action_name;

    $model_file = strtolower($model_name).'.php';
    $model_path = "application/models/".$model_file;
    if (file_exists($model_path))
      include ($model_path);

    $controller_file = strtolower($controller_name).'.php';
    $controller_path = "application/controllers/".$controller_file;
    if (file_exists($controller_path))
      include ($controller_path);
    else
      Route::ErrorPage404();

    $controller = new $controller_name;
    $action = $action_name;
    if (method_exists($controller, $action))
      $controller->$action();
    else
      Route::ErrorPage404();
  }

  function ErrorPage404()
  {
	$host = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']."/";
    header('HTTP/1.1 404 Not Found');
    header('Status: 404 Not Found');
    header('Location:'.$host.'404');
  }
  
  function show_favicon()
  {
		header("Content-Type: image/png");
    echo base64_decode(
      'AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAA'.
      'AAAAAAAAAAAA/4QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA'.
      'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABEREQEREQAAEQARARARAAARABEB'.
      'EBEAABEAAAEQAAAAEQAAARAAAAARAAABEAAAABEAAAEQAAAAEQAAARAAAAARAAABEBEAABEAAAEQ'.
      'EQAAEQAAARERAAAAAAAAAAAAAAAAAAAAAAD//wAA//8AAP//AADAgwAAzJMAAMyTAADPnwAAz58A'.
      'AM+fAADPnwAAz58AAM+TAADPkwAAz4MAAP//AAD//wAA');
  }
}

 ?>
